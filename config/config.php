<?php
return [
  'env' => 'local',
  'base_url' => '/',
  'session_name' => 'miniforum_sid',
  'csrf_key' => 'change-me-please',
  'db' => [
    'dsn' => 'mysql:host=127.0.0.1;dbname=miniforum;charset=utf8mb4',
    'user' => 'root',
    'pass' => 'root',
    'options' => [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
  ],
];
