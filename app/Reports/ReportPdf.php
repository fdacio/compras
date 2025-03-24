<?php

namespace App\Reports;

use Crabbly\Fpdf\Fpdf;
use Exception;

abstract class ReportPdf extends Fpdf
{

    protected $isHeader = true;

    protected $isFooter = true;

    protected $isLogo = true;

    protected $isFilter = false;

    protected $titleHeader;

    protected $filtros;

    protected $orientation = 'P';

    protected $pageSize = 'A4';

    protected $widths;

    protected $aligns;

    protected $borders;

    protected $fill = false;

    protected $fontes;

    protected $header1 = '';
    protected $header2 = '';
    protected $logo;

    public function __construct($title = null)
    {
        parent::__construct($this->orientation, "mm", $this->pageSize);
        $this->logo = "";
        //$this->logo =  asset('public/img/logo-sistema-compras.png');
        $this->header1 = '';
        $this->header2 = '';
        $this->setTitleHeader(utf8_decode($title));
        $this->SetAuthor('Gestor');
        $this->SetCreator('Gestor');
        $this->SetTitle('Gestor');
        $this->AliasNbPages();
        $this->AddPage();
    }

    public function setIsHeader($boolean)
    {
        $this->isHeader = $boolean;
    }

    public function getIsHeader()
    {
        return $this->isHeader;
    }

    public function setIsFooter($boolean)
    {
        $this->isFooter = $boolean;
    }

    public function getIsFooter()
    {
        return $this->isFooter;
    }

    public function setLogo($boolean)
    {
        $this->isLogo = $boolean;
    }

    public function getLogo()
    {
        return $this->isLogo;
    }

    protected function setTitleHeader($titleHeader)
    {
        $this->titleHeader = $titleHeader;
    }

    protected function getTitleHeader()
    {
        return $this->titleHeader;
    }

    public function setFiltros($filtros)
    {
        $this->filtros = $filtros;
    }

    public function getFiltros()
    {
        return $this->filtros;
    }

    public function setIsFilter($boolean)
    {
        $this->isFilter = $boolean;
    }

    public function getIsFilter()
    {
        return $this->isFilter;
    }

    // Page header
    public function Header()
    {
        if ($this->isHeader) {

            $x1 = $this->GetX();
            $y1 = $this->GetY();

            if ($this->logo) {
                $this->Image($this->logo, 12, 12, 30, 20);
            }

            $this->SetFont('Arial', 'B', 12);
            $this->Ln(3);
            $this->setX(45);
            $this->Cell(140, 5, utf8_decode($this->header1), 0, 1, 'L');
            $this->setX(45);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(140, 5, utf8_decode($this->header2), 0, 1, 'L');
            $this->Ln();
            $this->SetFont('Arial', 'B', 12);
            if ($this->getTitleHeader() != "") {
                $this->Cell(190, 5, $this->getTitleHeader(), 0, 1, 'C');
                $this->Ln(5);
            }

            $y2 = $this->GetY();
            $this->Rect($x1, $y1, 190, $y2 - $y1);

            $this->Ln();
        }
    }

    public function Filter()
    {
        if ($this->isFilter) {
            $this->SetFont('Arial', '', 8);
            foreach ($this->filtros as $key => $value) {
                $this->Cell(40, 5, utf8_decode($key), '1');
                $this->SetX(50);
                $this->Cell(150, 5, utf8_decode($value), '1');
                $this->Ln();
            }
            $this->Ln();
        }
    }

    public function Footer()
    {
        if ($this->isFooter) {
            $this->SetY(-15);
            $this->SetFont('Arial', '', 8);
            $this->Cell(95, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 'T', 0, 'L');
            date_default_timezone_set('America/Fortaleza');
            $dataLocal = date('d/m/Y H:i', time());
            $this->Cell(95, 10, $dataLocal, 'T', 0, 'R');
        }
    }

    public function download($filename = 'report.pdf', $option = 'I')
    {
        try {
            ob_end_clean();
        } catch (Exception $e) {}
        
        $this->Output($option, $filename);
    }

    public function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    public function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    public function setBorders($b)
    {
        $this->borders = $b;
    }

    public function SetFontes($fontes)
    {
        $this->fontes = $fontes;
    }

    public function SetFill($fill)
    {
        $this->fill = $fill;
    }

    public function GetFill()
    {
        return $this->fill;
    }

    public function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        $fill = $this->GetFill();
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            if(isset($this->fontes)) {
                $this->SetFont($this->fontes[$i][0], $this->fontes[$i][1], $this->fontes[$i][2]);
            }

            //Draw the border
            if (isset($this->borders)) {
                $this->MultiCell($w, 5, $data[$i], $this->borders[$i], $a, $fill);
            } else {
                $this->Rect($x, $y, $w, $h);
                //Print the text
                $this->MultiCell($w, 5, $data[$i], 0, $a, $fill);
                //Put the position to the right of the cell
            }
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    public function Circle($x, $y, $r, $style = 'D')
    {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    public function Ellipse($x, $y, $rx, $ry, $style = 'D')
    {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x + $rx) * $k,
            ($h - $y) * $k,
            ($x + $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x + $lx) * $k,
            ($h - ($y - $ry)) * $k,
            $x * $k,
            ($h - ($y - $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $lx) * $k,
            ($h - ($y - $ry)) * $k,
            ($x - $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x - $rx) * $k,
            ($h - $y) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x - $lx) * $k,
            ($h - ($y + $ry)) * $k,
            $x * $k,
            ($h - ($y + $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x + $lx) * $k,
            ($h - ($y + $ry)) * $k,
            ($x + $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x + $rx) * $k,
            ($h - $y) * $k,
            $op
        ));
    }
}
