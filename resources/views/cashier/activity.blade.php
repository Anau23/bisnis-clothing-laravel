@extends('cashier.layout')

@section('title', 'Aktivitas - Dili Society')

@section('page_title', 'Aktivitas Transaksi')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Section - Mobile Optimized -->
    <div class="card border-0 shadow-sm mb-2 mb-md-4">
        <div class="card-body p-2 p-md-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div class="mb-2 mb-md-0">
                    <h2 class="h5 mb-1 mb-md-2 fw-bold text-navy-dark">
                        <i class="fas fa-receipt d-inline d-md-none me-2"></i>
                        Aktivitas Transaksi
                    </h2>
                    <p class="text-muted mb-0 small d-none d-md-block">Riwayat penjualan dan aktivitas kasir</p>
                </div>
                <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
                    <!-- Date Filter -->
                    <div class="position-relative flex-grow-1 flex-md-grow-0" style="min-width: 120px;">
                        <div class="position-absolute top-50 start-0 translate-middle-y ps-2 ps-md-3">
                            <i class="fas fa-calendar-alt text-muted"></i>
                        </div>
                        <input type="date" id="dateFilter" 
                               class="form-control form-control-sm ps-4 ps-md-5 border border-light"
                               style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content - Mobile First -->
    <div class="row g-2 g-md-4">
        <!-- Left Column - Transaction List -->
        <div class="col-12 col-lg-5 col-xl-4">
            <!-- Search and Filter Card -->
            <div class="card border-0 shadow-sm mb-2 mb-md-4">
                <div class="card-body p-2 p-md-4">
                    <!-- Search Bar -->
                    <div class="input-group input-group-sm mb-2 mb-md-3">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm border-start-0"
                               placeholder="Cari invoice...">
                    </div>
                    
                    <!-- Filter Buttons -->
                    <div class="row g-2 mb-2">
                        <div class="col-8">
                            <button onclick="ActivityManager.filterByDate('today')" 
                                    class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-calendar-day me-1"></i> Hari Ini
                            </button>
                        </div>
                        <div class="col-4">
                            <button onclick="ActivityManager.resetFilters()" 
                                    class="btn btn-outline-secondary btn-sm w-100">
                                <i class="fas fa-redo"></i>
                                <span class="d-none d-sm-inline ms-1">Reset</span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="mb-2">
                        <label class="form-label small fw-medium mb-2">Status Transaksi</label>
                        <div class="btn-group btn-group-sm w-100" role="group">
                            <input type="radio" class="btn-check" name="statusFilter" id="statusAll" autocomplete="off" checked onclick="ActivityManager.filterByStatus('all')">
                            <label class="btn btn-outline-primary" for="statusAll">Semua</label>
                            
                            <input type="radio" class="btn-check" name="statusFilter" id="statusCompleted" autocomplete="off" onclick="ActivityManager.filterByStatus('completed')">
                            <label class="btn btn-outline-success" for="statusCompleted">Selesai</label>
                            
                            <input type="radio" class="btn-check" name="statusFilter" id="statusCancelled" autocomplete="off" onclick="ActivityManager.filterByStatus('cancelled')">
                            <label class="btn btn-outline-danger" for="statusCancelled">Batal</label>
                        </div>
                    </div>
                    
                    <!-- Active Filters -->
                    <div id="activeFilters" class="d-flex flex-wrap gap-1 mb-2"></div>
                    
                    <!-- Date Range Info -->
                    <div id="dateRangeInfo" class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        <span id="dateInfoText">Menampilkan data hari ini</span>
                    </div>
                </div>
            </div>
            
            <!-- Transaction List Card -->
            <div class="card border-0 shadow-sm" style="min-height: 400px;">
                <div class="card-header bg-white border-bottom py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-navy-dark small">
                            <i class="fas fa-list-alt me-2 text-primary d-none d-md-inline"></i>
                            Daftar Transaksi
                        </h5>
                        <div class="text-end">
                            <div class="text-muted small">
                                <span id="transactionCount">0</span> transaksi
                            </div>
                            <div class="fw-bold text-primary small" id="totalAmountDisplay">$ 0</div>
                        </div>
                    </div>
                </div>
                
                <!-- Loading State -->
                <div id="loadingState" class="card-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Memuat transaksi...</p>
                </div>
                
                <!-- Empty State -->
                <div id="emptyState" class="card-body text-center py-5 d-none">
                    <div class="text-muted mb-3">
                        <i class="fas fa-receipt fa-2x opacity-50"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Belum ada transaksi</h5>
                    <p class="text-muted mb-3 small">Tidak ada transaksi untuk filter yang dipilih</p>
                    <button onclick="ActivityManager.resetFilters()" 
                            class="btn btn-primary btn-sm">
                        <i class="fas fa-redo me-1"></i> Reset Filter
                    </button>
                </div>
                
                <!-- Transaction List -->
                <div id="transactionsContainer" class="list-group list-group-flush" 
                     style="max-height: 350px; overflow-y: auto;">
                    <!-- Transactions will be loaded here -->
                </div>
                
                <!-- Pagination -->
                <div id="pagination" class="card-footer bg-white border-top py-2 px-3 d-none">
                    <!-- Pagination will be loaded here -->
                </div>
            </div>
        </div>
        
        <!-- Right Column - Transaction Detail & Summary -->
        <div class="col-12 col-lg-7 col-xl-8 mt-3 mt-lg-0">
            <!-- Transaction Detail Panel -->
            <div id="transactionDetailPanel" class="card border-0 shadow-sm mb-3 d-none">
                <!-- Mobile Header dengan tombol navigasi -->
                <div class="card-header bg-white border-bottom py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Tombol Kembali untuk mobile -->
                        <button onclick="ActivityManager.closeDetailPanel()" 
                                class="btn btn-outline-secondary btn-sm d-lg-none">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </button>
                        
                        <!-- Desktop Header -->
                        <div class="d-none d-lg-flex align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold text-navy-dark">
                                    <i class="fas fa-file-invoice me-2 text-primary"></i>
                                    Detail Transaksi
                                </h5>
                                <div class="mt-1" id="transactionDetailHeader">
                                    <!-- Transaction info will appear here -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right side buttons - Different for mobile/desktop -->
                        <div class="d-flex gap-2">
                            <!-- Tombol Pilih Lain untuk mobile -->
                            <button onclick="ActivityManager.closeDetailPanel()" 
                                    class="btn btn-outline-primary btn-sm d-lg-none">
                                <i class="fas fa-list me-2"></i> Pilih Lain
                            </button>
                            
                            <!-- Desktop buttons -->
                            <div class="d-none d-lg-flex gap-2">
                                <button onclick="ActivityManager.printReceipt()" 
                                        id="printReceiptBtn"
                                        class="btn btn-primary btn-sm">
                                    <i class="fas fa-print"></i>
                                    <span class="ms-1">Cetak</span>
                                </button>
                                <button onclick="ActivityManager.closeDetailPanel()" 
                                        class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile transaction header info -->
                    <div id="mobileTransactionHeader" class="d-lg-none mt-3">
                        <!-- Transaction info will appear here -->
                    </div>
                </div>
                
                <!-- Loading State for Detail -->
                <div id="detailLoadingState" class="card-body text-center py-5 d-none">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mb-0">Memuat detail transaksi...</p>
                </div>
                
                <!-- Detail Content -->
                <div id="detailContent" class="card-body p-0" 
                     style="max-height: calc(100vh - 200px); overflow-y: auto;">
                    <!-- Content will be loaded here -->
                </div>
                
                <!-- Mobile Footer Actions -->
                <div class="card-footer bg-white border-top p-3 d-lg-none">
                    <div class="row g-2">
                        <div class="col-6">
                            <button onclick="ActivityManager.closeDetailPanel()" 
                                    class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i> Pilih Lain
                            </button>
                        </div>
                        <div class="col-6">
                            <button onclick="ActivityManager.printReceipt()" 
                                    class="btn btn-primary w-100">
                                <i class="fas fa-print me-2"></i> Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Empty State for Detail Panel -->
            <div id="detailEmptyState" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 px-3">
                    <div class="text-muted mb-4">
                        <i class="fas fa-receipt fa-3x opacity-50"></i>
                    </div>
                    <h4 class="fw-bold text-navy-dark mb-2">Belum ada transaksi dipilih</h4>
                    <p class="text-muted mb-4">Pilih salah satu transaksi dari daftar untuk melihat detail</p>
                </div>
            </div>
            
            <!-- Summary Card -->
            <div id="summaryCard" class="card border-0 shadow-sm mt-3">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold text-navy-dark">
                            <i class="fas fa-chart-pie me-2 text-primary"></i>
                            Ringkasan
                        </h5>
                        <span class="text-muted small" id="summaryPeriod">Hari ini</span>
                    </div>
                    
                    <!-- Total Revenue -->
                    <div class="bg-white bg-opacity-10 p-3 rounded mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded p-2 me-3">
                                <i class="fas fa-coins text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Total Penghasilan</p>
                                <h3 class="fw-bold text-primary mb-0" id="summaryRevenue">$ 0</h3>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div class="row mb-3">
                        <div class="col-6 col-md-3 mb-2">
                            <div class="text-center">
                                <p class="text-muted small mb-1">Transaksi</p>
                                <h4 class="fw-bold text-navy-dark" id="summaryTransactions">0</h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="text-center">
                                <p class="text-muted small mb-1">Produk</p>
                                <h4 class="fw-bold text-navy-dark" id="summaryItems">0</h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="text-center">
                                <p class="text-muted small mb-1">Rata-rata</p>
                                <h4 class="fw-bold text-navy-dark" id="summaryAvgTransaction">$ 0</h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="text-center">
                                <p class="text-muted small mb-1">Cash</p>
                                <h4 class="fw-bold text-navy-dark" id="summaryCash">$ 0</h4>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="row g-2">
                        <div class="col-6">
                            <button onclick="ActivityManager.printReport()" 
                                    class="btn btn-primary w-100">
                                <i class="fas fa-print me-2"></i> Cetak
                            </button>
                        </div>
                        <div class="col-6">
                            <button onclick="ActivityManager.exportReport()" 
                                    class="btn btn-outline-primary w-100">
                                <i class="fas fa-download me-2"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Template (Hidden) -->
<div id="printTemplate" class="d-none">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printArea, #printArea * {
                visibility: visible;
            }
            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>
    <div id="printArea"></div>
</div>

<script>
// ==================== FUNGSI UTILITAS WAKTU TIMOR-LESTE ====================
const TimeUtils = {
    // ================= TIMEZONE =================
    TL_OFFSET_MS: 9 * 60 * 60 * 1000, // UTC+9

    // UTC STRING -> Date TL
    utcToTL(utcString) {
        if (!utcString) return null;
        const utc = new Date(utcString);
        return new Date(utc.getTime() + this.TL_OFFSET_MS);
    },

    // Current Date TL
    getCurrentTLDate() {
        const now = new Date();
        return new Date(now.getTime() + this.TL_OFFSET_MS);
    },

    // Today TL YYYY-MM-DD
    getTodayTLDateString() {
        return this.getCurrentTLDate().toISOString().slice(0, 10);
    },

    // Yesterday TL YYYY-MM-DD
    getYesterdayTLDateString() {
        const d = this.getCurrentTLDate();
        d.setDate(d.getDate() - 1);
        return d.toISOString().slice(0, 10);
    },

    // TL date string -> UTC range
    getUTCDayRange(tlDateString) {
        const startTL = new Date(`${tlDateString}T00:00:00+09:00`);
        const endTL   = new Date(`${tlDateString}T23:59:59+09:00`);
        return {
            start: startTL.toISOString(),
            end: endTL.toISOString()
        };
    },

    // ================= FORMAT =================
    formatDateTimeFromUTC(utcString) {
        const d = this.utcToTL(utcString);
        if (!d) return '-';
        return d.toLocaleString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    formatDateOnlyFromUTC(utcString) {
        const d = this.utcToTL(utcString);
        if (!d) return '-';
        return d.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    },

    formatTimeOnlyFromUTC(utcString) {
        const d = this.utcToTL(utcString);
        if (!d) return '-';
        return d.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    formatDateFromString(dateString) {
        if (!dateString) return '-';
        const [y, m, d] = dateString.split('-');
        const date = new Date(`${y}-${m}-${d}T00:00:00+09:00`);
        return date.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }
};

const ActivityManager = {
    currentPage: 1,
    itemsPerPage: 10,
    totalPages: 1,
    totalTransactions: 0,
    allTransactions: [],
    currentTransaction: null,
    activeFilters: {
        status: 'all',
        date: TimeUtils.getTodayTLDateString(),
        dateRange: 'today'
    },
    currentStats: null,
    isMobile: window.innerWidth < 768,
    
    async init() {
        console.log('🚀 Activity Manager Initializing...');
        
        this.isMobile = window.innerWidth < 768;
        this.itemsPerPage = this.isMobile ? 5 : 10;
        
        // PERBAIKAN: Debug informasi tanggal
        console.log('=== DEBUG DATE INFORMATION ===');
        const now = new Date();
        console.log('Browser time now:', now.toString());
        console.log('Browser date (local):', now.toDateString());
        console.log('Browser ISO:', now.toISOString());
        console.log('Browser timezone offset:', now.getTimezoneOffset(), 'minutes');
        console.log('Timezone name:', Intl.DateTimeFormat().resolvedOptions().timeZone);
        
        const todayTL = TimeUtils.getTodayTLDateString();
        console.log('Today TL date string:', todayTL);
        
        const dateInput = document.getElementById('dateFilter');
        if (dateInput) {
            dateInput.value = todayTL;
            dateInput.max = todayTL;
            this.activeFilters.date = todayTL;
            console.log('Date input value set to:', todayTL);
        }
        
        this.setupEventListeners();
        await this.loadStats();
        await this.loadTransactions();
        this.updateActiveFiltersDisplay();
        this.updateDateRangeInfo();
        
        console.log('✅ Activity Manager initialized with TL date:', todayTL);
    },
    
    setupEventListeners() {
        const dateFilter = document.getElementById('dateFilter');
        if (dateFilter) {
            dateFilter.addEventListener('change', async (e) => {
                this.activeFilters.date = e.target.value || TimeUtils.getTodayTLDateString();
                this.activeFilters.dateRange = 'custom';
                this.currentPage = 1;
                await this.loadStats();
                await this.loadTransactions();
                this.updateActiveFiltersDisplay();
                this.updateDateRangeInfo();
            });
        }
        
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.currentPage = 1;
                    this.loadTransactions();
                }, 500);
            });
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && document.getElementById('transactionDetailPanel').classList.contains('d-none') === false) {
                this.closeDetailPanel();
            }
        });
        
        window.addEventListener('resize', this.handleResize.bind(this));
    },
    
    handleResize() {
        const wasMobile = this.isMobile;
        this.isMobile = window.innerWidth < 768;
        
        if (wasMobile !== this.isMobile) {
            this.itemsPerPage = this.isMobile ? 5 : 10;
            this.loadTransactions();
        }
    },
    
    async loadStats() {
        try {
            const date = this.activeFilters.date;
            const dateRange = TimeUtils.getUTCDayRange(date);
            
            console.log('=== LOADING STATS ===');
            console.log('TL Date selected:', date);
            console.log('UTC Date range for filter:', dateRange);
            
            const response = await fetch(`/api/cashier/activity/stats?start_date=${encodeURIComponent(dateRange.start)}&end_date=${encodeURIComponent(dateRange.end)}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Stats API Response:', data);
            
            if (data.success) {
                this.currentStats = data.stats;
                this.updateStatsDisplay(data.stats);
                
                // Update totalAmountDisplay dari stats API
                const totalSales = data.stats.total_sales || 0;
                document.getElementById('totalAmountDisplay').textContent = `$ ${this.formatNumber(totalSales)}`;
                console.log(`✅ Total sales for date ${date}: $${totalSales}`);
            } else {
                console.warn('Stats API error:', data.message);
                this.currentStats = {
                    total_sales: 0,
                    total_transactions: 0,
                    total_items: 0,
                    cash_sales: 0,
                    transfer_sales: 0,
                    avg_transaction: 0,
                    change_percent: 0,
                    today_transactions: 0
                };
                this.updateStatsDisplay(this.currentStats);
                document.getElementById('totalAmountDisplay').textContent = '$ 0';
            }
        } catch (error) {
            console.error('Error loading stats:', error);
            this.currentStats = {
                total_sales: 0,
                total_transactions: 0,
                total_items: 0,
                cash_sales: 0,
                transfer_sales: 0,
                avg_transaction: 0,
                change_percent: 0,
                today_transactions: 0
            };
            this.updateStatsDisplay(this.currentStats);
            document.getElementById('totalAmountDisplay').textContent = '$ 0';
        }
    },
    
    updateStatsDisplay(stats) {
        document.getElementById('summaryRevenue').textContent = `$ ${this.formatNumber(stats.total_sales)}`;
        document.getElementById('summaryTransactions').textContent = stats.total_transactions;
        document.getElementById('summaryItems').textContent = stats.total_items;
        document.getElementById('summaryAvgTransaction').textContent = `$ ${this.formatNumber(Math.round(stats.avg_transaction || 0))}`;
        document.getElementById('summaryCash').textContent = `$ ${this.formatNumber(stats.cash_sales || 0)}`;
        
        const periodText = this.getDateRangeText();
        document.getElementById('summaryPeriod').textContent = periodText;
        document.getElementById('dateInfoText').textContent = periodText;
    },
    
    async loadTransactions() {
        try {
            this.showLoadingState();
            
            const searchQuery = document.getElementById('searchInput')?.value.trim() || '';
            const date = this.activeFilters.date;
            const dateRange = TimeUtils.getUTCDayRange(date);
            
            console.log('=== LOADING TRANSACTIONS ===');
            console.log('TL Date selected:', date);
            console.log('UTC Date range for filter:', dateRange);
            
            const params = new URLSearchParams({
                page: this.currentPage,
                per_page: this.itemsPerPage,
                status: this.activeFilters.status,
                start_date: dateRange.start,
                end_date: dateRange.end,
                search: searchQuery
            });
            
            const url = `/api/cashier/activity/transactions?${params}`;
            console.log('Fetching URL:', url);
            
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Transactions API Response:', data);
            
            if (data.success) {
                if (data.transactions && data.transactions.length > 0) {
                    this.allTransactions = data.transactions;
                    this.totalTransactions = data.total || data.transactions.length;
                    this.totalPages = data.pages || Math.ceil(this.totalTransactions / this.itemsPerPage);
                    
                    console.log(`✅ Loaded ${this.allTransactions.length} transactions`);
                    
                    this.updateTransactionsUI(data.transactions);
                    this.updatePagination(data);
                    
                    document.getElementById('transactionCount').textContent = this.totalTransactions;
                    
                    if (!this.isMobile && data.transactions.length > 0 && !this.currentTransaction) {
                        await this.viewTransactionDetail(data.transactions[0].id);
                    }
                } else {
                    console.log('❌ No transactions found');
                    this.showEmptyState();
                    this.hideDetailPanel();
                    document.getElementById('transactionCount').textContent = '0';
                }
            } else {
                console.error('API Error:', data.message);
                this.showEmptyState();
                this.hideDetailPanel();
                document.getElementById('transactionCount').textContent = '0';
            }
        } catch (error) {
            console.error('Error loading transactions:', error);
            this.showEmptyState();
            this.hideDetailPanel();
            document.getElementById('transactionCount').textContent = '0';
        }
    },
    
    updateTransactionsUI(transactions) {
        const container = document.getElementById('transactionsContainer');
        const loadingState = document.getElementById('loadingState');
        const emptyState = document.getElementById('emptyState');
        
        this.hideLoadingState();
        emptyState.classList.add('d-none');
        container.classList.remove('d-none');
        
        if (transactions.length === 0) {
            container.innerHTML = `
                <div class="list-group-item text-center py-4">
                    <div class="text-muted mb-2">
                        <i class="fas fa-receipt fa-2x opacity-50"></i>
                    </div>
                    <h5 class="fw-bold mb-1 small">Belum ada transaksi</h5>
                    <p class="text-muted mb-2 small">Tidak ada transaksi untuk tanggal ${this.activeFilters.date}</p>
                    <button onclick="ActivityManager.resetFilters()" 
                            class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-redo me-1"></i> Tampilkan Semua
                    </button>
                </div>
            `;
            return;
        }
        
        const transactionsHtml = transactions.map(transaction => {
            // Convert UTC to Timor-Leste Time
            const utcDate = new Date(transaction.created_at);
            
            
            const status = transaction.status === 'completed' ? 'Selesai' : 
                          transaction.status === 'cancelled' ? 'Batal' : 
                          transaction.status;
            
            const totalItems = transaction.items ? transaction.items.length : 0;
            const isActive = this.currentTransaction && this.currentTransaction.id === transaction.id;
            
            // PERBAIKAN: Gunakan format Timor-Leste time dari fungsi yang sudah benar
            const displayDate = TimeUtils.formatDateOnlyFromUTC(transaction.created_at);
            const displayTime = TimeUtils.formatTimeOnlyFromUTC(transaction.created_at);
            
            if (this.isMobile) {
                return `
                <div class="list-group-item list-group-item-action ${isActive ? 'active' : ''}" 
                     onclick="ActivityManager.viewTransactionDetail(${transaction.id})">
                    <div class="card border mb-2">
                        <div class="card-body p-3">
                            <!-- Header dengan invoice dan total -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary me-2">${transaction.transaction_code}</span>
                                        <span class="badge ${this.getStatusColor(transaction.status)}">
                                            ${status}
                                        </span>
                                    </div>
                                    <!-- WAKTU TIMOR-LESTE -->
                                    <div class="text-muted small">
                                        <i class="fas fa-calendar-alt me-1"></i>${displayDate}
                                        <i class="fas fa-clock ms-2 me-1"></i>${displayTime}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary mb-1">$ ${this.formatNumber(transaction.total_amount || 0)}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-${transaction.payment_method === 'cash' ? 'money-bill-wave' : 'exchange-alt'}"></i>
                                        ${transaction.payment_method === 'cash' ? 'Cash' : 'Transfer'}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Info kasir dan items -->
                            <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                                <div>
                                    <small class="text-muted d-block">Kasir</small>
                                    <span class="fw-medium small">${transaction.cashier || 'Unknown'}</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Items</small>
                                    <span class="fw-medium small">${totalItems} item</span>
                                </div>
                            </div>
                            
                            <!-- Items preview -->
                            ${transaction.items && transaction.items.length > 0 ? `
                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-1">
                                    ${transaction.items.slice(0, 2).map(item => `
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-tshirt me-1 text-xs"></i>
                                            ${item.product_name} (${item.quantity})
                                        </span>
                                    `).join('')}
                                    ${transaction.items.length > 2 ? `
                                        <span class="badge bg-primary text-white">
                                            +${transaction.items.length - 2} lainnya
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            ` : ''}
                            
                            ${isActive ? `
                            <div class="mt-3 text-center">
                                <span class="badge bg-primary">
                                    <i class="fas fa-eye me-1"></i> Terpilih
                                </span>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                `;
            }
            
            return `
            <div class="list-group-item list-group-item-action ${isActive ? 'active' : ''}" 
                 onclick="ActivityManager.viewTransactionDetail(${transaction.id})">
                <div class="d-flex w-100 justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2">${transaction.transaction_code}</span>
                        <!-- WAKTU TIMOR-LESTE -->
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>${displayDate}
                            <span class="mx-1">•</span>
                            <i class="fas fa-clock me-1"></i>${displayTime}
                        </small>
                        ${isActive ? `
                            <span class="badge bg-primary ms-2">
                                <i class="fas fa-eye me-1"></i> Terpilih
                            </span>
                        ` : ''}
                    </div>
                    <div class="text-end">
                        <h6 class="mb-1 text-primary">$ ${this.formatNumber(transaction.total_amount || 0)}</h6>
                        <span class="badge ${this.getStatusColor(transaction.status)}">
                            ${status}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 fw-medium">Pelanggan</p>
                        <small class="text-muted">
                            <i class="fas fa-user-tie me-1"></i>Kasir: ${transaction.cashier || 'Unknown'}
                        </small>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">
                            <i class="fas fa-box me-1"></i> ${totalItems} item
                            <span class="mx-2">•</span>
                            <i class="fas fa-money-bill-wave me-1"></i> ${transaction.payment_method === 'cash' ? 'Cash' : 'Transfer'}
                        </small>
                    </div>
                </div>
                
                ${transaction.items && transaction.items.length > 0 ? `
                <div class="mt-3">
                    <div class="d-flex flex-wrap gap-1">
                        ${transaction.items.slice(0, 3).map(item => `
                            <span class="badge bg-light text-dark border border-light">
                                <i class="fas fa-tshirt me-1 text-xs"></i>
                                ${item.product_name} (${item.quantity})
                            </span>
                        `).join('')}
                        ${transaction.items.length > 3 ? `
                            <span class="badge bg-light text-dark border border-light">
                                +${transaction.items.length - 3} lainnya
                            </span>
                        ` : ''}
                    </div>
                </div>
                ` : ''}
            </div>
            `;
        }).join('');
        
        container.innerHTML = transactionsHtml;
    },
    
    updatePagination(data) {
        const pagination = document.getElementById('pagination');
        if (!pagination) return;
        
        if (this.totalPages <= 1) {
            pagination.classList.add('d-none');
            return;
        }
        
        pagination.classList.remove('d-none');
        
        if (this.isMobile) {
            pagination.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <button onclick="ActivityManager.changePage(${this.currentPage - 1})"
                            class="btn btn-outline-secondary btn-sm ${this.currentPage <= 1 ? 'disabled' : ''}"
                            ${this.currentPage <= 1 ? 'disabled' : ''}>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="text-muted small">
                        Halaman ${this.currentPage} dari ${this.totalPages}
                    </span>
                    <button onclick="ActivityManager.changePage(${this.currentPage + 1})"
                            class="btn btn-outline-secondary btn-sm ${this.currentPage >= this.totalPages ? 'disabled' : ''}"
                            ${this.currentPage >= this.totalPages ? 'disabled' : ''}>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            `;
            return;
        }
        
        let paginationHtml = `
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan ${(this.currentPage - 1) * this.itemsPerPage + 1} - 
                    ${Math.min(this.currentPage * this.itemsPerPage, this.totalTransactions)} dari ${this.totalTransactions}
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
        `;
        
        paginationHtml += `
            <li class="page-item ${this.currentPage <= 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="ActivityManager.changePage(${this.currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        const startPage = Math.max(1, this.currentPage - 1);
        const endPage = Math.min(this.totalPages, startPage + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            if (i === this.currentPage) {
                paginationHtml += `
                    <li class="page-item active">
                        <span class="page-link">${i}</span>
                    </li>
                `;
            } else {
                paginationHtml += `
                    <li class="page-item">
                        <button class="page-link" onclick="ActivityManager.changePage(${i})">${i}</button>
                    </li>
                `;
            }
        }
        
        paginationHtml += `
            <li class="page-item ${this.currentPage >= this.totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="ActivityManager.changePage(${this.currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        paginationHtml += `</ul></nav></div>`;
        pagination.innerHTML = paginationHtml;
    },
    
    async changePage(page) {
        if (page < 1 || page > this.totalPages) return;
        
        this.currentPage = page;
        await this.loadTransactions();
        
        if (this.isMobile) {
            document.getElementById('transactionsContainer').scrollTop = 0;
        }
    },
    
    showLoadingState() {
        const loadingState = document.getElementById('loadingState');
        const transactionsContainer = document.getElementById('transactionsContainer');
        const emptyState = document.getElementById('emptyState');
        const pagination = document.getElementById('pagination');
        
        if (loadingState) loadingState.classList.remove('d-none');
        if (transactionsContainer) transactionsContainer.classList.add('d-none');
        if (emptyState) emptyState.classList.add('d-none');
        if (pagination) pagination.classList.add('d-none');
    },
    
    hideLoadingState() {
        const loadingState = document.getElementById('loadingState');
        if (loadingState) loadingState.classList.add('d-none');
    },
    
    showEmptyState() {
        const loadingState = document.getElementById('loadingState');
        const transactionsContainer = document.getElementById('transactionsContainer');
        const emptyState = document.getElementById('emptyState');
        const pagination = document.getElementById('pagination');
        
        if (loadingState) loadingState.classList.add('d-none');
        if (transactionsContainer) transactionsContainer.classList.add('d-none');
        if (emptyState) emptyState.classList.remove('d-none');
        if (pagination) pagination.classList.add('d-none');
    },
    
    async viewTransactionDetail(transactionId) {
        try {
            this.showDetailLoading();
            
            const response = await fetch(`/api/cashier/transaction/${transactionId}`);
            const data = await response.json();
            
            if (data.success) {
                this.currentTransaction = data.transaction;
                this.showTransactionDetail(data.transaction);
                this.updateActiveStateInList(transactionId);
            } else {
                console.error('Error loading transaction detail:', data.message);
                this.showDetailError(data.message);
            }
        } catch (error) {
            console.error('Error loading transaction detail:', error);
            this.showDetailError('Terjadi kesalahan saat memuat detail transaksi');
        }
    },
    
    showTransactionDetail(transaction) {
        document.getElementById('detailEmptyState').classList.add('d-none');
        document.getElementById('summaryCard').classList.add('d-none');
        document.getElementById('transactionDetailPanel').classList.remove('d-none');
        
        this.hideDetailLoading();
        
        // Convert UTC to Timor-Leste Time
        
        const displayDateTime = TimeUtils.formatDateTimeFromUTC(transaction.created_at);
        const displayDate = TimeUtils.formatDateOnlyFromUTC(transaction.created_at);
        const displayTime = TimeUtils.formatTimeOnlyFromUTC(transaction.created_at);
        
        const status = transaction.status === 'completed' ? 'Selesai' : 
                      transaction.status === 'cancelled' ? 'Batal' : 
                      transaction.status;
        
        // Update desktop header
        document.getElementById('transactionDetailHeader').innerHTML = `
           
        `;
        
        // Update mobile header
        document.getElementById('mobileTransactionHeader').innerHTML = `
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div>
                    <h6 class="fw-bold text-navy-dark mb-1">${transaction.transaction_code}</h6>
                    <div class="text-muted small">
                        <i class="fas fa-calendar-alt me-1"></i> ${displayDateTime}
                    </div>
                </div>
                <span class="badge ${this.getStatusColor(transaction.status)}">
                    ${status}
                </span>
            </div>
            <div class="d-flex align-items-center">
               
            </div>
        `;
        
        const detailContent = document.getElementById('detailContent');
        
        // Mobile view
        if (this.isMobile) {
            detailContent.innerHTML = `
                <!-- Info Card -->
                <div class="p-3 border-bottom">
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title text-muted mb-2 small">
                                        <i class="fas fa-user-tie me-1"></i> Kasir
                                    </h6>
                                    <p class="card-text fw-medium small mb-0">${transaction.cashier}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card bg-light border-0">
                                <div class="card-body p-2">
                                    <h6 class="card-title text-muted mb-2 small">
                                        <i class="fas fa-money-bill-wave me-1"></i> Pembayaran
                                    </h6>
                                    <p class="card-text fw-medium small mb-0">
                                        ${transaction.payment_method === 'cash' ? 'Cash' : 'Transfer'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-medium">$ ${this.formatNumber(transaction.subtotal || 0)}</span>
                    </div>
                    
                    ${transaction.discount > 0 ? `
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded mt-1">
                        <span class="text-muted">Diskon:</span>
                        <span class="fw-medium text-danger">-$ ${this.formatNumber(transaction.discount)}</span>
                    </div>
                    ` : ''}
                </div>
                
                <!-- Products Section -->
                <div class="p-3">
                    <h6 class="fw-bold text-navy-dark mb-3 d-flex align-items-center">
                        <i class="fas fa-shopping-bag me-2 text-primary"></i>
                        Detail Barang
                        <span class="badge bg-primary ms-2">${transaction.items?.length || 0} item</span>
                    </h6>
                    
                    <div class="list-group">
                        ${transaction.items && transaction.items.length > 0 ? 
                            transaction.items.map(item => `
                                <div class="list-group-item border-0 p-0 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="fw-bold mb-1">${item.product_name}</h6>
                                                    ${item.variant_name ? `
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag me-1"></i>${item.variant_name}
                                                        </small>
                                                    ` : ''}
                                                </div>
                                                <span class="badge bg-primary">${item.quantity} pcs</span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    <small class="text-muted d-block">Harga</small>
                                                    <span class="fw-medium">$ ${this.formatNumber(item.price)}</span>
                                                </div>
                                                <div>
                                                    <small class="text-muted d-block">Subtotal</small>
                                                    <span class="fw-bold text-primary">$ ${this.formatNumber(item.subtotal)}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).join('') : 
                            `<div class="text-center py-4">
                                <div class="text-muted mb-2">
                                    <i class="fas fa-box-open fa-2x opacity-50"></i>
                                </div>
                                <p class="text-muted">Tidak ada data barang</p>
                            </div>`
                        }
                    </div>
                </div>
                
                <!-- Summary Section -->
                <div class="p-3 bg-light">
                    <h6 class="fw-bold text-navy-dark mb-3">
                        <i class="fas fa-calculator me-2 text-primary"></i>
                        Ringkasan Pembayaran
                    </h6>
                    
                    <div class="card border-0 bg-white">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Total Barang:</span>
                                <span class="fw-medium">$ ${this.formatNumber(transaction.subtotal || 0)}</span>
                            </div>
                            
                            ${transaction.discount > 0 ? `
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Diskon:</span>
                                <span class="fw-medium text-danger">-$ ${this.formatNumber(transaction.discount)}</span>
                            </div>
                            ` : ''}
                            
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-3">
                                <span class="fw-bold text-navy-dark">Total Transaksi:</span>
                                <span class="fw-bold text-primary fs-5">$ ${this.formatNumber(transaction.total_amount || 0)}</span>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-6">
                                    <div class="card bg-success bg-opacity-10 border-0">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted d-block">Dibayar</small>
                                            <span class="fw-bold text-success">$ ${this.formatNumber(transaction.amount_paid || 0)}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-white bg-opacity-10 border-0">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted d-block">Kembalian</small>
                                            <span class="fw-bold text-primary">$ ${this.formatNumber(transaction.change_amount || 0)}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top text-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Transaksi dibuat ${displayDateTime}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return;
        }
        
        // Desktop view
        detailContent.innerHTML = `
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3 d-flex align-items-center">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Informasi Transaksi
                            </h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Invoice:</span>
                                <span class="fw-medium">${transaction.transaction_code}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Waktu:</span>
                                <span class="fw-medium">${displayDateTime}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status:</span>
                                <span class="badge ${this.getStatusColor(transaction.status)}">
                                    ${status}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Kasir:</span>
                                <span class="fw-medium">${transaction.cashier}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3 d-flex align-items-center">
                                <i class="fas fa-credit-card me-2 text-primary"></i>
                                Informasi Pembayaran
                            </h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Metode:</span>
                                <span class="badge ${transaction.payment_method === 'cash' ? 'bg-success' : 'bg-primary'}">
                                    <i class="fas fa-${transaction.payment_method === 'cash' ? 'money-bill-wave' : 'exchange-alt'} me-1"></i>
                                    ${transaction.payment_method === 'cash' ? 'CASH' : 'TRANSFER'}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Items:</span>
                                <span class="fw-medium">${transaction.items_count || transaction.items?.length || 0} item</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Lokasi:</span>
                                <span class="fw-medium">Dili Society</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5 class="fw-bold text-navy-dark mb-3 d-flex align-items-center">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    Detail Barang
                </h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="border-bottom">
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${transaction.items && transaction.items.length > 0 ? 
                                transaction.items.map(item => `
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="fw-medium">${item.product_name}</div>
                                            ${item.variant_name ? `<small class="text-muted">${item.variant_name}</small>` : ''}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">${item.quantity}</span>
                                        </td>
                                        <td class="text-end">$ ${this.formatNumber(item.price)}</td>
                                        <td class="text-end fw-bold">$ ${this.formatNumber(item.subtotal)}</td>
                                    </tr>
                                `).join('') : 
                                `<tr><td colspan="4" class="text-center text-muted py-4">Tidak ada data barang</td></tr>`
                            }
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h5 class="fw-bold text-navy-dark mb-3 d-flex align-items-center">
                                <i class="fas fa-calculator me-2 text-primary"></i>
                                Ringkasan Transaksi
                            </h5>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Subtotal Barang:</span>
                                <span class="fw-medium">$ ${this.formatNumber(transaction.subtotal || 0)}</span>
                            </div>
                            ${transaction.discount > 0 ? `
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Diskon:</span>
                                <span class="fw-medium text-danger">-$ ${this.formatNumber(transaction.discount)}</span>
                            </div>
                            ` : ''}
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="fw-bold text-navy-dark">Total Penghasilan:</span>
                                <span class="fw-bold text-primary fs-4">$ ${this.formatNumber(transaction.total_amount || 0)}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-white bg-opacity-10 border-0">
                        <div class="card-body">
                            <h5 class="fw-bold text-navy-dark mb-3">Detail Pembayaran</h5>
                            <div class="mb-3">
                                <small class="text-muted d-block">Dibayar</small>
                                <span class="fw-bold text-success fs-4">$ ${this.formatNumber(transaction.amount_paid || 0)}</span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Kembalian</small>
                                <span class="fw-bold text-primary fs-4">$ ${this.formatNumber(transaction.change_amount || 0)}</span>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        `;
    },
    
    updateActiveStateInList(transactionId) {
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
        
        const selectedItem = document.querySelector(`.list-group-item[onclick*="viewTransactionDetail(${transactionId})"]`);
        if (selectedItem) {
            selectedItem.classList.add('active');
            
            if (!this.isMobile) {
                selectedItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    },
    
    showDetailLoading() {
        document.getElementById('detailLoadingState').classList.remove('d-none');
        document.getElementById('detailContent').innerHTML = '';
    },
    
    hideDetailLoading() {
        document.getElementById('detailLoadingState').classList.add('d-none');
    },
    
    showDetailError(message) {
        document.getElementById('detailEmptyState').classList.add('d-none');
        document.getElementById('summaryCard').classList.add('d-none');
        document.getElementById('transactionDetailPanel').classList.remove('d-none');
        
        document.getElementById('detailContent').innerHTML = `
            <div class="text-center py-4">
                <div class="text-danger mb-3">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <h5 class="fw-bold mb-2">Gagal Memuat Detail</h5>
                <p class="text-muted mb-3">${message}</p>
                <button onclick="ActivityManager.closeDetailPanel()" 
                        class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </button>
            </div>
        `;
    },
    
    hideDetailPanel() {
        document.getElementById('transactionDetailPanel').classList.add('d-none');
        document.getElementById('detailEmptyState').classList.remove('d-none');
        document.getElementById('summaryCard').classList.remove('d-none');
        this.currentTransaction = null;
    },
    
    closeDetailPanel() {
        this.hideDetailPanel();
        
        document.querySelectorAll('.list-group-item').forEach(item => {
            item.classList.remove('active');
        });
    },
    
    filterByStatus(status) {
        this.activeFilters.status = status;
        this.currentPage = 1;
        this.updateActiveFiltersDisplay();
        this.loadStats();
        this.loadTransactions();
        this.closeDetailPanel();
    },
    
    filterByDateRange(range) {
        const todayTL = TimeUtils.getCurrentTLDate();
        let targetDate = new Date(todayTL);
        
        switch(range) {
            case 'today':
                targetDate = todayTL;
                break;
            case 'yesterday':
                targetDate.setDate(targetDate.getDate() - 1);
                break;
            case 'week':
                targetDate.setDate(targetDate.getDate() - 7);
                break;
            case 'month':
                targetDate.setDate(targetDate.getDate() - 30);
                break;
            default:
                targetDate = todayTL;
        }
        
        const dateStr = targetDate.toISOString().split('T')[0];
        this.activeFilters.date = dateStr;
        this.activeFilters.dateRange = range;
        document.getElementById('dateFilter').value = dateStr;
        this.currentPage = 1;
        this.updateActiveFiltersDisplay();
        this.updateDateRangeInfo();
        this.loadStats();
        this.loadTransactions();
        this.closeDetailPanel();
    },
    
    filterByDate(type) {
        if (type === 'today') {
            this.filterByDateRange('today');
        }
    },
    
    resetFilters() {
        const todayTL = TimeUtils.getTodayTLDateString();
        this.activeFilters = {
            status: 'all',
            date: todayTL,
            dateRange: 'today'
        };
        
        document.getElementById('dateFilter').value = todayTL;
        document.getElementById('searchInput').value = '';
        
        // Reset radio buttons
        document.getElementById('statusAll').checked = true;
        
        this.currentPage = 1;
        
        this.updateActiveFiltersDisplay();
        this.updateDateRangeInfo();
        this.loadStats();
        this.loadTransactions();
        this.closeDetailPanel();
    },
    
    updateActiveFiltersDisplay() {
        const container = document.getElementById('activeFilters');
        if (!container) return;
        
        const filters = [];
        
        if (this.activeFilters.status !== 'all') {
            filters.push({
                label: this.activeFilters.status === 'completed' ? 'Selesai' : 'Batal',
                type: 'status'
            });
        }
        
        if (this.activeFilters.dateRange !== 'today') {
            filters.push({
                label: this.activeFilters.dateRange === 'yesterday' ? 'Kemarin' : 
                       this.activeFilters.dateRange === 'week' ? '7 hari terakhir' : 
                       this.activeFilters.dateRange === 'month' ? '30 hari terakhir' : 
                       'Tanggal custom',
                type: 'date'
            });
        }
        
        if (filters.length > 0) {
            container.innerHTML = filters.map(filter => `
                <div class="badge bg-primary d-flex align-items-center small">
                    ${filter.label}
                    <button onclick="ActivityManager.removeFilter('${filter.type}')" class="btn-close btn-close-white ms-1" style="font-size: 0.6rem;"></button>
                </div>
            `).join('');
        } else {
            container.innerHTML = '';
        }
    },
    
    updateDateRangeInfo() {
        const dateInfoText = document.getElementById('dateInfoText');
        if (dateInfoText) {
            dateInfoText.textContent = this.getDateRangeText();
        }
    },
    
    getDateRangeText() {
        let dateText = '';
        
        // PERBAIKAN: Gunakan TimeUtils.formatDateFromString untuk format yang benar
        switch(this.activeFilters.dateRange) {
            case 'today':
                const todayFormatted = TimeUtils.formatDateFromString(this.activeFilters.date);
                dateText = `Hari ini (${todayFormatted})`;
                break;
            case 'yesterday':
                const yesterdayTL = TimeUtils.getYesterdayTLDateString();
                const yesterdayFormatted = TimeUtils.formatDateFromString(yesterdayTL);
                dateText = `Kemarin (${yesterdayFormatted})`;
                break;
            case 'week':
                const weekAgo = new Date(this.activeFilters.date);
                weekAgo.setDate(weekAgo.getDate() - 7);
                const weekAgoFormatted = TimeUtils.formatDateOnly(weekAgo);
                const todayFormattedWeek = TimeUtils.formatDateFromString(this.activeFilters.date);
                dateText = `7 hari terakhir (${weekAgoFormatted} - ${todayFormattedWeek})`;
                break;
            case 'month':
                const monthAgo = new Date(this.activeFilters.date);
                monthAgo.setDate(monthAgo.getDate() - 30);
                const monthAgoFormatted = TimeUtils.formatDateOnly(monthAgo);
                const todayFormattedMonth = TimeUtils.formatDateFromString(this.activeFilters.date);
                dateText = `30 hari terakhir (${monthAgoFormatted} - ${todayFormattedMonth})`;
                break;
            case 'custom':
                const customFormatted = TimeUtils.formatDateFromString(this.activeFilters.date);
                dateText = `Tanggal ${customFormatted}`;
                break;
            default:
                const defaultFormatted = TimeUtils.formatDateFromString(this.activeFilters.date);
                dateText = `Hari ini (${defaultFormatted})`;
        }
        
        return dateText;
    },
    
    removeFilter(type) {
        switch(type) {
            case 'status':
                this.activeFilters.status = 'all';
                document.getElementById('statusAll').checked = true;
                break;
            case 'date':
                this.activeFilters.dateRange = 'today';
                this.activeFilters.date = TimeUtils.getTodayTLDateString();
                document.getElementById('dateFilter').value = this.activeFilters.date;
                break;
        }
        
        this.currentPage = 1;
        this.updateActiveFiltersDisplay();
        this.loadStats();
        this.loadTransactions();
    },
    
    printReceipt() {
        if (this.currentTransaction) {
            const printWindow = window.open('', '_blank', 'width=400,height=600');
            
            // Convert UTC to Timor-Leste Time
       
            const receiptDateTime = TimeUtils.formatDateTime(tlDate);
            const receiptDate = TimeUtils.formatDateOnlyFromUTC(transaction.created_at);
            const receiptTime = TimeUtils.formatTimeOnlyFromUTC(transaction.created_at);
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Struk ${this.currentTransaction.transaction_code}</title>
                    <style>
                        body {
                            font-family: 'Courier New', monospace;
                            margin: 0;
                            padding: 20px;
                            width: 300px;
                            font-size: 12px;
                            line-height: 1.4;
                        }
                        
                        .header {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        
                        .header h1 {
                            margin: 0;
                            font-size: 16px;
                            font-weight: bold;
                        }
                        
                        .header p {
                            margin: 2px 0;
                        }
                        
                        .time-info {
                            background-color: #f3f4f6;
                            padding: 5px 10px;
                            border-radius: 5px;
                            margin: 10px 0;
                            font-size: 11px;
                            color: #6b7280;
                        }
                        
                        .divider {
                            border-top: 1px dashed #000;
                            margin: 10px 0;
                        }
                        
                        .item {
                            margin: 5px 0;
                        }
                        
                        .total {
                            font-weight: bold;
                            font-size: 14px;
                        }
                        
                        .footer {
                            margin-top: 30px;
                            text-align: center;
                            font-size: 10px;
                        }
                        
                        @media print {
                            @page {
                                margin: 0;
                                size: auto;
                            }
                            body {
                                margin: 0;
                                padding: 10px;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Dili Society</h1>
                        <p>R. Gov. José Celestino da Silva, Díli</p>
                        <p>Telp: +670 77430583</p>
                        <div class="time-info">
                            <i class="fas fa-clock"></i> ${receiptDateTime}
                        </div>
                        <p>No. Transaksi: <strong>${this.currentTransaction.transaction_code}</strong></p>
                        <p>Kasir: ${this.currentTransaction.cashier}</p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div>
                        <p><strong>Customer:</strong> Pelanggan</p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div>
                        <p><strong>DETAIL BARANG:</strong></p>
                        ${this.currentTransaction.items && this.currentTransaction.items.map(item => `
                            <div class="item">
                                ${item.product_name}
                                <br>
                                ${item.quantity} × $ ${this.formatNumber(item.price)} = $ ${this.formatNumber(item.subtotal)}
                            </div>
                        `).join('')}
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div style="text-align: right;">
                        <p>Subtotal: $ ${this.formatNumber(this.currentTransaction.subtotal)}</p>
                        ${this.currentTransaction.discount > 0 ? `<p>Diskon: -$ ${this.formatNumber(this.currentTransaction.discount)}</p>` : ''}
                        <p class="total">TOTAL: $ ${this.formatNumber(this.currentTransaction.total_amount)}</p>
                        <p>Dibayar: $ ${this.formatNumber(this.currentTransaction.amount_paid)}</p>
                        <p>Kembali: $ ${this.formatNumber(this.currentTransaction.change_amount)}</p>
                        <p><strong>Metode: ${this.currentTransaction.payment_method === 'cash' ? 'CASH' : 'TRANSFER'}</strong></p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="footer">
                        <p><strong>TERIMA KASIH</strong></p>
                        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
                    </div>
                    
                    <script>
                        window.onload = function() {
                            setTimeout(function() {
                                window.print();
                            }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
        } else {
            alert('Silakan pilih transaksi terlebih dahulu');
        }
    },
    
    printReport() {
        try {
            const periodText = this.getDateRangeText();
            const printDate = TimeUtils.formatDateTime(TimeUtils.getCurrentTLDate());
            
            let totalRevenue = 0;
            let totalItems = 0;
            let transactionList = '';
            
            this.allTransactions.forEach(transaction => {
                totalRevenue += transaction.total_amount || 0;
                totalItems += transaction.items_count || transaction.items?.length || 0;
                
                
                const displayDateTime = TimeUtils.formatDateTime(tlDate);
                const status = transaction.status === 'completed' ? 'Selesai' : 
                              transaction.status === 'cancelled' ? 'Batal' : 
                              transaction.status;
                
                transactionList += `
                    <div style="border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 15px; padding: 15px; break-inside: avoid;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <div>
                                <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                    <span style="background-color: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                        ${transaction.transaction_code}
                                    </span>
                                    <span style="color: #6b7280; font-size: 11px; margin-left: 8px;">
                                        <i class="fas fa-clock me-1"></i> ${displayDateTime}
                                    </span>
                                </div>
                                <div style="color: #374151; font-size: 14px; margin-bottom: 5px;">
                                    <strong>Customer:</strong> Pelanggan
                                </div>
                                <div style="color: #6b7280; font-size: 12px; margin-bottom: 10px;">
                                    <strong>Kasir:</strong> ${transaction.cashier}
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 5px;">
                                    $ ${this.formatNumber(transaction.total_amount)}
                                </div>
                                <span style="display: inline-block; padding: 4px 8px; font-size: 10px; font-weight: 600; border-radius: 12px; ${status === 'Selesai' ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;'}">
                                    ${status}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            const printWindow = window.open('', '_blank', 'width=800,height=600');
            
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Laporan Transaksi - ${TimeUtils.formatDateOnly(new Date(this.activeFilters.date))}</title>
                    <style>
                        body {
                            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                            margin: 0;
                            padding: 20px;
                            color: #333;
                        }
                        
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            padding-bottom: 20px;
                            border-bottom: 3px solid #2563eb;
                        }
                        
                        .header h1 {
                            color: #2563eb;
                            margin: 0 0 10px 0;
                            font-size: 24px;
                        }
                        
                        .header p {
                            color: #6b7280;
                            margin: 5px 0;
                            font-size: 14px;
                        }
                        
                        .summary {
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            gap: 15px;
                            margin-bottom: 25px;
                        }
                        
                        .summary-item {
                            border: 1px solid #e5e7eb;
                            border-radius: 8px;
                            padding: 15px;
                            background: #f9fafb;
                            text-align: center;
                        }
                        
                        .summary-item.highlight {
                            background: linear-gradient(135deg, #2563eb, #1d4ed8);
                            color: white;
                            border: none;
                        }
                        
                        .summary-item h3 {
                            margin: 0 0 8px 0;
                            font-size: 13px;
                            color: #6b7280;
                        }
                        
                        .summary-item.highlight h3 {
                            color: #e0e7ff;
                        }
                        
                        .summary-value {
                            font-size: 20px;
                            font-weight: bold;
                            color: #1f2937;
                        }
                        
                        .summary-item.highlight .summary-value {
                            color: white;
                        }
                        
                        .transactions-header {
                            margin: 30px 0 15px 0;
                            padding-bottom: 10px;
                            border-bottom: 2px solid #2563eb;
                        }
                        
                        .transactions-header h2 {
                            color: #374151;
                            margin: 0;
                            font-size: 18px;
                        }
                        
                        .transactions-count {
                            color: #6b7280;
                            font-size: 13px;
                            margin-top: 5px;
                        }
                        
                        .footer {
                            margin-top: 40px;
                            padding-top: 20px;
                            border-top: 2px solid #e5e7eb;
                            text-align: center;
                            font-size: 12px;
                            color: #6b7280;
                        }
                        
                        @media print {
                            @page {
                                margin: 15mm;
                            }
                            
                            body {
                                padding: 0;
                            }
                            
                            .no-print {
                                display: none;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>LAPORAN TRANSAKSI</h1>
                        <p>${periodText}</p>
                        <p>Dicetak pada: ${printDate} (Waktu Timor-Leste)</p>
                    </div>
                    
                    <div class="summary">
                        <div class="summary-item highlight">
                            <h3>TOTAL PENGHASILAN</h3>
                            <div class="summary-value">$ ${this.formatNumber(totalRevenue)}</div>
                        </div>
                        
                        <div class="summary-item">
                            <h3>JUMLAH TRANSAKSI</h3>
                            <div class="summary-value">${this.allTransactions.length}</div>
                        </div>
                        
                        <div class="summary-item">
                            <h3>TOTAL ITEM TERJUAL</h3>
                            <div class="summary-value">${totalItems}</div>
                        </div>
                        
                        <div class="summary-item">
                            <h3>RATA-RATA PER TRANSAKSI</h3>
                            <div class="summary-value">$ ${this.formatNumber(this.allTransactions.length > 0 ? totalRevenue / this.allTransactions.length : 0)}</div>
                        </div>
                    </div>
                    
                    <div class="transactions-header">
                        <h2>DETAIL TRANSAKSI</h2>
                        <div class="transactions-count">
                            Total ${this.allTransactions.length} transaksi ditemukan
                        </div>
                    </div>
                    
                    ${transactionList || '<p style="text-align: center; color: #6b7280; padding: 40px;">Tidak ada transaksi untuk ditampilkan</p>'}
                    
                    <div class="footer">
                        <p>Laporan ini dicetak secara otomatis dari sistem kasir</p>
                        <p>Dili Society &copy; ${new Date().getFullYear()} • Waktu Timor-Leste (UTC+9)</p>
                    </div>
                    
                    <div class="no-print" style="margin-top: 20px; text-align: center;">
                        <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer;">
                            🖨️ Cetak Laporan
                        </button>
                        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                            ✖️ Tutup
                        </button>
                    </div>
                    
                    <script>
                        window.onload = function() {
                            setTimeout(function() {
                                window.print();
                            }, 1000);
                        };
                    <\/script>
                </body>
                </html>
            `);
            
            printWindow.document.close();
            
        } catch (error) {
            console.error('Error printing report:', error);
            alert('Terjadi kesalahan saat mencetak laporan');
        }
    },
    
    exportReport() {
        try {
            const periodText = this.getDateRangeText();
            const exportDate = TimeUtils.formatDateTime(TimeUtils.getCurrentTLDate());
            
            let totalRevenue = 0;
            let totalItems = 0;
            
            const transactionsData = this.allTransactions.map(transaction => {
                totalRevenue += transaction.total_amount || 0;
                totalItems += transaction.items_count || transaction.items?.length || 0;
                
               
                
                return {
                    invoice: transaction.transaction_code,
                    date: TimeUtils.formatDateOnlyFromUTC(transaction.created_at),
                    time: TimeUtils.formatTimeOnlyFromUTC(transaction.created_at),
                    date_time: TimeUtils.formatDateTime(tlDate),
                    customer: 'Pelanggan',
                    cashier: transaction.cashier,
                    status: transaction.status === 'completed' ? 'Selesai' : 'Batal',
                    payment: transaction.payment_method === 'cash' ? 'Cash' : 'Transfer',
                    total: transaction.total_amount,
                    items: transaction.items?.map(i => ({
                        product: i.product_name,
                        quantity: i.quantity,
                        price: i.price,
                        subtotal: i.subtotal
                    })) || []
                };
            });
            
            const exportData = {
                period: periodText,
                export_date_time: exportDate,
                timezone: 'Asia/Dili (UTC+9)',
                total_revenue: totalRevenue,
                total_transactions: this.allTransactions.length,
                total_items: totalItems,
                avg_transaction: Math.round(this.allTransactions.length > 0 ? totalRevenue / this.allTransactions.length : 0),
                transactions: transactionsData,
                export_timestamp: new Date().toISOString()
            };
            
            const dataStr = JSON.stringify(exportData, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            
            const exportFileDefaultName = `laporan-transaksi-${new Date().toISOString().split('T')[0]}.json`;
            
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
            
            alert('Laporan berhasil diexport!');
            
        } catch (error) {
            console.error('Error exporting report:', error);
            alert('Terjadi kesalahan saat mengexport laporan');
        }
    },
    
    // Utility functions
    formatNumber(num) {
        if (num === null || num === undefined || isNaN(num)) return '0';
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    
    getStatusColor(status) {
        switch(status?.toLowerCase()) {
            case 'completed':
            case 'selesai':
                return 'bg-success';
            case 'cancelled':
            case 'batal':
                return 'bg-danger';
            case 'pending':
                return 'bg-warning';
            default:
                return 'bg-secondary';
        }
    }
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    ActivityManager.init();
    window.ActivityManager = ActivityManager;
    window.TimeUtils = TimeUtils;
});
</script>

<style>
/* Mobile-First Styles */
.list-group-item {
    border-left: none;
    border-right: none;
    padding: 0.75rem 1rem;
    transition: all 0.2s ease;
    border-color: #e5e7eb;
    cursor: pointer;
    font-size: 14px;
}

.list-group-item.active {
    background-color: rgba(29, 78, 216, 0.1);
    border-color: #e5e7eb;
    color: #1f2937;
    border-left: 4px solid #1d4ed8;
}

.list-group-item:hover:not(.active) {
    background-color: rgba(15, 26, 47, 0.05);
}

.card {
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.card-header {
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
    font-size: 14px;
}

.btn-primary {
    background: #1d4ed8;
    border-color: #1d4ed8;
}

.btn-outline-primary {
    color: #1d4ed8;
    border-color: #1d4ed8;
}

.btn-outline-success {
    color: #059669;
    border-color: #059669;
}

.btn-outline-success:hover {
    background-color: #059669;
    color: white;
}

.btn-outline-danger {
    color: #dc2626;
    border-color: #dc2626;
}

.btn-outline-danger:hover {
    background-color: #dc2626;
    color: white;
}

.btn-check:checked + .btn-outline-success,
.btn-check:active + .btn-outline-success {
    background-color: #059669;
    border-color: #059669;
    color: white;
}

.btn-check:checked + .btn-outline-danger,
.btn-check:active + .btn-outline-danger {
    background-color: #dc2626;
    border-color: #dc2626;
    color: white;
}

.badge {
    font-weight: 600;
    font-size: 11px;
    padding: 0.2em 0.5em;
    border-radius: 6px;
}

.input-group-text {
    background-color: white;
    border-color: #e5e7eb;
}

.form-control {
    border-color: #e5e7eb;
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    font-size: 14px;
}

.form-control:focus {
    border-color: #1d4ed8;
    box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.1);
}

#transactionsContainer {
    scrollbar-width: thin;
    scrollbar-color: rgba(15, 26, 47, 0.1) transparent;
}

#transactionsContainer::-webkit-scrollbar {
    width: 4px;
}

#transactionsContainer::-webkit-scrollbar-track {
    background: transparent;
}

#transactionsContainer::-webkit-scrollbar-thumb {
    background: rgba(15, 26, 47, 0.1);
    border-radius: 10px;
}

#transactionsContainer::-webkit-scrollbar-thumb:hover {
    background: rgba(15, 26, 47, 0.2);
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

#transactionDetailPanel {
    animation: slideIn 0.3s ease-out;
}

.text-navy-dark {
    color: #0f1a2f !important;
}

.bg-primary {
    background-color: #1d4ed8 !important;
}

.border-light {
    border-color: #e5e7eb !important;
}

/* Mobile Detail Panel Styling */
#transactionDetailPanel .card-header {
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

#mobileTransactionHeader {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem;
    margin: -0.5rem -0.75rem 0 -0.75rem;
    border-radius: 0 0 12px 12px;
}

#mobileTransactionHeader .badge {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

#detailContent .list-group-item .card {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    transition: transform 0.2s ease;
}

#detailContent .list-group-item .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Desktop improvements */
@media (min-width: 992px) {
    #transactionDetailPanel .card-body {
        padding: 1.5rem !important;
    }
    
    .table th, .table td {
        padding: 0.75rem 1rem !important;
    }
}

/* Animation for mobile panel */
@keyframes slideInUp {
    from {
        transform: translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 991.98px) {
    #transactionDetailPanel {
        animation: slideInUp 0.3s ease-out;
    }
}

/* Better scrollbar for detail content */
#detailContent::-webkit-scrollbar {
    width: 6px;
}

#detailContent::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

#detailContent::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

#detailContent::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Mobile-specific adjustments */
@media (max-width: 767.98px) {
    .container-fluid {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
    
    .card {
        margin-bottom: 0.75rem !important;
    }
    
    .btn, .btn-sm {
        min-height: 44px !important;
    }
    
    .list-group-item {
        min-height: 60px;
        padding: 0.75rem 1rem;
    }
    
    .table {
        font-size: 13px;
    }
    
    .table th, .table td {
        padding: 0.5rem !important;
    }
    
    .col-12 {
        padding-left: 0.25rem !important;
        padding-right: 0.25rem !important;
    }
    
    .mb-3 {
        margin-bottom: 1rem !important;
    }
    
    .p-3 {
        padding: 1rem !important;
    }
    
    #transactionDetailPanel {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        z-index: 1050 !important;
        margin: 0 !important;
        border-radius: 0 !important;
        height: 100vh !important;
        width: 100vw !important;
    }
    
    #transactionDetailPanel:not(.d-none) ~ #summaryCard {
        display: none !important;
    }
    
    #transactionDetailPanel:not(.d-none) ~ #detailEmptyState {
        display: none !important;
    }
    
    input, select, textarea {
        font-size: 16px !important;
    }
}

/* Desktop styles */
@media (min-width: 768px) {
    .container-fluid {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }
    
    .d-md-block {
        display: block !important;
    }
    
    .d-md-none {
        display: none !important;
    }
}

/* Better touch feedback */
.list-group-item:active {
    background-color: rgba(29, 78, 216, 0.15) !important;
    transform: scale(0.98);
}

.btn:active {
    transform: scale(0.98);
}

/* Print styles */
@media print {
    .no-print {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}

/* Styling untuk ikon waktu */
.fa-calendar-alt, .fa-clock {
    opacity: 0.7;
}

/* Loading animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.spinner-border {
    animation: pulse 1.5s ease-in-out infinite;
}
</style>
@endsection
