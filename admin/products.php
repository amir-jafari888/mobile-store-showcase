<?php
declare(strict_types=1);
require_once dirname(__DIR__).'/app/Config/bootstrap.php';
use App\Core\Database;
use App\Middleware\AdminGuard;
use App\Middleware\Csrf;
use App\Services\AdminCatalogService;
use InvalidArgumentException;
use PDOException;
AdminGuard::require();
$admin=(new App\Services\AuthService())->admin()??[];
$adminName=(string)($admin['name']??'مدیر');$adminEmail=(string)($admin['email']??'');
$pageTitle='مدیریت محصولات';$activeSection='products';$service=new AdminCatalogService();$error='';$success='';
$editId=filter_input(INPUT_GET,'edit',FILTER_VALIDATE_INT)?:null;
$form=['name'=>'','slug'=>'','category_id'=>'','short_description'=>'','description'=>'','image_path'=>'','sort_order'=>0,'featured'=>1,'is_active'=>1];
$products=[];$categories=[];
if(!Database::configured()){$error='اتصال دیتابیس تنظیم نشده است.';}else{
 try{
  if($_SERVER['REQUEST_METHOD']==='POST'){
   if(!Csrf::verify($_POST['_csrf']??null))throw new InvalidArgumentException('درخواست معتبر نیست؛ صفحه را تازه‌سازی کنید.');
   $id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT)?:null;
   if(($_POST['action']??'save')==='delete'){$service->deleteProduct((int)$id);$_SESSION['admin_flash']='محصول حذف شد.';header('Location: /admin/products.php',true,303);exit;}
   $service->saveProduct($_POST,$id);$_SESSION['admin_flash']=$id?'محصول ویرایش شد.':'محصول ثبت شد.';header('Location: /admin/products.php',true,303);exit;
  }
  $success=(string)($_SESSION['admin_flash']??'');unset($_SESSION['admin_flash']);
  if($editId){$found=$service->product($editId);if(!$found)throw new InvalidArgumentException('محصول پیدا نشد.');$form=array_merge($form,$found);}
  $products=$service->products();$categories=$service->categories();
 }catch(InvalidArgumentException $e){$error=$e->getMessage();$form=array_merge($form,$_POST);$products=$service->products();$categories=$service->categories();}
 catch(PDOException $e){$error=(string)$e->getCode()==='23000'?'Slug تکراری است.':'ذخیره‌سازی انجام نشد؛ دیتابیس را بررسی کنید.';$form=array_merge($form,$_POST);$products=$service->products();$categories=$service->categories();}
 catch(Throwable $e){$error='دریافت اطلاعات ناموفق بود؛ تنظیمات دیتابیس و migration را بررسی کنید.';}
}
require __DIR__.'/partials/header.php';
?>
<section class="admin-panel"><div class="panel-heading"><div><span>کاتالوگ فروشگاه</span><h2><?= $editId?'ویرایش محصول':'افزودن محصول' ?></h2></div></div>
<?php if($error):?><div class="crud-alert error"><?=e($error)?></div><?php endif;?><?php if($success):?><div class="crud-alert success"><?=e($success)?></div><?php endif;?>
<form class="crud-form" method="post" action="/admin/products.php">
<input type="hidden" name="_csrf" value="<?=e(Csrf::token())?>"><input type="hidden" name="action" value="save"><?php if($editId):?><input type="hidden" name="id" value="<?=(int)$editId?>"><?php endif;?>
<label>نام محصول *<input name="name" maxlength="180" required value="<?=e($form['name']??'')?>"></label>
<label>Slug انگلیسی *<input name="slug" maxlength="220" pattern="[a-z0-9]+(-[a-z0-9]+)*" required dir="ltr" value="<?=e($form['slug']??'')?>"></label>
<label>دسته‌بندی<select name="category_id"><option value="">بدون دسته‌بندی</option><?php foreach($categories as $c):?><option value="<?=(int)$c['id']?>" <?=((string)($form['category_id']??'')===(string)$c['id'])?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select></label>
<label>توضیح کوتاه<textarea name="short_description" maxlength="500" rows="2"><?=e($form['short_description']??'')?></textarea></label>
<label class="wide">توضیحات کامل<textarea name="description" rows="4"><?=e($form['description']??'')?></textarea></label>
<label class="wide">مسیر تصویر<input name="image_path" dir="ltr" placeholder="/assets/uploads/product.webp" value="<?=e($form['image_path']??'')?>"><small>آپلود فایل در این فاز فعال نیست؛ مسیر محلی معتبر وارد کنید.</small></label>
<label>ترتیب نمایش<input type="number" name="sort_order" value="<?=e($form['sort_order']??0)?>"></label>
<div class="crud-checks"><label><input type="checkbox" name="featured" value="1" <?=!empty($form['featured'])?'checked':''?>> محصول منتخب</label><label><input type="checkbox" name="is_active" value="1" <?=!empty($form['is_active'])?'checked':''?>> فعال</label></div>
<div class="crud-actions"><button class="crud-button primary" type="submit"><?= $editId?'ذخیره تغییرات':'ثبت محصول' ?></button><?php if($editId):?><a class="crud-button secondary" href="/admin/products.php">انصراف</a><?php endif;?></div></form></section>
<section class="admin-panel"><div class="panel-heading"><div><span>فهرست کاتالوگ</span><h2>محصولات (<?=count($products)?>)</h2></div></div><div class="crud-table-wrap"><table class="crud-table"><thead><tr><th>محصول</th><th>دسته‌بندی</th><th>وضعیت</th><th>منتخب</th><th>عملیات</th></tr></thead><tbody>
<?php foreach($products as $p):?><tr><td><b><?=e($p['name'])?></b><small><?=e($p['slug'])?></small></td><td><?=e($p['category_name']??'—')?></td><td><span class="crud-status <?=$p['is_active']?'on':'off'?>"><?=$p['is_active']?'فعال':'غیرفعال'?></span></td><td><?=$p['featured']?'بله':'خیر'?></td><td class="crud-row-actions"><a href="/admin/products.php?edit=<?=(int)$p['id']?>">ویرایش</a><form method="post"><input type="hidden" name="_csrf" value="<?=e(Csrf::token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=(int)$p['id']?>"><button type="submit">حذف</button></form></td></tr><?php endforeach;?>
<?php if(!$products):?><tr><td colspan="5" class="crud-empty">محصولی ثبت نشده است.</td></tr><?php endif;?></tbody></table></div></section>
<?php require __DIR__.'/partials/footer.php';