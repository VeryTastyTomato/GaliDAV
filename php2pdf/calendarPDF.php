<?php

//Generate a PDF documment with EDT datas

require_once('phpToPDF.php');

class calendarPDF extends phpToPDF
{

	//attributes
	public $version = null;
	//methods
	//builders
	public function __construct()//paramètre EDTClasse à ajouter ensuite
	{
		parent::FPDF('P','cm','Letter');
	}

	public function drawEDT() //EDTClasse parameter to take from EDTClasse
	{
		$title = 'Informatique 2eme annee';//to auto take
		$version = '31 mars 2015';//to auto take from Modification
		$this->AddPage();
		//title + version display
		$this->drawTitle($title,$version);
		
		for($w = 0; $w < 4; $w++)
		{
			//1 week
			$this->drawWeek($w);
		}		
		//pdf display
		$this->Output();
	}

	public function drawTitle($title, $version)
	{
		$this->SetFont("Courier","B",16);
		$this->Cell(0,0.5,$title,0,2,'C');//title
		$this->SetFont("Courier","I",12);
		$this->Cell(0,0.4,'Version du '.$version,0,1,'C');//version
	}

	public function drawWeek($w)//à passer : nème semaine sur la page
	{

		$this->SetFont('Courier','B',6);
		$this->SetY(2+5.8*$w);
		//time slots
		$this->MultiCellTable(2,0.5,"Semaine du \n ../..  \n au \n ../..",1,'C','M',0,3.8);

		//hours display
		$this->SetXY(3,2+5.8*$w);
		$this->Cell(1.7,0.4,"Horaires",1,2,'C');
		$this->Cell(1.7,1,"8h30 - 10h",1,2,'C');
		$this->Cell(1.7,1,"10h15-11h45",1,2,'C');
		$this->Cell(1.7,0.4,"12h - 13h30",1,2,'C');
		$this->Cell(1.7,1,"13h45-15h15",1,2,'C');
		$this->Cell(1.7,1,"15h30-17h",1,2,'C');
		$this->Cell(1.7,1,"17h15-19h45",1,0,'C');

		for($d=0; $d<5; $d++)
		{
			//origin for courses table
			$this->SetXY(4.7+$d*3,2+5.8*$w);
			//which day ?
			switch ($d) {
				case 0:
					$this->Cell(3,0.4,"Lundi ../..",1,2,'C');
					break;
				case 1:
					$this->Cell(3,0.4,"Mardi ../..",1,2,'C');
					break;
				case 2:
					$this->Cell(3,0.4,"Mercredi ../..",1,2,'C');
					break;
				case 3:
					$this->Cell(3,0.4,"Jeudi ../..",1,2,'C');
					break;
				case 4:
					$this->Cell(3,0.4,"Vendredi ../..",1,2,'C');
					break;
			}
			$this->SetFillColor(255,0,0);
			$this->MultiCell(3,0.33,"Zizi\nCM1\nG107",1,'C',1);
			$this->SetXY(4.7+$d*3,3.4+5.8*$w);
			$this->MultiCell(3,0.33,"Zizi\nTD1\nG107",1,'C',0);
			$this->SetXY(4.7+$d*3,4.4+5.8*$w);
			$this->MultiCell(3,0.39,"Lunch",1,'C',0);
			$this->SetXY(4.7+$d*3,4.8+5.8*$w);
			$this->MultiCell(3,0.33,"Zizi\nCM2\nG107",1,'C',0);
			$this->SetXY(4.7+$d*3,5.8+5.8*$w);
			$this->MultiCell(3,0.33,"Zizi\nTD2\nG107",1,'C',0);
			$this->SetXY(4.7+$d*3,6.8+5.8*$w);
			$this->MultiCell(3,0.33,"Zizi (Info)\nTP1\nG107",1,'C',0);
		}
	}
}




/* Solution with table : too complicated I think
		$tableType = array(
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0,
			'TB_ALIGN' => 'C',
			'L_MARGIN' => 2,
		);
		$headerType = array(
			'T_COLOR' => array(128,255,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Courier',
			'T_ALIGN_COL0' => 'C',
			'T_ALIGN' => 'C', //doesn't work ?
			'V_ALIGN' => 'M',
			'T_TYPE' => 'B',
			'LN_SIZE' => 0.4,
			'BG_COLOR_COL0' => array(0, 0, 0),
			'BG_COLOR' => array(0, 0, 0),
			'BRD_COLOR' => array(204,0,0),
			'BRD_SIZE' => 0,
			'BRD_TYPE' => 1,
			'BRD_TYPE_NEW_PAGE' => '',
		);
		$headerDatas = array(
			3, 3, 3, 3, 3,
			"Lundi ../..", "Mardi ../..", "Mercredi ../..", "Jeudi ../..", "Vendredi ../.."
		);
		$datasType = array(
			'T_COLOR' => array(0,0,0),
			'T_SIZE' => 8,
			'T_FONT' => 'Courier',
			'T_ALIGN_COL0' => '', //doesn't work ?
			'T_ALIGN' => '', //doesn't work ?
			'V_ALIGN' => 'B',
			'T_TYPE' => '',
			'LN_SIZE' => 1,
			'BG_COLOR_COL0' => array(0, 102, 204),
			'BG_COLOR' => array(0, 102, 204),
			'BRD_COLOR' => array(0,0,0),
			'BRD_SIZE' => 0,
			'BRD_TYPE' => 1,
			'BRD_TYPE_NEW_PAGE' => '',
		);	
		$datas = array("zizi1","","ziziFestif","","","",
			"zizi2","","","",
			"Pause dejeuner. Bon app les gens !","COLSPAN2","COLSPAN2","COLSPAN2","COLSPAN2");
		$this->drawTableau($this, $tableType, $headerType, $headerDatas, $datasType, $datas);
*/

?>
