<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order {{ $po->po_number }} - Dili Society</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Font Import */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Source+Serif+Pro:wght@400;600;700&display=swap');
        
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Print Styles */
        @media print {
            @page {
                size: A4;
                margin: 2cm 1.5cm;
                marks: crop cross;
            }
            
            @page :first {
                margin-top: 1.5cm;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                font-size: 11pt;
                line-height: 1.5;
                color: #1a1a1a;
                background: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none !important;
            }
            
            .print-container {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .avoid-break {
                page-break-inside: avoid;
            }
            
            .header-section, .signature-section, .footer-section {
                break-inside: avoid;
            }
            
            a {
                color: inherit !important;
                text-decoration: none !important;
            }
        }
        
        /* Main Styles */
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #1a1a1a;
        }
        
        .print-container {
            max-width: 21cm;
            width: 100%;
            background: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            position: relative;
            border: 1px solid #e0e0e0;
        }
        
        /* Watermark Background */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.03);
            z-index: 0;
            font-family: 'Source Serif Pro', serif;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }
        
        /* Header Styles */
        .letterhead {
            padding: 40px 50px 30px;
            border-bottom: 2px solid #1a365d;
            position: relative;
            z-index: 1;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .company-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .company-identity {
            flex: 1;
        }
        
        .company-name {
            font-family: 'Source Serif Pro', serif;
            font-size: 28px;
            font-weight: 700;
            color: #1a365d;
            letter-spacing: -0.5px;
            margin-bottom: 4px;
        }
        
        .company-tagline {
            font-size: 13px;
            color: #4a5568;
            font-weight: 400;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        
        .company-details {
            font-size: 11px;
            color: #718096;
            line-height: 1.6;
        }
        
        .company-details i {
            width: 16px;
            text-align: center;
            margin-right: 6px;
            color: #4a5568;
        }
        
        .document-header {
            text-align: right;
            border-left: 1px solid #e2e8f0;
            padding-left: 25px;
            min-width: 250px;
        }
        
        .document-type {
            font-size: 32px;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        
        .document-subtitle {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }
        
        .document-number {
            font-size: 14px;
            font-weight: 600;
            color: #1a365d;
            background: #edf2f7;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-block;
        }
        
        /* PO Information */
        .po-info-section {
            padding: 30px 50px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            position: relative;
            z-index: 1;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .info-item {
            margin-bottom: 12px;
        }
        
        .info-label {
            font-size: 10px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a1a;
            line-height: 1.5;
        }
        
        .info-value strong {
            font-weight: 700;
            color: #1a365d;
        }
        
        .status-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .status-pending { background-color: #ecc94b; }
        .status-approved { background-color: #48bb78; }
        .status-fulfilled { background-color: #4299e1; }
        
        .status-text {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-pending-text { color: #975a16; }
        .status-approved-text { color: #276749; }
        .status-fulfilled-text { color: #2c5282; }
        
        /* Items Section */
        .items-section {
            padding: 35px 50px 25px;
            position: relative;
            z-index: 1;
        }
        
        .section-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-title {
            font-family: 'Source Serif Pro', serif;
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            position: relative;
            padding-left: 20px;
        }
        
        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 80%;
            background: #1a365d;
            border-radius: 3px;
        }
        
        .items-count {
            font-size: 11px;
            color: #718096;
            background: #edf2f7;
            padding: 4px 12px;
            border-radius: 12px;
        }
        
        /* Table Styles */
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 11px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .items-table thead {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
        }
        
        .items-table th {
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .items-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s;
        }
        
        .items-table tbody tr:last-child {
            border-bottom: none;
        }
        
        .items-table tbody tr:hover {
            background-color: #f7fafc;
        }
        
        .items-table td {
            padding: 14px 12px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .serial-cell {
            width: 40px;
            text-align: center;
            color: #718096;
            font-weight: 500;
        }
        
        .product-cell {
            font-weight: 500;
            color: #2d3748;
        }
        
        .sku-cell {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            color: #718096;
            letter-spacing: 0.5px;
        }
        
        .quantity-cell, .price-cell {
            text-align: right;
            font-weight: 500;
        }
        
        .price-cell {
            color: #1a365d;
            font-weight: 600;
        }
        
        /* Summary Section */
        .summary-section {
            padding: 25px 50px 30px;
            border-top: 2px solid #e2e8f0;
            background: #f8fafc;
            position: relative;
            z-index: 1;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 30px;
            align-items: start;
        }
        
        .notes-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 18px;
        }
        
        .notes-label {
            font-size: 11px;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .notes-content {
            font-size: 12px;
            color: #4a5568;
            line-height: 1.6;
            white-space: pre-line;
        }
        
        .totals-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 18px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .total-row:last-child {
            border-bottom: none;
        }
        
        .total-label {
            font-size: 12px;
            color: #718096;
        }
        
        .total-amount {
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
        }
        
        .grand-total {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #e2e8f0;
        }
        
        .grand-total .total-label {
            font-size: 14px;
            font-weight: 700;
            color: #1a365d;
        }
        
        .grand-total .total-amount {
            font-size: 18px;
            font-weight: 800;
            color: #1a365d;
        }
        
        /* Signature Section */
        .signature-section {
            padding: 35px 50px;
            border-top: 1px solid #e2e8f0;
            background: white;
            position: relative;
            z-index: 1;
        }
        
        .signature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-title {
            font-size: 12px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .signature-area {
            min-height: 80px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }
        
        .signature-details {
            font-size: 11px;
            color: #718096;
            line-height: 1.6;
        }
        
        .signature-details strong {
            color: #4a5568;
            font-weight: 600;
        }
        
        .stamp-area {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .official-stamp {
            border: 2px solid #c53030;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            font-weight: 700;
            color: #c53030;
            text-align: center;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Footer */
        .footer-section {
            padding: 25px 50px;
            background: #1a365d;
            color: #cbd5e0;
            font-size: 10px;
            position: relative;
            z-index: 1;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-legal {
            max-width: 500px;
            line-height: 1.6;
        }
        
        .footer-links {
            text-align: right;
        }
        
        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.2s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .page-number {
            text-align: center;
            font-size: 10px;
            color: #a0aec0;
            margin-top: 10px;
        }
        
        /* Print Controls */
        .print-controls {
            width: 100%;
            max-width: 21cm;
            margin: 0 auto 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            min-width: 140px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1a365d 0%, #2d3748 100%);
            color: white;
            border: 1px solid #1a365d;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2d3748 0%, #1a365d 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 54, 93, 0.2);
        }
        
        .btn-secondary {
            background: white;
            color: #4a5568;
            border: 1px solid #e2e8f0;
        }
        
        .btn-secondary:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #a0aec0;
        }
        
        .empty-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #e2e8f0;
        }
        
        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: #718096;
            margin-bottom: 8px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .print-container {
                margin: 10px auto;
            }
            
            .letterhead,
            .po-info-section,
            .items-section,
            .summary-section,
            .signature-section,
            .footer-section {
                padding: 25px;
            }
            
            .company-header {
                flex-direction: column;
                gap: 20px;
            }
            
            .document-header {
                text-align: left;
                border-left: none;
                border-top: 1px solid #e2e8f0;
                padding-left: 0;
                padding-top: 20px;
                width: 100%;
            }
            
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .summary-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .signature-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .print-controls {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .items-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<!-- PRINT CONTROLS -->
<div class="print-controls no-print">
    <button class="btn btn-primary" onclick="window.print()">
        <i class="fas fa-print"></i> Print Document
    </button>
    <a href="{{ url('/admin/inventory/purchase') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <button class="btn btn-secondary" onclick="window.close()">
        <i class="fas fa-times"></i> Close Window
    </button>
</div>

<div class="print-container">

    <div class="watermark">DILI SOCIETY</div>

    <!-- HEADER -->
    <div class="letterhead">
        <div class="company-header">
            <div class="company-identity">
                <h1 class="company-name">DILI SOCIETY</h1>
                <div class="company-tagline">Premium Fashion Retailer</div>
            </div>

            <div class="document-header">
                <div class="document-type">PURCHASE ORDER</div>
                <div class="document-subtitle">Official Procurement Document</div>
                <div class="document-number">
                    PO/{{ $po->po_number }}/{{ $po->created_at->format('Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- INFO -->
    <div class="po-info-section">
        <div class="info-grid">

            <div class="info-item">
                <div class="info-label">PO Number</div>
                <div class="info-value"><strong>{{ $po->po_number }}</strong></div>
            </div>

            <div class="info-item">
                <div class="info-label">Issue Date</div>
                <div class="info-value">{{ $po->created_at->format('d M Y') }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-text status-{{ $po->status }}-text">
                        {{ strtoupper($po->status) }}
                    </span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Supplier</div>
                <div class="info-value">{{ $po->supplier ?? 'To be determined' }}</div>
            </div>

        </div>
    </div>

    <!-- ITEMS -->
    <div class="items-section">
        <div class="section-header">
            <h2 class="section-title">Order Items</h2>
            <div class="items-count">{{ $po->order_items->count() }} ITEMS</div>
        </div>

        @if($po->order_items->count())
        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($po->order_items as $i => $item)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->sku }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price,0,',','.') }}</td>
                    <td class="text-right">{{ number_format($item->total_price,0,',','.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="empty-state">
                <h3>No Items</h3>
            </div>
        @endif
    </div>

    <!-- TOTAL -->
    <div class="summary-section">
        <div class="total-row grand-total">
            <span>GRAND TOTAL</span>
            <span>Rp {{ number_format($po->total_amount,0,',','.') }}</span>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer-section">
        <div class="page-number">
            Generated on {{ $currentDate }}
        </div>
    </div>

</div>

</body>
</html>
