<?php
namespace App\Services;
class Cache {
  public function __construct(private string $dir){ if(!is_dir($dir)) @mkdir($dir,0777,true); }
  public function path(string $key): string { return $this->dir.'/'.sha1($key).'.html'; }
  public function get(string $key): ?string { $p=$this->path($key); return is_file($p)?file_get_contents($p):null; }
  public function put(string $key,string $val): void { file_put_contents($this->path($key),$val); }
  public function forget(string $key): void { @unlink($this->path($key)); }
}
