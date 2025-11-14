<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\{Topic,Post};

class PanelController {
  public function __construct(private \App\Core\Container $c){}

  public function me(){
    $auth=$this->c->get('auth'); $auth->requireLogin();
    $db=$this->c->get('db'); $uid=$auth->id();
    View::render('panel/me',[
      'title'=>'My Space',
      'my_topics'=>Topic::byUser($db,$uid,12),
      'my_posts'=>Post::byUser($db,$uid,12),
      'csrf'=>$this->c->get('csrf'),
      'auth'=>$auth,
    ]);
  }

  public function mod(){
    $this->c->get('auth')->requireRole('mod');
    $db=$this->c->get('db');
    View::render('panel/mod',[
      'title'=>'Moderation',
      'topics'=>Topic::paginated($db,null,null,1,50),
      'posts'=>Post::recentWithScore($db,50),
      'csrf'=>$this->c->get('csrf')
    ]);
  }

  public function toggleTopic(int $id){
    $this->c->get('auth')->requireRole('mod');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    Topic::toggle($this->c->get('db'),$id);
    header('Location: /panel/mod');
  }

  public function resetVotes(int $postId){
    $this->c->get('auth')->requireRole('mod');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    Post::resetVotes($this->c->get('db'),$postId);
    header('Location: /panel/mod');
  }

  public function deletePost(int $postId){
    $this->c->get('auth')->requireRole('mod');
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')) exit('CSRF');
    Post::delete($this->c->get('db'),$postId);
    $_SESSION['flash'] = 'Comment deleted successfully';

    // Redirect back to mod panel or referer
    $referer = $_SERVER['HTTP_REFERER'] ?? '/panel/mod';
    header('Location: ' . $referer);
  }
}
