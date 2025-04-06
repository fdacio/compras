<?php

namespace App\Reports;

use App\AutorizacaoPagamento;
use App\Helpers\Formatter;
use Carbon\Carbon;

class DemoAutorizacaoPagamentoPdf extends ReportPdf
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


    public function setContent(AutorizacaoPagamento $autorizacao)
    {

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(20, 5, utf8_decode('Número'), 'LTR');
        $this->Cell(30, 5, utf8_decode('Data'), 'LTR');
        $this->Cell(140, 5, utf8_decode('Favorecido'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 5, $autorizacao->id, 'LBR');
        $this->Cell(30, 5, Carbon::parse($autorizacao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(140, 5, utf8_decode(Formatter::cpfCnpj($autorizacao->favorecido->pessoa->cpf_cnpj) . ' - ' . $autorizacao->favorecido->pessoa->nome_razao_social), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(80, 5, utf8_decode('Centro de Custo'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Forma de Pagamento'), 'LTR');
        $this->Cell(30, 5, utf8_decode('Valor'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(80, 5, utf8_decode($autorizacao->centroCusto->nome), 'LBR');
        $this->Cell(80, 5, utf8_decode($autorizacao->formaPagamento->nome), 'LBR');
        $this->Cell(30, 5, Formatter::valorTotal($autorizacao->valor), 'LBR', 0, 'R');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(45, 5, utf8_decode('Banco'), 'LTR');
        $this->Cell(45, 5, utf8_decode('Agencia'), 'LTR');
        $this->Cell(45, 5, utf8_decode('Conta'), 'LTR');
        $this->Cell(55, 5, utf8_decode('Operação'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(45, 5, utf8_decode($autorizacao->banco), 'LBR');
        $this->Cell(45, 5, $autorizacao->agencia, 'LBR');
        $this->Cell(45, 5, $autorizacao->conta, 'LBR');
        $this->Cell(55, 5, utf8_decode($autorizacao->operacao), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(190, 5, utf8_decode('Chave PIX'), 'LTR');
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 5, utf8_decode($autorizacao->chave_pix), 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('Itens da Autorização'), 1, 0, 'C');

        $this->Ln();

        $this->SetWidths([20, 170]);
        $this->setBorders(['L', 'L']);
        $this->Row([utf8_decode('Item'), utf8_decode('Descrição')]);
        $this->setBorders(NULL);

        $this->SetFont('Arial', '', 8);
        if ($autorizacao->itens->isEmpty()) {
            $this->Cell(190, 5, utf8_decode('Nenhum item informado'), 'LTRB', 0);
            $this->Ln();
        } else {
            foreach ($autorizacao->itens as $item) {
                $descricao = $item->descricao;
                if ($item->veiculo) {
                    $descricao .= "\n" . "Veículo: " . $item->veiculo->placa . '-' . $item->veiculo->marca . ' ' . $item->veiculo->modelo;
                }
                if ($item->produto) {
                    $descricao .= "\n" . "Produto: " . $item->produto->nome . '-' . $item->produto->unidade->nome;
                }
                
                $this->Row([$item->item, utf8_decode($descricao)]);
            }
        }
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(60, 5, utf8_decode('Situação'), 'LTR');
        $this->Cell(70, 5, utf8_decode('Usuário Autorizador'), 'LTR');
        $this->Cell(60, 5, utf8_decode('Data da Autorização'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(60, 5, $autorizacao->situacao_nome, 'LBR');
        $this->Cell(70, 5, utf8_decode(($autorizacao->usuarioAutorizacao) ? $autorizacao->usuarioAutorizacao->name : ''), 'LBR');
        $this->Cell(60, 5, ($autorizacao->data_autorizacao) ? Carbon::parse($autorizacao->data_autorizacao)->format('d/m/Y') : '', 'LBR');
        $this->Ln();
        $this->Ln();

        $x = $this->GetX();
        $y = $this->GetY();

        $this->SetFillColor(190, 190, 190);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 5, utf8_decode('Autorização de Pagamento - Carimbo'), 'LTR', 0, 'C', true);
        $this->Cell(10, 5, '', 0);
        $this->Cell(90, 5, utf8_decode('Observação'), 'LTR', 0, 'C', true);
        $this->Ln();

        $this->SetFont('Arial', '', 6);
        $this->MultiCell(90, 30, utf8_decode(''), 'LTRB', 'L');
        $this->SetXY($x + 90, $y + 5);
        $this->Cell(10, 5, '', 0);
        $this->SetWidths([90]);
        $this->setBorders(['']);
        $this->Row([utf8_decode($autorizacao->obsrvacao)]);
        $this->Rect(($x + 100), ($y + 5), 90, 30);
        $this->Ln();
    }
}
