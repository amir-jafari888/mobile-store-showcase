<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
use PDO;
final class ProductRepository {
 private function db():PDO{return Database::connection();}
 public function activeList():array{return $this->db()->query("SELECT p.*,c.name AS category_name,c.slug AS category_slug FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 ORDER BY p.sort_order,p.id DESC")->fetchAll();}
 public function featuredList():array{return $this->db()->query("SELECT p.*,c.name AS category_name,c.slug AS category_slug FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.is_active=1 AND p.featured=1 ORDER BY p.sort_order,p.id DESC")->fetchAll();}
 public function findActiveBySlug(string $slug):?array{$s=$this->db()->prepare("SELECT p.*,c.name AS category_name,c.slug AS category_slug FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.slug=:slug AND p.is_active=1 LIMIT 1");$s->execute(['slug'=>$slug]);return $s->fetch()?:null;}
 public function findById(int $id):?array{$s=$this->db()->prepare("SELECT p.*,c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=:id LIMIT 1");$s->execute(['id'=>$id]);return $s->fetch()?:null;}
 public function slugExists(string $slug,?int $exceptId=null):bool{$sql="SELECT 1 FROM products WHERE slug=:slug".($exceptId!==null?" AND id<>:except_id":"")." LIMIT 1";$s=$this->db()->prepare($sql);$p=['slug'=>$slug];if($exceptId!==null)$p['except_id']=$exceptId;$s->execute($p);return(bool)$s->fetchColumn();}
 public function adminList():array{return $this->db()->query("SELECT p.*,c.name AS category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.sort_order,p.id DESC")->fetchAll();}
 public function create(array $d):int{$s=$this->db()->prepare("INSERT INTO products(category_id,name,slug,short_description,description,image_path,featured,is_active,sort_order) VALUES(:category_id,:name,:slug,:short_description,:description,:image_path,:featured,:is_active,:sort_order)");$s->execute($this->normalize($d));return(int)$this->db()->lastInsertId();}
 public function update(int $id,array $d):bool{$v=$this->normalize($d);$v['id']=$id;$s=$this->db()->prepare("UPDATE products SET category_id=:category_id,name=:name,slug=:slug,short_description=:short_description,description=:description,image_path=:image_path,featured=:featured,is_active=:is_active,sort_order=:sort_order WHERE id=:id");$s->execute($v);return $s->rowCount()>0||$this->findById($id)!==null;}
 public function delete(int $id):bool{$s=$this->db()->prepare("DELETE FROM products WHERE id=:id");$s->execute(['id'=>$id]);return$s->rowCount()>0;}
 private function normalize(array $d):array{return['category_id'=>isset($d['category_id'])&&$d['category_id']!==''?(int)$d['category_id']:null,'name'=>trim((string)($d['name']??'')),'slug'=>trim((string)($d['slug']??'')),'short_description'=>($d['short_description']??'')!==''?trim((string)$d['short_description']):null,'description'=>($d['description']??'')!==''?trim((string)$d['description']):null,'image_path'=>($d['image_path']??'')!==''?trim((string)$d['image_path']):null,'featured'=>!empty($d['featured'])?1:0,'is_active'=>!empty($d['is_active'])?1:0,'sort_order'=>(int)($d['sort_order']??0)];}
}