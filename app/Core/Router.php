<?php
declare(strict_types=1);
namespace App\Core;
final class Router {
 private array $routes=[];
 public function get(string $path,callable $handler):void{$this->add('GET',$path,$handler);}
 public function post(string $path,callable $handler):void{$this->add('POST',$path,$handler);}
 private function add(string $method,string $path,callable $handler):void{$path='/'.trim($path,'/');$this->routes[$method][$path===''?'/':$path]=$handler;}
 public function dispatch(string $uri,?string $method=null):void{
  $path='/'.trim(rawurldecode(parse_url($uri,PHP_URL_PATH)?:'/'),'/');$path=$path==='/'?'/':$path;
  $method=strtoupper($method??$_SERVER['REQUEST_METHOD']??'GET');
  if(isset($this->routes[$method][$path])){($this->routes[$method][$path])();return;}
  $allowed=[];foreach($this->routes as $verb=>$routes)if(isset($routes[$path]))$allowed[]=$verb;
  if($allowed){header('Allow: '.implode(', ',$allowed));http_response_code(405);exit('Method Not Allowed');}
  http_response_code(404);require BASE_PATH.'/pages/404.php';
 }
}