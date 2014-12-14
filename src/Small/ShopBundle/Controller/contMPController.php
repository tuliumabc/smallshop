<?php
namespace Small\ShopBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class contMPController extends Controller
{
	const PP= 5;
	const DCUT= 45;
	public $link;
	public $filters = array(array());
	public $tpages = array();
	public $products = array(array());
	public $prodi = 0;
	
    public function f1Action($ParentID, $numpage)
    {
		$GLOBALS['globprod']= 1;
		contMPController::dbopen();
		mysqli_query($this->link, "SET NAMES 'utf8'");
		$QR3= mysqli_query($this->link, "SELECT Name FROM productcategory WHERE CategoryID=$ParentID");
		$R3= mysqli_fetch_array($QR3);
		$curcat = ($R3 ? $R3['Name'] : 'все товары');
		contMPController::mkfilter();
		contMPController::ShowProd($ParentID, $numpage);
		contMPController::FormCatID($ParentID, $numpage);
		contMPController::gettpages($numpage);
		mysqli_close($this->link);
		return $this->render('SmallShopBundle:Default:mainP.html.php', 
			array('ParentID' => $ParentID, 'numpage'=> $numpage,
				'prmin' => $_GET['prmin'], 'prmax' => $_GET['prmax'],
				'curcat' => $curcat, 'filters' => $this->filters,
				'tpages' => $this->tpages, 'products' => $this->products));
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
	
	function mkfilter()
	{
		$Q2= 'SELECT ManufactID, Name FROM manufacturer';
		$QR2= mysqli_query($this->link, $Q2);
		static $i = 0;
		if (mysqli_num_rows($QR2) > 0) 
		{
			while ($R2= mysqli_fetch_array($QR2)) 
			{
				$this->filters[$i]['ManufactID'] = $R2['ManufactID'];
				$this->filters[$i]['Name'] = $R2['Name'];
				$this->filters[$i]['checked'] = ((array_search($R2['ManufactID'],
					array_keys($_GET, 'm')) === false ? false : true));
				$i++;
			}
		}
	}
	
	function gettpages($numpage)
	{
		$totalpage= ceil(($GLOBALS['globprod']-1)/contMPController::PP);
		for($n=1; $n<=$totalpage; $n++)
		{
			$this->tpages[$n] = '';
			if (array_search('m', $_GET) !== false) 
			{
				$this->tpages[$n] = '&'.implode('=m&', array_keys($_GET, 'm')).'=m';
			}
		}
	}
    
    function FormCatID($ParentID, $numpage)
	{
		$Q1= "SELECT CategoryID, Name, ParCatID FROM productcategory WHERE ParCatID=$ParentID ORDER BY Name";
		$QR1= mysqli_query($this->link, $Q1);
		if (mysqli_num_rows($QR1) > 0) 
		{
			while ($R1= mysqli_fetch_array($QR1)) 
			{
				contMPController::ShowProd($R1['CategoryID'], $numpage);
				contMPController::FormCatID($R1['CategoryID'], $numpage);
			}
		}
	}

	function ShowProd($CategoryID, $numpage)
	{
		$Q2= "SELECT ProductID, Title, Price, Description, Photo, ManufactID, CategoryID FROM product WHERE CategoryID=$CategoryID ORDER BY Title";
		$QR2= mysqli_query($this->link, $Q2);
		if (mysqli_num_rows($QR2) > 0) 
		{
			$imin= ($numpage-1)*contMPController::PP+1;
			$imax= $numpage*contMPController::PP;
			while ($R2= mysqli_fetch_array($QR2)) 
			{
				$Fprmin= ($_GET['prmin']!='не указано' ? $R2['Price']>=$_GET['prmin'] : true);  
				$Fprmax= ($_GET['prmax']!='не указано' ? $R2['Price']<=$_GET['prmax'] : true);			
				$Fman= (array_search('m', $_GET)!== false ? array_key_exists($R2['ManufactID'], $_GET) : true);
				if ($Fman and $Fprmin and $Fprmax)
				{
					if ($GLOBALS['globprod']>=$imin and $GLOBALS['globprod']<=$imax)
					{
						$this->products[$this->prodi]['ems']= '';
						if (array_search('m', $_GET) !== false) 
						{
							$this->products[$this->prodi]['ems'] ='&'.implode('=m&', array_keys($_GET, 'm')).'=m';
						}
						$this->products[$this->prodi]['ProductID'] = $R2['ProductID'];
						$this->products[$this->prodi]['Title'] = $R2['Title'];
						$this->products[$this->prodi]['Description'] =
							mb_substr($R2['Description'], 0, contMPController::DCUT,'UTF-8');
						$this->products[$this->prodi]['Price'] = $R2['Price'];
						$this->products[$this->prodi]['Photo'] = $R2['Photo'];
						$this->prodi++;
					}
					$GLOBALS['globprod']++;
				}							
			}
		}
	}
}
