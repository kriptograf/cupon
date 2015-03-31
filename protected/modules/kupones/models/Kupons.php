<?php

/**
 * This is the model class for table "kupons".
 *
 * The followings are the available columns in table 'kupons':
 * @property integer $id_kupon
 * @property string $action
 * @property integer $city_id
 * @property integer $cat_id
 * @property integer $company_id
 * @property string $image
 * @property string $code
 * @property string $old_price
 * @property string $new_price
 * @property string $diff разница в цене
 * @property int $tax скидка
 * @property string $conditions
 * @property string $details
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property integer $position
 * @property int $voters
 * @property string $rating
 * @property integer $views
 *
 * The followings are the available model relations:
 * @property Companies $company
 * @property Cities $city
 * @property CategoriesKupon $cat
 */
class Kupons extends CActiveRecord
{
    public $economy;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Kupons the static model class
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
		return 'kupons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('action, city_id, cat_id, company_id, code, old_price, new_price, conditions, details, start_date, end_date, position', 'required'),
			array('city_id, cat_id, company_id, status, position, views, voters', 'numerical', 'integerOnly'=>true),
			array('action, image, code', 'length', 'max'=>255),
			array('old_price, new_price, rating', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('id_kupon, action, city_id, cat_id, company_id, image, code, old_price, new_price, conditions, details, start_date, end_date, status, position, rating, views', 'safe'),
			array('id_kupon, action, city_id, cat_id, company_id, image, code, old_price, new_price, conditions, details, start_date, end_date, status, position, rating, views', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Companies', 'company_id'),
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'cat' => array(self::BELONGS_TO, 'CategoriesKupon', 'cat_id'),
            'comments' => array(self::HAS_MANY, 'Comments', 'kupon_id'),
            'countComments' => array(self::STAT, 'Comments', 'kupon_id'),
            'kuponuser' => array(self::HAS_MANY, 'UsersKupon', 'kupon_id'),
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_kupon' => 'ID',
			'action' => 'Заголовок',
			'city_id' => 'Город',
			'cat_id' => 'Категория',
			'company_id' => 'Компания',
			'image' => 'Изображение',
			'code' => 'Код купона',
			'old_price' => 'Старая цена',
			'new_price' => 'Новая цена',
			'conditions' => 'Условия акции',
			'details' => 'Детали акции',
			'start_date' => 'Дата начала',
			'end_date' => 'Дата завершения',
			'status' => 'Публикация',
			'position' => 'Позиция',
			'rating' => 'Рейтинг',
			'views' => 'Просмотров',
            'tax'=>'Скидка%(авт.)',
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

                $criteria->with = array('company','cat');

		$criteria->compare('id_kupon',$this->id_kupon);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('t.city_id',Yii::app()->user->getState('currentCity',1));
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('old_price',$this->old_price,true);
		$criteria->compare('new_price',$this->new_price,true);
		$criteria->compare('conditions',$this->conditions,true);
		$criteria->compare('details',$this->details,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('position',$this->position);
		$criteria->compare('rating',$this->rating,true);
		$criteria->compare('views',$this->views);

        $sort = new CSort();

        $sort->attributes = array(
            'id_kupon' => array(
                // добавляем сортировку по postTitle
                'asc' => 'id_kupon',
                'desc' => 'id_kupon desc',
            ),
            'action' => array(
                // добавляем сортировку по postTitle
                'asc' => 'action',
                'desc' => 'action desc',
            ),
            'code' => array(
                // добавляем сортировку по postTitle
                'asc' => 'code',
                'desc' => 'code desc',
            ),
            'old_price' => array(
                // добавляем сортировку по postTitle
                'asc' => 'old_price',
                'desc' => 'old_price desc',
            ),
            'new_price' => array(
                // добавляем сортировку по postTitle
                'asc' => 'new_price',
                'desc' => 'new_price desc',
            ),
            'start_date' => array(
                // добавляем сортировку по postTitle
                'asc' => 'start_date',
                'desc' => 'start_date desc',
            ),
            'end_date' => array(
                // добавляем сортировку по postTitle
                'asc' => 'end_date',
                'desc' => 'end_date desc',
            ),
            'status' => array(
                // добавляем сортировку по postTitle
                'asc' => 'status',
                'desc' => 'status desc',
            ),
            'rating' => array(
                // добавляем сортировку по postTitle
                'asc' => 'rating',
                'desc' => 'rating desc',
            ),
            'views' => array(
                // добавляем сортировку по postTitle
                'asc' => 'views',
                'desc' => 'views desc',
            ),
            'tax' => array(
                // добавляем сортировку по postTitle
                'asc' => 'tax',
                'desc' => 'tax desc',
            ),
        );

        $sort->attributes['cat_id'] = array(
            // добавляем сортировку по категории
            'asc' => 'cat.name',
            'desc' => 'cat.name desc',
        );

        $sort->attributes['company_id'] = array(
            // добавляем сортировку по категории
            'asc' => 'company.title',
            'desc' => 'company.title desc',
        );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}

    /**
     * Обрезка названия акции на главной.
     * @param $string
     * @param $limit
     * @return string
     */
    public static function crop($string, $limit)
    {

        if (strlen($string) >= $limit )
        {
            $substring_limited = substr($string,0, $limit);
            return substr($substring_limited, 0, strrpos($substring_limited, ' ' )).' ...';
        }
        else
        {
            //Если количество символов строки меньше чем задано,
            //то просто возращаем оригинал
            return $string;
        }
    }
}