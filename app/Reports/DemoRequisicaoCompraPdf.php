<?php
namespace App\Reports;

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
        $this->Cell(30, 5, utf8_decode('Número:'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Data:'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Tipo:'), 'LTR');

        $this->Ln();     

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $requisicao->id, 'LBR');
        $this->Cell(80, 5, Carbon::parse($requisicao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(80, 5, utf8_decode($requisicao->tipo_nome), 'LBR');

        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Requisitante:'), 'LTR');

        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->requisitante->nome), 'LBR');

        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Solicitante:'), 'LTR');

        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->solicitante->nome), 'LBR');

        $this->Ln();
        
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Veículo:'), 'LTR');

        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->veiculo->placa . ' - ' . $requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo), 'LBR');

        $this->Ln();
        
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('Itens da requisição'), 1, 0, 'C');

        $this->Ln();   

        $this->SetWidths([20, 70, 30, 40, 30]);
        $this->setBorders(['L', 'L', 'L', 'L', 'LR']);   
        $this->Row([utf8_decode('Item'), utf8_decode('Produto/Serviço'), utf8_decode('Unidade'), utf8_decode('Quantidade solicitada'), utf8_decode('Quantidade a cotar')]);
        $this->setBorders(NULL);

        $this->SetFont('Arial', '', 8);
        foreach ($requisicao->itens as $item) {
            $this->Row([$item->item, utf8_decode($item->descricao), utf8_decode($item->unidade), utf8_decode($item->quantidade_solicitada), utf8_decode($item->quantidade_a_cotar)]);
        }
        $this->Ln();
        
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Local entrega'), 'LTR');
        $this->Ln();
        
        $this->SetFont('Arial', '', 8);
        $this->SetWidths([190]);
        $this->setBorders(['RBL']);
        $this->Row([utf8_decode($requisicao->local_entrega)]);

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Autorização de cotação'), 'LTR', 0, 'C');
        $this->Ln();
        $this->MultiCell(190, 30, utf8_decode(''), 1, 'LBR');
        
    }
}

?>