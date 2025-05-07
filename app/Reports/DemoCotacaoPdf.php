<?php

namespace App\Reports;

use App\Cotacao;
use App\Reports\ReportPdf;
use App\RequisicaoCompra;
use Illuminate\Support\Carbon;

class DemoCotacaoPdf extends ReportPdf
{

    public function __construct($title)
    {
        parent::__construct($title);
    }

    public function Header()
    {
        if ($this->isHeader) {

            $x1 = $this->GetX();
            $y1 = $this->GetY();

            if ($this->logo) {
                $this->Image($this->logo, 12, 12, 30, 20);
            }

            $this->SetFont('Arial', 'B', 12);
            if ($this->getTitleHeader() != "") {
                $this->Ln(5);
                $this->Cell(190, 5, $this->getTitleHeader(), 0, 1, 'C');
                $this->Ln(5);
            }
            $this->Rect($x1, $y1, 190, 20);
            $this->Ln();
        }
    }

    public function setContent(Cotacao $cotacao)
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 5, utf8_decode('Número'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Data'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Finalizada'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $cotacao->id, 'LBR');
        $this->Cell(80, 5, Carbon::parse($cotacao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(80, 5, utf8_decode(($cotacao->finaliza) ? "Sim" : "Não"), 'LBR');
        $this->Ln();

        //Aqui dados da requisição
        
        
        //Aqui fornecedores da cotação, quandou houver fornecedores
        if ($cotacao->fornecedores->count() > 0) {

            foreach ($cotacao->fornecedores as $fornecedor) {
                
                foreach ($cotacao->fornecedores->itens as $item) {

                }
            }


        }

        //Aqui fornecedore vecedor(es), quando a cotação estiver finalizada
        if ($cotacao->finalizada) {

            foreach ($cotacao->fornecedoresVencedores as $fornecedor) {

            }
        }


    }
}
