<?php
namespace App\Services;
use PDO;

class Mailer {
  public function __construct(private PDO $db){}
  public function queue(string $to,string $subject,string $html): void {
    $this->db->prepare("INSERT INTO mail_queue(to_email,subject,body_html,created_at) VALUES(?,?,?,NOW())")
      ->execute([$to,$subject,$html]);
  }
}
