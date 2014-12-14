<?php
namespace Small\ShopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class contHPController extends Controller
{
	public $list = array(array());
    public function f1Action()
    {
		$link= contHPController::dbopen();
		mysqli_query($link, "SET NAMES 'utf8'");
		contHPController::ShowTree(0, $link);
		mysqli_close($link);
        return $this->render('SmallShopBundle:Default:homeP.html.php', array('lst' => $this->list));
    }
    
    function DBopen($hostName= 'localhost', $userName= 'root', $password= '', $databaseName= 'smallstore')
	{	
		$link = mysqli_connect($hostName, $userName, $password, $databaseName);
		if (!$link) 
		{
			echo'Ошибка при соединении с MySQL!';
			exit();
		}
		return $link;
	}
	
	function ShowTree($ParentID, $link)
	{
		$Q1= "SELECT CategoryID,Name,ParCatID FROM productcategory WHERE ParCatID=$ParentID ORDER BY Name";
		$QR1= mysqli_query($link, $Q1);
		static $l = 0; $l++; static $si = 0;
		if (mysqli_num_rows($QR1) > 0) 
		{
			while ($R1= mysqli_fetch_array($QR1)) 
			{
				$this->list[$si]['nul'] = $l;
				$this->list[$si]['Name'] = $R1['Name'];
				$this->list[$si]['CategoryID'] = $R1['CategoryID'];
				$si++; contHPController::ShowTree($R1['CategoryID'], $link);
			}
		}
		$l--;
	}
}
