<?php
namespace App\Services;

class Csrf {
  private string $key;
  public function __construct(string $key){ $this->key=$key; }
  public function token(): string {
    if(empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    return hash_hmac('sha256', $_SESSION['_csrf'], $this->key);
  }
  public function field(): string {
    return '<input type="hidden" name="_token" value="'.$this->token().'">';
  }
  public function validate(string $t): bool {
    return hash_equals($this->token(), $t ?? '');
  }
}
  