<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$name = $this->username;
		$sql = "SELECT password, id, authority FROM `user` WHERE name='" .$name . "'";
		$user = User::model()->findBySql($sql);

		if ( !$user ) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		} else {
			$password = $user->password;
			$identity = $user->authority;
			$users=array(
				// username => password
				$name => $password
				//'ni'=>'123',
				//'admin'=>'admin',
			);
		

			if(!isset($users[$this->username])) 
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			else if($users[$this->username]!==$this->password)
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			else {
				$this->errorCode=self::ERROR_NONE;
				$this->_id = $user->id;
				Yii::app()->user->setState('identity' , $identity);
			}
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}