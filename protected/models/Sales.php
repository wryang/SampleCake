<?php

/**
 * This is the model class for table "sales".
 *
 * The followings are the available columns in table 'sales':
 * @property integer $id
 * @property integer $pid
 * @property integer $count
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Product $p
 */
class Sales extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Sales the static model class
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
		return 'sales';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pid, timestamp', 'required'),
			array('pid, count', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pid, count, timestamp', 'safe', 'on'=>'search'),
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
			'count' => 'Count',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('count',$this->count);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}