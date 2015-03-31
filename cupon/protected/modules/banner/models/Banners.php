<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $img
 * @property string $alt
 * @property string $html
 * @property integer $city_id
 * @property integer $user_id
 * @property integer $width
 * @property integer $height
 * @property integer $percent
 * @property integer $pos_id
 * @property integer $num
 * @property string $sdate
 * @property string $edate
 * @property string $views
 * @property string $clicks
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property PosBanner $pos
 * @property Cities $city
 * @property StatBanner[] $statBanners
 */
class Banners extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banners the static model class
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
		return 'banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, city_id, width, height, percent, pos_id, num, sdate, edate, views, clicks, status', 'required'),
			array('city_id, user_id, width, height, percent, pos_id, num, status', 'numerical', 'integerOnly'=>true),
			array('name, img, alt', 'length', 'max'=>255),
			array('views, clicks', 'length', 'max'=>20),
			array('html', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url, img, alt, html, city_id, user_id, width, height, percent, pos_id, num, sdate, edate, views, clicks, status', 'safe', 'on'=>'search'),
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
			'city' => array(self::BELONGS_TO, 'Cities', 'city_id'),
			'statBanners' => array(self::HAS_MANY, 'StatBanner', 'banner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'url' => 'Ссылка',
			'img' => 'Изображение',
			'alt' => 'Альтернативный текст',
			'html' => 'Html код',
			'city_id' => 'Город',
			'user_id' => 'Пользователь',
			'width' => 'Ширина',
			'height' => 'Высота',
			'percent' => 'Процент показа',
			'pos_id' => 'Позиция',
			'num' => 'Номер на странице',
			'sdate' => 'Дата начала показа',
			'edate' => 'Дата окончания показа',
			'views' => 'Показов',
			'clicks' => 'Кликов',
			'status' => 'Сост.',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('alt',$this->alt,true);
		$criteria->compare('html',$this->html,true);
		$criteria->compare('city_id',  Yii::app()->user->getState('currentCity',1));
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('percent',$this->percent);
		$criteria->compare('pos_id',$this->pos_id);
		$criteria->compare('num',$this->num);
		$criteria->compare('sdate',$this->sdate,true);
		$criteria->compare('edate',$this->edate,true);
		$criteria->compare('views',$this->views,true);
		$criteria->compare('clicks',$this->clicks,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}