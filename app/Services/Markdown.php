<?php
namespace App\Services;
class Markdown {
  public function toHtml(string $md): string {
    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $md);
    $html = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $html);
    $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);
    $html = nl2br($html);
    return $html;
  }
}
