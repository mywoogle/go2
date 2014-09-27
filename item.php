<head>
<style type="text/css">
.huohao_bg{
	background: #B62A07;
	width: 1200px;
	height: 80px;
	line-height: 80px;
	font-size: 36px;
	color: #fff;
}
#item_page{
	width: 1200px;
	margin: auto;
	text-align: center;
}
.go_back a{
	float: right;
	padding-right: 50px;
}
.go_back a{
	color: white;
	text-decoration: none;
	font-weight: bold;
}
.woogle-price{
	font-size: 26px;
	font-family: Courier New;
	font-weight: bold;
	color: #080;
	text-align: center;
}
.woogle-em{
	height: 24px;
	font-style: normal;
	font-size: 24px;
	color: #666;
	font-weight: normal;
	text-align: center;
}
.product_body_price_em{
	background: #FDF2F2;
	padding: 20px;
}


</style>

</head>
<?php 
header("Content-type: text/html; charset=utf-8"); 
include 'phpQuery/phpQuery.php';  
include 'pinyin.php';  

$item_attr = $_SERVER["QUERY_STRING"]."<br>"; #id=5
$new_item_attr = str_replace("&&","?",$item_attr);
$new_item_attr = 'http://www.go2.cn/product/'.$new_item_attr;

phpQuery::newDocumentFile($new_item_attr);  
$product_body = pq('#productmemo')->html();
$product_body_img_start = strpos($product_body,'<img src="',0);
$product_body_id = pq('#biinfo')->find('h5 span')->text();
$product_body_id = str_replace('商家编码：','', $product_body_id);
$product_body_id_old = str_replace('商家编码：','', $product_body_id);



$product_body_id_shangjia = explode("&",$product_body_id);
$product_body_id_shangjia = $product_body_id_shangjia[0];
$product_body_id_shangjia_new = pinyin(trim($product_body_id_shangjia));
$product_body_id_shangjia_pinyin = str_replace($product_body_id_shangjia,$product_body_id_shangjia_new,$product_body_id_old);

$product_body_price_em = @file_get_contents('prices/'.$product_body_id_shangjia_pinyin.'.txt');
  if(substr_count($product_body_price_em,'woogle-price') == 1){
    $product_body_price_em = $product_body_price_em;
  }else{
	$product_body_price_em = '<a href="http://item.taobao.com/item.htm?id=41388497386" target="_blank">联系5元代发</a>';
  }

$product_body_id = '<div class="huohao_bg">完整货号：'.$product_body_id_shangjia_pinyin.'<span class="go_back"><a href="/"><<返回首页</a></span></div>';

$product_body_text = preg_replace("/<img.*?>/si","",$product_body);
$product_body_text_new = explode('<br>',$product_body_text);
$product_body_text_new = array_flip($product_body_text_new);
$product_body_text_new = array_flip($product_body_text_new);

preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$product_body,$imgs);

echo '<div id="item_page">';
echo $product_body_id;
echo '<div class="product_body_price_em">'.$product_body_price_em.'</div>';
echo '<br><br>';

$text_filter_tem = filter_new($product_body_text_new);
echo $text_filter_tem;

//------------------------------------------------------------------------------

echo '<br>';
foreach($imgs[0] as $img){
	echo $img;
}

echo '</div>';

include 'footer.php'; 
//-----------------------------------------------------------------

function filter_new($str){
	$tem = $str;
	$tem = text_filter($tem);
	$tem = end_calculatePrice('元',$tem);
	$tem = pre_calculatePrice('价',$tem);
	$tem = pre_calculatePrice('加',$tem);
	return $tem;
}

function filter($str){
	$tem = $str;
	$tem = text_filter($tem);
	$tem = end_calculatePrice('元',$tem);
	$tem = pre_calculatePrice('价',$tem);
	$tem = pre_calculatePrice('加',$tem);
	return $tem;
}

function text_filter($strings){
	$returns = array();
	$return_string_end = '';
	$finds=array(
		'q',
		'Q',
		'电',
		'话',
		'地',
		'址',
		'厂',
		'家',
		"号",
		'GO2',
		'go2',
		'代',
		'传',
		'真',
		'联',
		'系',
		'手',
		'机',
		'品',
		'牌',
		'包装',
		'鞋业',
		'群',
		'支付宝',
		'商贸城',
		);
		
	foreach($finds as $find){
		foreach($strings as $string){
			if(strpos($string, $find)>0){
				if(!in_array($string,$returns)){
					array_push($returns,$string);
				}
			}
		}
	}
	$tem_diff_texts = array_diff($strings,$returns);
	foreach($tem_diff_texts as $tem_diff_text){
		$return_string_end = $return_string_end.$tem_diff_text.'<br>';
	}
	return $return_string_end;
}



function filte_url($string){

   $string = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $string);
   
   $string = preg_replace('/13[0-9]{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|5|6|7|8|9]\d{8}/', '', $string);
   
   $string = preg_replace('/[1-9][0-9]{4,}/', '', $string);
   $string = preg_replace('/QQ:/', '', $string);
   $string = preg_replace('/qq:/', '', $string);
   $string = preg_replace('/QQ/', '', $string);
   $string = preg_replace('/qq/', '', $string);
   $string = preg_replace('/Q Q/', '', $string);

   
  $string = str_replace('国际商贸城','', $string);
  $string = str_replace('区', '', $string);
  $string = str_replace('楼', '', $string);
  $string = str_replace('街', '', $string);
  $string = str_replace('市场拿货地址：', '', $string);
  $string = str_replace('拿货地址：', '', $string);
  $string = str_replace('地址：', '', $string);
  $string = str_replace('电话：', '', $string);
  $string = str_replace('电话', '', $string);
  $string = str_replace('GO2', '', $string);
    $string = str_replace('电  话：', '', $string);
	$string = str_replace('电    话', '', $string);
	
	$string = str_replace('地  址：', '', $string);
	$string = str_replace('联系方式：', '', $string);
	$string = str_replace('件代发', '', $string);
	$string = str_replace('群', '', $string);

	$tem_start_init = strpos($string,'厂家',0);
	$tem_num_init = substr($string,$tem_start_init,20);
	$string = str_replace($tem_num_init, '', $string);
	
	$tem_start_init = strpos($string,'厂 家',0);
	$tem_num_init = substr($string,$tem_start_init,20);
	$string = str_replace($tem_num_init, '', $string);
	
	$tem_start_init = strpos($string,'品牌',0);
	$tem_num_init = substr($string,$tem_start_init,20);
	$string = str_replace($tem_num_init, '', $string);

	return $string;
}

//pre_calculatePrice('加',$product_body);
function pre_calculatePrice($flag,$str){
	$offset = 0;
	$tem_length = 20;
	$finish = 0;
	$new_product_body = $str;
	$modified = 0;

	$tem_start_init = strpos($new_product_body,$flag,0);
	$new_start_init = $tem_start_init>0?$tem_start_init:0;
	$tem_num_init = substr($new_product_body,$new_start_init,20);
	if($modified == 0){
		while($finish == 0){
			if(!strpos($new_product_body,$flag,$offset+1)){
				$finish = 1;
			}else{
			$tem_start = strpos($new_product_body,$flag,$offset+1).'<br>';
			$new_start = $tem_start>0?$tem_start:0;
			@$tem_num = substr($new_product_body,$new_start,$tem_length);
			$old_num = findNum($tem_num);
			$new_num = '<span clas="price">'.round($old_num>30?$old_num*1.05:$old_num*1.6).'</span>';
			$new_tem_num = str_replace($old_num,$new_num,$tem_num);
			$new_product_body = substr_replace($new_product_body,$new_tem_num,$new_start,$tem_length);
			$offset = strpos($new_product_body,$flag,$offset+1);
			}
		}
		return $new_product_body;
	}
}

//end_calculatePrice('元',$tem);
function end_calculatePrice($flag,$str){
	$offset = 0;
	$tem_length = 15;
	$finish = 0;
	$new_product_body = $str;
	$modified = 0;

	$tem_start_init = strpos($new_product_body,$flag,0);
	$new_start_init = $tem_start_init-50>0?$tem_start_init-50:0;
	$tem_num_init = substr($new_product_body,$new_start_init,50);
	
	if(strpos($tem_num_init,'clas="price"',0)){
		$modified = 1;
		echo 'It is working';
	}
	
	if($modified == 0){
		while($finish == 0){
			if(!strpos($new_product_body,$flag,$offset+1)){
				$finish = 1;
			}else{
			$tem_start = strpos($new_product_body,$flag,$offset+1).'<br>';
			$new_start = $tem_start-$tem_length>0?$tem_start-$tem_length:0;
			$tem_num = substr($new_product_body,$new_start,$tem_length);
			$old_num = findNum($tem_num);
			$new_num = '<span clas="price">'.round($old_num>30?$old_num*1.05:$old_num*1.6).'</span>';
			$new_tem_num = str_replace($old_num,$new_num,$tem_num);
			$new_product_body = substr_replace($new_product_body,$new_tem_num,$new_start,$tem_length);

			$offset = strpos($new_product_body,$flag,$offset+1);
			
			}
		}
		return $new_product_body;
	}
}

function findNum($str=''){

	$str=trim($str);

	if(empty($str)){return '';}

	$result='';

	for($i=0;$i<strlen($str);$i++){

		if(is_numeric($str[$i])){

			$result.=$str[$i];

		}
	}

	return $result;
}
?> 
