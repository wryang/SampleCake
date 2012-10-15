<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $authority
 * @property integer $id
 * @property string $name
 * @property integer $gender
 * @property string $birthday
 * @property string $address
 * @property string $password
 *
 * The followings are the available model relations:
 * @property MembershipCard[] $membershipCards
 * @property Order[] $orders
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, birthday, address', 'required'),
			array('authority, gender', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('address', 'length', 'max'=>100),
			array('password', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('authority, id, name, gender, birthday, address, password', 'safe', 'on'=>'search'),
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
			'membershipCards' => array(self::HAS_MANY, 'MembershipCard', 'uid'),
			'orders' => array(self::HAS_MANY, 'Order', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'authority' => 'Authority',
			'id' => 'ID',
			'name' => 'Name',
			'gender' => 'Gender',
			'birthday' => 'Birthday',
			'address' => 'Address',
			'password' => 'Password',
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

		$criteria->compare('authority',$this->authority);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}