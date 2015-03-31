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
		
		/*
		$titletemp = "EDT Info2"; //titre à récup dans $edt ?
		$version = "version du 30 mars 2015"; //à récup grâce à la classe Modification (?)

		//hours display size 
		$hourdisplayhg = 1;
		$hourdisplaywd = 2;
		//cells size (1 course) (cm)
		$edtcellheight = $hourdisplayhg;
		$edtcellwidth = 3.5;

		//pdf creation
		$pdf = new FPDF("P","cm","Letter");
		$pdf->SetTitle($titletemp, true);
		$pdf->AddPage();

		//writing of title & date version
		$pdf->SetFont("Courier","B",16);
		$pdf->Cell(0,0.5,$titletemp,0,2,'C');//title
		$pdf->SetFont("Courier","I",12);
		$pdf->Cell(0,0.4,$version,0,1,'C');//version

		for ($i = 0; $i < 4; $i++)
		{
			//1 week
			//descritpion of table properties
			$tableProperties = ;	
			$this->pdf->SetFont("Courier","B",8);
			$this->pdf->Cell($hourdisplaywd,5*$hourdisplayhg + 0.8,"Semaine du ...",1,0,'C');
			$this->pdf->Cell($hourdisplaywd,$hourdisplayhg,"8h30 - 10h",1,2,'C');
			$this->pdf->Cell($hourdisplaywd,$hourdisplayhg,"10h15-11h45",1,2,'C');
			$this->pdf->Cell($hourdisplaywd,0.8,"12h - 13h30",1,2,'C');
			$this->pdf->Cell($hourdisplaywd,$hourdisplayhg,"13h45-15h15",1,2,'C');
			$this->pdf->Cell($hourdisplaywd,$hourdisplayhg,"15h30-17h",1,2,'C');
			$this->pdf->Cell($hourdisplaywd,$hourdisplayhg,"17h15-19h45",1,1,'C');
		}
		//timetable display
		$this->pdf->Rect($this->pdf->x,$this->pdf->y,5*$edtcellwidth,5*$edtcellheight);
		
		//pdf display (in the browser)
		$pdf->Output();	*/
	}

	public function drawEDT() //EDTClasse parameter to take from EDTClasse
	{
		$title = 'Informatique 2eme annee';//to auto take
		$version = '31 mars 2015';//to auto take from Modification
		$this->AddPage();
		//title + version display
		$this->drawTitle($title,$version);
		
		//1 week
		$this->drawWeek();
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

	public function drawWeek()//à passer : nème semaine sur la page
	{
	//BORDEL par tableau ça me paraît pas possible -> je repasse par une construction cellule par cellule (avec MultiCellTable cette fois)
		$this->SetFont('Courier','B',6);
		$this->SetY(2);
		//time slots
		$this->MultiCellTable(2,0.5,"Semaine du ../.. au ../..",1,'J','M',0,4.8);
		$this->SetXY(3,2);
		$this->Cell(2,0.4,"Horaires",1,2,'C');
		$this->Cell(2,1,"8h30 - 10h",1,2,'C');
		$this->Cell(2,1,"10h15-11h45",1,2,'C');
		$this->Cell(2,0.4,"12h - 13h30",1,2,'C');
		$this->Cell(2,1,"13h45-15h15",1,2,'C');
		$this->Cell(2,1,"15h30-17h",1,2,'C');
		$this->Cell(2,1,"17h15-19h45",1,0,'C');

		//origin for courses table
		$this->SetXY(8,2);
		//courses & days
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
	}
}

?>
