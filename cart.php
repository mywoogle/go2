<head>
<style type="text/css">
#cart{
	background: #FDF2F2;
	padding: 20px 20px 50px 20px;
}
table{
	border: solid 1px #ccc;
	width: 800px;
	margin: auto;
	line-height: 24px;
	font-size: 18px;
}
td{
	width: 200px;
	border: solid 1px #ccc;
	vertical-align: top;
}
#cart-title{
	background: #B62A07;
	color: white;
	font-weight: bold;
}
#buy-flow,
#table-header{
	font-weight: bold;
}
a{
	text-decoration: none;
}
.cart-button{
	width: 150px;
	background: #B62A07;
	margin: 5px auto;
	height: 30px;
	line-height: 30px;
	text-align: center;
	border: 1px solid #CCC;
	color: white;
	font-weight: bold;
}

</style>

</head>
<?php 
header("Content-type: text/html; charset=utf-8"); 
?>
<div id="cart">
	<div id="cart-body">
		<div id="cart-body-content">
			<table cellpadding="2" cellspacing="0">
				<tr>
					<td colspan="4" id="cart-title">
						拿到手一共要花多少钱？
					</td>
				</tr>
				<tr id="table-header">
					<td>
						出厂价格
					</td>
					<td>
						应付邮费
					</td>
					<td>
						服务费用
					</td>
					<td>
						到手费用
					</td>
				</tr>
				<tr>
					<td>
						<span id="my-price"></span>
					</td>
					<td>
						10元起
					</td>
					<td>
						5元
					</td>
					<td>
						<a href='#'><div id="my-total" class="cart-button">获取最终费用</div></a>
					</td>
				</tr>
				<tr>
					<td>
						8天无理由退换货（没有弄脏，没有磨损，不影响第二次销售）
					</td>
					<td>
						随地区不同，邮费略有浮动，非质量问题邮费不退还。
					</td>
					<td>
						5元服务费为人工费，一律不退还。
					</td>
					<td>
						<a href='http://item.taobao.com/item.htm?id=41388497386' target="_blank"><div class="cart-button">马上去购买</div></a>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<span id="buy-flow">购买流程:</span><br>
						<ol>
							<li><a href='/buy_flow.php#step1' target="_blank">点击去求购买，到达购买代发卡的页面。</a></li>
							<li><a href='/buy_flow.php#step2' target="_blank">在购买页面，输入购买数量（购买数量=出厂价），点击立即购买。</a></</li>
							<li><a href='/buy_flow.php#step3' target="_blank">填写留言。格式为：产品网址---颜色---尺码---快递公司</a></</li>
							<li><a href='/buy_flow.php#step4' target="_blank">提交订单，并付款。</a></</li>
							<li><a href='/buy_flow.php#step5' target="_blank">提交订单，并付款。</a></</li>
						</ol>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript" src="http://lib.sinaapp.com/js/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
var tem_price=$('.woogle-price').text();
if(tem_price==''){
$('#my-price').html('<a href="http://item.taobao.com/item.htm?id=41388497386" target="_blank">联系5元代发</a>');
	$("#my-total").click(function(){
		$(this).html('<a href="http://item.taobao.com/item.htm?id=41388497386" target="_blank">联系5元代发</a>');
	});
}else{
	var price = tem_price.replace(/¥/, "")
	$('#my-price').text(price+'元');
	$("#my-total").click(function(){
		$(this).text('就'+total+'元起');
	});
}

var total = parseInt(price)+5+10;



</script>
