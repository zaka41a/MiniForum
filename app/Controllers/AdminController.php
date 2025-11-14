<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\{User,Topic,Tag,Post};

class AdminController {
  public function __construct(private \App\Core\Container $c){}

  public function dashboard(){
    $this->c->get('auth')->requireRole('admin');
    $db=$this->c->get('db');
    View::render('panel/admin',[
      'title'=>'Admin',
      'users'=>User::all($db),
      'tags'=>Tag::all($db),
      'topics'=>\App\Models\Topic::paginated($db,null,null,1,50),
      'csrf'=>$this->c->get('csrf')
    ]);
  }

  public function setRole(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    $role=$_POST['role']??'user'; if(!in_array($role,['user','mod','admin'],true)) $role='user';
    \App\Models\User::setRole($this->c->get('db'),$id,$role);
    header('Location: /panel/admin');
  }

  public function editUser(int $id){
    $this->c->get('auth')->requireRole('admin');
    $db = $this->c->get('db');
    $user = \App\Models\User::findById($db, $id);
    if(!$user) exit('User not found');
    View::render('panel/edit-user',[
      'title'=>'Edit User',
      'user'=>$user,
      'csrf'=>$this->c->get('csrf')
    ]);
  }

  public function updateUser(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');

    $db = $this->c->get('db');
    $name = trim($_POST['name']??'');
    $email = trim($_POST['email']??'');
    $role = $_POST['role']??'user';
    $newPassword = trim($_POST['new_password']??'');

    // Validate role
    if(!in_array($role,['user','mod','admin'],true)) $role='user';

    // Update user info
    \App\Models\User::update($db, $id, $name, $email, $role);

    // Update password if provided
    if(!empty($newPassword) && strlen($newPassword) >= 6) {
      \App\Models\User::updatePassword($db, $id, $newPassword);
    }

    $_SESSION['flash'] = 'User updated successfully';
    header('Location: /panel/admin');
  }

  public function deleteUser(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    \App\Models\User::delete($this->c->get('db'),$id);
    header('Location: /panel/admin');
  }

  public function createTag(){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    $name=trim($_POST['name']??''); if($name){ $slug=$this->c->get('slug')->make($name); \App\Models\Tag::create($this->c->get('db'),$name,$slug); }
    header('Location: /panel/admin');
  }

  public function deleteTag(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    \App\Models\Tag::delete($this->c->get('db'),$id);
    header('Location: /panel/admin');
  }

  public function pin(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    \App\Models\Topic::pin($this->c->get('db'),$id, true);
    header('Location: /panel/admin');
  }

  public function toggleTopic(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    \App\Models\Topic::toggle($this->c->get('db'),$id);
    header('Location: /panel/admin');
  }

  public function deleteTopic(int $id){
    $this->c->get('auth')->requireRole('admin');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    \App\Models\Topic::delete($this->c->get('db'),$id);
    header('Location: /panel/admin');
  }
}
