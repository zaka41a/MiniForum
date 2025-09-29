<?php
namespace App\Models;

use PDO;

class Topic
{
    /* Liste paginée (+ recherche plein texte + filtre tag) */
    public static function paginated(PDO $db, ?string $q, ?string $tag, int $page = 1, int $per = 10): array
    {
        $where  = [];
        $params = [];

        if ($q) {
            $where[]          = "MATCH(t.title,t.body) AGAINST (:q IN NATURAL LANGUAGE MODE)";
            $params[':q']     = $q;
        }
        if ($tag) {
            $where[]          = "EXISTS(
                                   SELECT 1 FROM topic_tag tt
                                   JOIN tags tg ON tg.id = tt.tag_id
                                   WHERE tt.topic_id = t.id AND tg.slug = :tag
                                 )";
            $params[':tag']   = $tag;
        }

        $sql = "SELECT t.*
                FROM topics t " .
               ($where ? "WHERE " . implode(' AND ', $where) : "") . "
                ORDER BY (t.pinned_at IS NOT NULL) DESC, t.created_at DESC
                LIMIT :lim OFFSET :off";

        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':lim', $per, PDO::PARAM_INT);
        $stmt->bindValue(':off', ($page - 1) * $per, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function countAll(PDO $db, ?string $q, ?string $tag): int
    {
        $where  = [];
        $params = [];

        if ($q) {
            $where[]        = "MATCH(title,body) AGAINST (:q IN NATURAL LANGUAGE MODE)";
            $params[':q']   = $q;
        }
        if ($tag) {
            $where[]        = "EXISTS(
                                 SELECT 1 FROM topic_tag tt
                                 JOIN tags tg ON tg.id = tt.tag_id
                                 WHERE tt.topic_id = topics.id AND tg.slug = :tag
                               )";
            $params[':tag'] = $tag;
        }

        $sql = "SELECT COUNT(*) FROM topics " . ($where ? "WHERE " . implode(' AND ', $where) : "");
        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    /* Mes sujets */
    public static function byUser(PDO $db, int $uid, int $limit = 12): array
    {
        $sql = "SELECT id, title, slug, status, created_at
                FROM topics
                WHERE user_id = :uid
                ORDER BY id DESC
                LIMIT :lim";
        $s = $db->prepare($sql);
        $s->bindValue(':uid', $uid, PDO::PARAM_INT);
        $s->bindValue(':lim', $limit, PDO::PARAM_INT);
        $s->execute();
        return $s->fetchAll();
    }

    /* Trouver un topic */
    public static function find(PDO $db, int $id): ?array
    {
        $s = $db->prepare("SELECT * FROM topics WHERE id = :id");
        $s->execute([':id' => $id]);
        $row = $s->fetch();
        return $row ?: null;
    }

    /* Posts d’un topic (avec auteur) */
    public static function posts(PDO $db, int $topicId): array
    {
        $sql = "SELECT p.id, p.user_id, p.body, p.created_at, u.name
                FROM posts p
                JOIN users u ON u.id = p.user_id
                WHERE p.topic_id = :tid
                ORDER BY p.id ASC";
        $s = $db->prepare($sql);
        $s->execute([':tid' => $topicId]);
        return $s->fetchAll();
    }

    /* Créer un topic + lier les tags */
    public static function create(PDO $db, int $userId, string $title, string $slug, string $body, array $tagIds = []): int
    {
        $tagIds = array_values(array_unique(array_map('intval', $tagIds)));

        try {
            $db->beginTransaction();

            $stmt = $db->prepare(
                "INSERT INTO topics (user_id, title, slug, body, status, accepted_post_id, created_at, updated_at)
                 VALUES (:uid, :title, :slug, :body, 'open', NULL, NOW(), NOW())"
            );
            $stmt->execute([
                ':uid'   => $userId,
                ':title' => $title,
                ':slug'  => $slug,
                ':body'  => $body,
            ]);

            $topicId = (int) $db->lastInsertId();

            if (!empty($tagIds)) {
                $link = $db->prepare("INSERT IGNORE INTO topic_tag (topic_id, tag_id) VALUES (:tid, :tag)");
                foreach ($tagIds as $tg) {
                    $link->execute([':tid' => $topicId, ':tag' => $tg]);
                }
            }

            $db->commit();
            return $topicId;
        } catch (\Throwable $e) {
            if ($db->inTransaction()) { $db->rollBack(); }
            throw $e;
        }
    }

    /* Épingler / désépingler */
    public static function pin(PDO $db, int $id): void
    {
        $sql = "UPDATE topics
                SET pinned_at = CASE WHEN pinned_at IS NULL THEN NOW() ELSE NULL END,
                    updated_at = NOW()
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /* Ouvrir / fermer */
    public static function toggle(PDO $db, int $id): void
    {
        $sql = "UPDATE topics
                SET status = CASE WHEN status='open' THEN 'closed' ELSE 'open' END,
                    updated_at = NOW()
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /* Supprimer (votes -> posts -> liaisons -> topic) */
    public static function delete(PDO $db, int $id): void
    {
        $db->beginTransaction();
        try {
            $db->prepare("DELETE v FROM votes v
                          JOIN posts p ON p.id = v.post_id
                          WHERE p.topic_id = :id")->execute([':id' => $id]);

            $db->prepare("DELETE FROM posts WHERE topic_id = :id")
               ->execute([':id' => $id]);

            $db->prepare("DELETE FROM topic_tag WHERE topic_id = :id")
               ->execute([':id' => $id]);

            $db->prepare("DELETE FROM topics WHERE id = :id")
               ->execute([':id' => $id]);

            $db->commit();
        } catch (\Throwable $e) {
            if ($db->inTransaction()) { $db->rollBack(); }
            throw $e;
        }
    }
}
