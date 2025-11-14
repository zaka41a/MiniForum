<?php
use App\Controllers\{AuthController,TopicController,PostController,VoteController,AdminController,PanelController};

return function($r){
  $r->get('/', [TopicController::class,'home']);
  $r->get('/topics', [TopicController::class,'index']);
  $r->get('/topics/{id:\d+}-{slug}', [TopicController::class,'show']);
  $r->get('/topics/new', [TopicController::class,'new']);
  $r->post('/topics/create', [TopicController::class,'create']);
  $r->post('/topics/{id:\d+}/reply', [PostController::class,'reply']);

  $r->post('/posts/{id:\d+}/vote', [VoteController::class,'vote']);

  $r->get('/login', [AuthController::class,'loginForm']);
  $r->post('/login', [AuthController::class,'login']);
  $r->get('/register', [AuthController::class,'registerForm']);
  $r->post('/register', [AuthController::class,'register']);
  $r->post('/logout', [AuthController::class,'logout']);
// AVANT (ne match pas)
$r->get('/topics/{id:\d+}-{slug}', [TopicController::class,'show']);

// APRÈS (slug autorise a-z, 0-9 et tirets)
$r->get('/topics/{id:\d+}-{slug:[a-z0-9\-]+}', [TopicController::class,'show']);

  $r->get('/me', [PanelController::class,'me']);
  $r->get('/panel/admin', [AdminController::class,'dashboard']);
  $r->get('/panel/admin/users/{id:\d+}/edit', [AdminController::class,'editUser']);
  $r->post('/panel/admin/users/{id:\d+}/update', [AdminController::class,'updateUser']);
  $r->post('/panel/admin/users/{id:\d+}/role', [AdminController::class,'setRole']);
  $r->post('/panel/admin/users/{id:\d+}/delete', [AdminController::class,'deleteUser']);
  $r->post('/panel/admin/tags/create', [AdminController::class,'createTag']);
  $r->post('/panel/admin/tags/{id:\d+}/delete', [AdminController::class,'deleteTag']);
  $r->post('/panel/admin/topics/{id:\d+}/pin', [AdminController::class,'pin']);
  $r->post('/panel/admin/topics/{id:\d+}/toggle', [AdminController::class,'toggleTopic']);
  $r->post('/panel/admin/topics/{id:\d+}/delete', [AdminController::class,'deleteTopic']);

  $r->get('/panel/mod', [PanelController::class,'mod']);
  $r->post('/panel/mod/topics/{id:\d+}/toggle', [PanelController::class,'toggleTopic']);
  $r->post('/panel/mod/votes/{postId:\d+}/reset', [PanelController::class,'resetVotes']);
  $r->post('/panel/mod/posts/{postId:\d+}/delete', [PanelController::class,'deletePost']);
};
