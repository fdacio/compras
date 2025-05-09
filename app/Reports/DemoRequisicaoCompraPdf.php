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

    public function setContent(RequisicaoCompra $requisicao)
    {
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 5, utf8_decode('Número'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Data'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Tipo'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $requisicao->id, 'LBR');
        $this->Cell(80, 5, Carbon::parse($requisicao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(80, 5, utf8_decode($requisicao->tipo_nome), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Contrato'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->empresa->pessoa->nome_razao_social), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Centro de Custo'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->requisitante->nome), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Solicitante'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($requisicao->solicitante->nome), 'LBR');
        $this->Ln();

        if ($requisicao->veiculo) {

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 5, utf8_decode('DADOS DO VEÍCULO'), 'LTRB', 0, 'C');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Ano:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->ano), 'LTR');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Placa:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->placa), 'LTR');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Marca/Modelo:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->marca . ' - ' . $requisicao->veiculo->modelo), 'LTR');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Chassi:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->chassi), 'LTR');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Cidade:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->centroCusto->nome), 'LTR');
            $this->Ln();

            $this->SetFont('Arial', 'B', 8);
            $this->Cell(30, 5, utf8_decode('Empresa:'), 'LTR');
            $this->SetFont('Arial', '', 8);
            $this->Cell(160, 5, utf8_decode($requisicao->veiculo->empresa->pessoa->nomeRazaoSocial), 'LTR');
            $this->Ln();
        } 

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Observação'), 'LTR');
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->SetWidths([190]);
        $this->SetBorders(['LR']);
        $this->Row([utf8_decode($requisicao->observacao)]);
        $this->SetBorders(['LRB']);
        if ($requisicao->urgente) {
            $this->SetAligns(['C']);
            $this->SetFont('Arial', 'B', 10);
            $this->Row([utf8_decode("URGENTE" . "\n\n")]);
        } else {
            $this->Row([' ']);
        }

        
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('Itens da Requisição'), 1, 0, 'C');
        $this->Ln();

        $this->SetWidths([20, 100, 30, 40]);
        $this->setBorders(['L', 'L', 'L', 'LR']);
        $this->SetAligns(['L', 'L', 'L', 'R']);
        $this->Row([utf8_decode('Item'), utf8_decode('Produto/Serviço'), utf8_decode('Unidade'), utf8_decode('Quantidade solicitada')]);
        $this->setBorders(NULL);

        $this->SetFont('Arial', '', 8);
        if ($requisicao->itens->isEmpty()) {
            $this->Cell(190, 5, utf8_decode('Nenhum item informado'), 'LTRB', 0);
            $this->Ln();
        } else {
            foreach ($requisicao->itens as $item) {
                $this->Row([$item->item, utf8_decode($item->descricao), utf8_decode($item->unidade), utf8_decode($item->quantidade_solicitada)]);
            }
        }
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(60, 5, utf8_decode('Situação'), 'LTR');
        $this->Cell(70, 5, utf8_decode('Usuário Autorizador'), 'LTR');
        $this->Cell(60, 5, utf8_decode('Data da Autorização'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(60, 5, $requisicao->situacao_nome, 'LBR');
        $this->Cell(70, 5, utf8_decode(($requisicao->usuarioAutorizacao) ? $requisicao->usuarioAutorizacao->name : ''), 'LBR');
        $this->Cell(60, 5, ($requisicao->data_autorizacao) ? Carbon::parse($requisicao->data_autorizacao)->format('d/m/Y') : '', 'LBR');
        $this->Ln();
        $this->Ln();

        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetFillColor(190, 190, 190);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 5, utf8_decode('Autorização de Cotação'), 'LTR', 0, 'C', true);
        $this->Cell(10, 5, '', 0);
        $this->Cell(90, 5, utf8_decode('Local de Entrega'), 'LTR', 0, 'C', true);
        $this->Ln();

        $this->SetFont('Arial', '', 6);
        $this->MultiCell(90, 30, utf8_decode(''), 'LTRB', 'L');
        $this->SetXY($x + 90, $y + 5);
        $this->Cell(10, 5, '', 0);
        $this->SetWidths([90]);
        $this->setBorders(['']);
        $this->Row([utf8_decode($requisicao->local_entrega)]);
        $this->Rect(($x + 100), ($y + 5), 90, 30);
        $this->Ln();

    }
}
