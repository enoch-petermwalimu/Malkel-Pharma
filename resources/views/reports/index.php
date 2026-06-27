<?php ob_start(); ?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Reports</h1>
            <p class="text-muted mb-0">Generate professional pharmacy reports and export them as PDF.</p>
        </div>
    </div>

    <!-- Report Categories -->
    <div class="row g-4 mb-4">
        <!-- Sales Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-primary-light text-primary me-3">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Sales Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Sales by day, week, month and custom period.</p>
                </div>
            </div>
        </div>

        <!-- Inventory Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-success-light text-success me-3">
                            <i class="fas fa-boxes fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Inventory Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Current stock, low stock, out-of-stock, stock valuation.</p>
                </div>
            </div>
        </div>

        <!-- Purchase Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-warning-light text-warning me-3">
                            <i class="fas fa-truck fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Purchase Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Purchases by supplier and period.</p>
                </div>
            </div>
        </div>

        <!-- Customer Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-info-light text-info me-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Customer Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Customer purchase history and spending.</p>
                </div>
            </div>
        </div>

        <!-- Supplier Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-secondary-light text-secondary me-3">
                            <i class="fas fa-handshake fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Supplier Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Purchases, balances and supplier activity.</p>
                </div>
            </div>
        </div>

        <!-- Financial Reports -->
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-danger-light text-danger me-3">
                            <i class="fas fa-dollar-sign fa-lg"></i>
                        </div>
                        <h5 class="card-title mb-0">Financial Reports</h5>
                    </div>
                    <p class="card-text text-muted small">Revenue, profit and payment statistics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Reports</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="startDate" class="form-label small fw-semibold">Start Date</label>
                    <input type="date" class="form-control" id="startDate">
                </div>
                <div class="col-md-3">
                    <label for="endDate" class="form-label small fw-semibold">End Date</label>
                    <input type="date" class="form-control" id="endDate">
                </div>
                <div class="col-md-3">
                    <label for="reportType" class="form-label small fw-semibold">Report Type</label>
                    <select class="form-select" id="reportType">
                        <option selected>All Reports</option>
                        <option>Sales</option>
                        <option>Inventory</option>
                        <option>Purchases</option>
                        <option>Customers</option>
                        <option>Suppliers</option>
                        <option>Financial</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" disabled>
                        <i class="fas fa-play me-1"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Panel -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fas fa-download me-2"></i>Export</h5>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                <a href="/reports/export-pdf" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-1"></i>Export PDF
                </a>
                <button class="btn btn-success" disabled>
                    <i class="fas fa-file-excel me-1"></i>Export Excel
                </button>
                <button class="btn btn-secondary" disabled>
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Future WhatsApp Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fab fa-whatsapp me-2 text-success"></i>Share Report</h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                This feature will allow sending generated PDF reports directly via WhatsApp.
            </p>
            <button class="btn btn-success" disabled>
                <i class="fab fa-whatsapp me-1"></i>Send via WhatsApp
                <span class="badge bg-light text-dark ms-2">Coming Soon</span>
            </button>
        </div>
    </div>

    <!-- Recent Reports Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Reports</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Report</th>
                            <th>Generated By</th>
                            <th>Format</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2026-06-27</td>
                            <td>Sales Report (Weekly)</td>
                            <td>Admin</td>
                            <td>PDF</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2026-06-26</td>
                            <td>Inventory Stock Valuation</td>
                            <td>Admin</td>
                            <td>PDF</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2026-06-25</td>
                            <td>Purchase Report (June)</td>
                            <td>Manager</td>
                            <td>PDF</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>2026-06-24</td>
                            <td>Customer Spending Analysis</td>
                            <td>Admin</td>
                            <td>PDF</td>
                            <td><span class="badge bg-warning text-dark">Processing</span></td>
                        </tr>
                        <tr>
                            <td>2026-06-23</td>
                            <td>Financial Summary Q2</td>
                            <td>Finance</td>
                            <td>PDF</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

$content = ob_get_clean();

$pageTitle = $pageTitle ?? 'Reports';

include dirname(__DIR__) . '/layouts/app.php';
