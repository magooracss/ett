<?php 

    echo $this->Form->create('Author');

    echo $this->Form->input('name'
                           , array(
                                   'label' =>__('Su nombre')
                                  ) 
                           );

     echo $this->Form->input('mail'
                           , array(
                                   'label' => __('Correo electr&oacute;nico')

                                  ) 
			  );

     echo $this->Form->input('password'
                           , array(
                                   'label' => __('Clave')

                                  ) 
			  );  
     
    echo $this->Form->input('birthday'
                           , array(
                                   'label' => __('Fecha de nacimiento')
                                  ) 
                           );

    echo $this->Form->input('isHuman'
                           , array(
				   'label' => __('Es una organizaci&oacute;n?')  
			          )
                           );
                           
   echo $this->Form->label('Notas');                       
   echo $this->Wysiwyg->textarea( 'Authors.notes'
                                 , array(
                                         
                                         'rows' => '10'
                                        // ,'label' => 'Notes2' 
                                        )
                                 , array (
                                            'language' => 'es'
                                          , 'plugins' => 'paste'
                                          , 'plugins' => 'autosave'
                                          ,  'plugins' => 'wordcount'
                                          ) 
				  ) ;   

    echo $this->Form->end(__('Grabar')); 

?>
