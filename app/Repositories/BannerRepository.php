<?php
declare(strict_types=1);
namespace App\Repositories;
use App\Core\Database;
final class BannerRepository {
 public function activeList():array{return Database::connection()->query('SELECT * FROM banners WHERE is_active=1 ORDER BY sort_order ASC,id DESC')->fetchAll();}
 public function adminList():array{return Database::connection()->query('SELECT * FROM banners ORDER BY sort_order ASC,id DESC')->fetchAll();}
 public function findById(int $id):?array{$s=Database::connection()->prepare('SELECT * FROM banners WHERE id=:id LIMIT 1');$s->execute(['id'=>$id]);return$s->fetch()?:null;}
 public function create(array $d):int{$s=Database::connection()->prepare('INSERT INTO banners(title,subtitle,image_path,link_url,is_active,sort_order) VALUES(:title,:subtitle,:image_path,:link_url,:is_active,:sort_order)');$s->execute($d);return(int)Database::connection()->lastInsertId();}
 public function update(int $id,array $d):bool{$d['id']=$id;$s=Database::connection()->prepare('UPDATE banners SET title=:title,subtitle=:subtitle,image_path=:image_path,link_url=:link_url,is_active=:is_active,sort_order=:sort_order WHERE id=:id');$s->execute($d);return$s->rowCount()>0||$this->findById($id)!==null;}
 public function delete(int $id):bool{$s=Database::connection()->prepare('DELETE FROM banners WHERE id=:id');$s->execute(['id'=>$id]);return$s->rowCount()>0;}
}