<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Receipt</title>
<style>
/* ---------- thermal receipt optimizations ---------- */
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,sans-serif;color:#000000;font-size:9px;line-height:1.2;background:#fff}
.receipt{width:58mm;margin:0 auto;padding:2px;overflow:hidden}
.center{text-align:center}
.line{border-top:1px dashed #000000;margin:4px 0}
.receipt-title{font-size:12px;font-weight:700}
.receipt-subtitle{font-size:8px;color:#000000}
.receipt-meta{text-align:center;font-size:9px}
.section-title{font-weight:700;margin-bottom:2px}
table{width:100%;border-collapse:collapse;font-size:9px}
td{padding:1px 0}
.product-name{font-weight:600}
.total-box{padding:4px;border:1px solid #000000;border-radius:4px;background:#f8fafc}
.total-line{display:flex;justify-content:space-between;margin-bottom:2px}
.total-final{font-size:11px;font-weight:700}
.footer{text-align:center;font-size:8px;color:#000000}
button{width:100%;padding:4px;border:none;border-radius:4px;background:#2563eb;color:white;cursor:pointer;margin-bottom:4px;font-size:9px}
@media print{
@page{size:58mm auto;margin:0}
body{margin:0;padding:0;background:#fff;-webkit-print-color-adjust:exact;print-color-adjust:exact}
.receipt{width:58mm;margin:0;padding:0;overflow:hidden;page-break-inside:avoid;page-break-after:avoid}
button{display:none!important}
}
</style>
</head>
<body>
<div class="receipt">
<button onclick="window.print()">Print</button>
<div class="center">
<span style="display:block;font-size:24px;text-align:center;margin-bottom:4px">☤</span>
<div class="receipt-title">MALKEL PHARMA</div>
<div class="receipt-subtitle">Healthcare &amp; Pharmaceutical Center<br> No 11 Avenue MUNUA<br>Lubumbashi - DR Congo<br>+243 842 205 811<br>contact@malkelpharma.com</div>
</div>
<div class="line"></div>
<div class="receipt-meta"><strong>SALES RECEIPT</strong><br><?= htmlspecialchars($sale['invoice_number']) ?><br><?= htmlspecialchars($sale['created_at']) ?></div>
<div class="line"></div>
<div><span class="section-title">Customer</span><br><?= htmlspecialchars($sale['customer_name'] ?? 'Walk-in Customer') ?><br><?= htmlspecialchars($sale['customer_phone'] ?? '-') ?></div>
<div class="line"></div>
<div><span class="section-title">Cashier</span><br><?= htmlspecialchars($sale['cashier_name'] ?? '-') ?></div>
<div class="line"></div>
<table>
<?php foreach($items as $item): ?>
<tr><td colspan="2" class="product-name"><?= htmlspecialchars($item['name']) ?></td></tr>
<tr><td><?= (int)$item['quantity'] ?> × <?= number_format($item['unit_price'],2) ?> USD</td><td align="right"><?= number_format($item['total_price'],2) ?> USD</td></tr>
<?php endforeach; ?>
</table>
<div class="line"></div>
<?php $rate=2850; $totalCDF=$sale['total']*$rate; ?>
<div class="total-box">
<div class="total-line"><span>Subtotal</span><span><?= number_format($sale['subtotal'],2) ?> USD</span></div>
<div class="total-line"><span>Discount</span><span><?= number_format($sale['discount'],2) ?> USD</span></div>
<div class="total-line"><span>Tax</span><span><?= number_format($sale['tax'],2) ?> USD</span></div>
<div class="line"></div>
<div class="total-line total-final"><span>TOTAL USD</span><span><?= number_format($sale['total'],2) ?> USD</span></div>
<div class="total-line total-final"><span>TOTAL CDF</span><span><?= number_format($totalCDF,0) ?> FC</span></div>
</div>
<div class="line"></div>
<div><span class="section-title">Payment</span><br>Method: <?= htmlspecialchars($sale['payment_method'] ?? 'Cash') ?><br>Currency: <?= htmlspecialchars($sale['currency_mode'] ?? 'USD') ?><br>USD Rec: <?= number_format($sale['amount_received_usd']??0,2) ?> USD<br>CDF Rec: <?= number_format($sale['amount_received_cdf']??0,0) ?> FC<br>Change USD: <?= number_format($sale['change_usd']??0,2) ?> USD<br>Change CDF: <?= number_format($sale['change_cdf']??0,0) ?> FC</div>
<div class="line"></div>
<div class="footer">Thank you for your trust.<br>Your Health, Our Priority.<br><strong>MALKEL PHARMA</strong></div>
</div>
<script>
(function(){
    // auto‑print on load
    window.print();
    // after printing (or cancel) redirect to POS
    var redirectTimer = setTimeout(function(){
        window.location.href = '/pos';
    }, 2000);
    // if the user actually printed, the browser may fire onafterprint
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql){
            if (!mql.matches) {
                clearTimeout(redirectTimer);
                window.location.href = '/pos';
            }
        });
    }
    // fallback for browsers that don't support matchMedia listener
    window.onafterprint = function(){
        clearTimeout(redirectTimer);
        window.location.href = '/pos';
    };
})();
</script>
</body>
</html>
