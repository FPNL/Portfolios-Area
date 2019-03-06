<!DOCTYPE html>
<html lang="zh-TW">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}	
		body{

			background-image: url(img/bg.jpg);
			background-size: cover;
			background-repeat: no-repeat;
			background-attachment: fixed;
			}
		#review{
			margin: auto auto;
			margin-top: 200px;
			width: 500px;
			border: 2px solid  #a31901;
			border-radius: 3px;
			text-align: center;
			line-height: 30px;
		}
	</style>
</head>
<body>
	<!-- <div id="content"> -->
		<div id="review" class="">
		你竟然 <?php echo $_GET["zhfood01like"]; ?> 麻婆豆腐 <br>

		那你也許 <?php echo $_GET["zhfood02like"]; ?> 日式照燒烤肉醬 <br>

		所以番茄滑蛋你	<?php echo $_GET["zhfood03like"]; ?>囉!?
		</div>
	<!-- </div> -->
</body>
</html>