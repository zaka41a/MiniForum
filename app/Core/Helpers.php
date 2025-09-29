<?php
namespace App\Core;

function url(string $path): string {
  $b = rtrim($_SERVER['BASE_URI'] ?? '', '/');
  return $b . $path;
}
function redirect(string $path): never {
  header('Location: '.$path, true, 302); exit;
}
function is_post(): bool { return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'; }
function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
