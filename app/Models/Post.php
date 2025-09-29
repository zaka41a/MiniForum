<?php
namespace App\Models;
use PDO;

class Post {
  public static function create(PDO $db,int $topicId,int $userId,string $body): int {
    $db->prepare("INSERT INTO posts(topic_id,user_id,body,created_at,updated_at) VALUES(?,?,?,NOW(),NOW())")
      ->execute([$topicId,$userId,$body]);
    return (int)$db->lastInsertId();
  }
  public static function find(PDO $db,int $id): ?array {
    $s=$db->prepare("SELECT * FROM posts WHERE id=?"); $s->execute([$id]); return $s->fetch() ?: null;
  }
  public static function score(PDO $db,int $id): int {
    $s=$db->prepare("SELECT COALESCE(SUM(value),0) s FROM votes WHERE post_id=?"); $s->execute([$id]); return (int)$s->fetchColumn();
  }
public static function byUser(PDO $db, int $uid, int $limit = 12): array
{
    $sql = "SELECT p.id, p.topic_id, t.title, t.slug, p.created_at
            FROM posts p
            JOIN topics t ON t.id = p.topic_id
            WHERE p.user_id = ?
            ORDER BY p.id DESC
            LIMIT ?";
    $s = $db->prepare($sql);
    $s->bindValue(1, $uid, PDO::PARAM_INT);
    $s->bindValue(2, $limit, PDO::PARAM_INT);
    $s->execute();
    return $s->fetchAll();
}



public static function recentWithScore(PDO $db, int $limit = 50): array
{
    $sql = "SELECT p.id, p.topic_id, p.created_at, u.name, t.title, t.slug,
                   COALESCE(SUM(v.value), 0) AS score
            FROM posts p
            JOIN users u ON u.id = p.user_id
            JOIN topics t ON t.id = p.topic_id
            LEFT JOIN votes v ON v.post_id = p.id
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT ?";
    $s = $db->prepare($sql);
    $s->bindValue(1, $limit, PDO::PARAM_INT);
    $s->execute();
    return $s->fetchAll();
}

public static function resetVotes(PDO $db, int $postId): void
{
    $s = $db->prepare("DELETE FROM votes WHERE post_id = ?");
    $s->execute([$postId]);
}


}
