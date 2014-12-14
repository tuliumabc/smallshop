<html>
<head>
	<title> SmallStore </title>
	<link rel="stylesheet" href="<?php echo $view['assets']->getUrl('bundles/smallshop/css/style.css') ?>">
</head>
<body>
<center><h1>-----<?php echo ' <a href="'.$view['router']->generate('HomeP', 
			array()).'">SmallStore</a> ' ?> -----</h1></center>			
<div class="leftpanel">
<form action="<?php echo $view['router']->generate('MainP', 
	array('ParentID' => $ParentID, 'numpage'=> 1)) ?>" method="GET">
	Цена: <br>от <input type="text" name="prmin" value="<?php echo $prmin ?>" size="8%"> до
	<input type="text" name="prmax" value="<?php echo $prmax ?>" size="8%"> грн.<br><br>
	<?php
	for($i = 0; $i < count($filters); $i++)
		echo '<input type="checkbox" name="'.$filters[$i]['ManufactID'].'" value="m"'.
			($filters[$i]['checked'] ? ' checked' : '').'>'.$filters[$i]['Name'].'<br>';		
	?>
	<br><input type="submit" value="Отфильтровать">
</form>	
</div>
<div class="main">
	<i>Выбраны товары из категории:</i> <b><?php echo $curcat ?></b><br>
	<?php
	if (isset($products[0]['ProductID'])) 
	{
		for ($i=0; $i <count($products); $i++)
		{
			echo '<li><a href="'.$view['router']->generate('ProdP', 
				array('ProductID' => $products[$i]['ProductID'],'ParentID' => $ParentID,
				'numpage'=> $numpage, 'prmin' => $_GET['prmin'], 'prmax' => $_GET['prmax'])).
				$products[$i]['ems'].'">'.$products[$i]['Title'].'</a><br>';
			echo '<b><i>цена: </i></b>'.$products[$i]['Price'].' грн.<br>'.
				$products[$i]['Description'].'...<br>';
			echo '<img src="'.$view['assets']->getUrl("bundles/smallshop/images/{$products[$i]['Photo']}").'" height="70"><br><br>';
		}
	}
	?>
	<center><h2>
	<?php
	for($i=1; $i <= count($tpages); $i++)
	{
		if ($i == $numpage) echo $i;
		else echo '<a href="'.$view['router']->generate('MainP', 
				array('ParentID' => $ParentID, 'numpage'=> $i, 'prmin' => $prmin,
				'prmax' => $prmax)).$tpages[$i].'">'.$i.'</a>';
		echo ' ';
	}
	?>
	</h2></center>
</div>
</body>
</html>
