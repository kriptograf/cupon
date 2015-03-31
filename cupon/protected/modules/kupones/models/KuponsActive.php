<?php

/**
 * This is the model class for table "kupons_active".
 *
 * The followings are the available columns in table 'kupons_active':
 * @property integer $id
 * @property integer $user_id
 * @property integer $kupon_id
 * @property integer $date
 * @property integer $utilized
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Kupons $kupon
 * @property Users $user
 */
class KuponsActive extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KuponsActive the static model class
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
		return 'kupons_active';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, kupon_id, date', 'required'),
			array('user_id, kupon_id, date, utilized, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, kupon_id, date, utilized, status', 'safe', 'on'=>'search'),
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
			'kupon' => array(self::BELONGS_TO, 'Kupons', 'kupon_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'kupon_id' => 'Купон',
			'date' => 'Дата',
			'utilized' => 'Использован',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('kupon_id',$this->kupon_id);
		$criteria->compare('date',$this->date);
		$criteria->compare('utilized',$this->utilized);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}