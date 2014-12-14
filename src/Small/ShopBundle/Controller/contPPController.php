<?php

namespace Small\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class contPPController extends Controller
{
	public $link;
	public $product = array();
	
    public function f1Action($ProductID, $ParentID, $numpage)
    {
		contPPController::dbopen();
		mysqli_query($this->link, "SET NAMES 'utf8'");
		$Q1= "SELECT ProductID, Title, Price, Description, Photo, ManufactID, CategoryID FROM product WHERE ProductID=$ProductID";
		$QR1= mysqli_query($this->link, $Q1);
		$R1= mysqli_fetch_array($QR1);
		$Q2= "SELECT ManufactID, Name FROM manufacturer WHERE ManufactID={$R1['ManufactID']}";
		$QR2= mysqli_query($this->link, $Q2);
		$R2= mysqli_fetch_array($QR2);
		$this->product['ems'] = '';
		if (array_search('m', $_GET) !== false) 
		{
			$this->product['ems'] ='&'.implode('=m&', array_keys($_GET, 'm')).'=m';
		}
		mysqli_close($this->link);
		$this->product['Title'] = $R1['Title'];
		$this->product['Price'] = $R1['Price'];
		$this->product['Description'] = $R1['Description'];
		$this->product['Photo'] = $R1['Photo'];
		$this->product['Man'] = $R2['Name'];
        return $this->render('SmallShopBundle:Default:prodP.html.php', array(
			'ParentID' => $ParentID, 'product' => $this->product, 'numpage' => $numpage));
    }
    
	function DBopen($hostName= 'localhost', $userName= 'root', $password= '', $databaseName= 'smallstore')
	{	
		$this->link = mysqli_connect($hostName, $userName, $password, $databaseName);
		if (!$this->link) 
		{
			echo'Ошибка при соединении с MySQL!';
			exit();
		}
	}
}
