@extends('admin.layout')

@section('title', 'Analytics Dashboard - ERP System')
@section('page_title', '📊 Analytics Dashboard')

@section('content')

{{-- ================= FILTER SECTION ================= --}}
<div class="card mb-4 print-hide">
    <div class="card-body">
        <div class="row">
            <div class="col-md-9">
                <div class="btn-group">
                    <button class="btn btn-outline-primary filter-btn active" data-period="today">Hari Ini</button>
                    <button class="btn btn-outline-primary filter-btn" data-period="week">7 Hari</button>
                    <button class="btn btn-outline-primary filter-btn" data-period="month">30 Hari</button>
                    <button class="btn btn-outline-primary filter-btn" data-period="year">Tahun Ini</button>
                </div>
                <button class="btn btn-outline-secondary filter-btn ms-2" data-period="custom">
                    <i class="fas fa-calendar-alt"></i> Custom
                </button>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-success" onclick="printReport()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>
        </div>

        <div id="customDateRange" class="row mt-3" style="display:none">
            <div class="col-md-4">
                <label>Start Date</label>
                <input type="date" id="startDate" class="form-control" value="{{ $start_date }}">
            </div>
            <div class="col-md-4">
                <label>End Date</label>
                <input type="date" id="endDate" class="form-control" value="{{ $end_date }}">
            </div>
            <div class="col-md-4">
                <label>&nbsp;</label>
                <button class="btn btn-primary w-100" onclick="applyCustomFilter()">Apply</button>
            </div>
        </div>
    </div>
</div>

{{-- ================= KPI CARDS ================= --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="text-xs fw-bold text-primary">Total Revenue</div>
                <div class="h5 fw-bold">Rp {{ number_format($total_sales ?? 0) }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="text-xs fw-bold text-success">Total Transactions</div>
                <div class="h5 fw-bold">{{ $total_transactions ?? 0 }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="text-xs fw-bold text-info">Average Transaction</div>
                <div class="h5 fw-bold">
                    Rp {{ $total_transactions > 0 ? number_format($total_sales / $total_transactions) : 0 }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="text-xs fw-bold text-warning">Net Cash Flow</div>
                <div class="h5 fw-bold">Rp {{ number_format($net_cash ?? 0) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ================= CHARTS ================= --}}
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <canvas id="combinedChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-body">
                <canvas id="paymentMethodChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ================= CASHIER PERFORMANCE ================= --}}
<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="fw-bold">Top Cashier Performance</h6>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Cashier</th>
                <th>Transactions</th>
                <th>Sales</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cashier_stats as $index => $cashier)
                <tr>
                    <td>#{{ $index + 1 }}</td>
                    <td>{{ $cashier->username ?? 'Unknown' }}</td>
                    <td>{{ $cashier->total_transactions }}</td>
                    <td>Rp {{ number_format($cashier->total_sales) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= CASH DRAWER SUMMARY ================= --}}
<div class="card shadow">
    <div class="card-header">
        <h6 class="fw-bold">Recent Cash Drawers</h6>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Drawer</th>
                <th>Cashier</th>
                <th>Status</th>
                <th>Opening</th>
                <th>Actual</th>
                <th>Difference</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recent_drawers as $drawer)
                <tr>
                    <td>#{{ $drawer->drawer_number }}</td>
                    <td>{{ $drawer->cashier->username ?? 'Unknown' }}</td>
                    <td>
                        <span class="badge bg-{{ $drawer->status === 'open' ? 'success' : 'secondary' }}">
                            {{ ucfirst($drawer->status) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($drawer->opening_balance) }}</td>
                    <td>Rp {{ number_format($drawer->actual_cash ?? 0) }}</td>
                    <td class="{{ ($drawer->difference ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                        Rp {{ number_format($drawer->difference ?? 0) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No drawer data</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = @json($chart_labels);
const revenueData = @json($chart_revenue_data);
const cashInData = @json($chart_cash_in);
const cashOutData = @json($chart_cash_out);

new Chart(document.getElementById('combinedChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            { label: 'Revenue', data: revenueData, borderColor: '#4e73df', fill: false },
            { label: 'Cash In', data: cashInData, borderColor: '#1cc88a', fill: false },
            { label: 'Cash Out', data: cashOutData, borderColor: '#e74a3b', fill: false },
        ]
    }
});
</script>
@endsection
