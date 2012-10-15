<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property double $price
 * @property string $imgurl
 * @property string $description
 * @property integer $tid
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property ProductType $t
 * @property Sales[] $sales
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, imgurl, description, tid', 'required'),
			array('tid', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>20),
			array('imgurl', 'length', 'max'=>100),
			array('description', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, imgurl, description, tid', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'pid'),
			't' => array(self::BELONGS_TO, 'ProductType', 'tid'),
			'sales' => array(self::HAS_MANY, 'Sales', 'pid'),
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
			'price' => 'Price',
			'imgurl' => 'Imgurl',
			'description' => 'Description',
			'tid' => 'Tid',
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
		$criteria->compare('price',$this->price);
		$criteria->compare('imgurl',$this->imgurl,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('tid',$this->tid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}