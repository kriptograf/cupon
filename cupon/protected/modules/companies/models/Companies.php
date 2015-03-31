<?php

/**
 * This is the model class for table "companies".
 *
 * The followings are the available columns in table 'companies':
 * @property integer $id
 * @property integer $city_id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property string $logo
 * @property string $address
 * @property string $phones
 * @property string $link
 * @property integer $status
 * @property string $boss
 * @property string $boss_contacts
 * @property string $boss_phones
 * @property string $schedule
 * @property string $checked
 * @property string $video
 * @property float $x
 * @property float $y
 *
 * The followings are the available model relations:
 * @property CategoriesCompany $category
 * @property Cities $city
 * @property Kupons[] $kupons
 */
class Companies extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Companies the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'companies';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_id, category_id, title, logo, description, address, phones, status,boss, boss_contacts, boss_phones, schedule', 'required', 'on' => 'create'),
            array('city_id, category_id, status, checked', 'numerical', 'integerOnly' => true),
            array('title, logo, link', 'length', 'max' => 255),
            array('description', 'length', 'max' => 1000),
            //array('link','url'),
            array('video,x,y','safe'),
            array('x,y', 'type', 'type'=>'float'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, city_id, category_id, title, description, logo, address, phones, link, status, checked, x, y', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'CategoriesCompany', 'category_id'),
            'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
            'kupons' => array(self::HAS_MANY, 'Kupons', 'company_id'),
            'countKupons' => array(self::STAT, 'Kupons', 'company_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'gallery' => array(self::HAS_MANY, 'Gallery', 'company_id'),
            'newsCompany' => array(self::HAS_MANY, 'NewsCompany', 'company_id'),
            'comments'=>array(self::HAS_MANY, 'Comment', 'owner_id'),
            'commentsCount'=>array(self::STAT, 'Comment', 'owner_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'city_id' => 'Город',
            'category_id' => 'Подкатегория',
            'title' => 'Название организации',
            'description' => 'Описание организации',
            'logo' => 'Логотип',
            'address' => 'Адрес организации',
            'phones' => 'Телефоны организации',
            'link' => 'Адрес сайта',
            'status' => 'Публикация',
            'boss' => 'ФИО руководителя',
            'boss_contacts' => 'Email руководителя',
            'boss_phones' => 'Телефон руководителя',
            'schedule' => 'Время и дни работы',
            'checked'=>'Проверена',
            'video'=>'Код видеоролика',
            'x'=>'Широта',
            'y'=>'Долгота',
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

        $criteria = new CDbCriteria;

        $criteria->with = array('city', 'category');


        $criteria->compare('id', $this->id);
        $criteria->compare('city_id', Yii::app()->user->getState('currentCity',1));
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phones', $this->phones, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('checked', 1);

        $sort = new CSort();

        $sort->attributes = array(
            'id' => array(
                // добавляем сортировку по postTitle
                'asc' => 't.id',
                'desc' => 't.id desc',
            ),
            'title' => array(
                // добавляем сортировку по postTitle
                'asc' => 'title',
                'desc' => 'title desc',
            ),
            'address' => array(
                // добавляем сортировку по postTitle
                'asc' => 'address',
                'desc' => 'address desc',
            ),
            'status' => array(
                // добавляем сортировку по postTitle
                'asc' => 'status',
                'desc' => 'status desc',
            ),
        );

        $sort->attributes['city_id'] = array(
            // добавляем сортировку по city
            'asc' => 'city.name',
            'desc' => 'city.name desc',
        );

        $sort->attributes['category_id'] = array(
            // добавляем сортировку по категории
            'asc' => 'category.name',
            'desc' => 'category.name desc',
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchnew()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array('city', 'category');


        $criteria->compare('id', $this->id);
        $criteria->compare('city_id', Yii::app()->user->getState('currentCity',1));
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phones', $this->phones, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('checked', 0);

        $sort = new CSort();

        $sort->attributes = array(
            'id' => array(
                // добавляем сортировку по postTitle
                'asc' => 't.id',
                'desc' => 't.id desc',
            ),
            'title' => array(
                // добавляем сортировку по postTitle
                'asc' => 'title',
                'desc' => 'title desc',
            ),
            'address' => array(
                // добавляем сортировку по postTitle
                'asc' => 'address',
                'desc' => 'address desc',
            ),
            'status' => array(
                // добавляем сортировку по postTitle
                'asc' => 'status',
                'desc' => 'status desc',
            ),
        );

        $sort->attributes['city_id'] = array(
            // добавляем сортировку по city
            'asc' => 'city.name',
            'desc' => 'city.name desc',
        );

        $sort->attributes['category_id'] = array(
            // добавляем сортировку по категории
            'asc' => 'category.name',
            'desc' => 'category.name desc',
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
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

        if (strlen($string) >= $limit)
        {
            $substring_limited = substr($string, 0, $limit);
            return substr($substring_limited, 0, strrpos($substring_limited, ' ')) . " ...";
        }
        else
        {
            //Если количество символов строки меньше чем задано, то просто возращаем оригинал
            return $string;
        }
    }
    
    public static function getCountNew()
    {
        $models = self::model()->findAllByAttributes(array('checked' => 0, 'city_id'=>Yii::app()->user->getState('currentCity',1)));
//        $count = 0;
//
//        foreach ($models as $model)
//        {
//            $count += $model->countCompanies;
//        }
        return count($models);
    }

}