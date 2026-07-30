<?php

namespace App\Modules\Sales\Services;

use TCPDF;
use App\Modules\Sales\Repositories\SaleRepository;

class InvoiceService
{
    protected SaleRepository $repository;

    public function __construct()
    {
        $this->repository =
            new SaleRepository();
    }

    public function generatePdf(
        int $saleId
    ): void {

        $sale =
            $this->repository->find(
                $saleId
            );

        if (!$sale) {

            exit('Invoice not found');
        }

        $items =
            $this->repository
                ->saleDetails(
                    $saleId
                );

        $pdf = new TCPDF();

        $pdf->SetCreator(
            'MALKEL PHARMA'
        );

        $pdf->SetAuthor(
            'MALKEL PHARMA'
        );

        $pdf->SetTitle(
            $sale['invoice_number']
        );

        $pdf->SetMargins(
            15,
            15,
            15
        );

        $pdf->SetAutoPageBreak(
            true,
            15
        );

        $pdf->AddPage();

        $logo =
            dirname(__DIR__, 4)
            . '/public/assets/images/logo.png';

        if (
            file_exists($logo)
        ) {

            $pdf->Image(
                $logo,
                140,
                15,
                55
            );
        }

        $rate =
            (float)(
                $sale['exchange_rate']
                ?? 2850
            );

        $totalCDF =
            $sale['total']
            * $rate;

        $html = <<<HTML

        <table width="100%" cellpadding="0" border="0">

        <tr>

        <td width="60%">

        <h1 style="color:#0B3D91;font-size:34px;">
        MALKEL PHARMA
        </h1>

        <p style="font-size:11px;color:#555555;line-height:18px;">

        No 11 Avenue MUNUA

        <br>

        Lubumbashi

        <br>

        Democratic Republic of Congo

        <br>

        +243 842 205 811

        <br>

        contact@malkelpharma.com

        </p>

        </td>

        <td width="35%" align="right">

        <br><br><br><br><br><br><br><br><br><br>

        <h2
        style="
        color:#11B5AE;
        font-size:22px;
        "
        >
        INVOICE
        </h2>

        <p>

        <b>{$sale['invoice_number']}</b>

        <br><br>

        {$sale['created_at']}

        </p>

        </td>

        </tr>

        </table>

        <hr>

        <br>

        <table width="100%" cellpadding="8">

        <tr>

        <td width="48%"
        style="
        border:1px solid #D8E2EA;
        "
        >

        <b style="color:#0B3D91;">
        CUSTOMER INFORMATION
        </b>

        <br><br>

        Name :

        {$sale['customer_name']}

        <br><br>

        Phone :

        {$sale['customer_phone']}

        </td>

        <td width="4%"></td>

        <td width="48%"
        style="
        border:1px solid #D8E2EA;
        "
        >

        <b style="color:#0B3D91;">
        TRANSACTION INFORMATION
        </b>

        <br><br>

        Cashier :

        {$sale['cashier_name']}

        <br><br>

        Payment :

        {$sale['payment_method']}

        <br><br>

        Currency :

        {$sale['currency_mode']}

        </td>

        </tr>

        </table>

        <br>

        <h3 style="color:#0B3D91;">
        PRODUCTS
        </h3>

        <table
        width="100%"
        border=none;
        cellpadding="8"
        >

        <tr
        style="
        background-color:#0B3D91;
        color:white;
        "
        >

        <th width="45%">
        PRODUCT
        </th>

        <th width="15%">
        QTY
        </th>

        <th width="20%">
        UNIT PRICE
        </th>

        <th width="20%">
        TOTAL
        </th>


        </tr>

    HTML;

        $html .= '

        </table>

        <br><br>

        <table
        width="100%"
        border="0"
        cellpadding="8"
        >

        <tr>

        <td width="48%"
        style="
        border:1px solid #D8E2EA;
        "
        >

        <h3
        style="
        color:#0B3D91;
        "
        >
        PAYMENT DETAILS
        </h3>

        Currency :
        '
        .
        ($sale['currency_mode'] ?? 'USD')
        .
        '

        <br><br>

        USD Received :
        '
        .
        number_format(
            $sale['amount_received_usd'],
            2
        )
        .
        ' USD

        <br><br>

        CDF Received :
        '
        .
        number_format(
            $sale['amount_received_cdf'],
            0
        )
        .
        ' FC

        <br><br>

        Change USD :
        '
        .
        number_format(
            $sale['change_usd'],
            2
        )
        .
        ' USD

        <br><br>

        Change CDF :
        '
        .
        number_format(
            $sale['change_cdf'],
            0
        )
        .
        ' FC

        </td>

        <td width="4%"></td>

        <td width="48%"
        style="
        border:1px solid #0B3D91;
        background-color:#F7FBFF;
        "
        >

        <h3
        style="
        color:#0B3D91;
        "
        >
        FINANCIAL SUMMARY
        </h3>

        Subtotal :
        '
        .
        number_format(
            $sale['subtotal'],
            2
        )
        .
        ' USD

        <br><br>

        Discount :
        '
        .
        number_format(
            $sale['discount'],
            2
        )
        .
        ' USD

        <br><br>

        Tax :
        '
        .
        number_format(
            $sale['tax'],
            2
        )
        .
        ' USD

        <br><br>

        <b>

        TOTAL USD :

        '
        .
        number_format(
            $sale['total'],
            2
        )
        .
        ' USD

        </b>

        <br><br>

        <b
        style="
        color:#11B5AE;
        "
        >

        TOTAL CDF :

        '
        .
        number_format(
            $totalCDF,
            0
        )
        .
        ' FC

        </b>

        </td>

        </tr>

        </table>


        <div
        style="
        text-align:center;
        "
        >

        <h2
        style="
        color:#0B3D91;
        "
        >
        Thank You
        </h2>


        Thank you for your trust.

       

        Your Health, Our Priority.


        </div>
        ';


        $pdf->writeHTML(
            $html,
            true,
            false,
            true,
            false,
            ''
        );

        $pdf->Output(
            'MALKEL-INVOICE.pdf',
            'I'
        );
    }
}
