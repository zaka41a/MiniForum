<?php
namespace App\Models;
use PDO;

class User {
  public static function byEmail(PDO $db,string $email): ?array {
    $s=$db->prepare("SELECT * FROM users WHERE email=?"); $s->execute([$email]); return $s->fetch() ?: null;
  }
  public static function create(PDO $db,string $name,string $email,string $pass): int {
    $db->prepare("INSERT INTO users(name,email,password_hash,role,created_at) VALUES(?,?,?, 'user', NOW())")
      ->execute([$name,$email,password_hash($pass,PASSWORD_DEFAULT)]);
    return (int)$db->lastInsertId();
  }
  public static function all(PDO $db): array { return $db->query("SELECT id,name,email,role,reputation,created_at FROM users ORDER BY id DESC")->fetchAll(); }
  public static function setRole(PDO $db,int $id,string $role): void { $db->prepare("UPDATE users SET role=? WHERE id=?")->execute([$role,$id]); }
  public static function delete(PDO $db,int $id): void { $db->prepare("DELETE FROM users WHERE id=?")->execute([$id]); }
}
