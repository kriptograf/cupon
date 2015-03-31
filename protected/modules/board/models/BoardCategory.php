<?php

/**
 * This is the model class for table "board_category".
 *
 * The followings are the available columns in table 'board_category':
 * @property integer $id
 * @property string $name
 * @property integer $section_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Section $section
 * @property CategoryTypes[] $categoryTypes
 * @property Goods[] $goods
 */
class BoardCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BoardCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'board_category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, section_id', 'required'),
			array('section_id, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, section_id, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'section' => array(self::BELONGS_TO, 'Section', 'section_id'),
			'categoryTypes' => array(self::HAS_MANY, 'CategoryTypes', 'category_id'),
			'ads' => array(self::HAS_MANY, 'Ads', 'category_id'),
            'countAds'=>array(self::STAT, 'Ads', 'category_id', 'condition'=>'checked=1 AND status=1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'section_id' => 'Section',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Получить количество дочерних категорий в разделе
     * @param $parent
     * @return int
     */
    public static function getCountChildsItems($parent)
    {
        /**
         * Получить все категории, где раздел такой то
         */
        $models = self::model()->findAllByAttributes(array('id_section' => $parent));
        $count = 0;

        /**
         * Проходим циклом по категориям
         */
        foreach ($models as $model)
        {
            /**
             * И собираем количество
             */
            $count += $model->countCompanies;
        }
        return $count;
    }

    /**
     * Создать дерево для представления в CTreeView
     *
     * @param array $models
     */
    public static function generateTree()
    {
        $models = Section::model()->findAll();
        $data = array();

        foreach ($models as $section)
        {
            $data[$section->id] = array(
                'id' => $section->id,
                'text' => '<span class="label">' . $section->title . ' </span>' ,
            );

            foreach ($section->boardCategories as $item)
            {
                $class = (Yii::app()->request->getParam('id') == $item->id || Yii::app()->request->getParam('category') == $item->id) ? 'active' : '';
                $data[$section->id]['children'][$item->id] = array(
                    'id' => $item->id,
                    'text' => '<a class="' . $class . '" href="/category/' . $item->id . '">&raquo;&nbsp;' . $item->name . ' <span class="count-cat"></span></a> ',
                    'expanded' => false,
                );
            }
        }
        return $data;
    }

    public static function getCategoriesForSelect()
    {
        $categories = self::model()->findAll();
        $result = array();
        foreach($categories as $category)
        {
            if($category->countAds)
            {
                $result[$category->id] = $category->name;
            }

        }
        return $result;
    }
}