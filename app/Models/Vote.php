<?php
namespace App\Models;
use PDO;

class Vote {
  public static function cast(PDO $db,int $postId,int $userId,int $val): void {
    $db->prepare("INSERT INTO votes(post_id,user_id,value,created_at) VALUES(?,?,?,NOW())
      ON DUPLICATE KEY UPDATE value=VALUES(value), created_at=NOW()")->execute([$postId,$userId,$val]);
  }
}
