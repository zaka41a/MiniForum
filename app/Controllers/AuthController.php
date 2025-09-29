<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\User;

class AuthController {
  public function __construct(private \App\Core\Container $c){}

  public function loginForm(){ 
    View::render('auth/login',[
      'title'=>'Login',
      'csrf'=>$this->c->get('csrf')
    ]); 
  }

  public function registerForm(){ 
    View::render('auth/register',[
      'title'=>'Sign Up',
      'csrf'=>$this->c->get('csrf')
    ]); 
  }

  public function login(){
    $csrf=$this->c->get('csrf'); 
    if(!$csrf->validate($_POST['_token']??'')) exit('CSRF');
    $ok=$this->c->get('auth')->attempt(trim($_POST['email']??''), $_POST['password']??'');
    if(!$ok){ 
      $_SESSION['flash']='Invalid email/password.'; 
      header('Location: /login'); 
      return; 
    }
    $role=$this->c->get('auth')->role();
    header('Location: '.($role==='admin'?'/panel/admin':($role==='mod'?'/panel/mod':'/me')));
  }

  public function register(){
    $csrf=$this->c->get('csrf'); 
    if(!$csrf->validate($_POST['_token']??'')) exit('CSRF');
    $name=trim($_POST['name']??''); 
    $email=trim($_POST['email']??''); 
    $pass=$_POST['password']??'';
    if(!$name || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($pass)<6){ 
      $_SESSION['flash']='Invalid fields.'; 
      header('Location: /register'); 
      return; 
    }
    if(User::byEmail($this->c->get('db'),$email)){ 
      $_SESSION['flash']='Email already in use.'; 
      header('Location: /register'); 
      return; 
    }
    User::create($this->c->get('db'),$name,$email,$pass);
    $this->c->get('auth')->attempt($email,$pass);
    header('Location: /me');
  }

  public function logout(){ 
    $this->c->get('auth')->logout(); 
    header('Location: /'); 
  }
}
