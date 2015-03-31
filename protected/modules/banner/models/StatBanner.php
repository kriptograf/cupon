<?php

/**
 * This is the model class for table "stat_banner".
 *
 * The followings are the available columns in table 'stat_banner':
 * @property string $id
 * @property integer $banner_id
 * @property string $date
 * @property integer $city_id
 * @property integer $pos_id
 *
 * The followings are the available model relations:
 * @property PosBanner $pos
 * @property Banners $banner
 * @property Cities $city
 */
class StatBanner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatBanner the static model class
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
		return 'stat_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('banner_id, date, city_id, pos_id', 'required'),
			array('banner_id, city_id, pos_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, banner_id, date, city_id, pos_id', 'safe', 'on'=>'search'),
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
			'pos' => array(self::BELONGS_TO, 'PosBanner', 'pos_id'),
			'banner' => array(self::BELONGS_TO, 'Banners', 'banner_id'),
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'banner_id' => 'Баннер',
			'date' => 'Дата',
			'city_id' => 'Город',
			'pos_id' => 'Позиция',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('banner_id',$this->banner_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('city_id',Yii::app()->user->getState('currentCity',1));
		$criteria->compare('pos_id',$this->pos_id);
                
                //$criteria->group = 'banner_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}