<?php

class UloginModel extends CModel {

    public $identity;//идентификатор пользователя в сети
    public $network;//имя сети
    public $email;//почта
    public $full_name;//полное имя
    public $token;//токен
    public $error_type;//тип ошибки
    public $error_message;//сообщение об ошибке

    /**
     * @var string адрес авторизации
     */
    private $uloginAuthUrl = 'http://ulogin.ru/token.php?token=';

    public function rules()
    {
        return array(
            array('identity,network,token', 'required'),
            array('email', 'email'),
            array('identity,network,email', 'length', 'max'=>1000),
            array('full_name', 'length', 'max'=>255),
        );
    }

    public function attributeLabels()
    {
        return array(
            'network'=>'Сервис',
            'identity'=>'Идентификатор сервиса',
            'email'=>'eMail',
            'full_name'=>'Имя',
        );
    }

    /**
     * Получение авторизационных данных
     */
    public function getAuthData()
    {
        //Получаем данные из сети и кодируем в джейсон
        $authData = json_decode(file_get_contents($this->uloginAuthUrl.$this->token.'&host='.$_SERVER['HTTP_HOST']),true);

        //echo CVarDumper::dump($authData,10,true);
        $this->setAttributes($authData);

        $this->full_name = $authData['first_name'].' '.$authData['last_name'];
        //echo CVarDumper::dump($this->attributes,10,true);
        //echo '<hr>';
        return $this;
    }

    public function login()
    {
        $identity = new UloginUserIdentity();
        //echo CVarDumper::dump($this->identity,10, true);
        //echo CVarDumper::dump($this->network,10, true);
        //echo CVarDumper::dump($this->email,10, true);
        //echo CVarDumper::dump($this->full_name,10, true);
       // echo CVarDumper::dump($this,10, true);exit;
        if ($identity->authenticate($this))
        {
            //echo CVarDumper::dump($identity,10, true);exit;
            $duration = 3600*24*30;
            Yii::app()->user->login($identity,$duration);
            return true;
        }
        return false;
    }

    public function attributeNames()
    {
        return array(
            'identity'
            ,'network'
            ,'email'
            ,'full_name'
            ,'token'
            ,'error_type'
            ,'error_message'
        );
    }
}