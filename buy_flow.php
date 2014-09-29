<head>
<style type="text/css">
#buy-flow{
	width: 1210px;
	margin: 50px auto;
}
li{
	padding: 20px 0;
}
</style>
</head>
<?php 
header("Content-type: text/html; charset=utf-8"); 
include 'header.php'; 
?>
<div id="buy-flow">
下面以购买一双出厂价61元，黑色，35码，发中通的鞋子做为例子，来描述购物流程。(http://5yuandaifa.cn/item.php?ogcksg.go&&_page=fh_1&_cat=all&_pos=3&_type=img)
<ol>
	<li>
		<a name="step1">点击去求购买，到达购买代发卡的页面。</a><br>
		<img src="/images/buy_flow1.jpg"/>
	</li>
	<li>
		<a name="step1">在购买页面，输入购买数量（购买数量=出厂价），点击立即购买。</a><br>
		<img src="/images/buy_flow2.jpg"/>
	</li>
	<li>
		<a name="step3">填写留言。格式为：产品网址---颜色---尺码---快递公司</a><br>
		<img src="/images/buy_flow3.jpg"/>
	</li>
	<li>
		<a name="step4">提交订单，并付款。</a>
	</li>
	<li>
		<a name="step5">我们检查打包发货。</a>
	</li>
</ol>

</div>

<?php
include 'footer.php'; 
?> 

<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">

	$(".pagelist li a").each(function(){
		if($(this).attr('href')=='list.php'+window.location.search){
			$(this).parent().css({"background":"#BF0000","color":"white"});
			$(this).css({"background":"#BF0000","color":"white"});
		}
	});

</script>