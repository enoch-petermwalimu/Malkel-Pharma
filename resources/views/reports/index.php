<?php ob_start(); ?>

<h1>Pharma Activities Report</h1>

<div style="margin-bottom: 20px;">
    <a href="/reports/export-pdf" class="btn btn-primary">Export PDF</a>
</div>

<h2>Sales</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities['sales'] as $sale): ?>
        <tr>
            <td><?= $sale->id ?></td>
            <td>$<?= number_format($sale->total, 2) ?></td>
            <td><?= $sale->created_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Purchases</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities['purchases'] as $purchase): ?>
        <tr>
            <td><?= $purchase->id ?></td>
            <td>$<?= number_format($purchase->total, 2) ?></td>
            <td><?= $purchase->created_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Stock Movements</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities['stockMovements'] as $movement): ?>
        <tr>
            <td><?= $movement->id ?></td>
            <td><?= $movement->type ?></td>
            <td><?= $movement->quantity ?></td>
            <td><?= $movement->created_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Returns</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Reason</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($activities['returns'] as $return): ?>
        <tr>
            <td><?= $return->id ?></td>
            <td><?= $return->reason ?></td>
            <td><?= $return->created_at ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php

$content = ob_get_clean();

$pageTitle = $pageTitle ?? 'Reports';

include dirname(__DIR__) . '/layouts/app.php';
