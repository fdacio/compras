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
    }
}
?>