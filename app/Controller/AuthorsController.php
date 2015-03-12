<?php

class AuthorsController extends Controller {
    public $helpers = array('Wysiwyg.Wysiwyg');

    public function index() 
    {

        $this->set('authors', $this->Author->find('all'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Author->create();
            $this->Author->set($this->request->data);
         //   $this->Bike->set (array ('user_id'=> AuthComponent::user('id')));
            
        if ($this->Author->save()) {
                $this->Session->setFlash(__('El autor ha sido grabado'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El autor no pudo ser grabado. Inténtelo de nuevo'));
            }
        } 
    }

    public function edit ( $id = null)
    {
        $this->Author->id = $id;
        if (!$this->Author->exists()) {
            throw new NotFoundException(__('Autor inexistente'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Author->save($this->request->data)) {
                $this->Session->setFlash(__('El autor ha sido grabado'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El autor no pudo ser grabado. Por favor vuelva a intentarlo'));
            }
        } else {
            $this->request->data = $this->Author->read(null, $id);
            }
    }
    
   
    public function delete( $id = null)         
    {
        
        $this->Author->id = $id;
        
        if (!$this->Author->exists()) {
            throw new NotFoundException(__('Autor inválido'));
        }
 
         if ($this->Bike->delete($id)) 
        {
             $this->Session->setFlash(__('El autor ha sido borrado'));
                $this->redirect(array('action' => 'index'));
        } else {
                $this->Session->setFlash(__('El autor no ha sido borrado. Vuelva a intentarlo'));
        }       
     }  
}
