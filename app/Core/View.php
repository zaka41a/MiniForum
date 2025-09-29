<?php
namespace App\Core;
class View {
  public static function render(string $view, array $data=[], ?string $layout='layout'){
    extract($data,EXTR_SKIP);
    $file=__DIR__.'/../Views/'.$view.'.php';
    if($layout){
      $content=(function() use($file,$data){ extract($data); ob_start(); require $file; return ob_get_clean(); })();
      require __DIR__.'/../Views/'.$layout.'.php';
    } else { require $file; }
  }
}
