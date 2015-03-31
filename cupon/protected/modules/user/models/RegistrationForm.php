<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			array('password, email', 'required', 'on'=>'registration'),
            array('email,password', 'required', 'on'=>'create'),
            array('email', 'email','on'=>'create'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('verifyPassword', 'compare', 'on'=>'registration', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.") ),
		);
		//if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			//array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		//}
		
		array_push($rules,array('verifyPassword', 'compare', 'on'=>'registration', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		return $rules;
	}
	
}