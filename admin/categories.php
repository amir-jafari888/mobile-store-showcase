<?php
declare(strict_types=1);
require_once dirname(__DIR__).'/app/Config/bootstrap.php';
use App\Core\Database;
use App\Middleware\AdminGuard;
use App\Middleware\Csrf;
use App\Services\AdminCatalogService;
AdminGuard::require();
$admin=(new App\Services\AuthService())->admin()??[];
$adminName=(string)($admin['name']??'مدیر');$adminEmail=(string)($admin['email']??'');
$pageTitle='مدیریت دسته‌بندی‌ها';$activeSection='categories';$service=new AdminCatalogService();$error='';$success='';
$editId=filter_input(INPUT_GET,'edit',FILTER_VALIDATE_INT)?:null;
$form=['name'=>'','slug'=>'','description'=>'','image_path'=>'','sort_order'=>0,'is_active'=>1];$categories=[];
if(!Database::configured()){$error='اتصال دیتابیس تنظیم نشده است.';}else{
 try{
  if($_SERVER['REQUEST_METHOD']==='POST'){
   if(!Csrf::verify($_POST['_csrf']??null))throw new InvalidArgumentException('درخواست معتبر نیست؛ صفحه را تازه‌سازی کنید.');
   $id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT)?:null;
   if(($_POST['action']??'save')==='delete'){$service->deleteCategory((int)$id);$_SESSION['admin_flash']='دسته‌بندی حذف شد؛ محصولات مرتبط حفظ می‌شوند.';header('Location: /admin/categories.php',true,303);exit;}
   $service->saveCategory($_POST,$id);$_SESSION['admin_flash']=$id?'دسته‌بندی ویرایش شد.':'دسته‌بندی ثبت شد.';header('Location: /admin/categories.php',true,303);exit;
  }
  $success=(string)($_SESSION['admin_flash']??'');unset($_SESSION['admin_flash']);
  if($editId){$found=$service->category($editId);if(!$found)throw new InvalidArgumentException('دسته‌بندی پیدا نشد.');$form=array_merge($form,$found);}
  $categories=$service->categories();
 }catch(InvalidArgumentException $e){$error=$e->getMessage();$form=array_merge($form,$_POST);$categories=$service->categories();}
 catch(PDOException $e){$error=(string)$e->getCode()==='23000'?'Slug تکراری است.':'ذخیره‌سازی انجام نشد؛ دیتابیس را بررسی کنید.';$form=array_merge($form,$_POST);$categories=$service->categories();}
 catch(Throwable $e){$error='دریافت اطلاعات ناموفق بود؛ تنظیمات دیتابیس و migration را بررسی کنید.';}
}
require __DIR__.'/partials/header.php';
?>
<section class="admin-panel"><div class="panel-heading"><div><span>ساختار کاتالوگ</span><h2><?=$editId?'ویرایش دسته‌بندی':'افزودن دسته‌بندی'?></h2></div></div>
<?php if($error):?><div class="crud-alert error"><?=e($error)?></div><?php endif;?><?php if($success):?><div class="crud-alert success"><?=e($success)?></div><?php endif;?>
<form class="crud-form" method="post" action="/admin/categories.php"><input type="hidden" name="_csrf" value="<?=e(Csrf::token())?>"><input type="hidden" name="action" value="save"><?php if($editId):?><input type="hidden" name="id" value="<?=(int)$editId?>"><?php endif;?>
<label>نام دسته‌بندی *<input name="name" maxlength="120" required value="<?=e($form['name']??'')?>"></label>
<label>Slug انگلیسی *<input name="slug" maxlength="160" pattern="[a-z0-9]+(-[a-z0-9]+)*" required dir="ltr" placeholder="mobile-phones" value="<?=e($form['slug']??'')?>"></label>
<label class="wide">توضیحات<textarea name="description" maxlength="500" rows="3"><?=e($form['description']??'')?></textarea></label>
<label class="wide">مسیر تصویر<input name="image_path" dir="ltr" placeholder="/assets/uploads/category.webp" value="<?=e($form['image_path']??'')?>"><small>آپلود فایل در این فاز فعال نیست.</small></label>
<label>ترتیب نمایش<input type="number" name="sort_order" value="<?=e($form['sort_order']??0)?>"></label>
<div class="crud-checks"><label><input type="checkbox" name="is_active" value="1" <?=!empty($form['is_active'])?'checked':''?>> فعال در سایت</label></div>
<div class="crud-actions"><button class="crud-button primary" type="submit"><?=$editId?'ذخیره تغییرات':'ثبت دسته‌بندی'?></button><?php if($editId):?><a class="crud-button secondary" href="/admin/categories.php">انصراف</a><?php endif;?></div></form></section>
<section class="admin-panel"><div class="panel-heading"><div><span>فهرست گروه‌ها</span><h2>دسته‌بندی‌ها (<?=count($categories)?>)</h2></div></div><div class="crud-table-wrap"><table class="crud-table"><thead><tr><th>دسته‌بندی</th><th>تعداد محصولات</th><th>وضعیت</th><th>عملیات</th></tr></thead><tbody>
<?php foreach($categories as $c):?><tr><td><b><?=e($c['name'])?></b><small><?=e($c['slug'])?></small></td><td><?=(int)$c['products_count']?></td><td><span class="crud-status <?=$c['is_active']?'on':'off'?>"><?=$c['is_active']?'فعال':'غیرفعال'?></span></td><td class="crud-row-actions"><a href="/admin/categories.php?edit=<?=(int)$c['id']?>">ویرایش</a><form method="post"><input type="hidden" name="_csrf" value="<?=e(Csrf::token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=(int)$c['id']?>"><button type="submit">حذف</button></form></td></tr><?php endforeach;?>
<?php if(!$categories):?><tr><td colspan="4" class="crud-empty">دسته‌بندی ثبت نشده است.</td></tr><?php endif;?></tbody></table></div></section>
<?php require __DIR__.'/partials/footer.php';