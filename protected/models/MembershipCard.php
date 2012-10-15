<?php

/**
 * This is the model class for table "membership_card".
 *
 * The followings are the available columns in table 'membership_card':
 * @property integer $id
 * @property integer $uid
 * @property integer $state
 * @property double $balance
 * @property string $deadline
 * @property string $cardnumber
 * @property double $accumulated
 *
 * The followings are the available model relations:
 * @property User $u
 */
class MembershipCard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MembershipCard the static model class
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
		return 'membership_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, deadline, cardnumber', 'required'),
			array('uid, state', 'numerical', 'integerOnly'=>true),
			array('balance, accumulated', 'numerical'),
			array('cardnumber', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, state, balance, deadline, cardnumber, accumulated', 'safe', 'on'=>'search'),
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
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'uid' => 'Uid',
			'state' => 'State',
			'balance' => 'Balance',
			'deadline' => 'Deadline',
			'cardnumber' => 'Cardnumber',
			'accumulated' => 'Accumulated',
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
		$criteria->compare('uid',$this->uid);
		$criteria->compare('state',$this->state);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('deadline',$this->deadline,true);
		$criteria->compare('cardnumber',$this->cardnumber,true);
		$criteria->compare('accumulated',$this->accumulated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}