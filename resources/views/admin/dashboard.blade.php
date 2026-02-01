@extends('admin.layout')

@section('title', 'Admin Dashboard - Dili Society')
@section('page_title', 'Analytics Dashboard')
@section('page_subtitle', 'Dili Society Management System')

@section('styles')
<style>
    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
        backdrop-filter: blur(5px);
    }
    
    .loading-overlay.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #3498db;
        border-radius: 50%;
        animation: spin 1.5s linear infinite;
        margin-bottom: 20px;
    }
    
    .loading-text {
        color: #3498db;
        font-weight: 600;
        font-size: 1.1rem;
        text-align: center;
        max-width: 300px;
        line-height: 1.5;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Filter Controls Styling */
    .filter-container {
        background: linear-gradient(135deg, #225fbbff 0%, #2599ffff 100%);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .filter-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
        position: relative;
        z-index: 1;
    }
    
    .filter-header h3 {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .real-data-indicator {
        background: rgba(255, 255, 255, 0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        background: rgba(255, 255, 255, 0.1);
        padding: 5px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .filter-btn {
        padding: 10px 20px;
        border-radius: 50px;
        border: none;
        background: transparent;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    
    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-1px);
    }
    
    .filter-btn.active {
        background: white;
        color: #3498db;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .filter-btn i {
        font-size: 0.9rem;
    }
    
    /* Date Range Picker */
    #custom-date-range {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        position: relative;
        z-index: 1;
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .date-range-picker {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    .date-input-group label {
        color: white;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    .date-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 8px;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        transition: all 0.3s;
        font-family: inherit;
    }
    
    .date-input:focus {
        outline: none;
        border-color: white;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
    }
    
    .apply-filter-btn {
        background: white;
        color: #3498db;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 20px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        font-family: inherit;
    }
    
    .apply-filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        background: #f8f9fa;
    }
    
    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        border-radius: 15px 15px 0 0;
    }
    
    .stat-card.revenue::before { background: linear-gradient(90deg, #3498db, #2980b9); }
    .stat-card.profit::before { background: linear-gradient(90deg, #2ecc71, #27ae60); }
    .stat-card.purchase-cost::before { background: linear-gradient(90deg, #e74c3c, #c0392b); }
    .stat-card.transactions::before { background: linear-gradient(90deg, #9b59b6, #8e44ad); }
    
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    
    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    
    .stat-icon.revenue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
    .stat-icon.profit { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .stat-icon.purchase-cost { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
    .stat-icon.transactions { background: rgba(155, 89, 182, 0.1); color: #9b59b6; }
    
    .stat-change {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
    }
    
    .stat-change.positive {
        background: rgba(46, 204, 113, 0.15);
        color: #27ae60;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }
    
    .stat-change.negative {
        background: rgba(231, 76, 60, 0.15);
        color: #c0392b;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }
    
    .stat-change.neutral {
        background: rgba(149, 165, 166, 0.15);
        color: #7f8c8d;
        border: 1px solid rgba(149, 165, 166, 0.3);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .stat-label {
        color: #7f8c8d;
        font-size: 1rem;
        margin-bottom: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .stat-footer {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 2px solid #f1f2f6;
        font-size: 0.9rem;
        color: #95a5a6;
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    
    /* Cost Breakdown Modal */
    .cost-breakdown {
        margin-top: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #3498db;
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .cost-breakdown.show {
        display: block;
    }
    
    .cost-breakdown h5 {
        font-size: 0.95rem;
        color: #2c3e50;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
    }
    
    .cost-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 0.9rem;
        color: #34495e;
        border-bottom: 1px solid #eaeaea;
    }
    
    .cost-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .cost-item.total {
        font-weight: 700;
        color: #2c3e50;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 2px solid #ddd;
        font-size: 1rem;
    }
    
    .cost-value {
        font-weight: 600;
    }
    
    /* Charts */
    .charts-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .chart-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .chart-card .card-header {
        padding: 20px 30px;
        background: linear-gradient(90deg, #2c3e50, #34495e);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .chart-card .card-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-type-selector {
        display: flex;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 4px;
        border-radius: 8px;
    }
    
    .chart-type-btn {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        padding: 8px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .chart-type-btn.active {
        background: white;
        color: #2c3e50;
    }
    
    .chart-card .card-body {
        padding: 25px;
        height: 400px;
        position: relative;
    }
    
    /* Data Tables */
    .recent-data-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    
    .data-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .data-card .card-header {
        padding: 20px 30px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .data-card .card-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .view-all {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        text-decoration: none;
        transition: color 0.3s;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    
    .view-all:hover {
        color: white;
        text-decoration: none;
        transform: translateX(3px);
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        padding: 15px 25px;
        text-align: left;
        font-weight: 700;
        color: #2c3e50;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f2f6;
        background: #f8f9fa;
        white-space: nowrap;
    }
    
    .data-table td {
        padding: 15px 25px;
        color: #34495e;
        border-bottom: 1px solid #f1f2f6;
        vertical-align: middle;
    }
    
    .data-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }
    
    .badge-success {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.2);
    }
    
    .badge-warning {
        background: rgba(243, 156, 18, 0.1);
        color: #f39c12;
        border: 1px solid rgba(243, 156, 18, 0.2);
    }
    
    .badge-danger {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.2);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #bdc3c7;
    }
    
    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .empty-state p {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    
    /* Error Message */
    .alert-danger {
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .charts-container {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 992px) {
        .recent-data-container {
            grid-template-columns: 1fr;
        }
        
        .chart-card .card-body {
            height: 350px;
        }
    }
    
    @media (max-width: 768px) {
        .filter-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-buttons {
            justify-content: center;
        }
        
        .date-range-picker {
            grid-template-columns: 1fr;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .stat-value {
            font-size: 2rem;
        }
        
        .chart-card .card-body {
            height: 300px;
            padding: 15px;
        }
        
        .data-table th,
        .data-table td {
            padding: 10px 15px;
        }
    }
    
    @media (max-width: 576px) {
        .filter-container {
            padding: 20px;
        }
        
        .filter-btn {
            padding: 8px 15px;
            font-size: 0.85rem;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
        }
        
        .chart-card .card-header,
        .data-card .card-header {
            padding: 15px 20px;
        }
    }
    
    .category-badge {
        background: #e3f2fd;
        color: #1976d2;
        border: none;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .refresh-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .refresh-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    /* ==== FORCE DASHBOARD STYLE (ANTI OVERRIDE) ==== */

    .data-card {
        background: white !important;
        border-radius: 15px !important;
        overflow: hidden !important;
    }

    .data-card .card-header {
        background: linear-gradient(90deg, #3498db, #2980b9) !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .data-card .card-header h3 {
        color: white !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
    }
</style>
@endsection

@section('content')

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="loading-spinner"></div>
    <div class="loading-text" id="loading-text">Loading dashboard data...</div>
</div>

<!-- Error Message -->
<div id="error-message" class="alert alert-danger alert-dismissible fade show" style="display:none">
    <i class="fas fa-exclamation-circle me-2"></i>
    <span id="error-text"></span>
    <button type="button" class="btn-close" onclick="hideError()"></button>
</div>

<!-- Success Message -->
<div id="success-message" class="alert alert-success alert-dismissible fade show" style="display:none">
    <i class="fas fa-check-circle me-2"></i>
    <span id="success-text"></span>
    <button type="button" class="btn-close" onclick="hideSuccess()"></button>
</div>

<!-- FILTER -->
<div class="filter-container">
    <div class="filter-header">
        <h3>
            <i class="fas fa-chart-line"></i>
            Analytics Dashboard
            <span class="real-data-indicator">
                <i class="fas fa-database me-1"></i>REAL-TIME DATA
            </span>
        </h3>

        <div class="filter-buttons">
            <button class="filter-btn active" onclick="loadDashboardData('today')">Today</button>
            <button class="filter-btn" onclick="loadDashboardData('week')">This Week</button>
            <button class="filter-btn" onclick="loadDashboardData('month')">This Month</button>
            <button class="filter-btn" onclick="loadDashboardData('year')">This Year</button>
            <button class="filter-btn" onclick="showCustomRange()">Custom</button>
            <button class="filter-btn" onclick="exportExcelReport()">Export Excel</button>
        </div>
    </div>

    <div id="custom-date-range" style="display:none">
        <div class="date-range-picker">
            {{-- <input type="date" id="start-date" value="{{ $start_date ?? '' }}"> --}}
            <input type="date" id="start-date" value="">
            {{-- <input type="date" id="end-date" value="{{ $end_date ?? '' }}"> --}}
            <input type="date" id="end-date" value="">
        </div>
        <button class="apply-filter-btn" onclick="applyCustomFilter()">Apply Filter</button>
    </div>
</div>

<!-- STATS -->
<div class="stats-container">
    <div class="stat-card revenue">
        <div class="stat-value" id="revenue-value">
            {{-- {{ number_format($stats['revenue'], 2) }} --}}
            Loading...
        </div>
        <div class="stat-label">Total Revenue</div>
    </div>

    <div class="stat-card profit">
        <div class="stat-value" id="profit-value">Loading...</div>
        <div id="cost-breakdown" class="cost-breakdown"></div>
        <button onclick="toggleCostBreakdown()" id="detail-btn">Details</button>
    </div>

    <div class="stat-card purchase-cost">
        <div class="stat-value" id="purchase-cost-value">Loading...</div>
    </div>

    <div class="stat-card transactions">
        <div class="stat-value" id="transactions-value">Loading...</div>
    </div>
</div>

<!-- CHART -->
<div class="charts-container">
    <div class="chart-card">
        <canvas id="revenue-profit-chart"></canvas>
        <div id="revenue-profit-chart-error" class="empty-state" style="display:none"></div>
    </div>

    <div class="chart-card">
        <canvas id="cost-profit-chart"></canvas>
        <div id="cost-profit-chart-error" class="empty-state" style="display:none"></div>
    </div>
</div>

<!-- TABLES -->
<div class="recent-data-container">
    <table>
        <tbody id="recent-transactions"></tbody>
    </table>

    <table>
        <tbody id="top-products"></tbody>
    </table>

    <table>
        <tbody id="low-stock-products"></tbody>
    </table>
</div>

@endsection

@section('scripts')
<!-- Load Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Main Dashboard Script Block -->
<script>
    /* ================= EXPORT FUNCTION ================= */
    function exportExcelReport() {
        let url = `/admin/reports/export-excel?period=${currentPeriod}`;

        if (currentPeriod === 'custom') {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;

            if (!startDate || !endDate) {
                alert('Please select start & end date');
                return;
            }
            url += `&start_date=${startDate}&end_date=${endDate}`;
        }

        window.location.href = url;
    }

    /* ================= TIMOR LESTE TIMEZONE HELPER ================= */
    function convertToTimorLeste(dateString) {
        if (!dateString) return null;

        const date = new Date(dateString);
        if (isNaN(date.getTime())) return null;

        // Timor-Leste = UTC +9
        const TL_OFFSET = 9 * 60; // minutes
        const localOffset = date.getTimezoneOffset(); // browser offset (WIB = -420)

        return new Date(date.getTime() + (TL_OFFSET + localOffset) * 60000);
    }

    /* ================= MAIN DASHBOARD LOGIC ================= */
    // Dashboard JavaScript - REAL DATA 100%
    let revenueProfitChart = null;
    let costProfitChart = null;
    let currentDashboardData = null;
    let currentPeriod = 'week';
    
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Dashboard initialized - REAL Data from Database');
        setupEventListeners();
        initializeDateInputs();
        
        // Load initial data
        loadDashboardData('week');
    });
    
    function initializeDateInputs() {
        const today = new Date();
        const weekAgo = new Date(today.getTime() - 6 * 24 * 60 * 60 * 1000);
        
        const formatDate = (date) => date.toISOString().split('T')[0];
        
        document.getElementById('end-date').value = formatDate(today);
        document.getElementById('start-date').value = formatDate(weekAgo);
    }
    
    function showCustomRange() {
        const customRangeDiv = document.getElementById('custom-date-range');
        if (customRangeDiv) {
            customRangeDiv.style.display = 'block';
        }
        
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        
        const customBtn = Array.from(document.querySelectorAll('.filter-btn'))
            .find(btn => btn.textContent.includes('Custom'));
        if (customBtn) {
            customBtn.classList.add('active');
        }
    }
    
    function showLoading(show, message = 'Loading dashboard data...') {
        const overlay = document.getElementById('loading-overlay');
        const loadingText = document.getElementById('loading-text');
        
        if (overlay && loadingText) {
            loadingText.textContent = message;
            overlay.classList.toggle('active', show);
        }
    }
    
    function showError(message) {
        const errorDiv = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        
        if (errorDiv && errorText) {
            errorText.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(hideError, 5000);
        }
    }
    
    function hideError() {
        const errorDiv = document.getElementById('error-message');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }
    
    function showSuccess(message) {
        const successDiv = document.getElementById('success-message');
        const successText = document.getElementById('success-text');
        
        if (successDiv && successText) {
            successText.textContent = message;
            successDiv.style.display = 'block';
            setTimeout(hideSuccess, 3000);
        }
    }
    
    function hideSuccess() {
        const successDiv = document.getElementById('success-message');
        if (successDiv) {
            successDiv.style.display = 'none';
        }
    }
    
    async function loadDashboardData(period) {
        console.log(`📊 Loading dashboard data for period: ${period}`);
        currentPeriod = period;
        
        showLoading(true, `Loading ${getPeriodName(period)} data...`);
        hideError();
        
        try {
            // Reset loading states
            resetStatsLoading();
            
            // API URL
            let apiUrl = `/admin/dashboard/filter?period=${period}&_t=${Date.now()}`;

            // For custom period, add date parameters
            if (period === 'custom') {
                const startDate = document.getElementById('start-date').value;
                const endDate = document.getElementById('end-date').value;
                if (startDate && endDate) {
                    apiUrl += `&start_date=${startDate}&end_date=${endDate}`;
                }
            }
            
            console.log('🌐 API Request:', apiUrl);
            
            const response = await fetch(apiUrl);
            
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            console.log('✅ API Response:', {
                success: data.success,
                stats: data.stats,
                hasCharts: !!data.charts,
                hasTables: !!data.tables
            });
            
            // Debug top products
            if (data.tables && data.tables.top_products) {
                console.log('🏆 Top Products Data:', data.tables.top_products);
                console.log('📊 Number of Top Products:', data.tables.top_products.length);
            }
            
            if (data.success) {
                // Validate REAL data
                validateRealData(data.stats);
                
                updateDashboard(data);
                updateActiveFilterButton(period);
                currentDashboardData = data;
                
                // Show success message with real data info
                const periodName = getPeriodName(period);
                const revenue = formatCurrency(data.stats?.revenue || 0);
                const transactions = data.stats?.transactions || 0;
                const topProductsCount = data.tables?.top_products?.length || 0;
                
                showSuccess(`${periodName} data loaded: ${transactions} transactions, ${topProductsCount} top products`);
            } else {
                throw new Error(data.message || 'Failed to load data');
            }
        } catch (error) {
            console.error('❌ Error loading dashboard:', error);
            showError(`Failed to load data: ${error.message}`);
        } finally {
            showLoading(false);
        }
    }
    
    function refreshTopProducts() {
        const refreshBtn = document.getElementById('refresh-top-products');
        if (refreshBtn) {
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Loading...';
            refreshBtn.disabled = true;
        }
        
        // Simulate refresh by reloading dashboard data
        loadDashboardData(currentPeriod).finally(() => {
            if (refreshBtn) {
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Refresh';
                refreshBtn.disabled = false;
                showSuccess('Top products data refreshed');
            }
        });
    }
    
    function resetStatsLoading() {
        document.querySelectorAll('.stat-value').forEach(el => {
            el.innerHTML = '<span class="text-muted">Loading...</span>';
        });
        
        // Reset tables
        resetTablesLoading();
    }
    
    function resetTablesLoading() {
        const tables = ['recent-transactions', 'top-products', 'low-stock-products'];
        tables.forEach(tableId => {
            const tbody = document.getElementById(tableId);
            if (tbody) {
                if (tableId === 'top-products') {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-chart-bar"></i>
                                    <p>Calculating top products...</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-sync-alt fa-spin"></i>
                                    <p>Loading data...</p>
                                </div>
                            </td>
                        </tr>
                    `;
                }
            }
        });
    }
    
    function validateRealData(stats) {
        if (!stats) {
            console.warn('⚠️ No statistics data from API');
            return;
        }
        
        console.log('🔍 REAL Data Validation:');
        console.log('📈 Revenue:', stats.revenue, 'Type:', typeof stats.revenue);
        console.log('💰 Costs:', stats.purchase_cost, 'Type:', typeof stats.purchase_cost);
        console.log('💵 Profit:', stats.profit, 'Type:', typeof stats.profit);
        console.log('🛒 Transactions:', stats.transactions, 'Type:', typeof stats.transactions);
        
        // Check for dummy data
        const suspiciousValues = [50000, 100000, 0, 'dummy', 'test'];
        let hasDummyData = false;
        
        Object.entries(stats).forEach(([key, value]) => {
            if (suspiciousValues.includes(value)) {
                console.warn(`⚠️ Suspicious value found: ${key} = ${value}`);
                hasDummyData = true;
            }
        });
        
        if (hasDummyData) {
            console.warn('🚨 POSSIBLE DUMMY DATA! Check Flask route.');
        }
    }
    
    function getPeriodName(period) {
        const periods = {
            'today': 'today',
            'week': 'this week',
            'month': 'this month',
            'year': 'this year',
            'custom': 'custom'
        };
        return periods[period] || period;
    }
    
    function toggleCostBreakdown() {
        const breakdownDiv = document.getElementById('cost-breakdown');
        const detailBtn = document.getElementById('detail-btn');
        
        if (!currentDashboardData || !currentDashboardData.stats) {
            showError('Data not loaded yet');
            return;
        }
        
        const stats = currentDashboardData.stats;
        const revenue = parseFloat(stats.revenue) || 0;
        const purchaseCost = parseFloat(stats.purchase_cost) || 0;
        const profit = parseFloat(stats.profit) || (revenue - purchaseCost);
        
        if (breakdownDiv.classList.contains('show')) {
            breakdownDiv.classList.remove('show');
            if (detailBtn) {
                detailBtn.innerHTML = '<i class="fas fa-calculator"></i> Details';
            }
            return;
        }
        
        // Calculate percentage
        let profitPercentage = 0;
        let profitPercentageText = '0%';
        if (revenue > 0) {
            profitPercentage = (profit / revenue) * 100;
            profitPercentageText = profitPercentage.toFixed(1) + '%';
        }
        
        // Percentage color
        let percentageClass = 'text-muted';
        if (profitPercentage > 20) {
            percentageClass = 'text-success';
        } else if (profitPercentage > 10) {
            percentageClass = 'text-warning';
        } else if (profitPercentage < 0) {
            percentageClass = 'text-danger';
        }
        
        breakdownDiv.innerHTML = `
            <h5><i class="fas fa-calculator me-2"></i>Profit Calculation Details</h5>
            <div class="cost-item">
                <span>Total Revenue:</span>
                <span class="cost-value text-success">${formatCurrency(revenue)}</span>
            </div>
            <div class="cost-item">
                <span>Purchase Order Costs:</span>
                <span class="cost-value text-danger">${formatCurrency(purchaseCost)}</span>
            </div>
            <div class="cost-item">
                <span>Gross Profit:</span>
                <span class="cost-value ${profit >= 0 ? 'text-primary' : 'text-danger'}">
                    ${formatCurrency(profit)}
                </span>
            </div>
            <div class="cost-item total">
                <span>Profit Margin:</span>
                <span class="cost-value ${percentageClass}">
                    ${profitPercentageText}
                </span>
            </div>
            <div class="mt-3 small text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Formula: Profit = Revenue - Purchase Order Costs
            </div>
        `;
        
        breakdownDiv.classList.add('show');
        if (detailBtn) {
            detailBtn.innerHTML = '<i class="fas fa-times"></i> Close';
        }
    }
    
    async function applyCustomFilter() {
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');
        
        if (!startDateInput || !endDateInput) {
            showError('Date inputs not found');
            return;
        }
        
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        
        if (!startDate || !endDate) {
            showError('Please select start and end dates');
            return;
        }
        
        const start = new Date(startDate);
        const end = new Date(endDate);
        
        if (start > end) {
            showError('Start date cannot be later than end date');
            return;
        }
        
        const daysDiff = Math.floor((end - start) / (1000 * 60 * 60 * 24));
        if (daysDiff > 365) {
            showError('Date range maximum is 1 year');
            return;
        }
        
        if (daysDiff < 0) {
            showError('Invalid dates');
            return;
        }
        
        showLoading(true, `Loading data from ${startDate} to ${endDate}...`);
        
        try {
            const apiUrl = `/admin/dashboard/filter?period=custom&start_date=${startDate}&end_date=${endDate}&_t=${Date.now()}`;
            
            console.log('🌐 Custom API Request:', apiUrl);
            
            const response = await fetch(apiUrl);
            
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                updateDashboard(data);
                document.getElementById('custom-date-range').style.display = 'none';
                updateActiveFilterButton('custom');
                currentDashboardData = data;
                
                const revenue = formatCurrency(data.stats?.revenue || 0);
                const topProductsCount = data.tables?.top_products?.length || 0;
                showSuccess(`Data ${startDate} - ${endDate} loaded. ${topProductsCount} top products found.`);
            } else {
                throw new Error(data.message || 'Failed to load custom data');
            }
        } catch (error) {
            console.error('❌ Custom filter error:', error);
            showError(`Failed to load data: ${error.message}`);
        } finally {
            showLoading(false);
        }
    }
    
    function updateDashboard(data) {
        if (!data) {
            console.error('❌ No data to update dashboard');
            return;
        }
        
        console.log('🔄 Updating dashboard with REAL data');
        
        // Update stats
        if (data.stats) {
            updateStats(data.stats);
        } else {
            console.error('❌ No statistics data');
            showError('Statistics data not available');
        }
        
        // Update charts
        if (data.charts && data.charts.labels && data.charts.labels.length > 0) {
            updateCharts(data.charts);
            hideChartErrors();
        } else {
            console.info('ℹ️ Chart data empty (valid state)');
            hideChartErrors();
        }
        
        // Update tables
        if (data.tables) {
            updateTables(data.tables);
        } else {
            console.warn('⚠️ No table data');
        }
    }
    
    function updateStats(stats) {
        console.log('📊 Update stats with REAL data:', stats);
        
        // Validated data
        const revenue = parseFloat(stats.revenue) || 0;
        const purchaseCost = parseFloat(stats.purchase_cost) || 0;
        const profit = parseFloat(stats.profit) || (revenue - purchaseCost);
        const transactions = parseInt(stats.transactions) || 0;
        
        // 1. Revenue
        document.getElementById('revenue-value').innerHTML = formatCurrency(revenue);
        
        // 2. Profit
        const profitColor = profit > 0 ? 'text-success' : profit < 0 ? 'text-danger' : 'text-muted';
        document.getElementById('profit-value').innerHTML = `
            <span class="${profitColor}">${formatCurrency(profit)}</span>
        `;
        
        // 3. Purchase Order Costs
        document.getElementById('purchase-cost-value').innerHTML = formatCurrency(purchaseCost);
        
        // 4. Transaction Count
        document.getElementById('transactions-value').textContent = transactions.toLocaleString('en-US');
        
        console.log('✅ Stats updated:', { revenue, purchaseCost, profit, transactions });
    }
    
    function updateCharts(chartData) {
        console.log('📈 Update charts with REAL data:', chartData);
        
        const labels = chartData.labels || [];
        const revenueData = chartData.revenue || [];
        const profitData = chartData.profit || [];
        const purchaseCostData = chartData.purchase_cost || [];
        
        // Validate chart data
        const hasValidData = revenueData.length > 0 || profitData.length > 0 || purchaseCostData.length > 0;
        
        if (!hasValidData) {
            console.warn('⚠️ No valid data for charts');
            showChartErrors();
            return;
        }
        
        // Hide error messages
        hideChartErrors();
        
        // 1. Revenue & Profit Chart
        updateRevenueProfitChart(labels, revenueData, profitData);
        
        // 2. Cost vs Profit Chart
        updateCostProfitChart(labels, purchaseCostData, profitData);
    }
    
    function updateRevenueProfitChart(labels, revenueData, profitData) {
        const ctx = document.getElementById('revenue-profit-chart');
        if (!ctx) return;
        
        if (revenueProfitChart) {
            revenueProfitChart.destroy();
        }
        
        const revenueGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        revenueGradient.addColorStop(0, 'rgba(52, 152, 219, 0.3)');
        revenueGradient.addColorStop(1, 'rgba(52, 152, 219, 0.05)');
        
        const profitGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        profitGradient.addColorStop(0, 'rgba(46, 204, 113, 0.3)');
        profitGradient.addColorStop(1, 'rgba(46, 204, 113, 0.05)');
        
        revenueProfitChart = new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: '#3498db',
                        backgroundColor: revenueGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3498db',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Profit',
                        data: profitData,
                        borderColor: '#2ecc71',
                        backgroundColor: profitGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#2ecc71',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: getChartOptions('$', 'Revenue & Profit')
        });
    }
    
    function updateCostProfitChart(labels, purchaseCostData, profitData) {
        const ctx = document.getElementById('cost-profit-chart');
        if (!ctx) return;
        
        if (costProfitChart) {
            costProfitChart.destroy();
        }
        
        costProfitChart = new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Purchase Order Costs',
                        data: purchaseCostData,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)',
                        borderColor: '#e74c3c',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: 'Profit',
                        data: profitData,
                        backgroundColor: 'rgba(46, 204, 113, 0.8)',
                        borderColor: '#2ecc71',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: getChartOptions('$', 'Costs vs Profit')
        });
    }
    
    function showChartErrors() {
        const errors = ['revenue-profit-chart-error', 'cost-profit-chart-error'];
        errors.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'block';
        });
    }
    
    function hideChartErrors() {
        const errors = ['revenue-profit-chart-error', 'cost-profit-chart-error'];
        errors.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });
    }
    
    function getChartOptions(prefix = '', title = '') {
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#34495e',
                        font: { size: 12, weight: 'bold' },
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(44, 62, 80, 0.95)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#3498db',
                    borderWidth: 1,
                    cornerRadius: 6,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const label = context.dataset.label || '';
                            const value = context.parsed.y;
                            return `${label}: ${prefix}${value.toLocaleString('en-US')}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: {
                        color: '#7f8c8d',
                        padding: 8,
                        callback: function(value) {
                            return prefix + value.toLocaleString('en-US');
                        }
                    }
                },
                x: {
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false },
                    ticks: { color: '#7f8c8d', padding: 8 }
                }
            },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        };
    }
    
    function updateTables(tableData) {
        if (!tableData) {
            console.warn('⚠️ No table data');
            return;
        }
        
        console.log('📋 Update tables with REAL data');
        
        if (tableData.recent_transactions) {
            updateTransactionTable(tableData.recent_transactions);
        }
        
        if (tableData.top_products) {
            updateProductTable(tableData.top_products);
        }
        
        if (tableData.low_stock) {
            updateLowStockTable(tableData.low_stock);
        }
    }
    
    function updateTransactionTable(transactions) {
        const tbody = document.getElementById('recent-transactions');
        if (!tbody) return;
        
        if (!transactions || transactions.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <p>No transactions yet</p>
                            <small class="text-muted mt-2">Database has no transactions in this period</small>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        transactions.forEach(transaction => {
            const date = formatTransactionDate(transaction.created_at_wib || transaction.created_at);
            const amount = parseFloat(transaction.total_amount) || 0;
            const statusInfo = getStatusInfo(transaction.status);
            
            html += `
                <tr>
                    <td><strong class="text-primary">${transaction.transaction_code || 'N/A'}</strong></td>
                    <td>${date}</td>
                    <td><span class="fw-bold text-success">${formatCurrency(amount)}</span></td>
                    <td><span class="badge ${statusInfo.class}"><i class="fas ${statusInfo.icon} me-1"></i>${statusInfo.text}</span></td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
    }
    
    function updateProductTable(products) {
        const tbody = document.getElementById('top-products');
        if (!tbody) return;
        
        console.log('🏆 Rendering top products:', products);
        
        // DEBUG: Log product details for verification
        if (products && products.length > 0) {
            products.forEach((p, i) => {
                console.log(`Product ${i + 1}: ${p.name}, Sold: ${p.total_sold}, Revenue: ${p.total_revenue}`);
            });
        }
        
        if (!products || products.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>No product sales data yet</p>
                            <small class="text-muted mt-2">No products sold in this period</small>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        products.forEach((product, index) => {
            const medal = getMedalIcon(index);
            const sold = parseInt(product.total_sold) || 0;
            const revenue = parseFloat(product.total_revenue) || 0;
            const productName = product.name || 'Unknown Product';
            
            // Handle SKU - if "N/A" or empty, show placeholder
            let skuDisplay = product.sku || 'No SKU';
            if (skuDisplay === 'N/A' || skuDisplay === '' || skuDisplay === null) {
                skuDisplay = '<span class="text-muted">-</span>';
            }
            
            const category = product.category || 'General';
            
            html += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-2">${medal}</div>
                            <div>
                                <strong>${productName}</strong>
                                <div class="text-muted small">${skuDisplay}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="category-badge">${category}</span></td>
                    <td><span class="fw-bold text-primary">${sold.toLocaleString('en-US')} pcs</span></td>
                    <td><span class="fw-bold text-success">${formatCurrency(revenue)}</span></td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
        console.log(`✅ ${products.length} top products displayed`);
    }
    
    function updateLowStockTable(products) {
        const tbody = document.getElementById('low-stock-products');
        if (!tbody) return;
        
        if (!products || products.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-check-circle text-success"></i>
                            <p>All stock is safe</p>
                            <small class="text-muted mt-2">No products with low stock</small>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        products.forEach(product => {
            const stock = parseInt(product.stock) || 0;
            const alertLevel = parseInt(product.low_stock_alert) || 10;
            const stockInfo = getStockInfo(stock, alertLevel);
            const percentage = alertLevel > 0 ? Math.min(100, (stock / alertLevel) * 100) : 0;
            
            html += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-box text-primary me-2"></i>
                            <div>
                                <strong>${product.name || 'Product'}</strong>
                                <div class="text-muted small">Alert: ${alertLevel} pcs</div>
                            </div>
                        </div>
                    </td>
                    <td>${product.category || 'General'}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                <div class="progress-bar ${stockInfo.progressClass}" style="width: ${percentage}%"></div>
                            </div>
                            <span class="fw-bold ${stockInfo.textClass}">${stock}</span>
                        </div>
                    </td>
                    <td><span class="badge ${stockInfo.badgeClass}"><i class="fas ${stockInfo.icon} me-1"></i>${stockInfo.status}</span></td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
    }
    
    // Helper Functions
    function formatCurrency(amount) {
        if (typeof amount !== 'number') {
            amount = parseFloat(amount) || 0;
        }
        
        return '$' + amount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
    
    function updateActiveFilterButton(period) {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        
        const buttonTexts = {
            'today': 'Today',
            'week': 'This Week',
            'month': 'This Month',
            'year': 'This Year',
            'custom': 'Custom'
        };
        
        const targetText = buttonTexts[period];
        if (targetText) {
            const targetButton = Array.from(document.querySelectorAll('.filter-btn'))
                .find(btn => btn.textContent.includes(targetText));
            if (targetButton) targetButton.classList.add('active');
        }
    }
    
    function formatTransactionDate(dateString) {
        if (!dateString) return 'N/A';

        try {
            const tlDate = convertToTimorLeste(dateString);
            if (!tlDate) return 'N/A';

            const day = String(tlDate.getDate()).padStart(2, '0');
            const month = String(tlDate.getMonth() + 1).padStart(2, '0');
            const year = tlDate.getFullYear();
            const hours = String(tlDate.getHours()).padStart(2, '0');
            const minutes = String(tlDate.getMinutes()).padStart(2, '0');

            return `${day}/${month}/${year} ${hours}:${minutes}`;
        } catch (err) {
            console.error('Date format error:', err);
            return 'N/A';
        }
    }
    
    function getStatusInfo(status) {
        const statusMap = {
            'completed': { class: 'badge-success', icon: 'fa-check', text: 'Completed' },
            'pending': { class: 'badge-warning', icon: 'fa-clock', text: 'Pending' },
            'cancelled': { class: 'badge-danger', icon: 'fa-times', text: 'Cancelled' }
        };
        
        return statusMap[status] || { class: 'badge-secondary', icon: 'fa-question', text: status || 'Unknown' };
    }
    
    function getMedalIcon(index) {
        const medals = [
            '<i class="fas fa-crown text-warning"></i>',
            '<i class="fas fa-medal text-secondary"></i>',
            '<i class="fas fa-award text-danger"></i>'
        ];
        return medals[index] || '<i class="fas fa-star text-info"></i>';
    }
    
    function getStockInfo(stock, alertLevel) {
        if (stock < 3) {
            return {
                progressClass: 'bg-danger',
                textClass: 'text-danger',
                badgeClass: 'badge-danger',
                icon: 'fa-fire',
                status: 'CRITICAL'
            };
        } else if (stock < alertLevel) {
            return {
                progressClass: 'bg-warning',
                textClass: 'text-warning',
                badgeClass: 'badge-warning',
                icon: 'fa-exclamation-triangle',
                status: 'LOW'
            };
        } else {
            return {
                progressClass: 'bg-success',
                textClass: 'text-success',
                badgeClass: 'badge-success',
                icon: 'fa-check-circle',
                status: 'SAFE'
            };
        }
    }
    
    function changeChartType(chartId, type) {
        const chart = chartId === 'revenue-profit' ? revenueProfitChart : costProfitChart;
        const container = document.getElementById(chartId + '-chart')?.closest('.chart-card');
        
        if (container && chart) {
            const buttons = container.querySelectorAll('.chart-type-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            buttons.forEach(btn => {
                if (btn.textContent.toLowerCase().includes(type)) {
                    btn.classList.add('active');
                }
            });
            
            chart.config.type = type;
            chart.update();
        }
    }
    
    function setupEventListeners() {
        // Date input enter key
        document.getElementById('start-date')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') applyCustomFilter();
        });
        
        document.getElementById('end-date')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') applyCustomFilter();
        });
    }
    
    // Debug function
    window.debugDashboard = function() {
        console.log('=== DASHBOARD DEBUG INFO ===');
        console.log('Current Period:', currentPeriod);
        console.log('Current Data:', currentDashboardData);
        console.log('Revenue Chart:', revenueProfitChart?.data);
        console.log('Cost Chart:', costProfitChart?.data);
        
        if (currentDashboardData?.stats) {
            const stats = currentDashboardData.stats;
            console.log('📊 STATS CALCULATION CHECK:');
            console.log('Revenue:', stats.revenue);
            console.log('Purchase Cost:', stats.purchase_cost);
            console.log('Profit (from API):', stats.profit);
            console.log('Profit (calculated):', (parseFloat(stats.revenue) || 0) - (parseFloat(stats.purchase_cost) || 0));
            console.log('Transactions:', stats.transactions);
        }
        
        if (currentDashboardData?.tables?.top_products) {
            console.log('🏆 TOP PRODUCTS DATA:');
            currentDashboardData.tables.top_products.forEach((product, index) => {
                console.log(`${index + 1}. ${product.name}: ${product.total_sold} sold, ${formatCurrency(product.total_revenue)}`);
            });
        }
    };
    
    // Auto-refresh every 5 minutes
    setInterval(() => {
        if (!document.querySelector('#loading-overlay.active') && currentPeriod) {
            console.log('🔄 Auto-refresh dashboard');
            loadDashboardData(currentPeriod);
        }
    }, 300000);
    
    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey) {
            switch(e.key) {
                case 'r': e.preventDefault(); loadDashboardData(currentPeriod); break;
                case 'd': e.preventDefault(); window.debugDashboard(); break;
                case 'e': e.preventDefault(); toggleCostBreakdown(); break;
                case 't': e.preventDefault(); refreshTopProducts(); break;
            }
        }
    });
</script>
@endsection