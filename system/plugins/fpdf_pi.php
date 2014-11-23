<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
//Page header
function Header()
{
    //Logo
    $this->Image('img/jata-header.jpg',10,8,33);
    //Arial bold 15
    $this->SetFont('Arial','',13);
    //Move to the right
    //Title
    $this->Ln(8);
    $this->Cell(40);
    $this->Cell(0,0,'Laporan Fail Meja Elektronik Kementerian',0,0,'L');
    $this->Ln(6);
    $this->Cell(40);
    $this->SetFont('Arial','',10);
    $this->Cell(0,0,'Tarikh : '.date('d / n / Y'),0,0,'L');
/*    $this->Ln(6);
    $this->Cell(40);
    $this->SetFont('Arial','',10);
    $this->Cell(0,0,'Muka Surat : '.$this->PageNo().'/{nb}',0,0,'L');*/
    //Line break
    $this->Ln(20);
}

function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    $this->Cell(12);
    $w=array(10,140,18);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=false; 
    $bil = 1;
    foreach($data as $row)
    {
    	$this->Cell(12);
        $this->Cell($w[0],6,$bil.'.','LR',0,'C',$fill);
        $this->Cell($w[1],6,$row['dept_name'],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row['percentage'].' %','LR',0,'C',$fill);
        $this->Ln();
        $fill=!$fill;
        $bil++;
    }
    $this->Cell(12);
    $this->Cell(array_sum($w),0,'','T');
}

function PositionTable($header,$data)
{
/*    //Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Header
    //$this->Cell(5);
    $w=array(10,120,40,18);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
   
    //Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');*/
    //Data
    $fill=false; 
    $bil = 1;
    $rowLimiter = 1;
    $pgSplitter = 36;
    $w=array(10,120,40,18);
    foreach($data as $row)
    {
    	// split pages into 30 rows
    	
    	if($bil == $rowLimiter) {
    		if($rowLimiter > $pgSplitter) {
    			$this->AddPage();
    		}
    	    //Colors, line width and bold font
		    $this->SetFillColor(255,0,0);
		    $this->SetTextColor(255);
		    $this->SetDrawColor(128,0,0);
		    $this->SetLineWidth(.3);
		    $this->SetFont('','B');
		    //Header
		    //$this->Cell(5);
		    //$w=array(10,120,40,18);
		    for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		    $this->Ln();
		    $rowLimiter = $rowLimiter + $pgSplitter;
    	}
    	
    	//Color and font restoration
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    //Data
	    //$fill=false; 
    	
    	//$this->Cell(5);
        $this->Cell($w[0],6,$bil.'.','LR',0,'C',$fill);
        $this->Cell($w[1],6,$row['fullname'],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row['singkatan'],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row['completeInt'].' %','LR',0,'C',$fill);
        $this->Ln();
        $fill=!$fill;
        $bil++;
    }
    //$this->Cell(5);
    $this->Cell(array_sum($w),0,'','T');
}


//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
	


}
/*
$pdf=new PDF();
//Column titles
$header=array('Country','Capital','Area (sq km)','Pop. (thousands)');
//Data loading
$data=$pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();*/
?>
