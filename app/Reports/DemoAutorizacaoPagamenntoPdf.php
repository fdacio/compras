<?php
namespace App\Reports;

use App\AutorizacaoPagamento;

class DemoAutorizacaoPagamentoPdf extends ReportPdf
{

    public function __construct($title)
    {
        parent::__construct($title);
    }

    public function setContent(AutorizacaoPagamento $autorizacao)
    {
    }
}
?>