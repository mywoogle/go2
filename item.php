<head>
<style type="text/css">
.huohao_bg{
	background: blue;
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

$item_attr = $_SERVER["QUERY_STRING"]."<br>"; #id=5

$new_item_attr = str_replace("&&","?",$item_attr);
//http://www.go2.cn/product/oamagi.go?_page=fh_1&_cat=all&_pos=2&_type=img
$new_item_attr = 'http://www.go2.cn/product/'.$new_item_attr;
//echo $new_item_attr;

phpQuery::newDocumentFile($new_item_attr);  
$product_body = pq('#productmemo')->html();
$product_body_img_start = strpos($product_body,'<img src="',0);
$product_body_id = pq('#biinfo')->find('h5 span')->text();
$product_body_id = str_replace('商家编码：','', $product_body_id);
$product_body_id_old = str_replace('商家编码：','', $product_body_id);

$product_body_price_em = @file_get_contents('prices/'.iconv("ISO-8859-1","UTF-8",trim($product_body_id_old)).'.txt');

$product_body_id_shangjia = explode("&",$product_body_id);
$product_body_id_shangjia = $product_body_id_shangjia[0];
$product_body_id_shangjia_new = Pinyin($product_body_id,'utf-8');
$product_body_id_shangjia_pinyin = str_replace($product_body_id_shangjia,$product_body_id_shangjia_new,$product_body_id_old);


$product_body_id = '<div class="huohao_bg">完整货号：'.$product_body_id_shangjia_pinyin.'<span class="go_back"><a href="/"><<返回首页</a></span></div>';
//$product_body_text = substr($product_body,0,$product_body_img_start);
//$product_body_imgs = substr($product_body,$product_body_img_start);

$product_body_text = preg_replace("/<img.*?>/si","",$product_body);
$product_body_text_new = explode('<br>',$product_body_text);
$product_body_text_new = array_flip($product_body_text_new);
$product_body_text_new = array_flip($product_body_text_new);

//print_r($product_body_text_new);

preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$product_body,$imgs);


echo '<div id="item_page">';
echo $product_body_id;
echo '<div class="product_body_price_em">'.$product_body_price_em.'</div>';
echo '<br><br>';



//------------------------------------------------------------------

//$text_filter_tem = text_filter($product_body_text_new);








$text_filter_tem = filter_new($product_body_text_new);
echo $text_filter_tem;






//echo filter($product_body_text);
//echo $product_body_text;

//echo $product_body_imgs;

//print_r($match[0]);

//------------------------------------------------------------------------------

echo '<br>';
foreach($imgs[0] as $img){
	echo $img;
}


echo '</div>';












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
	/*
		"Q",
		"q",
		'电',
		'话',
		'地',
		'址',
		'家',
		'厂',
		"号",
		'GO2',
		'go2',
		'代发',
		'传真',
		'联系',
		'手机',
		'厂名',
		'厂',
		'品牌',
		'品',
		'牌',
		'包装',
		'鞋业',
		'群',
		'支付宝',
		'商贸城’,
		*/
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
	/*
	if(strpos($tem_num_init,'clas="price"',0)){
		$modified = 1;
		echo 'It is working';
	}
	*/
	if($modified == 0){
		while($finish == 0){
			if(!strpos($new_product_body,$flag,$offset+1)){
				$finish = 1;
			}else{
			$tem_start = strpos($new_product_body,$flag,$offset+1).'<br>';
			$new_start = $tem_start>0?$tem_start:0;
			@$tem_num = substr($new_product_body,$new_start,$tem_length);
			//echo $tem_num.'**************************<br>';
			//echo @substr($new_product_body,$new_start,$tem_length).'++++++++++++++++++++<br>';
			$old_num = findNum($tem_num);
			$new_num = '<span clas="price">'.round($old_num>30?$old_num*1.1:$old_num*1.6).'</span>';
			$new_tem_num = str_replace($old_num,$new_num,$tem_num);
			//echo $new_tem_num.'-----------------<br>';
			//echo $new_start.'===============<br>';
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
			//echo substr($new_product_body,$new_start,$tem_length).'--++++++-----<br>';
			$old_num = findNum($tem_num);
			$new_num = '<span clas="price">'.round($old_num>30?$old_num*1.1:$old_num*1.6).'</span>';
			$new_tem_num = str_replace($old_num,$new_num,$tem_num);
			//echo $new_tem_num.'-----------------<br>';
			//echo $new_start.'===============<br>';
			$new_product_body = substr_replace($new_product_body,$new_tem_num,$new_start,$tem_length);

			$offset = strpos($new_product_body,$flag,$offset+1);
			
			}
		}
		return $new_product_body;
	}
}




/*
function end_calculatePrice($flag,$str){
	$tem_length = 10;
	$tem_start = strpos($str,$flag).'<br>';
	$new_start = $tem_start-$tem_length>0?$tem_start-$tem_length:0;
	//echo $new_start;
	$tem_num = substr($str,$new_start,$tem_length);
	echo substr($str,$new_start,$tem_length).'-------';
	//echo findNum($tem_num);
	$old_num = findNum($tem_num);
	$new_num = round($old_num>30?$old_num*1.1:$old_num*1.6);
	$new_tem_num = str_replace($old_num,$new_num,$tem_num);
	$new_product_body = substr_replace($str,$new_tem_num,$new_start,$tem_length);



	echo $new_product_body;

}

*/


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

















//------------------------------------------------

function Pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha". 
                        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|". 
                        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er". 
                        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui". 
                        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang". 
                        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang". 
                        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue". 
                        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne". 
                        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen". 
                        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang". 
                        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|". 
                        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|". 
                        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu". 
                        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you". 
                        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|". 
                        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo"; 
        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990". 
                        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725". 
                        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263". 
                        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003". 
                        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697". 
                        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211". 
                        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922". 
                        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468". 
                        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664". 
                        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407". 
                        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959". 
                        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652". 
                        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369". 
                        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128". 
                        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914". 
                        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645". 
                        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149". 
                        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087". 
                        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658". 
                        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340". 
                        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888". 
                        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585". 
                        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847". 
                        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055". 
                        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780". 
                        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274". 
                        "|-10270|-10262|-10260|-10256|-10254"; 
        $_TDataKey   = explode('|', $_DataKey); 
        $_TDataValue = explode('|', $_DataValue);
        $_Data = array_combine($_TDataKey, $_TDataValue);
        arsort($_Data); 
        reset($_Data);
        if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String); 
        $_Res = ''; 
        for($i=0; $i<strlen($_String); $i++) { 
                $_P = ord(substr($_String, $i, 1)); 
                if($_P>160) { 
                        $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
                } 
                $_Res .= _Pinyin($_P, $_Data); 
        } 
        return preg_replace("/[^a-z0-9]*/", '', $_Res); 
} 
function _Pinyin($_Num, $_Data){ 
        if($_Num>0 && $_Num<160 ){
                return chr($_Num);
        }elseif($_Num<-20319 || $_Num>-10247){
                return '';
        }else{ 
                foreach($_Data as $k=>$v){ if($v<=$_Num) break; } 
                return $k; 
        } 
}
function _U2_Utf8_Gb($_C){ 
        $_String = ''; 
        if($_C < 0x80){
                $_String .= $_C;
        }elseif($_C < 0x800) { 
                $_String .= chr(0xC0 | $_C>>6); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        }elseif($_C < 0x10000){ 
                $_String .= chr(0xE0 | $_C>>12); 
                $_String .= chr(0x80 | $_C>>6 & 0x3F); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        }elseif($_C < 0x200000) { 
                $_String .= chr(0xF0 | $_C>>18); 
                $_String .= chr(0x80 | $_C>>12 & 0x3F); 
                $_String .= chr(0x80 | $_C>>6 & 0x3F); 
                $_String .= chr(0x80 | $_C & 0x3F); 
        } 
        return @iconv('UTF-8', 'GB2312', $_String); 
}
 
//测试
//echo Pinyin('中文字','utf-8'); //第二个参数“1”可随意设置即为utf8编码
//echo 'It is working!';


































?> 
