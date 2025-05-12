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
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 5, utf8_decode('Requisição Nº'), 'LTR');
        $this->Cell(45, 5, utf8_decode('Data da Requisição'), 'LTR');
        $this->Cell(45, 5, utf8_decode('Tipo da Requisição'), 'LTR');
        $this->Cell(70, 5, utf8_decode('Contrato da Requisição'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $cotacao->requisicao->id, 'LBR');
        $this->Cell(45, 5, \Carbon\Carbon::parse($cotacao->requisicao->data)->format('d/m/Y'), 'LBR');
        $this->Cell(45, 5, $cotacao->requisicao->tipo_nome, 'LBR');
        $this->Cell(70, 5, $cotacao->requisicao->empresa->pessoa->nome_razao_social, 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 5, utf8_decode('Centro de Custo'), 'LTR');
        $this->Cell(35, 5, utf8_decode('Solicitante'), 'LTR');
        $this->Cell(45, 5, utf8_decode('Veículo'), 'LTR');
        $this->Cell(80, 5, utf8_decode('Local de entrega'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 5, $cotacao->requisicao->requisitante->nome, 'LBR');
        $this->Cell(35, 5, $cotacao->requisicao->solicitante->nome, 'LBR');
        $this->Cell(45, 5, $cotacao->requisicao->veiculo ? $cotacao->requisicao->veiculo->placa . ' - ' . $cotacao->requisicao->veiculo->marca . ' - ' . $cotacao->requisicao->veiculo->modelo : '', 'LBR');
        $this->Cell(80, 5, $cotacao->requisicao->local_entrega, 'LBR');
        $this->Ln();

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(60, 5, utf8_decode('Situação'), 'LTR');
        $this->Cell(70, 5, utf8_decode('Observação'), 'LTR');
        $this->Cell(60, 5, utf8_decode('Urgente'), 'LTR');
        $this->Ln();

        $this->SetFont('Arial', '', 8);
        $this->Cell(60, 5, $cotacao->requisicao->situacao_nome, 'LBR');
        $this->Cell(70, 5, $cotacao->requisicao->observacao, 'LBR');
        $this->Cell(60, 5, ($cotacao->requisicao->urgente) ? "Sim" : "Não", 'LBR');
        $this->Ln();
        
        //Aqui fornecedores da cotação, quandou houver fornecedores
        if ($cotacao->fornecedores->count() > 0) {
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(190, 5, utf8_decode('Fornecedores'), 'LTRB' ,0 ,'C');
            $this->Ln();

            foreach ($cotacao->fornecedores as $fornecedor) {
                $this->Ln(5);
                $this->SetFont('Arial', '', 8);
                $this->Cell(190, 5, utf8_decode($fornecedor->fornecedor->pessoa->nome_razao_social), 'LTBR');
                $this->Ln();
                
                foreach ($fornecedor-> itens as $item) {
                    $this->SetFont('Arial', 'B', 6);
                    $this->Cell(20, 5, utf8_decode('Item'), 'LTR');
                    $this->Cell(170, 5, utf8_decode('Descrição'), 'LTR');
                    $this->Ln();

                    $this->SetFont('Arial', '', 8);
                    $this->Cell(20, 5, $item->item, 'LBR');
                    $this->Cell(170, 5, utf8_decode($item->descricao), 'LBR');
                    $this->Ln();

                    $this->SetFont('Arial', 'B', 6);
                    $this->Cell(30, 5, utf8_decode('Unidade'), 'LTR');
                    $this->Cell(30, 5, utf8_decode('Qtde.Solicitada'), 'LTR');
                    $this->Cell(30, 5, utf8_decode('Qtde.Cotada'), 'LTR');
                    $this->Cell(30, 5, utf8_decode('Qtde.Atendida'), 'LTR');
                    $this->Cell(30, 5, utf8_decode('Vr.Unitário'), 'LTR');
                    $this->Cell(40, 5, utf8_decode('Vr.Total'), 'LTR');
                    $this->Ln();

                    $this->SetFont('Arial', '', 8);
                    $this->Cell(30, 5, utf8_decode($item->unidade), 'LBR');
                    $this->Cell(30, 5, $item->quantidade_solicitada, 'LBR');
                    $this->Cell(30, 5, $item->quantidade_cotada, 'LBR');
                    $this->Cell(30, 5, $item->quantidade_atendida, 'LBR');
                    $this->Cell(30, 5, 'R$ ' . number_format($item->valor_unitario, '2', ',', '.'), 'LBR');
                    $this->Cell(40, 5, 'R$ ' . number_format($item->valor_total, '2', ',', '.'), 'LBR');
                    $this->Ln();
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(150, 5, ('Total:'), 'LTBR',0 , 'R');
                    $this->Cell(40, 5, 'R$ ' . number_format($item->valor_total, '2', ',', '.') , 'LTBR');
                    $this->Ln(5);
                }
            }


        }

        //Aqui fornecedore vecedor(es), quando a cotação estiver finalizada
        if ($cotacao->finalizada) {
            $this->Ln();
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(190, 5, utf8_decode('Vencedor(es)'), 'LTRB' ,0 ,'C');
            $this->Ln(5);
            foreach ($cotacao->fornecedoresVencedores as $fornecedor) {
                $this->SetFont('Arial', '', 8);
                $this->Cell(190, 5, utf8_decode($fornecedor->fornecedor->pessoa->nome_razao_social), 'LBR');
                $this->Ln();
                foreach ($cotacao->fornecedores->where('id_fornecedor', $fornecedor->id_fornecedor) as $fornecedorItem){
                    foreach(\App\CotacaoFornecedorItem::where('id_cotacao_fornecedor', $fornecedorItem->id)->get() as $i) {
                        $this->SetFont('Arial', 'B', 6);
                        $this->Cell(20, 5, utf8_decode('Item'), 'LTR');
                        $this->Cell(170, 5, utf8_decode('Descrição'), 'LTR');
                        $this->Ln();

                        $this->SetFont('Arial', '', 8);
                        $this->Cell(20, 5, $i->item, 'LBR');
                        $this->Cell(170, 5, utf8_decode($i->descricao), 'LBR');
                        $this->Ln();

                        $this->SetFont('Arial', 'B', 6);
                        $this->Cell(30, 5, utf8_decode('Unidade'), 'LTR');
                        $this->Cell(30, 5, utf8_decode('Qtde.Solicitada'), 'LTR');
                        $this->Cell(30, 5, utf8_decode('Qtde.Cotada'), 'LTR');
                        $this->Cell(30, 5, utf8_decode('Qtde.Atendida'), 'LTR');
                        $this->Cell(30, 5, utf8_decode('Vr.Unitário'), 'LTR');
                        $this->Cell(40, 5, utf8_decode('Vr.Total'), 'LTR');
                        $this->Ln();

                        $this->SetFont('Arial', '', 8);
                        $this->Cell(30, 5, utf8_decode($i->unidade), 'LBR');
                        $this->Cell(30, 5, $i->quantidade_solicitada, 'LBR');
                        $this->Cell(30, 5, $i->quantidade_cotada, 'LBR');
                        $this->Cell(30, 5, $i->quantidade_atendida, 'LBR');
                        $this->Cell(30, 5, 'R$ ' . number_format($i->valor_unitario , '2', ',', '.'), 'LBR');
                        $this->Cell(40, 5, 'R$ ' . number_format($i->valor_total , '2', ',', '.'), 'LBR');
                        $this->Ln();
                        $this->SetFont('Arial', 'B', 8);
                        $this->Cell(150, 5, ('Total:'), 'LTBR',0 , 'R');
                        $this->Cell(40, 5, 'R$ ' . number_format($i->valor_total, '2', ',', '.') , 'LTBR');
                        $this->Ln(5);
                }
                }
                
                    
            }
        }
    }
}
