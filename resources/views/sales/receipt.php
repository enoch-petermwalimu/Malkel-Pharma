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
<svg width="24" height="24" viewBox="0 0 482 382" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto;margin-bottom:4px">
<g transform="matrix(1,0,0,1,-330.120994,-218.791934)">
<path d="M330.584,218.919L330.121,488.436C334.109,545.567 411.879,597.005 498.463,600.779C435.436,586.09 402.081,547.029 390.39,490.172L391.884,325.119L494.967,425.767L576.457,341.527L577.007,397.63L634.209,377.279L634.684,281.097C659.144,280.102 683.164,280.186 713.785,281.097C774.166,300.126 773.53,381.129 715.289,402.725C683.463,409.506 665.528,426.011 663.037,453.327C678.615,453.143 693.478,452.96 707.589,452.777C854.09,433.541 838.003,242.155 709.239,225.617L637.186,227.267C623.719,228.302 612.087,234.84 601.984,245.968L495.83,353.222L378.125,238.818C364.401,225.019 347.768,217.722 330.584,218.919Z" fill="url(#_Linear1)"/>
<path d="M576.316,440.31L576.419,583.481C576.305,590.537 574.045,595.107 569.992,599.21C606.614,594.619 627.74,576.441 634.568,544.348L634.282,399.856C652.389,385.374 673.648,378.772 695.434,373.487C558.528,393.175 428.669,480.429 494.078,576.162C469.019,500.894 505.116,460.573 576.316,440.31Z" fill="rgb(13,49,115)"/>
<path d="M512.094,532.212L566.48,531.684L566.128,497.021C558.06,469.181 522.216,463.492 511.566,497.021L512.094,532.212Z" fill="rgb(23,59,112)" stroke="black" stroke-width="1"/>
<path d="M511.566,538.558L566.48,538.91L566.48,574.464C559.483,606.969 517.272,606.615 511.566,574.464L511.566,538.558Z" fill="rgb(78,170,159)"/>
</g>
<defs>
<linearGradient id="_Linear1" x1="0" y1="0" x2="1" y2="0" gradientUnits="userSpaceOnUse" gradientTransform="matrix(481.588426,0,0,381.986647,330.120994,409.785258)"><stop offset="0" stop-color="rgb(78,170,159)"/><stop offset="0.2" stop-color="rgb(56,125,140)"/><stop offset="0.42" stop-color="rgb(33,79,121)"/><stop offset="1" stop-color="rgb(23,58,112)"/></linearGradient>
</defs>
</svg>
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
