<?php
// À lancer via cron: php bin/worker_mail_queue.php
$cfg = require __DIR__.'/../config/config.php';
$pdoFactory = require __DIR__.'/../config/database.php';
$db = $pdoFactory($cfg);

$rows = $db->query("SELECT * FROM mail_queue WHERE sent_at IS NULL ORDER BY id ASC LIMIT 50")->fetchAll();
foreach($rows as $m){
  // ICI envoyer l'email (mail()/SMTP). Nous simulons l'envoi :
  echo "Sending to {$m['to_email']} : {$m['subject']}\n";
  $db->prepare("UPDATE mail_queue SET sent_at=NOW(), attempts=attempts+1 WHERE id=?")->execute([$m['id']]);
}
