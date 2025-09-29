<?php
namespace App\Controllers;
use App\Models\Post;
use App\Models\Vote;

class VoteController {
  public function __construct(private \App\Core\Container $c){}

  public function vote(int $id){
    header('Content-Type: application/json');
    $auth=$this->c->get('auth'); if(!$auth->check()){ http_response_code(401); echo json_encode(['ok'=>false,'msg'=>'login']); return; }
    if(!$this->c->get('csrf')->validate($_POST['_token']??'')){ http_response_code(400); echo json_encode(['ok'=>false]); return; }
    $ip=$_SERVER['REMOTE_ADDR']??'0.0.0.0';
    if(!$this->c->get('rate')->hit('vote',$ip,20,60)){ http_response_code(429); echo json_encode(['ok'=>false,'msg'=>'rate']); return; }
    $val=(int)($_POST['value']??0); if(!in_array($val,[-1,1],true)){ http_response_code(400); echo json_encode(['ok'=>false]); return; }
    Vote::cast($this->c->get('db'), $id, $auth->id(), $val);
    $score=Post::score($this->c->get('db'), $id);
    echo json_encode(['ok'=>true,'score'=>$score]);
  }
}
