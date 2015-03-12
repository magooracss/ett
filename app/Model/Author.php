<?php


class Author extends AppModel {
	public $name = 'Author';
 
	public $validate = array(

		'name' => array('rule' => array('minLength', '2')
		               ,'required' => true)
			        

  	 , 'mail' => array(
		 'rule' => array('email', true)
		         ,'message' => 'Por favor, necesito una dirección válidade correo.'
			 ,'required' => true
		 )


		           
	 ,'password' => array(
                              'rule' => array('minLength', '8'),
                              'message' => 'Por lo menos 8 caracteres de longitud'
                            )
        ,'birthdate' => array(
                              'rule' => 'date',
                              'message' => 'Ingrese una fecha válida',
                              'allowEmpty' => false
	 	      )
	      );
                          
}
