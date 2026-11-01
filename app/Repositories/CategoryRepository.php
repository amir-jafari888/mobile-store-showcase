<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
use PDO;
final class CategoryRepository {
 private function db():PDO{return Database::connection();}
 public function activeList():array{return $this->db()->query("SELECT c.*,COUNT(p.id) AS products_count FROM categories c LEFT JOIN products p ON p.category_id=c.id AND p.is_active=1 WHERE c.is_active=1 GROUP BY c.id ORDER BY c.sort_order,c.id")->fetchAll();}
 public function adminList():array{return $this->db()->query("SELECT c.*,COUNT(p.id) AS products_count FROM categories c LEFT JOIN products p ON p.category_id=c.id GROUP BY c.id ORDER BY c.sort_order,c.id")->fetchAll();}
 public function findById(int $id):?array{$s=$this->db()->prepare("SELECT * FROM categories WHERE id=:id LIMIT 1");$s->execute(['id'=>$id]);return$s->fetch()?:null;}
 public function findBySlug(string $slug):?array{$s=$this->db()->prepare("SELECT * FROM categories WHERE slug=:slug LIMIT 1");$s->execute(['slug'=>$slug]);return$s->fetch()?:null;}
 public function slugExists(string $slug,?int $exceptId=null):bool{$sql="SELECT 1 FROM categories WHERE slug=:slug".($exceptId!==null?" AND id<>:except_id":"")." LIMIT 1";$s=$this->db()->prepare($sql);$p=['slug'=>$slug];if($exceptId!==null)$p['except_id']=$exceptId;$s->execute($p);return(bool)$s->fetchColumn();}
 public function create(array $d):int{$s=$this->db()->prepare("INSERT INTO categories(name,slug,description,image_path,is_active,sort_order) VALUES(:name,:slug,:description,:image_path,:is_active,:sort_order)");$s->execute($this->normalize($d));return(int)$this->db()->lastInsertId();}
 public function update(int $id,array $d):bool{$v=$this->normalize($d);$v['id']=$id;$s=$this->db()->prepare("UPDATE categories SET name=:name,slug=:slug,description=:description,image_path=:image_path,is_active=:is_active,sort_order=:sort_order WHERE id=:id");$s->execute($v);return$s->rowCount()>0||$this->findById($id)!==null;}
 public function delete(int $id):bool{$s=$this->db()->prepare("DELETE FROM categories WHERE id=:id");$s->execute(['id'=>$id]);return$s->rowCount()>0;}
 private function normalize(array $d):array{return['name'=>trim((string)($d['name']??'')),'slug'=>trim((string)($d['slug']??'')),'description'=>($d['description']??'')!==''?trim((string)$d['description']):null,'image_path'=>($d['image_path']??'')!==''?trim((string)$d['image_path']):null,'is_active'=>!empty($d['is_active'])?1:0,'sort_order'=>(int)($d['sort_order']??0)];}
}