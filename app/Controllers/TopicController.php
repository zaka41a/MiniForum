<?php
namespace App\Controllers;
use App\Core\View;
use App\Models\{Topic,Tag,Post};

class TopicController {
  public function __construct(private \App\Core\Container $c){}

  public function home(){
    $db=$this->c->get('db');
    $q=$_GET['search']??null; $tag=$_GET['tag']??null; 
    $page=max(1,(int)($_GET['page']??1)); $per=10;

    $topics=\App\Models\Topic::paginated($db,$q,$tag,$page,$per);
    $total=\App\Models\Topic::countAll($db,$q,$tag);
    $pages=max(1,(int)ceil($total/$per));

    \App\Core\View::render('home',[
      'title'=>'MiniForum',
      'topics'=>$topics,
      'tags'=>\App\Models\Tag::all($db),
      'auth'=>$this->c->get('auth'),
      'csrf'=>$this->c->get('csrf'),
      'page'=>$page,'pages'=>$pages,'q'=>$q,'tag'=>$tag
    ]);
  }

  public function index(){ return $this->home(); }

  public function show(int $id, string $slug){
    $db=$this->c->get('db'); $md=$this->c->get('md');
    $t=Topic::find($db,$id); 
    if(!$t){ 
      http_response_code(404); 
      exit('Topic not found'); 
    }
    $posts=Topic::posts($db,$id);
    // add score to each post
    foreach($posts as &$p){ $p['_score']=Post::score($db,(int)$p['id']); }
    View::render('topics/show', [
      'title'=>$t['title'],
      'topic'=>$t,
      'posts'=>$posts,
      'md'=>$md,
      'auth'=>$this->c->get('auth'),
      'csrf'=>$this->c->get('csrf')
    ]);
  }

  public function new(){
    $this->c->get('auth')->requireLogin();
    $db=$this->c->get('db');
    View::render('topics/create',[
      'title'=>'New Topic',
      'tags'=>Tag::all($db),
      'csrf'=>$this->c->get('csrf')
    ]);
  }

  public function create(){
    $auth=$this->c->get('auth'); $auth->requireLogin();
    $csrf=$this->c->get('csrf'); 
    if(!$csrf->validate($_POST['_token']??'')) exit('CSRF');
    $title=trim($_POST['title']??''); 
    $body=trim($_POST['body']??''); 
    $tags=$_POST['tags']??[];
    if(!$title || !$body){ 
      $_SESSION['flash']='Title & content required.'; 
      header('Location:/topics/new'); 
      return; 
    }
    $slug=$this->c->get('slug')->make($title);
    $id=\App\Models\Topic::create(
      $this->c->get('db'), 
      $auth->id(), 
      $title,
      $slug,
      $body, 
      array_map('intval',$tags)
    );
    header("Location: /topics/$id-$slug");
  }
}
