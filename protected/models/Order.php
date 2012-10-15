<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $pid
 * @property integer $uid
 * @property integer $count
 * @property string $timestamp
 * @property integer $state
 * @property double $amount
 * @property integer $cardnumber
 *
 * The followings are the available model relations:
 * @property Product $p
 * @property User $u
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, uid, count, timestamp, cardnumber', 'required'),
			array('pid, uid, count, state, cardnumber', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pid, uid, count, timestamp, state, amount, cardnumber', 'safe', 'on'=>'search'),
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
			'p' => array(self::BELONGS_TO, 'Product', 'pid'),
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
			'pid' => 'Pid',
			'uid' => 'Uid',
			'count' => 'Count',
			'timestamp' => 'Timestamp',
			'state' => 'State',
			'amount' => 'Amount',
			'cardnumber' => 'Cardnumber',
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
		$criteria->compare('pid',$this->pid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('count',$this->count);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('cardnumber',$this->cardnumber);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}