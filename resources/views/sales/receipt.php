<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Receipt</title>
<style>
body{font-family:Arial,sans-serif;width:58mm;margin:auto;padding:2px;color:#111827;font-size:9px;line-height:1.2}
.center{text-align:center}
.line{border-top:1px dashed #94a3b8;margin:4px 0}
.receipt-title{font-size:12px;font-weight:700}
.receipt-subtitle{font-size:8px;color:#64748b}
.receipt-meta{text-align:center;font-size:9px}
.section-title{font-weight:700;margin-bottom:2px}
table{width:100%;border-collapse:collapse;font-size:9px}
td{padding:1px 0}
.product-name{font-weight:600}
.total-box{padding:4px;border:1px solid #cbd5e1;border-radius:4px;background:#f8fafc}
.total-line{display:flex;justify-content:space-between;margin-bottom:2px}
.total-final{font-size:11px;font-weight:700}
.footer{text-align:center;font-size:8px;color:#475569}
button{width:100%;padding:4px;border:none;border-radius:4px;background:#2563eb;color:white;cursor:pointer;margin-bottom:4px;font-size:9px}
@media print{@page{margin:0;size:auto}body{margin:0;padding:0;width:auto;-webkit-print-color-adjust:exact;print-color-adjust:exact}button{display:none}}
</style>
</head>
<body>
<button onclick="window.print()">Print</button>
<div class="center">
<div class="receipt-title">MALKEL PHARMA</div>
<div class="receipt-subtitle">Healthcare &amp; Pharmaceutical Center<br>Avenue Lumumba<br>Lubumbashi - DR Congo<br>+243 999 999 999<br>contact@malkelpharma.cd</div>
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
</body>
</html>
