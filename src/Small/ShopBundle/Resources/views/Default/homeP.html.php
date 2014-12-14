<html>
<head>
	<title> SmallStore </title>
</head>
<body>
<center><h1>----- SmallStore -----</h1></center>	
<?php
echo '<a href="'.$view['router']->generate('MainP', 
	array('ParentID' => 0, 'numpage'=> 1, 'prmin'=>'не указано',
	'prmax'=>'не указано')).'"> Все товары</a>';
for ($i= 0; $i < count($lst); $i++) 
{
	for ($j = 0; $j < $lst[$i]['nul']; $j++) echo '<ul>';
	echo '<li><a href="'.$view['router']->generate('MainP', 
		array('ParentID' => $lst[$i]['CategoryID'], 'prmin'=>'не указано',
		'prmax'=>'не указано')).'">'.$lst[$i]['Name'].'</a>';
	for ($j = 0; $j < $lst[$i]['nul']; $j++) echo '</ul>';
}
?>
</body>
</html>
