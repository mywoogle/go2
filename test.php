






</head>
<?php 
header("Content-type: text/html; charset=utf-8"); 

	file_put_contents('test.txt','test1 ',FILE_APPEND);
	echo file_get_contents('test.txt');
	


?>


