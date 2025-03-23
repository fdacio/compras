<?php
namespace App\Reports;

use App\Helpers\Formatter;
use App\Reports\ReportPdf;
use App\RequisicaoCompra;
use Illuminate\Support\Carbon;

class DemoRequisicaoCompraPdf extends ReportPdf
{

    public function __construct($title)
    {
        parent::__construct($title);
    }

    public function setContent(RequisicaoCompra $requisicao)
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 5, utf8_decode('ID'), 'LTR');
        $this->Cell(50, 5, utf8_decode('Tipo'), 'LTR');
        $this->Cell(50, 5, utf8_decode('Número'), 'LTR');
        $this->Cell(30, 5, utf8_decode('Emissão'), 'LTR');
        $this->Cell(40, 5, utf8_decode('Valor'), 'LTR');
        $this->Ln();       
        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 5, $requisicao->id, 'LBR');
        $this->Cell(50, 5, utf8_decode($requisicao->tipo->nome), 'LBR');
        $this->Cell(50, 5, $requisicao->numero, 'LBR');
        $this->Cell(30, 5, Carbon::parse($requisicao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(40, 5, 'R$ ' . number_format($requisicao->valor, 2, ',', '.'), 'LBR');
        $this->Ln();


        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('Itens do Contrato'), 1, 0, 'C');
        $this->Ln();   
        $this->SetWidths([15, 55, 30, 30, 20, 20, 20]);
        $this->setBorders(['L', 'L', 'L', 'L', 'L', 'L', 'R']);   
        $this->Row([utf8_decode('Item'), utf8_decode('Produto'), utf8_decode('Unidade'), utf8_decode('Marca'), utf8_decode('Quantidade'), utf8_decode('Vr.Unitário'), utf8_decode('Vr.Total')]);
        $this->SetAligns(['L', 'L', 'L', 'L', 'R', 'R', 'R']);
        //$this->setBorders(['L', '0', '0', '0', '0', 'R']);        
        $this->setBorders(NULL);
        $totalGeral = 0;
        $nItem = 0;
        $this->SetFont('Arial', '', 8);
        foreach ($requisicao->produtos as $produto) {
            $totalGeral += ($produto->pivot->quantidade * $produto->pivot->valor_unitario);
            $nItem++;
            $this->Row([$produto->pivot->item, utf8_decode($produto->nome), utf8_decode($produto->unidade->nome), utf8_decode($produto->marca->nome), ($produto->pivot->quantidade), Formatter::valorUnitario($produto->pivot->valor_unitario), 'R$ ' . number_format(($produto->pivot->valor_unitario * $produto->pivot->quantidade), 2, ',', '.') ]);
        }
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(100, 5, utf8_decode("Total de {$nItem} itens"), 'LTB', 0, 'L');
        $this->Cell(70, 5, utf8_decode('Total Geral'), 'TB', 0, 'R');
        $this->Cell(20, 5,'R$ ' . number_format($totalGeral, 2, ',', '.'), 1, 0, 'R');
        $this->Ln();
        
    }
}

?>