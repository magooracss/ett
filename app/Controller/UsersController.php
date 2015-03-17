<?php
// app/Controller/UsersController.php

App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El usuario ha sido grabado'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El usuario no pudo ser grabado. Inténtelo de nuevo.'));
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El usuario ha sido grabado'));
                if ($this->Auth->login()) {
                  $this->redirect(array('controller' =>'bikes', 'action' => 'index'));
                } else
                {
                    $this->redirect(array('controller' =>'users', 'action' => 'login'));
                }
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function beforeFilter() {
         parent::beforeFilter();
        $this->Auth->allow('add'); // Letting users register themselves
      //   $this->Auth->allow('forgot_password','otpregister');
         $this->Auth->allow('edit');
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect('/bikes/');//$this->Auth->redirect());
             // return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
         }
    }


    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function forgot_password($id= null) {
       if ($this->request->is('post')) 
       {
           $form = $this->request->data;

           $anUser = $this->User->find ('first'
                                       , array('conditions' => array('User.email' => $form['User']['email'])

                                              )
                                       );
           if (!empty($anUser)) 
           {
               $randomPass = $this->Auth->password($this->generatePassword());

               $anUser['User']['passtmp'] = $randomPass;

               //$this->User->id = $anUser['User']['id'];

               $this->User->save($anUser, false);

               $now = microtime(true);
               $ttl =$now + 24*3600; // is good for the next 24 hours

               $link = '<a href="http://' . $_SERVER['SERVER_NAME'] . $this->webroot ;
               $link .= "users/otpregister/".$form['User']['email'] ."/".$ttl."/".$randomPass. __('"> Reset password link</a>');


               $Email = new CakeEmail();
               $Email->from(array('magoo@notebikes.com' => 'Notebikes administrator'));
               $Email->to($form['User']['email']);
               $Email->subject(__("[Notebikes] Reset your password"));
               

               $body  = '<br>';
               $body .= __('Please use the following link to access the website:');
               $body .= $link;
               $body .= '<br>'; 
               $body .= '<br>'; 
               $body .= '<br>';          
               $body .= __('If link not work, copy & paste this text  to your browser: ');
               $body .= '<br>';
               $body .= '<br>';
               $body .= 'http://' . $_SERVER['SERVER_NAME'] . $this->webroot ;
               $body .= 'users/otpregister/' . $form['User']['email'] .'/' . $ttl . '/' . $randomPass;

               $Email->emailFormat('both');
               $Email->send($body);

                $this->Session->setFlash(__('We send a mail to: ' . $anUser['User']['email'] ));
            }
            else
            {
                 $this->Session->setFlash(__('Email not found: ') . $form['User']['email']);  
                 $this->redirect('/users/login');
            }    

        }

    }


    public function otpregister ($email,$ttl,$otp) {

      if($email){
        $user = $this->User->find ('first'
                                       , array('conditions' => array('User.email' => $email)

                                              )
                                       );

        if($user){
           $passwordHash = $user["User"]["passtmp"];
           $now = microtime(true);
           if($now <  $ttl){
             if ($otp == $passwordHash){                                       
                                       $this->redirect(array('action' => 'edit', $user["User"]['id']));
                                       }
              else{
                    $this->Session->setFlash(__("Invalid request. Please contact the administration."));
                   // $this->redirect(array('action' => 'login'));

                   }
           }       
           else{
                $this->Session->setFlash(__("Your new password has expired. Please contact the website administration."));
               //$this->redirect(array('action' => 'login'));
               }
       
        }
       }
    }     


     function generatePassword($length=12, $strength=0){
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }


}
