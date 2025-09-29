<?php
namespace App\Core;

class Router {
  private array $routes=[]; private Container $c;
  public function __construct(Container $c){ $this->c=$c; }
  public function get($p,$h){ $this->map('GET',$p,$h); }
  public function post($p,$h){ $this->map('POST',$p,$h); }
  private function map($m,$p,$h){
    $re=preg_replace('#\{(\w+):([^}]+)\}#','(?P<$1>$2)',$p); $this->routes[]=[$m,'#^'.$re.'$#',$h];
  }
  public function dispatch($method,$uri){
    $uri=rtrim($uri,'/')?:'/';
    foreach($this->routes as [$m,$re,$h]){
      if($m!==$method) continue;
      if(preg_match($re,$uri,$mch)){
        $params=array_filter($mch,'is_string',ARRAY_FILTER_USE_KEY);
        if(is_array($h)){ [$cls,$meth]=$h; $obj=new $cls($this->c); return $obj->$meth(...array_values($params)); }
        return $h(...array_values($params));
      }
    }
    http_response_code(404); echo 'Not Found';
  }
}
