<?php
namespace App\Services;
class Slug {
  public function make(string $s): string {
    $s = strtolower(trim($s));
    $s = iconv('UTF-8','ASCII//TRANSLIT',$s);
    $s = preg_replace('/[^a-z0-9]+/','-',$s);
    return trim($s,'-') ?: 'topic';
  }
}
