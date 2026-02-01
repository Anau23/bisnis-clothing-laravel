

Berikut adalah kode yang telah diperbarui. Saya telah mengubah format route dari `route('cashier_pos')` menjadi `route('cashier.pos')` sesuai instruksi.

```blade
@extends('cashier.layout')

@section('title', 'Dashboard Kasir - Bisnis Clothing')

@section('page_title', 'Dashboard Kasir')

@section('content')
<div class="mb-4 md:mb-6">
    <p class="page-subtitle">
        Selamat datang, {{ auth()->user()->username }}! Ringkasan aktivitas hari ini.
    </p>

<!-- Shift Status Section -->
<div class="card border-0 shadow-lg mb-4 text-white" style="background: var(--blue-gradient);">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <div class="bg-white/20 p-3 rounded">
                            <i class="fas fa-clock text-white fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="h4 mb-1 text-white">Shift Saat Ini</h3>
                        <p class="mb-0 text-white/80">
                            Status: <span id="shiftStatusDisplay" class="fw-bold">
                                @if($cash_drawer && $cash_drawer->status == 'open') Aktif
                                @elseif($cash_drawer && $cash_drawer->status == 'completed') Selesai
                                @else Belum Dimulai @endif
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <div class="bg-white/10 rounded p-2 border border-white/20">
                            <p class="mb-1 text-white/80 small">Kasir</p>
                            <p class="mb-0 fw-medium text-white small">{{ $user->username ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-white/10 rounded p-2 border border-white/20">
                            <p class="mb-1 text-white/80 small">Shift #</p>
                            <p id="shiftNumberDisplay" class="mb-0 fw-medium text-white small">
                                @if($cash_drawer) {{ $cash_drawer->drawer_number }} @else - @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-white/10 rounded p-2 border border-white/20">
                            <p class="mb-1 text-white/80 small">Transaksi</p>
                            <p id="todayTransactionsDisplay" class="mb-0 fw-medium text-white small">
                                @if($total_transactions) {{ $total_transactions }} @else 0 @endif
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-white/10 rounded p-2 border border-white/20">
                            <p class="mb-1 text-white/80 small">Durasi</p>
                            <p id="shiftDurationDisplay" class="mb-0 fw-medium text-white small">
                                @if($cash_drawer && $cash_drawer->duration_display)
                                    {{ $cash_drawer->duration_display }}
                                @else
                                    -
                                @endif
</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="bg-white/10 rounded p-3 border border-white/20 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white/80 small">Saldo Tunai</p>
                            <p id="cashBalanceDisplay" class="h4 mb-0 fw-bold text-white">
                                $ @if($cash_drawer) {{ number_format($cash_drawer->opening_balance, 0, ',', '.') }} @else 0 @endif
                            </p>
                        </div>
                        <div class="ms-2">
                            <i class="fas fa-money-bill-wave text-white/70 fs-4"></i>
                        </div>
                    </div>
                    <p class="mt-2 mb-0 text-white/70 small">
                        <i class="fas fa-info-circle me-1"></i> Saldo awal shift
                    </p>
                </div>
                
                <div class="d-grid gap-2">
                    <!-- Button Mulai Shift - Hanya muncul saat shift belum berjalan -->
                    @if(!$cash_drawer || $cash_drawer->status != 'open')
                    <button id="startShiftBtn" 
                            class="btn btn-light fw-bold d-flex align-items-center justify-content-center py-2"
                            onclick="openStartShiftModal()">
                        <i class="fas fa-play-circle me-2"></i>
                        Mulai Shift
                    </button>
                    @endif
                    
                    <!-- Button Shift Berjalan - Hanya muncul saat shift aktif -->
                    @if($cash_drawer && $cash_drawer->status == 'open')
                    <button id="activeShiftBtn" 
                            class="btn btn-success fw-bold d-flex align-items-center justify-content-center py-2"
                            onclick="window.location.href='{{ route('cashier.pos') }}'">
                        <i class="fas fa-sync-alt me-2"></i>
                        Shift Berjalan
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <!-- Total Penjualan Hari Ini -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Total Penjualan</p>
                        <p id="totalSalesDisplay" class="h4 mb-0 fw-bold">
                            $ @if($total_sales) {{ number_format($total_sales, 0, ',', '.') }} @else 0 @endif
                        </p>
                    </div>
                    <div class="ms-2 bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-wallet text-primary fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p id="salesStatusDisplay" class="text-muted small mb-0">
                        @if($cash_drawer && $cash_drawer->status == 'open')
                        <i class="fas fa-sync-alt me-1"></i> Shift aktif
                        @else
                        <i class="fas fa-minus me-1"></i> Shift belum dimulai
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Transaksi -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Total Transaksi</p>
                        <p id="totalTransactionsDisplay" class="h4 mb-0 fw-bold">
                            @if($total_transactions) {{ $total_transactions }} @else 0 @endif
                        </p>
                    </div>
                    <div class="ms-2 bg-success bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-receipt text-success fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p id="transactionsStatusDisplay" class="text-muted small mb-0">
                        @if($cash_drawer && $cash_drawer->status == 'open')
                        <i class="fas fa-sync-alt me-1"></i> Shift aktif
                        @else
                        <i class="fas fa-minus me-1"></i> Shift belum dimulai
                        @endif
                    </p>
                </div>
            </div>
        </div>
</div>
    
    <!-- Rata-rata Transaksi -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-purple border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Rata-rata Transaksi</p>
                        <p id="averageTransactionDisplay" class="h4 mb-0 fw-bold">
                            $ @if($total_transactions && $total_sales) {{ number_format($total_sales / $total_transactions, 0, ',', '.') }} @else 0 @endif
                        </p>
                    </div>
                    <div class="ms-2 bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-chart-line text-primary fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p id="averageStatusDisplay" class="text-muted small mb-0">
                        @if($cash_drawer && $cash_drawer->status == 'open')
                        <i class="fas fa-sync-alt me-1"></i> Shift aktif
                        @else
                        <i class="fas fa-minus me-1"></i> Shift belum dimulai
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Item Terjual -->
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <p class="text-muted small mb-1">Item Terjual</p>
                        <p id="itemsSoldDisplay" class="h4 mb-0 fw-bold">
                            @if($total_items) {{ $total_items }} @else 0 @endif
                        </p>
                    </div>
                    <div class="ms-2 bg-warning bg-opacity-10 p-2 rounded-circle">
                        <i class="fas fa-box text-warning fs-5"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <p id="itemsStatusDisplay" class="text-muted small mb-0">
                        @if($cash_drawer && $cash_drawer->status == 'open')
                        <i class="fas fa-sync-alt me-1"></i> Shift aktif
                        @else
                        <i class="fas fa-minus me-1"></i> Shift belum dimulai
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="row g-3">
    <!-- Left Column -->
    <div class="col-xl-8">
        <!-- Recent Transactions -->
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-semibold">Transaksi Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="recentTransactionsContainer" class="p-3">
                    @if($cash_drawer && $cash_drawer->status == 'open' && $recent_transactions && count($recent_transactions) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr class="small">
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Waktu </th>
                                    <th class="border-0">Items</th>
                                    <th class="border-0">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_transactions->take(5) as $transaction)
                                <tr class="small">
                                    <td class="fw-medium">{{ $transaction->transaction_code }}</td>
                                    <!-- WAKTU TIMOR-LESTE -->
                                    <td class="text-muted" data-utc-time="{{ $transaction->created_at ? $transaction->created_at->toIso8601String() : '' }}">
                                        {{ $transaction->created_at ? $transaction->created_at->format('H:i') : '-' }}
                                    </td>
                                    <td>{{ $transaction->items_count ?? 0 }} items</td>
                                    <td class="fw-bold text-success">$ {{ $transaction->total_amount ? number_format($transaction->total_amount, 0, ',', '.') : '0' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @elseif($cash_drawer && $cash_drawer->status == 'open')
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart text-muted mb-3 fs-1"></i>
                        <p class="text-muted">Belum ada transaksi</p>
                        <p class="text-muted small">Mulai transaksi pertama Anda</p>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-clock text-muted mb-3 fs-1"></i>
                        <p class="text-muted">Shift belum dimulai</p>
                        <p class="text-muted small">Mulai shift untuk melihat transaksi</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Right Column -->
    <div class="col-xl-4">
        <!-- Shift Summary -->
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0 fw-semibold">Ringkasan Shift</h5>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="text-muted small mb-1">Shift Status</p>
                            <p id="shiftSummaryStatus" class="h3 fw-bold mb-0 @if($cash_drawer && $cash_drawer->status == 'open') text-success @else text-danger @endif">
                                @if($cash_drawer && $cash_drawer->status == 'open') Aktif @else Tidak Aktif @endif
                            </p>
                        </div>
                        <div id="shiftSummaryIcon" class="p-3 rounded-circle @if($cash_drawer && $cash_drawer->status == 'open') bg-success bg-opacity-10 @else bg-danger bg-opacity-10 @endif">
                            <i class="fas @if($cash_drawer && $cash_drawer->status == 'open') fa-play-circle text-success @else fa-pause-circle text-danger @endif fs-4"></i>
                        </div>
                    </div>
                </div>
                
                <div class="border-top pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Waktu Mulai</span>
                        <span id="startTimeDisplay" class="fw-medium small">
                            @if($cash_drawer && $cash_drawer->opened_at_time) {{ $cash_drawer->opened_at_time }} @else - @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Waktu Selesai</span>
                        <span id="endTimeDisplay" class="fw-medium small">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Durasi</span>
                       <p id="summaryDurationDisplay" class="fw-medium small">
    @if($cash_drawer && $cash_drawer->duration_display)
        {{ $cash_drawer->duration_display }}
    @else
        -
    @endif
</p>
                    </div>
                </div>
                
                <!-- Button Tutup Shift - Hanya aktif saat shift berjalan -->
                @if($cash_drawer && $cash_drawer->status == 'open')
                <button id="closeShiftBtn" 
                        class="btn btn-danger w-100 mt-4"
                        onclick="openCloseShiftModal()">
                    <i class="fas fa-stop-circle me-2"></i> Tutup Shift
                </button>
                @else
                <button class="btn btn-secondary w-100 mt-4" disabled>
                    <i class="fas fa-stop-circle me-2"></i> Tutup Shift
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Start Shift Modal -->
<div id="startShiftModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Mulai Shift Baru</h5>
                <button type="button" class="btn-close" onclick="closeStartShiftModal()"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-medium">Saldo Awal Tunai</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">$</span>
                        <input type="number" id="initialCash" class="form-control"
                               placeholder="0" value="100000" min="0" step="1000">
                    </div>
                    <div class="form-text small">
                        <i class="fas fa-info-circle me-1"></i> Masukkan jumlah uang tunai di kasir saat ini
                    </div>
                </div>
                
                <div class="alert alert-info mb-3">
                    <div class="d-flex">
                        <i class="fas fa-clock me-3 mt-1"></i>
                        <div>
                            <p class="mb-1 fw-medium small">Informasi Shift</p>
                            <div class="small">
                                <p class="mb-1">• Kasir: <span class="fw-medium">{{ $user->username ?? auth()->user()->username }}</span></p>
                                <p class="mb-1">• Shift #: <span class="fw-medium" id="modalShiftNumber">1</span></p>
                                <p class="mb-0">• Waktu Mulai: <span class="fw-medium" id="currentTimeDisplay">-</span> (Waktu)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="confirmStart">
                    <label class="form-check-label small" for="confirmStart">
                        Saya telah memeriksa saldo tunai dengan benar
                    </label>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeStartShiftModal()">Batal</button>
                <button type="button" class="btn btn-primary btn-sm" onclick="confirmStartShift()">
                    <i class="fas fa-play-circle me-2"></i>Mulai Shift
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Close Shift Modal -->
<div id="closeShiftModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Tutup Shift</h5>
                <button type="button" class="btn-close" onclick="closeCloseShiftModal()"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning mb-3">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle me-3 mt-1"></i>
                        <div>
                            <p class="mb-1 fw-medium small">Perhatian!</p>
                            <p class="mb-0 small">Pastikan semua transaksi telah diselesaikan sebelum menutup shift.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-light p-3 rounded mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Saldo Awal:</span>
                        <span class="fw-medium small">$ <span id="modalInitialCash">0</span></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Total Penjualan:</span>
                        <span class="fw-medium text-success small">$ <span id="modalTotalSales">0</span></span>
                    </div>
                    <div class="border-top pt-2 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-medium small">Saldo Akhir:</span>
                            <span class="fw-bold text-primary">$ <span id="modalClosingBalance">0</span></span>
                        </div>
                        <p class="small text-muted mt-1">
                            <i class="fas fa-info-circle me-1"></i> Saldo akhir = Saldo Awal + Total Penjualan
                        </p>
                    </div>
                    <div class="border-top pt-2 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Durasi Shift:</span>
                            <span class="fw-medium small"><span id="modalShiftDuration">-</span></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="text-muted small">Waktu:</span>
                            <span class="fw-medium small"><span id="modalCurrentTLTime">-</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary btn-sm" onclick="closeCloseShiftModal()">Kembali</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmCloseShift()">
                    <i class="fas fa-stop-circle me-2"></i>Tutup Shift
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ==================== FUNGSI UTILITAS WAKTU TIMOR-LESTE ====================
const TimeUtils = {
    // PERBAIKAN: Konversi UTC ke Timor-Leste Time (Asia/Dili) - UTC+9
    // Jika server menyimpan waktu dalam UTC, tambahkan 9 jam
    // Jika server menyimpan waktu dalam WIB (UTC+7), tambahkan 2 jam
    convertToTLTime: function(serverDateString) {
        if (!serverDateString) return null;
        
        try {
            console.log('🕒 Converting time to TL:', serverDateString);
            
            const serverDate = new Date(serverDateString);
            
            // Cek offset server
            const serverOffset = serverDate.getTimezoneOffset(); // dalam menit
            console.log('Server timezone offset (minutes):', serverOffset);
            
            // WIB = UTC+7 = -420 menit
            // Timor-Leste = UTC+9 = -540 menit
            // Perbedaan = 2 jam = 120 menit
            
            // Jika server di WIB (UTC+7), tambahkan 2 jam
            if (serverOffset === -420) {
                console.log('🔄 Server is in WIB (UTC+7), adding 2 hours for TL time (UTC+9)');
                const tlTime = new Date(serverDate.getTime() + (2 * 60 * 60 * 1000));
                return tlTime;
            }
            // Jika server di UTC, tambahkan 9 jam
            else if (serverOffset === 0) {
                console.log('🔄 Server is in UTC, adding 9 hours for TL time (UTC+9)');
                const tlTime = new Date(serverDate.getTime() + (9 * 60 * 60 * 1000));
                return tlTime;
            }
            // Default: asumsikan server UTC, tambah 9 jam
            else {
                console.log('⚠️ Unknown server timezone, defaulting to UTC+9');
                const tlTime = new Date(serverDate.getTime() + (9 * 60 * 60 * 1000));
                return tlTime;
            }
            
        } catch (error) {
            console.error('❌ Error converting to TL time:', error);
            return new Date(serverDateString);
        }
    },
    
    // Format untuk display
    formatDateTime: function(date) {
        if (!date) return "-";
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Okt', 'Nov', 'Des'
        ];
        
        const day = days[date.getDay()];
        const dateNum = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${day}, ${dateNum} ${month} ${year} ${hours}:${minutes}`;
    },
    
    formatDateOnly: function(date) {
        if (!date) return "-";
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Okt', 'Nov', 'Des'
        ];
        
        const day = days[date.getDay()];
        const dateNum = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        
        return `${day}, ${dateNum} ${month} ${year}`;
    },
    
    formatTimeOnly: function(date) {
        if (!date) return "-";
        
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${hours}:${minutes}`;
    },
    
    formatShortDateTime: function(date) {
        if (!date) return "-";
        
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        const dateNum = date.getDate();
        const month = months[date.getMonth()];
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');
        
        return `${dateNum} ${month} ${hours}:${minutes}`;
    },
    
    // Get current Timor-Leste time (UTC+9)
    getCurrentTLTime: function() {
        const now = new Date();
        const browserOffset = now.getTimezoneOffset(); // dalam menit
        
        console.log('🌐 Browser timezone offset:', browserOffset, 'minutes');
        
        // Jika browser sudah di UTC+9 (Timor-Leste)
        if (browserOffset === -540) { // UTC+9 = -540 menit
            console.log('✅ Browser is already in Timor-Leste time (UTC+9)');
            return now;
        }
        
        // Jika browser di WIB (UTC+7), tambah 2 jam
        if (browserOffset === -420) { // WIB = UTC+7 = -420 menit
            console.log('🔄 Converting from WIB to Timor-Leste (+2 hours)');
            const tlTime = new Date(now.getTime() + (2 * 60 * 60 * 1000));
            return tlTime;
        }
        
        // Default: convert to UTC+9
        console.log('🔧 Converting to Timor-Leste time (UTC+9)');
        const utcTime = now.getTime() + (browserOffset * 60 * 1000);
        const tlTime = new Date(utcTime + (9 * 60 * 60 * 1000));
        return tlTime;
    },
    
    // Get current Timor-Leste time string for display
    getCurrentTLTimeString: function() {
        const tlDate = this.getCurrentTLTime();
        return this.formatTimeOnly(tlDate);
    },
    
    // Get current Timor-Leste date and time
    getCurrentTLDateTimeString: function() {
        const tlDate = this.getCurrentTLTime();
        return this.formatDateTime(tlDate);
    },
    
    // Format server time string to Timor-Leste time
    // PERBAIKAN: Tambah 2 jam jika server di WIB
    formatServerTimeToTL: function(serverTimeString, format = 'time') {
        try {
            console.log('🕐 Formatting server time:', serverTimeString);
            
            if (!serverTimeString || serverTimeString === '') {
                return "-";
            }
            
            // Convert server time to Timor-Leste time
            const tlDate = this.convertToTLTime(serverTimeString);
            console.log('🕐 Converted TL time:', tlDate);
            
            if (!tlDate || isNaN(tlDate.getTime())) {
                return "-";
            }
            
            switch(format) {
                case 'time':
                    return this.formatTimeOnly(tlDate);
                case 'date':
                    return this.formatDateOnly(tlDate);
                case 'datetime':
                    return this.formatDateTime(tlDate);
                default:
                    return this.formatTimeOnly(tlDate);
            }
        } catch (error) {
            console.error('❌ Error formatting server time to TL:', error);
            return "-";
        }
    },
    
    // Debug function untuk melihat perbedaan waktu
    debugTimezoneInfo: function(serverTimeString) {
        console.log('=== DEBUG TIMEZONE INFO ===');
        
        if (serverTimeString) {
            const serverDate = new Date(serverTimeString);
            const tlDate = this.convertToTLTime(serverTimeString);
            
            console.log('Server time:', serverDate.toString());
            console.log('Server ISO:', serverDate.toISOString());
            console.log('Server offset:', serverDate.getTimezoneOffset(), 'minutes');
            
            console.log('Timor-Leste time:', tlDate.toString());
            console.log('TL ISO:', tlDate.toISOString());
            
            const diffHours = (tlDate.getTime() - serverDate.getTime()) / (1000 * 60 * 60);
            console.log('Time difference:', diffHours, 'hours');
        }
        
        const now = new Date();
        console.log('Browser local time:', now.toString());
        console.log('Browser offset:', now.getTimezoneOffset(), 'minutes');
        
        const tlNow = this.getCurrentTLTime();
        console.log('Current TL time:', tlNow.toString());
    }
};

// ==================== DASHBOARD MANAGER ====================
class DashboardManager {
    constructor() {
        this.shiftData = null;
        this.durationInterval = null;
        this.modalInterval = null;
    }
    
    async init() {
        console.log('🚀 Dashboard Manager Initializing with Timor-Leste Time...');
        
        try {
            // Debug informasi timezone
            TimeUtils.debugTimezoneInfo();
            
            await this.loadDashboardData();
            this.setupEventListeners();
            this.setupAutoRefresh();
            
            // Update waktu transaksi setelah semua dimuat
            setTimeout(() => {
                this.updateTransactionTimes();
            }, 100);
            
            console.log('✅ Dashboard Manager initialized successfully');
            
        } catch (error) {
            console.error('❌ Error initializing dashboard:', error);
            this.showNotification('Error loading dashboard data', 'error');
        }
    }
    
    async loadDashboardData() {
        try {
            console.log('📡 Loading dashboard data...');
            const response = await fetch('/api/cashier/dashboard/summary');
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                console.log('📊 Dashboard data loaded:', data);
                
                this.shiftData = {
                    isActive: data.shift_active,
                    initialCash: data.shift_data?.opening_balance || 0,
                    number: data.shift_data?.drawer_number || '1',
                    totalSales: data.stats?.total_sales || 0,
                    totalTransactions: data.stats?.total_transactions || 0,
                    itemsSold: data.stats?.items_sold || 0,
                    startTime: data.shift_data?.opened_at ? new Date(data.shift_data.opened_at) : null,
                    recentTransactions: data.recent_transactions || []
                };
                
                // Debug waktu transaksi
                if (this.shiftData.recentTransactions.length > 0) {
                    console.log('🔍 Sample transaction time debug:');
                    const sample = this.shiftData.recentTransactions[0];
                    console.log('Transaction created_at:', sample.created_at);
                    console.log('Formatted TL time:', TimeUtils.formatServerTimeToTL(sample.created_at, 'time'));
                    TimeUtils.debugTimezoneInfo(sample.created_at);
                }
                
                this.updateUI();
                return true;
            } else {
                console.error('❌ API error:', data.message);
                return false;
            }
            
        } catch (error) {
            console.error('❌ Error loading data:', error);
            return false;
        }
    }
    
    updateUI() {
        if (!this.shiftData) return;
        
        const shiftActive = this.shiftData.isActive;
        
        // Update shift status
        this.updateElementText('shiftStatusDisplay', shiftActive ? 'Aktif' : 'Belum Dimulai');
        
        // Update cash balance - DOLLAR FORMAT
        this.updateCurrency('cashBalanceDisplay', this.shiftData.initialCash);
        
        // Update shift number
        this.updateElementText('shiftNumberDisplay', shiftActive ? this.shiftData.number : '-');
        
        // Update today's transactions
        this.updateElementText('todayTransactionsDisplay', this.shiftData.totalTransactions);
        
        // Update stats - DOLLAR FORMAT
        this.updateCurrency('totalSalesDisplay', this.shiftData.totalSales);
        this.updateElementText('totalTransactionsDisplay', this.shiftData.totalTransactions);
        
        const avg = this.shiftData.totalTransactions > 0 
            ? Math.round(this.shiftData.totalSales / this.shiftData.totalTransactions)
            : 0;
        this.updateCurrency('averageTransactionDisplay', avg);
        
        this.updateElementText('itemsSoldDisplay', this.shiftData.itemsSold);
        
        // Update status texts
        const statusText = shiftActive 
            ? `<i class="fas fa-sync-alt me-1"></i> Shift aktif`
            : `<i class="fas fa-minus me-1"></i> Shift belum dimulai`;
        
        ['salesStatusDisplay', 'transactionsStatusDisplay', 
         'averageStatusDisplay', 'itemsStatusDisplay'].forEach(id => {
            this.updateElementHTML(id, statusText);
        });
        
        // Update shift summary
        this.updateElementText('shiftSummaryStatus', shiftActive ? 'Aktif' : 'Tidak Aktif');
        
        const summaryIcon = document.getElementById('shiftSummaryIcon');
        if (summaryIcon) {
            summaryIcon.className = shiftActive 
                ? 'p-3 rounded-circle bg-success bg-opacity-10' 
                : 'p-3 rounded-circle bg-danger bg-opacity-10';
            summaryIcon.innerHTML = shiftActive 
                ? '<i class="fas fa-play-circle text-success fs-4"></i>'
                : '<i class="fas fa-pause-circle text-danger fs-4"></i>';
        }
        
        // Update start time display dengan waktu Timor-Leste
        const startTimeDisplay = document.getElementById('startTimeDisplay');
        if (startTimeDisplay && this.shiftData.startTime) {
            // Format waktu Timor-Leste
            const tlStartTime = TimeUtils.formatServerTimeToTL(
                this.shiftData.startTime.toISOString(), 
                'time'
            );
            startTimeDisplay.textContent = tlStartTime;
        }
        
        // Update duration displays
        if (shiftActive) {
            this.startRealTimeUpdates();
            this.updateDurationDisplays();
        } else {
            this.stopRealTimeUpdates();
            this.updateElementText('summaryDurationDisplay', '-');
            this.updateElementText('shiftDurationDisplay', '-');
        }
        
        // Update recent transactions
        this.updateRecentTransactions();
    }
    
    updateRecentTransactions() {
        const container = document.getElementById('recentTransactionsContainer');
        if (!container) return;
        
        if (!this.shiftData || !this.shiftData.isActive) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-clock text-muted mb-3 fs-1"></i>
                    <p class="text-muted">Shift belum dimulai</p>
                    <p class="text-muted small">Mulai shift untuk melihat transaksi</p>
                </div>
            `;
            return;
        }
        
        const transactions = this.shiftData.recentTransactions || [];
        
        if (transactions.length === 0) {
            container.innerHTML = this.getEmptyTransactionsHTML();
            return;
        }
        
        container.innerHTML = this.generateTransactionsTable(transactions.slice(0, 5));
    }
    
    updateTransactionTimes() {
        // Update waktu transaksi di tabel dengan Timor-Leste Time
        const timeCells = document.querySelectorAll('td[data-utc-time]');
        console.log(`🕒 Updating ${timeCells.length} transaction times to TL time...`);
        
        timeCells.forEach(cell => {
            const utcTime = cell.getAttribute('data-utc-time');
            if (utcTime && utcTime.trim() !== '') {
                try {
                    const tlTime = TimeUtils.formatServerTimeToTL(utcTime, 'time');
                    console.log(`🕒 ${utcTime} → ${tlTime}`);
                    
                    // Tambah badge TL untuk identifikasi
                    cell.innerHTML = `
                        <div class="d-flex align-items-center">
                            <span class="me-1">${tlTime}</span>
                            
                        </div>
                    `;
                    cell.classList.add('time-updated');
                } catch (error) {
                    console.error('❌ Error updating time:', error);
                    cell.textContent = '-';
                }
            }
        });
    }
    
    getEmptyTransactionsHTML() {
        return `
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart text-muted mb-3 fs-1"></i>
                <p class="text-muted">Belum ada transaksi</p>
                <p class="text-muted small">Mulai transaksi pertama Anda</p>
            </div>
        `;
    }
    
    generateTransactionsTable(transactions) {
        let html = `
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr class="small">
                            <th class="border-0">ID</th>
                            <th class="border-0">Waktu</th>
                            <th class="border-0">Items</th>
                            <th class="border-0">Total</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        transactions.forEach(transaction => {
            // Simpan waktu UTC di data attribute
            const utcTime = transaction.created_at;
            
            html += `
                <tr class="small">
                    <td class="fw-medium">${transaction.transaction_code}</td>
                    <td class="text-muted" data-utc-time="${utcTime}">
                        <div class="d-flex align-items-center">
                            <span class="me-1">Loading...</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 9px; padding: 1px 4px;">
                                TL
                            </span>
                        </div>
                    </td>
                    <td>${transaction.items_count || 0} items</td>
                    <td class="fw-bold text-success">$ ${transaction.total_amount ? this.formatNumber(transaction.total_amount) : '0'}</td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
               
            </div>
        `;
        
        return html;
    }
    
    setupEventListeners() {
        console.log('🔗 Setting up event listeners...');
        
        // Event listener untuk button close shift
        document.getElementById('closeShiftBtn')?.addEventListener('click', (e) => {
            e.preventDefault();
            openCloseShiftModal();
        });
    }
    
    setupAutoRefresh() {
        // Auto refresh data setiap 30 detik
        setInterval(async () => {
            if (this.shiftData && this.shiftData.isActive) {
                console.log('🔄 Auto-refreshing dashboard data...');
                await this.loadDashboardData();
            }
        }, 30000);
    }
    
    startRealTimeUpdates() {
        this.stopRealTimeUpdates();
        
        this.durationInterval = setInterval(() => {
            if (this.shiftData && this.shiftData.isActive) {
                this.updateDurationDisplays();
            } else {
                this.stopRealTimeUpdates();
            }
        }, 1000);
    }
    
    stopRealTimeUpdates() {
        if (this.durationInterval) {
            clearInterval(this.durationInterval);
            this.durationInterval = null;
        }
    }
    
    updateDurationDisplays() {
        const duration = this.getShiftDuration();
        this.updateElementText('summaryDurationDisplay', duration);
        this.updateElementText('shiftDurationDisplay', duration);
    }
    
    getShiftDuration() {
        if (!this.shiftData || !this.shiftData.isActive || !this.shiftData.startTime) {
            return "-";
        }
        
        try {
            const startTime = new Date(this.shiftData.startTime);
            const now = new Date();
            
            const diffMs = now.getTime() - startTime.getTime();
            const totalSeconds = Math.floor(diffMs / 1000);
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            
            if (hours > 0) {
                return `${hours} jam ${minutes} menit`;
            } else if (minutes > 0) {
                return `${minutes} menit ${seconds} detik`;
            } else if (seconds > 0) {
                return `${seconds} detik`;
            } else {
                return "Baru mulai";
            }
            
        } catch (error) {
            return "-";
        }
    }
    
    updateElementText(id, text) {
        const element = document.getElementById(id);
        if (element) element.textContent = text;
    }
    
    updateElementHTML(id, html) {
        const element = document.getElementById(id);
        if (element) element.innerHTML = html;
    }
    
    updateCurrency(id, amount) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = `$ ${this.formatNumber(amount)}`;
        }
    }
    
    formatNumber(number) {
        return number.toLocaleString('id-ID');
    }
    
    showNotification(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        toast.style.zIndex = '9999';
        
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'} me-2"></i>
                <span>${message}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentNode) {
                const bsAlert = new bootstrap.Alert(toast);
                bsAlert.close();
            }
        }, 3000);
    }
}

const dashboardManager = new DashboardManager();

// ==================== FUNGSI MODAL ====================
function openStartShiftModal() {
    // Tampilkan waktu Timor-Leste saat ini
    const tlNow = TimeUtils.getCurrentTLTime();
    const tlTimeString = TimeUtils.formatTimeOnly(tlNow);
    const tlDateString = TimeUtils.formatDateOnly(tlNow);
    
    const currentTimeDisplay = document.getElementById('currentTimeDisplay');
    if (currentTimeDisplay) {
        currentTimeDisplay.textContent = `${tlTimeString} (${tlDateString})`;
    }
    
    fetch('/api/cashier/shift/next-number')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const shiftNumberDisplay = document.getElementById('modalShiftNumber');
                if (shiftNumberDisplay) {
                    shiftNumberDisplay.textContent = data.next_number;
                }
            }
        });
    
    const modal = new bootstrap.Modal(document.getElementById('startShiftModal'));
    modal.show();
    
    setTimeout(() => {
        const cashInput = document.getElementById('initialCash');
        if (cashInput) {
            cashInput.focus();
            cashInput.select();
        }
    }, 100);
}

function closeStartShiftModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('startShiftModal'));
    if (modal) {
        modal.hide();
    }
}

function openCloseShiftModal() {
    if (!dashboardManager.shiftData || !dashboardManager.shiftData.isActive) {
        dashboardManager.showNotification('Tidak ada shift aktif', 'error');
        return;
    }
    
    fetch('/api/cashier/shift/summary')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modalInitialCash = document.getElementById('modalInitialCash');
                const modalTotalSales = document.getElementById('modalTotalSales');
                const modalClosingBalance = document.getElementById('modalClosingBalance');
                const modalCurrentTLTime = document.getElementById('modalCurrentTLTime');
                
                if (modalInitialCash) {
                    modalInitialCash.textContent = dashboardManager.formatNumber(data.opening_balance);
                }
                
                if (modalTotalSales) {
                    modalTotalSales.textContent = dashboardManager.formatNumber(dashboardManager.shiftData.totalSales);
                }
                
                if (modalClosingBalance) {
                    const closingBalance = data.opening_balance + dashboardManager.shiftData.totalSales;
                    modalClosingBalance.textContent = dashboardManager.formatNumber(closingBalance);
                }
                
                // Update waktu Timor-Leste saat ini
                if (modalCurrentTLTime) {
                    const tlNow = TimeUtils.getCurrentTLTime();
                    modalCurrentTLTime.textContent = TimeUtils.formatTimeOnly(tlNow);
                    
                    // Update real-time
                    if (dashboardManager.modalInterval) {
                        clearInterval(dashboardManager.modalInterval);
                    }
                    
                    dashboardManager.modalInterval = setInterval(() => {
                        if (!document.getElementById('closeShiftModal').classList.contains('show')) {
                            clearInterval(dashboardManager.modalInterval);
                            dashboardManager.modalInterval = null;
                            return;
                        }
                        
                        const tlNow = TimeUtils.getCurrentTLTime();
                        modalCurrentTLTime.textContent = TimeUtils.formatTimeOnly(tlNow);
                    }, 60000); // Update setiap menit
                }
                
                const modalShiftDuration = document.getElementById('modalShiftDuration');
                if (modalShiftDuration) {
                    modalShiftDuration.textContent = dashboardManager.getShiftDuration();
                }
                
                const modal = new bootstrap.Modal(document.getElementById('closeShiftModal'));
                modal.show();
            }
        });
}

function closeCloseShiftModal() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('closeShiftModal'));
    if (modal) {
        modal.hide();
    }
    
    if (dashboardManager.modalInterval) {
        clearInterval(dashboardManager.modalInterval);
        dashboardManager.modalInterval = null;
    }
}

async function confirmStartShift() {
    const initialCashInput = document.getElementById('initialCash');
    const confirmCheck = document.getElementById('confirmStart');
    
    if (!initialCashInput || !confirmCheck) {
        dashboardManager.showNotification('Form tidak lengkap', 'error');
        return;
    }
    
    const cashValue = initialCashInput.value.replace(/\./g, '');
    const initialCash = parseFloat(cashValue);
    
    if (isNaN(initialCash) || initialCash < 0) {
        dashboardManager.showNotification('Masukkan jumlah saldo tunai yang valid', 'error');
        initialCashInput.focus();
        return;
    }
    
    if (!confirmCheck.checked) {
        dashboardManager.showNotification('Harap konfirmasi pemeriksaan saldo tunai', 'error');
        return;
    }
    
    try {
        dashboardManager.showNotification('Membuka shift...', 'info');
        
        const response = await fetch('/api/cashier/cash-drawer/open', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                opening_balance: initialCash
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            dashboardManager.showNotification('Shift berhasil dimulai!', 'success');
            closeStartShiftModal();
            
            setTimeout(async () => {
                await dashboardManager.loadDashboardData();
                location.reload();
            }, 1000);
        } else {
            dashboardManager.showNotification(data.message || 'Gagal memulai shift', 'error');
        }
    } catch (error) {
        console.error('Error starting shift:', error);
        dashboardManager.showNotification('Gagal memulai shift. Silakan coba lagi.', 'error');
    }
}

async function confirmCloseShift() {
    try {
        const modalInitialCash = document.getElementById('modalInitialCash');
        const modalTotalSales = document.getElementById('modalTotalSales');
        
        if (!modalInitialCash || !modalTotalSales) {
            dashboardManager.showNotification('Gagal mendapatkan data saldo', 'error');
            return;
        }
        
        const openingBalance = parseFloat(modalInitialCash.textContent.replace(/\./g, ''));
        const totalSales = parseFloat(modalTotalSales.textContent.replace(/\./g, ''));
        const closingBalance = openingBalance + totalSales;
        
        dashboardManager.showNotification('Menutup shift...', 'info');
        
        const response = await fetch('/api/cashier/cash-drawer/close', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                actual_cash: closingBalance,
                closing_balance: closingBalance,
                denominations: [],
                notes: 'Shift ditutup dari dashboard'
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            dashboardManager.showNotification(`Shift berhasil ditutup!`, 'success');
            closeCloseShiftModal();
            
            setTimeout(async () => {
                await dashboardManager.loadDashboardData();
                location.reload();
            }, 1000);
        } else {
            dashboardManager.showNotification(data.message || 'Gagal menutup shift', 'error');
        }
    } catch (error) {
        console.error('Error closing shift:', error);
        dashboardManager.showNotification('Gagal menutup shift. Silakan coba lagi.', 'error');
    }
}

// ==================== INISIALISASI ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('📋 Dashboard page loaded');
    
    // Debug timezone info
    console.log('=== INITIAL TIMEZONE INFO ===');
    console.log('Browser timezone:', Intl.DateTimeFormat().resolvedOptions().timeZone);
    console.log('Browser offset (minutes):', new Date().getTimezoneOffset());
    
    const testDate = new Date();
    console.log('Browser time:', testDate.toString());
    console.log('Browser ISO:', testDate.toISOString());
    
    // Inisialisasi Dashboard Manager
    dashboardManager.init();
    
    // Expose functions to global scope
    window.dashboardManager = dashboardManager;
    window.TimeUtils = TimeUtils;
    window.openStartShiftModal = openStartShiftModal;
    window.closeStartShiftModal = closeStartShiftModal;
    window.openCloseShiftModal = openCloseShiftModal;
    window.closeCloseShiftModal = closeCloseShiftModal;
    window.confirmStartShift = confirmStartShift;
    window.confirmCloseShift = confirmCloseShift;
    
    // Format input saldo tunai
    const initialCashInput = document.getElementById('initialCash');
    if (initialCashInput) {
        initialCashInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value === '') value = '0';
            
            const formatted = parseInt(value).toLocaleString('id-ID');
            e.target.value = formatted;
        });
        
        initialCashInput.addEventListener('blur', function(e) {
            if (e.target.value === '') {
                e.target.value = '0';
            }
        });
    }
    
    console.log('✅ Dashboard initialized with Timor-Leste Time support');
});
</script>

<style>
/* Custom styles untuk dashboard */
.card {
    border-radius: var(--radius) !important;
    transition: var(--transition);
}

.card:hover {
    box-shadow: var(--shadow-medium) !important;
}

.bg-purple {
    background-color: #9333EA !important;
}

.text-purple {
    color: #9333EA !important;
}

.border-purple {
    border-color: #9333EA !important;
}

.text-white\/80 {
    color: rgba(255, 255, 255, 0.8) !important;
}

.text-white\/70 {
    color: rgba(255, 255, 255, 0.7) !important;
}

.bg-white\/10 {
    background-color: rgba(255, 255, 255, 0.1) !important;
}

.bg-white\/20 {
    background-color: rgba(255, 255, 255, 0.2) !important;
}

.border-white\/20 {
    border-color: rgba(255, 255, 255, 0.2) !important;
}

/* Animation untuk update waktu */
@keyframes timeUpdate {
    0% { opacity: 0.5; transform: translateY(2px); }
    100% { opacity: 1; transform: translateY(0); }
}

.time-updated {
    animation: timeUpdate 0.3s ease-in-out;
}

/* Badge TL time indicator */
.badge-tl-time {
    background: linear-gradient(135deg, #1d4ed8, #3b82f6);
    color: white;
    font-size: 9px;
    padding: 1px 4px;
    border-radius: 4px;
    font-weight: 600;
    margin-left: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .h4 {
        font-size: 1.25rem !important;
    }
    
    .fs-4 {
        font-size: 1.25rem !important;
    }
    
    .fs-5 {
        font-size: 1rem !important;
    }
    
    .table-responsive {
        font-size: 13px;
    }
    
    .badge-tl-time {
        font-size: 8px;
        padding: 0 3px;
    }
}

@media (max-width: 576px) {
    .page-title {
        font-size: 1.25rem !important;
    }
    
    .page-subtitle {
        font-size: 0.75rem !important;
    }
    
    .card-header {
        padding: 0.75rem 1rem !important;
    }
    
    .card-title {
        font-size: 1rem !important;
    }
    
    .table th, .table td {
        padding: 0.5rem 0.25rem !important;
        font-size: 0.75rem;
    }
    
    .badge-tl-time {
        font-size: 7px;
        padding: 0 2px;
    }
}

/* Hover effects */
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Modal backdrop */
.modal-backdrop {
    background-color: rgba(15, 26, 47, 0.5);
}

/* Time display styling */
td[data-utc-time] {
    font-family: 'Courier New', monospace;
    font-weight: 500;
}
</style>
@endpush
```