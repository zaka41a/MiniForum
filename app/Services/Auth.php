<?php
namespace App\Services;
use App\Core\Container;
use App\Models\User;

class Auth {
  private Container $c;
  public function __construct(Container $c){ $this->c = $c; }

  public function user(): ?array {
    return $_SESSION['user'] ?? null;
  }
  public function id(): ?int { return $this->user()['id'] ?? null; }
  public function role(): ?string { return $this->user()['role'] ?? null; }
  public function check(): bool { return !!$this->user(); }
  public function requireLogin(): void { if(!$this->check()) { header("Location: /login"); exit; } }

  public function attempt(string $email,string $password): bool {
    $u = User::byEmail($this->c->get('db'), $email);
    if(!$u || !password_verify($password, $u['password_hash'])) return false;
    $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
    return true;
  }
  public function logout(): void { unset($_SESSION['user']); session_regenerate_id(true); }

  public function requireRole(string ...$roles): void {
    $this->requireLogin();
    if(!in_array($this->role(), $roles, true)){ http_response_code(403); exit('Forbidden'); }
  }
}
