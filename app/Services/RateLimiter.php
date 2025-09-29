<?php
namespace App\Services;
use PDO;

class RateLimiter {
  public function __construct(private PDO $db){}
  public function hit(string $route, string $ip, int $max, int $windowSec): bool {
    // table rate_limits(id, ip VARBINARY(16), route, window_start DATETIME, hits)
    $ipBin = inet_pton($ip) ?: random_bytes(16);
    $now = new \DateTimeImmutable();
    $win = $now->setTime((int)$now->format('H'), (int)floor(((int)$now->format('i')*60+(int)$now->format('s'))/$windowSec)*($windowSec/60), 0);
    $this->db->beginTransaction();
    $stmt = $this->db->prepare("SELECT id,hits FROM rate_limits WHERE ip=? AND route=? AND window_start=? FOR UPDATE");
    $stmt->execute([$ipBin,$route,$win->format('Y-m-d H:i:s')]);
    if($row=$stmt->fetch()){
      if($row['hits'] >= $max){ $this->db->rollBack(); return false; }
      $this->db->prepare("UPDATE rate_limits SET hits=hits+1 WHERE id=?")->execute([$row['id']]);
    } else {
      $this->db->prepare("INSERT INTO rate_limits(ip,route,window_start,hits) VALUES(?,?,?,1)")
        ->execute([$ipBin,$route,$win->format('Y-m-d H:i:s')]);
    }
    $this->db->commit();
    return true;
  }
}
