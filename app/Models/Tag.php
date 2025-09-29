<?php
namespace App\Models;
use PDO;

class Tag {
  public static function all(PDO $db): array { return $db->query("SELECT * FROM tags ORDER BY name")->fetchAll(); }
  public static function create(PDO $db,string $name,string $slug): int {
    $db->prepare("INSERT INTO tags(name,slug) VALUES(?,?)")->execute([$name,$slug]);
    return (int)$db->lastInsertId();
  }
  public static function delete(PDO $db,int $id): void { $db->prepare("DELETE FROM tags WHERE id=?")->execute([$id]); }
}
