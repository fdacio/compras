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
        
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(100, 5, utf8_decode('Veículo'), 'LTRB', 0, 'C');
        $this->Ln();

        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode('Ano:'), 'LTR');
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($requisicao->veiculo->ano), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode('Placa:'), 'LTR');
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($requisicao->veiculo->placa), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode('Chassi:'), 'LTR');
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($requisicao->veiculo->chassi), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode('Cidade:'), 'LTR');
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($requisicao->veiculo->centroCusto->nome), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode('Empresa:'), 'LTR');
        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($requisicao->veiculo->empresa->pessoa->nomeRazaoSocial), 'LTR');
        $this->Ln();

        $this->SetXY($x + 100, $y - 5);
        $this->SetFont('Arial', 'B', 10);
        if ($requisicao->urgente) {
            $this->MultiCell(90, 30, utf8_decode('URGENTE'), 'LTRB', 'C');
        } else {   
            $this->MultiCell(90, 30, utf8_decode(''), 'LTRB', 'C');
        }


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
        
        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetFillColor(190, 190, 190);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 5, utf8_decode('Autorização de cotação'), 'LTR', 0, 'C', true);
        $this->Cell(10, 5, '', 0);
        $this->Cell(90, 5, utf8_decode('Local entrega'), 'LTR', 0, 'C', true);
        $this->Ln();
        
        $this->SetFont('Arial', '', 6);
        $this->MultiCell(90, 30, utf8_decode(''), 'LTRB', 'L');
        $this->SetXY($x + 90, $y + 5);
        $this->Cell(10, 5, '', 0);
        $this->MultiCell(90, 30, utf8_decode($requisicao->local_entrega), 'LTRB', 'L');
        $this->Ln();
        
    }
}

?>