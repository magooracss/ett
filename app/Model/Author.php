<?php

class Author extends AppModel {
	public $name = 'Author';
 
	public $validate = array(

		'name' => array('rule' => array('minLength', '2')
		               ,'required' => true)
			        

        ,'birthdate' => array(
                              'rule' => 'date',
                              'message' => 'Ingrese una fecha válida',
                              'allowEmpty' => false
	 	      )
	      );
                          
}
