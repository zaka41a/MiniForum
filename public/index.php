<?php
declare(strict_types=1);

// Helpers minimalistes accessibles partout
function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function redirect(string $to): never { header('Location: '.$to, true, 302); exit; }

// --- Autoload maison (PSR-0-ish) ---
spl_autoload_register(function($c){
  $p = __DIR__ . '/../' . str_replace('\\','/',$c) . '.php';
  if (is_file($p)) require $p;
});

// --- Config & session ---
$config = require __DIR__ . '/../config/config.php';
session_name($config['session_name']); session_start();

// --- Container & Router ---
$container = new App\Core\Container($config);
$router    = new App\Core\Router($container);

// --- Routes ---
($routes = require __DIR__ . '/../config/routes.php')($router);

// --- Dispatch ---
$path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $path);
