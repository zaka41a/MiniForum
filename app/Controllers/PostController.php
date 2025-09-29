<?php
namespace App\Controllers;
use App\Models\Post;

class PostController {
  public function __construct(private \App\Core\Container $c){}

  public function reply(int $id){
    $auth=$this->c->get('auth'); $auth->requireLogin();
    $csrf=$this->c->get('csrf'); if(!$csrf->validate($_POST['_token']??'')) exit('CSRF');
    $body=trim($_POST['body']??''); 
    if(!$body){ 
      $_SESSION['flash']='Empty message.'; 
      header("Location: /topics/$id-".($_POST['slug']??'')); 
      return; 
    }
    Post::create($this->c->get('db'), $id, $auth->id(), $body);
    $this->c->get('cache')->forget('topic_'.$id);
    header("Location: /topics/$id-".($_POST['slug']??''));
  }
}
