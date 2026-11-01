<?php
declare(strict_types=1);
namespace App\Services;
use App\Repositories\BannerRepository;
use App\Repositories\StoreSettingRepository;
use InvalidArgumentException;
final class AdminStorefrontService {
 private const FIELDS=['store_name'=>['نام فروشگاه',120],'phone'=>['شماره تماس',40],'whatsapp'=>['شماره واتساپ',40],'contact_email'=>['ایمیل',190],'address'=>['آدرس',500],'opening_hours'=>['ساعات کاری',250],'instagram_url'=>['لینک اینستاگرام',255],'telegram_url'=>['لینک تلگرام',255],'map_url'=>['لینک نقشه',500]];
 public function __construct(private readonly BannerRepository $banners=new BannerRepository(),private readonly StoreSettingRepository $settings=new StoreSettingRepository()){}
 public function banners():array{return$this->banners->adminList();}
 public function banner(int $id):?array{return$this->banners->findById($id);}
 public function saveBanner(array $i,?int $id=null):int{$title=$this->value($i,'title');$subtitle=$this->value($i,'subtitle');$image=$this->value($i,'image_path');$url=$this->value($i,'link_url');$sort=filter_var($i['sort_order']??0,FILTER_VALIDATE_INT);if($title===''||mb_strlen($title)>180)throw new InvalidArgumentException('عنوان بنر الزامی و حداکثر ۱۸۰ کاراکتر است.');if(mb_strlen($subtitle)>500)throw new InvalidArgumentException('زیرعنوان حداکثر ۵۰۰ کاراکتر است.');if($sort===false)throw new InvalidArgumentException('ترتیب نمایش باید عدد صحیح باشد.');$this->image($image);$this->url($url,'لینک بنر');$d=['title'=>$title,'subtitle'=>$subtitle?:null,'image_path'=>$image?:null,'link_url'=>$url?:null,'is_active'=>isset($i['is_active'])?1:0,'sort_order'=>$sort];if($id===null)return$this->banners->create($d);if(!$this->banners->update($id,$d))throw new InvalidArgumentException('بنر پیدا نشد.');return$id;}
 public function deleteBanner(int $id):void{if($id<1||!$this->banners->delete($id))throw new InvalidArgumentException('بنر پیدا نشد.');}
 public function settings():array{$saved=$this->settings->all();$out=[];foreach(self::FIELDS as $k=>$m)$out[$k]=$saved[$k]??'';return$out;}
 public function saveSettings(array $i):void{$data=[];foreach(self::FIELDS as $k=>$meta){$v=$this->value($i,$k);if(mb_strlen($v)>$meta[1])throw new InvalidArgumentException($meta[0].' بیش از حد مجاز طولانی است.');if($k==='contact_email'&&$v!==''&&!filter_var($v,FILTER_VALIDATE_EMAIL))throw new InvalidArgumentException('ایمیل معتبر نیست.');if(in_array($k,['instagram_url','telegram_url','map_url'],true))$this->url($v,$meta[0]);if(in_array($k,['phone','whatsapp'],true)&&$v!==''&&!preg_match('/^[0-9+()\-\s]{7,40}$/',$v))throw new InvalidArgumentException($meta[0].' معتبر نیست.');$data[$k]=$v;}$this->settings->setMany($data);}
 private function value(array $i,string $k):string{$v=$i[$k]??'';if(!is_string($v)&&!is_numeric($v))throw new InvalidArgumentException('ساختار یکی از ورودی‌ها معتبر نیست.');return trim((string)$v);}
 private function image(string $p):void{if($p!==''&&(!preg_match('~^/assets/uploads/[a-zA-Z0-9/_-]+\.(jpg|jpeg|png|webp|avif)$~i',$p)||str_contains($p,'..')))throw new InvalidArgumentException('مسیر تصویر باید داخل assets/uploads و دارای پسوند مجاز باشد.');}
 private function url(string $u,string $label):void{if($u!==''&&(!filter_var($u,FILTER_VALIDATE_URL)||!in_array(strtolower((string)parse_url($u,PHP_URL_SCHEME)),['http','https'],true)))throw new InvalidArgumentException($label.' باید آدرس HTTP یا HTTPS معتبر باشد.');}
}