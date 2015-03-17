<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    public $name = 'User';
    public $validate = array(
  	  'mail' => array(
		 'rule' => array('email', false)
		 ,'required' => true
                 ,'message' => 'Por favor, necesito una dirección válida de correo.'
		 )

	 ,'password' => array(
                              'rule' => array('minLength', '8'),
                              'message' => 'Por lo menos 8 caracteres de longitud'
                            )

    );



    public function beforeSave( $options = array()  )  {
        if (isset($this->data[$this->alias]['password'])) {
        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
}
