<html>
<head>
	<title> SmallStore </title>
	<link rel="stylesheet" href="http://localhost/SmallStore/web/bundles/smallshop/css/style.css">
</head>
<body>
<center><h1>----- <?php echo '<a href="'.$view['router']->generate('HomeP', 
			array()).'">SmallStore</a>' ?> -----</h1></center>	
<?php
echo('<li>'.$product['Title'].'<br>');
echo('<li><b><i>цена:</b></i> '.$product['Price'].' грн.<br>');
echo('<li>'.$product['Description'].'<br>');
echo('<li><i><b>производитель:</b></i> '.$product['Man'].'<br>');
echo('<img src="'.$view['assets']->getUrl("bundles/smallshop/images/{$product['Photo']}").
	'" height="300"><br>');	
echo '<center><h2> <a href="'.$view['router']->generate('MainP', 
	array('ParentID' => $ParentID, 'numpage'=> $numpage,
	'prmin'=>$_GET['prmin'], 'prmax'=>$_GET['prmax'])).$product['ems'].'">Назад</a> </h2></center>';
?>
</body>
</html>
