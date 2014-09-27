<head>
<style type="text/css">
.pagelist li{
	float: left;
	width: 20px;
	text-align: center;
	cursor: pointer;
}
.pagelist{
	clear: both;
	overflow: hidden;
	width: 1200px;
	margin: auto;
	padding: 6px;
	padding-right: 1px;
	background: #FDF2F2;
	border: 1px solid #F2F2F2;
	font-size: 13px;
	list-style-type: none;
}
.pagelist li a{
	text-decoration: none;
	width: 20px;
	display: block;
	color: #06C;
}
.pagelist li:hover a{
	background: #BF0000;
	color: white;
}
.pagelist li:hover{
	background: #BF0000;
	color: white;
}
.product-box{
	float: left;
	width: 160px;
	height: 230px;
	margin: 20px;
}
#product-list{
	width: 1200px;
	overflow: hidden;
	margin: auto;
}
body{
	background: url(body_bg_01.gif);
}
.product-box strong a{
	text-decoration: none;	
}

.product-box strong{
	float: left;
	font-size: 12px;
	font-weight: normal;
	color: #333;
	width: 160px;
	height: 20px;
	margin-top: 10px;
	line-height: 20px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.product-box .woogle-price{
	float: left;
	font-size: 18px;
	font-family: Courier New;
	font-weight: bold;
	color: #080;
	width: 160px;
}
.product-box .woogle-em{
	width: 165px;
	height: 24px;
	font-style: normal;
	font-size: 12px;
	color: #666;
	font-weight: normal;
}
.product-box img{
	width: 160px;
	height: 160px;
	display: block;
}
</style>

</head>
<?php 
header("Content-type: text/html; charset=utf-8"); 
include 'phpQuery/phpQuery.php';  
include 'pinyin.php';  

$item_attr = $_SERVER["QUERY_STRING"]; #id=5
$new_item_attr = 'http://www.go2.cn/firsthand/'.$item_attr;
phpQuery::newDocumentFile($new_item_attr);  

$tem_list = pq('#productlist')->find('.pagelist');  
$tem_list = str_replace("/firsthand/","list.php?",$tem_list);

echo $tem_list;
$companies = pq('.pagelist')->prev()->find('li');  
echo '<div id="product-list">';
foreach($companies as $company)  
{  
  $tem = pq($company)->html();  
  $tem = str_replace("?","&&",$tem);
  $tem = str_replace("/product/","item.php?",$tem);
  $tem = str_replace('<img src="/images/recomm.gif" title="推荐新款单品" align="absmiddle">',"",$tem);
  $tem_text = pq($company)->find('strong')->find('a')->text();

  $tem_text_new = explode("&",$tem_text);
  $tem_text_new = $tem_text_new[0];
  
  $tem_text_pinyin_new = Pinyin($tem_text_new);
  $tem_code = str_replace($tem_text_new,$tem_text_pinyin_new,$tem_text);
  
  $tem_content_in_file = @file_get_contents('prices/'.trim($tem_code).'.txt');
  if(substr_count($tem_content_in_file,'woogle-price') == 1){
    $tem = '<div class="product-box">'.$tem.$tem_content_in_file.'</div>';
  }else{
	$tem = '<div class="product-box">'.$tem.'<a href="http://item.taobao.com/item.htm?id=41388497386" target="_blank">联系5元代发</a></div>';
  }
  $tem = str_replace($tem_text_new,$tem_text_pinyin_new,$tem);
  echo $tem;
}  
echo '</div>';

echo $tem_list;
?> 

<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
	$(".pagelist li a").first().parent().css({"background":"#BF0000","color":"white"});
	$(".pagelist li a").first().css({"background":"#BF0000","color":"white"});
</script>






