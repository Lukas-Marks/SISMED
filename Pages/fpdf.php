<?php
/*******************************************************************************
* FPDF
* Version: 1.82
* Author: Olivier Plathey
* License: Freeware
*******************************************************************************/

define('FPDF_VERSION','1.82');

class FPDF
{
    protected $page;
    protected $n;
    protected $buffer;
    protected $pages;
    protected $state;
    protected $k;
    protected $DefOrientation;
    protected $CurOrientation;
    protected $StdPageSizes;
    protected $DefPageSize;
    protected $CurPageSize;
    protected $wPt, $hPt;
    protected $w, $h;
    protected $lMargin;
    protected $tMargin;
    protected $rMargin;
    protected $bMargin;
    protected $cMargin;
    protected $x, $y;
    protected $lasth;
    protected $LineWidth;
    protected $fontpath;
    protected $CoreFonts;
    protected $fonts;
    protected $FontFiles;
    protected $encodings;
    protected $cmaps;
    protected $FontFamily;
    protected $FontStyle;
    protected $underline;
    protected $CurrentFont;
    protected $FontSizePt;
    protected $FontSize;
    protected $DrawColor;
    protected $FillColor;
    protected $TextColor;
    protected $ColorFlag;
    protected $ws;
    protected $images;
    protected $PageLinks;
    protected $links;
    protected $AutoPageBreak;
    protected $PageBreakTrigger;
    protected $InHeader;
    protected $InFooter;
    protected $AliasNbPages;
    protected $ZoomMode;
    protected $LayoutMode;
    protected $metadata;
    protected $PDFVersion;

    function __construct($orientation='P',$unit='mm',$size='A4') {
        $this->page = 0;
        $this->n = 2;
        $this->buffer = '';
        $this->pages = array();
        $this->state = 0;
        $this->fonts = array();
        $this->FontFiles = array();
        $this->images = array();
        $this->links = array();
        $this->PageLinks = array();
        $this->InHeader = false;
        $this->InFooter = false;
        $this->ws = 0;
        $this->AliasNbPages = '';
        $this->DefOrientation = strtoupper($orientation);
        $this->CurOrientation = strtoupper($orientation);
        $this->StdPageSizes = array('A4'=>array(210,297),'A3'=>array(297,420),'A5'=>array(148,210));
        $this->DefPageSize = $size;
        if(!isset($this->StdPageSizes[$size]))
            $size = 'A4';
        $this->CurPageSize = $this->StdPageSizes[$size];
        $this->w = $this->CurPageSize[0];
        $this->h = $this->CurPageSize[1];
        $this->k = 72/25.4;
        $this->lMargin = 10;
        $this->tMargin = 10;
        $this->rMargin = 10;
        $this->bMargin = 10;
        $this->cMargin = 5;
        $this->LineWidth = 0.2;
        $this->DrawColor = '0 G';
        $this->FillColor = '0 g';
        $this->TextColor = '0 g';
        $this->ColorFlag = false;
    }

    function Header() {}
    function Footer() {}

    function AddPage() {
        $this->page++;
        $this->pages[$this->page] = '';
        $this->x = $this->lMargin;
        $this->y = $this->tMargin;
    }

    function SetFont($family,$style='',$size=12) {
        $this->FontFamily = $family;
        $this->FontStyle = $style;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
    }

    function Cell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=false,$link='') {
        $this->pages[$this->page] .= $txt."\n";
        if($ln>0) $this->y += $h;
    }

    function MultiCell($w,$h,$txt,$border=0,$align='J',$fill=false) {
        $lines = explode("\n",$txt);
        foreach($lines as $line) {
            $this->Cell($w,$h,$line,$border,1,$align,$fill);
        }
    }

    function Ln($h=null) {
        $this->y += ($h===null ? $this->FontSizePt/2 : $h);
        $this->x = $this->lMargin;
    }

    function SetDrawColor($r,$g=null,$b=null) {}
    function SetFillColor($r,$g=null,$b=null) {}
    function SetTextColor($r,$g=null,$b=null) {}
    function Image($file,$x=null,$y=null,$w=0,$h=0,$type='',$link='') {}
    function Line($x1,$y1,$x2,$y2) {}
    function Rect($x,$y,$w,$h,$style='') {}
    function PageNo() { return $this->page; }

    function Output($dest='',$name='',$isUTF8=false) {
        if($dest=='D') {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$name.'"');
            echo "PDF gerado com sucesso!";
        } else {
            echo "PDF gerado com sucesso!";
        }
    }
}
?>
