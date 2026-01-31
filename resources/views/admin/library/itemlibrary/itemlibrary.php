@extends('admin.layout')

@section('title', 'Item Library - BONUS CLOTHING')
@section('page_title', 'Item Library')
@section('page_subtitle', 'Manage all your products and inventory items')

@section('styles')
<style>
    :root {
        --primary-blue: #2c7be5;
        --primary-blue-light: #e8f1fd;
        --primary-blue-dark: #1a5ab3;
        --secondary-blue: #6c84ee;
        --light-blue: #f0f5ff;
        --blue-gradient: linear-gradient(135deg, #2c7be5 0%, #6c84ee 100%);
        --blue-gradient-light: linear-gradient(135deg, #e8f1fd 0%, #f0f5ff 100%);
        --card-shadow: 0 4px 12px rgba(44, 123, 229, 0.08);
        --card-shadow-hover: 0 8px 24px rgba(44, 123, 229, 0.12);
        --border-radius: 12px;
        --transition: all 0.3s ease;
    }

    body {
        background-color: #f8fafc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    }

    /* Header Section */
    .page-header-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
    }

    .page-title-main {
        color: var(--primary-blue);
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 1.75rem;
    }

    .page-subtitle-main {
        color: #64748b;
        font-size: 0.95rem;
    }

    /* Stat Cards */
    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        transition: var(--transition);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }

    .stat-icon-container {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        background: var(--primary-blue-light);
        color: var(--primary-blue);
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .stat-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .stat-change {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        background: var(--primary-blue-light);
        color: var(--primary-blue);
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Filter Section */
    .filter-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
    }

    .filter-controls {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: nowrap;
        min-width: 0;
    }

    .filter-label {
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .outlet-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 16px;
        background: white;
        color: #334155;
        font-weight: 500;
        min-width: 160px;
        height: 40px;
        flex-shrink: 0;
    }

    .category-filters-container {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        min-width: 0;
        overflow: hidden;
    }

    .category-filters-wrapper {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 4px 0;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
        flex: 1;
    }

    .category-filters-wrapper::-webkit-scrollbar {
        height: 4px;
    }

    .category-filters-wrapper::-webkit-scrollbar-track {
        background: transparent;
    }

    .category-filters-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 2px;
    }

    .category-filter-btn {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #475569;
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        height: 40px;
        flex-shrink: 0;
    }

    .category-filter-btn:hover {
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }

    .category-filter-btn.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    .search-sort-container {
        display: flex;
        gap: 12px;
        flex: 1;
        min-width: 300px;
        max-width: 500px;
    }

    .search-container {
        position: relative;
        flex: 1;
        min-width: 200px;
    }

    .search-input {
        width: 100%;
        padding: 8px 16px 8px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #334155;
        font-size: 0.95rem;
        transition: var(--transition);
        height: 40px;
    }

    .search-input:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.1);
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .sort-dropdown {
        flex-shrink: 0;
    }

    .sort-btn {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #475569;
        font-weight: 500;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        white-space: nowrap;
    }

    .sort-btn:hover {
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }

    /* Products Table */
    .table-container {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
    }

    .table-header {
        background: var(--light-blue);
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        color: var(--primary-blue);
        font-weight: 600;
        margin: 0;
        font-size: 1.1rem;
    }

    .products-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .products-table th {
        background: #f8fafc;
        padding: 16px 24px;
        color: #475569;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    .products-table td {
        padding: 20px 24px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    /* Product Row */
    .product-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .product-image {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .product-image-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        background: var(--primary-blue-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .product-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .product-description {
        color: #64748b;
        font-size: 0.875rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .status-draft {
        background: #fef3c7;
        color: #92400e;
    }

    /* Category Badge */
    .category-badge {
        padding: 6px 12px;
        background: var(--primary-blue-light);
        color: var(--primary-blue);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Price Display */
    .price-value {
        font-weight: 700;
        color: #1e293b;
        font-size: 1rem;
    }

    /* Stock Indicator */
    .stock-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .stock-value {
        font-weight: 700;
        color: #1e293b;
    }

    .stock-value.low {
        color: #dc2626;
    }

    .stock-value.medium {
        color: #d97706;
    }

    .stock-value.high {
        color: #059669;
    }

    /* Low Stock Indicator */
    .low-stock-indicator {
        background: #fef3c7;
        color: #92400e;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-left: 4px;
    }

    .out-stock-indicator {
        background: #f1f5f9;
        color: #64748b;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-left: 4px;
    }

    /* Variant Section */
    .variant-info {
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px dashed #e2e8f0;
    }

    .variant-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 4px 0;
        font-size: 0.8rem;
    }

    .variant-name {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
        min-width: 0;
    }

    .variant-name i {
        color: var(--primary-blue);
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .variant-name span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
    }

    .variant-details {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .variant-price {
        color: #1e293b;
        font-weight: 600;
        white-space: nowrap;
        min-width: 80px;
        text-align: right;
    }

    .variant-stock {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        min-width: 60px;
        text-align: center;
    }

    .variant-stock.high {
        background: #d1fae5;
        color: #065f46;
    }

    .variant-stock.medium {
        background: #fef3c7;
        color: #92400e;
    }

    .variant-stock.low {
        background: #fee2e2;
        color: #991b1b;
    }

    .variant-stock.out {
        background: #f1f5f9;
        color: #64748b;
    }

    .variant-count-badge {
        background: var(--light-blue);
        color: var(--primary-blue);
        border-radius: 12px;
        padding: 2px 8px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-left: 8px;
    }

    .all-variants-link {
        color: var(--primary-blue);
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 8px;
        cursor: pointer;
        transition: var(--transition);
    }

    .all-variants-link:hover {
        color: var(--primary-blue-dark);
        text-decoration: underline;
    }

    /* Stock Detail Badges */
    .stock-detail-badge {
        font-size: 0.7rem;
        padding: 2px 6px;
        margin: 1px;
        border-radius: 4px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: inline-block;
    }

    .stock-detail-badge .variant-name {
        color: #475569;
        font-weight: 500;
    }

    .stock-detail-badge .stock-count {
        color: #1e293b;
        font-weight: 600;
        margin-left: 4px;
    }

    .stock-detail-badge .stock-count.low {
        color: #dc2626;
    }

    .stock-detail-badge .stock-count.medium {
        color: #d97706;
    }

    .stock-detail-badge .stock-count.high {
        color: #059669;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: var(--transition);
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn.edit {
        color: var(--primary-blue);
    }

    .action-btn.edit:hover {
        background: var(--primary-blue-light);
        border-color: var(--primary-blue);
    }

    .action-btn.view {
        color: #059669;
    }

    .action-btn.view:hover {
        background: #f0fdf4;
        border-color: #059669;
    }

    .action-btn.delete {
        color: #dc2626;
    }

    .action-btn.delete:hover {
        background: #fef2f2;
        border-color: #dc2626;
    }

    /* Empty State */
    .empty-state {
        padding: 64px 24px;
        text-align: center;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-blue-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: var(--primary-blue);
        font-size: 2rem;
    }

    .empty-state-title {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .empty-state-description {
        color: #64748b;
        max-width: 400px;
        margin: 0 auto 24px;
    }

    /* Quick Actions */
    .quick-actions-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 24px;
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
    }

    .section-title {
        color: var(--primary-blue);
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .quick-action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 24px;
        text-align: center;
        transition: var(--transition);
        height: 100%;
        cursor: pointer;
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: var(--primary-blue);
    }

    .quick-action-icon {
        width: 64px;
        height: 64px;
        background: var(--primary-blue-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        color: var(--primary-blue);
        font-size: 1.75rem;
    }

    .quick-action-title {
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .quick-action-description {
        color: #64748b;
        font-size: 0.875rem;
    }

    /* Mobile Products Cards */
    .mobile-product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 20px;
        margin-bottom: 16px;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        display: none;
    }

    .mobile-product-card:hover {
        box-shadow: var(--card-shadow-hover);
        border-color: var(--primary-blue);
    }

    .mobile-product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .mobile-product-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .mobile-product-image {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .mobile-product-image-placeholder {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: var(--primary-blue-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .mobile-product-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
        font-size: 1rem;
        line-height: 1.3;
    }

    .mobile-product-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 16px;
        text-align: center;
    }

    .mobile-stat-label {
        color: #64748b;
        font-size: 0.75rem;
        margin-bottom: 4px;
        display: block;
    }

    .mobile-stat-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.95rem;
    }

    /* Mobile Stock Details */
    .mobile-stock-details {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 4px;
    }

    .mobile-stock-item {
        font-size: 0.7rem;
        padding: 2px 6px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .mobile-stock-item .variant-name {
        color: #64748b;
    }

    .mobile-stock-item .stock-count {
        font-weight: 600;
    }

    /* Mobile Variants */
    .mobile-variant-info {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px dashed #e2e8f0;
    }

    .mobile-variant-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .mobile-variant-name {
        display: flex;
        align-items: center;
        gap: 6px;
        flex: 1;
    }

    .mobile-variant-name i {
        color: var(--primary-blue);
        font-size: 0.75rem;
    }

    .mobile-variant-details {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .mobile-variant-price {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.85rem;
        min-width: 70px;
        text-align: right;
    }

    .mobile-variant-stock {
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        min-width: 50px;
        text-align: center;
    }

    .mobile-variant-stock.high {
        background: #d1fae5;
        color: #065f46;
    }

    .mobile-variant-stock.medium {
        background: #fef3c7;
        color: #92400e;
    }

    .mobile-variant-stock.low {
        background: #fee2e2;
        color: #991b1b;
    }

    .mobile-variant-stock.out {
        background: #f1f5f9;
        color: #64748b;
    }

    .mobile-action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: 1px solid #e2e8f0;
        margin-top: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .pagination-info {
        color: #64748b;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .pagination-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination-btn {
        padding: 8px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #475569;
        font-weight: 500;
        transition: var(--transition);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .pagination-btn:hover {
        background: var(--primary-blue-light);
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }

    .pagination-btn.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    .pagination-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Modals */
    .modal-header-custom {
        background: var(--primary-blue);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        padding: 20px 24px;
    }

    .modal-header-custom .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .modal-content-custom {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--card-shadow-hover);
    }

    /* Product Details Modal */
    #productDetailsModal .modal-dialog {
        max-width: 900px;
        margin: 1rem auto;
    }

    .variant-icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 16px;
    }

    .variant-icon-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        text-align: center;
        transition: var(--transition);
    }

    .variant-icon-item:hover {
        background: var(--primary-blue-light);
        border-color: var(--primary-blue);
        transform: translateY(-2px);
    }

    .variant-icon {
        font-size: 1.5rem;
        color: var(--primary-blue);
        margin-bottom: 8px;
    }

    .variant-icon-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 4px;
    }

    .variant-icon-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: #1e293b;
    }

    /* Barcode Visual Styles */
    .barcode-visual {
        max-width: 300px;
        margin: 0 auto;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 15px;
        background: white;
    }

    .barcode-variant-visual {
        max-width: 200px;
        margin: 0 auto;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 10px;
        background: white;
    }

    .barcode-text-fallback {
        text-align: center;
        padding: 10px;
        background: #f8fafc;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    .barcode-bar {
        display: inline-block;
        background: #000;
        margin: 0 1px;
    }

    .barcode-action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        margin-top: 10px;
    }

    /* Edit Product Modal */
    #editProductModal .modal-dialog.modal-lg {
        max-width: 700px !important;
        margin: 1rem auto !important;
    }

    /* Buttons */
    .btn-primary-custom {
        background: var(--primary-blue);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        background: var(--primary-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 123, 229, 0.2);
        color: white;
    }

    .btn-light-custom {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-light-custom:hover {
        background: #f8fafc;
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }

    .btn-success-custom {
        background: #059669;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-success-custom:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        color: white;
    }
    
@section('content')
    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease forwards;
    }

    /* Edit Modal Responsive Fixes */
    #editProductModal .modal-dialog.modal-dialog-centered.modal-dialog-scrollable {
        max-width: 700px !important;
        margin: 1rem auto !important;
        height: auto;
        min-height: 100px;
        max-height: 85vh;
    }

    #editProductModal .modal-content {
        max-height: 85vh !important;
        display: flex;
        flex-direction: column;
        border-radius: var(--border-radius) !important;
        width: 100%;
        margin: 0 auto;
    }

    #editProductModal .modal-header {
        flex-shrink: 0;
        padding: 1.25rem 1.5rem;
        background: var(--primary-blue);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    #editProductModal .modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem !important;
        max-height: calc(85vh - 130px) !important;
        width: 100%;
    }

    #editProductModal .modal-footer {
        flex-shrink: 0;
        padding: 1.25rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0 0 var(--border-radius) var(--border-radius);
    }

    /* Form container styling */
    #editProductModal form {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
    }

    /* Section styling dalam modal */
    #editProductModal .mb-4 {
        margin-bottom: 1.5rem !important;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        width: 100%;
    }

    #editProductModal .mb-4:last-child {
        border-bottom: none;
        margin-bottom: 0 !important;
        padding-bottom: 0;
    }

    /* Form controls in modal */
    #editProductModal .form-control,
    #editProductModal .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
    }

    #editProductModal .form-label {
        font-weight: 500;
        color: #475569;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: block;
    }

    /* Row dalam form */
    #editProductModal .row {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
    }

    #editProductModal .col-md-6,
    #editProductModal .col-md-8,
    #editProductModal .col-md-4,
    #editProductModal .col-md-12 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Image upload container */
    #editProductModal .product-image-upload-container {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        background: #f8fafc;
        transition: var(--transition);
        max-width: 100%;
        overflow: hidden;
    }

    #editProductModal .product-image-upload-container:hover {
        border-color: var(--primary-blue);
        background: var(--primary-blue-light);
    }

    #editProductModal .image-preview-placeholder {
        width: 150px !important;
        height: 150px !important;
        margin: 0 auto;
    }

    /* Table variants styling */
    #editProductModal #variantsTable {
        margin-bottom: 0;
        font-size: 0.85rem;
        width: 100%;
    }

    #editProductModal #variantsTable thead {
        position: sticky;
        top: 0;
        background: var(--primary-blue-light);
        z-index: 10;
    }

    #editProductModal #variantsTable th,
    #editProductModal #variantsTable td {
        padding: 0.5rem !important;
        white-space: nowrap;
    }

    #editProductModal #variantsTable th:nth-child(1) { width: 20%; }
    #editProductModal #variantsTable th:nth-child(2) { width: 15%; }
    #editProductModal #variantsTable th:nth-child(3) { width: 15%; }
    #editProductModal #variantsTable th:nth-child(4) { width: 15%; }
    #editProductModal #variantsTable th:nth-child(5) { width: 15%; }
    #editProductModal #variantsTable th:nth-child(6) { width: 10%; }

    #editProductModal #variantsTable input {
        font-size: 0.8rem;
        padding: 0.375rem 0.5rem !important;
        width: 100% !important;
        min-width: 0;
    }

    /* Description textarea */
    #editProductModal textarea#editDescription {
        min-height: 80px;
        resize: vertical;
    }

    /* Responsive Styles */
    @media (max-width: 1400px) {
        .products-table th,
        .products-table td {
            padding: 16px 20px;
        }
        
        #editProductModal .modal-dialog.modal-lg {
            max-width: 650px !important;
        }
    }

    @media (max-width: 1200px) {
        .page-title-main {
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 1.75rem;
        }
        
        .products-table {
            font-size: 0.9rem;
        }
        
        .variant-price {
            min-width: 70px;
        }
        
        .variant-stock {
            min-width: 50px;
        }
        
        #editProductModal .modal-dialog.modal-lg {
            max-width: 600px !important;
        }
    }

    @media (max-width: 992px) {
        .d-none.d-lg-block {
            display: none !important;
        }
        
        .mobile-product-card {
            display: block;
        }
        
        .page-header-container {
            padding: 20px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .filter-section {
            padding: 16px;
        }
        
        .category-filters-wrapper {
            overflow-x: auto;
        }
        
        .category-filter-btn span:not(.d-sm-inline) {
            display: none;
        }
        
        #editProductModal .modal-dialog.modal-lg {
            max-width: 90% !important;
            margin: 0.5rem auto !important;
        }
        
        #editProductModal .modal-content {
            max-height: 90vh !important;
        }
        
        #editProductModal .modal-body {
            padding: 1.25rem !important;
            max-height: calc(90vh - 120px) !important;
        }
        
        .pagination-container {
            flex-direction: column;
            text-align: center;
            gap: 12px;
        }
    }

    @media (max-width: 768px) {
        .page-header-container {
            padding: 16px;
            margin-bottom: 16px;
        }
        
        .page-title-main {
            font-size: 1.375rem;
        }
        
        .page-subtitle-main {
            font-size: 0.9rem;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-icon-container {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
            margin-bottom: 12px;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .filter-controls {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        
        .search-sort-container {
            order: -1;
            min-width: 100%;
            max-width: 100%;
        }
        
        .category-filters-container {
            width: 100%;
        }
        
        .category-filter-btn {
            flex: 1;
            justify-content: center;
            padding: 8px 12px;
        }
        
        .mobile-product-card {
            padding: 16px;
            margin-bottom: 12px;
        }
        
        .mobile-product-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        
        .quick-action-card {
            padding: 16px;
        }
        
        .quick-action-icon {
            width: 56px;
            height: 56px;
            font-size: 1.5rem;
        }
        
        .pagination-container {
            flex-direction: column;
            text-align: center;
            padding: 16px;
            gap: 12px;
        }
        
        .pagination-info {
            order: -1;
            width: 100%;
            text-align: center;
        }
        
        .page-numbers {
            display: none !important;
        }
        
        #editProductModal .modal-dialog.modal-lg {
            max-width: 95% !important;
            margin: 0.5rem auto !important;
        }
        
        #editProductModal .modal-content {
            max-height: 95vh !important;
        }
        
        #editProductModal .modal-body {
            max-height: calc(95vh - 110px) !important;
            padding: 1rem !important;
        }
        
        #editProductModal .modal-header,
        #editProductModal .modal-footer {
            padding: 1rem !important;
        }
        
        #editProductModal .image-preview-placeholder {
            width: 120px !important;
            height: 120px !important;
        }
        
        #editProductModal #variantsTable {
            font-size: 0.8rem;
            display: block;
            overflow-x: auto;
        }
        
        #editProductModal #variantsTable th,
        #editProductModal #variantsTable td {
            padding: 0.375rem !important;
        }
        
        #editProductModal #variantsTable th:nth-child(4),
        #editProductModal #variantsTable td:nth-child(4),
        #editProductModal #variantsTable th:nth-child(5),
        #editProductModal #variantsTable td:nth-child(5) {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .page-title-main {
            font-size: 1.25rem;
        }
        
        .stat-value {
            font-size: 1.375rem;
        }
        
        .filter-section {
            padding: 12px;
        }
        
        .outlet-select,
        .category-filter-btn,
        .search-input,
        .sort-btn {
            height: 36px;
            font-size: 0.85rem;
            padding: 6px 12px;
        }
        
        .search-input {
            padding-left: 36px;
        }
        
        .mobile-product-card {
            padding: 12px;
            margin-bottom: 8px;
        }
        
        .mobile-product-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        
        .mobile-stat-value {
            font-size: 0.85rem;
        }
        
        .quick-actions-section {
            padding: 16px;
        }
        
        .quick-action-card {
            padding: 12px;
        }
        
        .quick-action-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
            margin-bottom: 12px;
        }
        
        .quick-action-title {
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        
        .quick-action-description {
            font-size: 0.8rem;
        }
        
        .btn-primary-custom,
        .btn-light-custom {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }
        
        .pagination-btn {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        #editProductModal .modal-dialog.modal-lg {
            max-width: 100% !important;
            margin: 0 !important;
            height: 100vh;
        }
        
        #editProductModal .modal-content {
            max-height: 100vh !important;
            border-radius: 0 !important;
            margin: 0;
        }
        
        #editProductModal .modal-body {
            max-height: calc(100vh - 110px) !important;
            padding: 1rem !important;
        }
        
        #editProductModal .mb-4 {
            margin-bottom: 1rem !important;
            padding-bottom: 1rem;
        }
        
        #editProductModal h6 {
            font-size: 0.95rem;
            margin-bottom: 0.75rem !important;
        }
        
        #editProductModal .row .col-md-6,
        #editProductModal .row .col-md-8,
        #editProductModal .row .col-md-4,
        #editProductModal .row .col-md-12 {
            width: 100%;
            margin-bottom: 1rem;
        }
        
        #editProductModal .row .col-md-6:last-child,
        #editProductModal .row .col-md-8:last-child,
        #editProductModal .row .col-md-4:last-child,
        #editProductModal .row .col-md-12:last-child {
            margin-bottom: 0;
        }
        
        #editProductModal .image-preview-placeholder {
            width: 100px !important;
            height: 100px !important;
        }
        
        #editProductModal .product-image-upload-container {
            padding: 0.75rem;
        }
        
        #editProductModal #variantsTable th:nth-child(3),
        #editProductModal #variantsTable td:nth-child(3) {
            display: none;
        }
        
        #editProductModal #variantsTable th:nth-child(1) { width: 40%; }
        #editProductModal #variantsTable th:nth-child(2) { width: 30%; }
        #editProductModal #variantsTable th:nth-child(6) { width: 10%; }
    }

    @media (max-width: 400px) {
        .mobile-product-stats {
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }
        
        .mobile-stat-label {
            font-size: 0.7rem;
        }
        
        .mobile-stat-value {
            font-size: 0.8rem;
        }
        
        .pagination-btn {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
        
        .pagination-buttons {
            justify-content: center;
            width: 100%;
        }
        
        .quick-action-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        #editProductModal .modal-header h5 {
            font-size: 1rem;
        }
        
        #editProductModal .btn-primary-custom,
        #editProductModal .btn-light-custom {
            padding: 6px 12px;
            font-size: 0.85rem;
        }
        
        #editProductModal #variantsTable {
            font-size: 0.75rem;
        }
        
        #editProductModal #variantsTable input {
            font-size: 0.75rem;
            padding: 0.25rem 0.375rem !important;
        }
    }

    /* Modal Responsive Fixes */
    @media (max-width: 768px) {
        .modal-body {
            padding: 1rem !important;
        }
    }

    /* Utility Classes */
    .flex-wrap {
        flex-wrap: wrap;
    }

    .gap-2 {
        gap: 8px;
    }

    .gap-3 {
        gap: 12px;
    }
    
    /* Scrollbar styling for modal */
    #editProductModal .modal-body::-webkit-scrollbar {
        width: 6px;
    }
    
    #editProductModal .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    #editProductModal .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    #editProductModal .modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
{% endblock %}

{% block content %}
<div class="container-fluid px-0 px-sm-2 px-md-3">
    <!-- Header Section -->
    <div class="page-header-container animate-fade-in">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h1 class="page-title-main">Item Library</h1>
                <p class="page-subtitle-main">Manage all your products and inventory items</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-success-custom d-flex align-items-center gap-2" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i>
                    <span>Export to Excel</span>
                </button>
                <a href="{{ url_for('admin_create_item') }}" class="btn-primary-custom d-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Create Item</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card animate-fade-in" style="animation-delay: 0.1s">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-icon-container">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <!-- Hitung total stock REAL dari semua variant -->
                        {% set total_variant_stock = namespace(total=0) %}
                        {% for product in products.items %}
                            {% if product.variants and product.variants|length > 0 %}
                                {% for variant in product.variants %}
                                    {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                    {% set total_variant_stock.total = total_variant_stock.total + variant_stock %}
                                {% endfor %}
                            {% else %}
                                {% set product_stock = product.stock|int if product.stock is not none else 0 %}
                                {% set total_variant_stock.total = total_variant_stock.total + product_stock %}
                            {% endif %}
                        {% endfor %}
                        <div class="stat-value" id="totalStock">{{ total_variant_stock.total }}</div>
                        <div class="stat-label">Total Stock</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card animate-fade-in" style="animation-delay: 0.2s">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-icon-container">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <!-- Hitung low stock berdasarkan TIAP VARIANT -->
                        {% set low_stock_variant_count = namespace(count=0) %}
                        {% set low_stock_items = namespace(count=0) %}
                        {% for product in products.items %}
                            {% set has_low_stock_variant = False %}
                            {% if product.variants and product.variants|length > 0 %}
                                {% for variant in product.variants %}
                                    {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                    {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                    {% if variant_stock > 0 and variant_stock <= low_stock_threshold %}
                                        {% set low_stock_variant_count.count = low_stock_variant_count.count + 1 %}
                                        {% set has_low_stock_variant = True %}
                                    {% endif %}
                                {% endfor %}
                            {% else %}
                                {% set product_stock = product.stock|int if product.stock is not none else 0 %}
                                {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                {% if product_stock > 0 and product_stock <= low_stock_threshold %}
                                    {% set low_stock_variant_count.count = low_stock_variant_count.count + 1 %}
                                    {% set has_low_stock_variant = True %}
                                {% endif %}
                            {% endif %}
                            {% if has_low_stock_variant %}
                                {% set low_stock_items.count = low_stock_items.count + 1 %}
                            {% endif %}
                        {% endfor %}
                        <div class="stat-value text-warning" id="lowStockCount">{{ low_stock_variant_count.count }}</div>
                        <div class="stat-label">Low Stock Variants</div>
                        <div class="small text-muted mt-1">Across {{ low_stock_items.count }} items</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card animate-fade-in" style="animation-delay: 0.3s">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="stat-icon-container">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <!-- Hitung in stock variants REAL -->
                        {% set in_stock_variant_count = namespace(count=0) %}
                        {% for product in products.items %}
                            {% if product.variants and product.variants|length > 0 %}
                                {% for variant in product.variants %}
                                    {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                    {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                    {% if variant_stock > low_stock_threshold %}
                                        {% set in_stock_variant_count.count = in_stock_variant_count.count + 1 %}
                                    {% endif %}
                                {% endfor %}
                            {% else %}
                                {% set product_stock = product.stock|int if product.stock is not none else 0 %}
                                {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                {% if product_stock > low_stock_threshold %}
                                    {% set in_stock_variant_count.count = in_stock_variant_count.count + 1 %}
                                {% endif %}
                            {% endif %}
                        {% endfor %}
                        <div class="stat-value text-success" id="inStockCount">{{ in_stock_variant_count.count }}</div>
                        <div class="stat-label">In Stock Variants</div>
                        <div class="small text-muted mt-1">(stock > alert threshold)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section animate-fade-in" style="animation-delay: 0.4s">
        <div class="filter-controls">
            <!-- Status Filter -->
            <div class="filter-group">
                <i class="fas fa-filter text-primary"></i>
                <select class="outlet-select" id="statusFilter">
                    <option value="all" selected>All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <!-- Category Filters -->
            <div class="category-filters-container">
                <span class="filter-label">Category:</span>
                <div class="category-filters-wrapper" id="categoryFilters">
                    <button class="category-filter-btn active" data-category="all">
                        <i class="fas fa-layer-group"></i>
                        <span class="d-none d-sm-inline">All Items</span>
                        <span class="d-inline d-sm-none">All</span>
                    </button>
                    {% for category in categories %}
                    <button class="category-filter-btn" data-category="{{ category.id }}">
                        <i class="fas fa-tag"></i>
                        <span class="category-name">{{ category.name }}</span>
                    </button>
                    {% endfor %}
                </div>
            </div>

            <!-- Search and Sort -->
            <div class="search-sort-container">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table (Desktop) -->
    <div class="d-none d-lg-block animate-fade-in" style="animation-delay: 0.5s">
        <div class="table-container">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="table-title">All Products</h3>
                    <span class="text-muted" id="itemsCount">
                        {% if products.total > 0 %}
                        Showing {{ ((products.page - 1) * products.per_page) + 1 }} to 
                        {{ [products.page * products.per_page, products.total]|min }} 
                        of {{ products.total }} items
                        {% else %}
                        No items found
                        {% endif %}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th style="width: 30%">Product</th>
                            <th style="width: 15%">Category</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 20%">Price Range</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    {% for product in products.items %}
                    <tr>
                        <!-- PRODUCT INFO & VARIANTS -->
                        <td>
                            <div class="product-info">
                                {% if product.image %}
                                <img src="{{ url_for('static', filename='uploads/' + product.image) }}" 
                                     alt="{{ product.name }}" 
                                     class="product-image">
                                {% else %}
                                <div class="product-image-placeholder">
                                    <i class="fas fa-box"></i>
                                </div>
                                {% endif %}
                                <div style="flex: 1;">
                                    <div class="product-name">{{ product.name }}</div>
                                    {% if product.brand %}
                                    <div class="product-description">Brand: {{ product.brand }}</div>
                                    {% endif %}
                                    <div class="product-description">{{ product.description|truncate(100) if product.description else '' }}</div>
                                    
                                    <!-- Variant Display Section -->
                                    {% if product.variants and product.variants|length > 0 %}
                                    <div class="variant-info">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="variant-count-badge">
                                                <i class="fas fa-layer-group"></i>
                                                {{ product.variants|length }} variant{% if product.variants|length != 1 %}s{% endif %}
                                            </span>
                                            {% if product.variants|length > 3 %}
                                            <a class="all-variants-link" onclick="viewProductDetails({{ product.id }})">
                                                View all <i class="fas fa-chevron-right"></i>
                                            </a>
                                            {% endif %}
                                        </div>
                                        
                                        {% for variant in product.variants[:3] %}
                                        <div class="variant-item">
                                            <div class="variant-name">
                                                <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                                                <span>{{ variant.name }}</span>
                                                <!-- Low Stock Indicator per Variant -->
                                                {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                                {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                                {% if variant_stock > 0 and variant_stock <= low_stock_threshold %}
                                                <span class="low-stock-indicator" title="Low Stock Alert (≤ {{ low_stock_threshold }})">
                                                    <i class="fas fa-exclamation-triangle"></i> Low
                                                </span>
                                                {% elif variant_stock == 0 %}
                                                <span class="out-stock-indicator">
                                                    <i class="fas fa-times-circle"></i> Out
                                                </span>
                                                {% endif %}
                                            </div>
                                            <div class="variant-details">
                                                <span class="variant-price">$ {{ "{:,.2f}".format(variant.price|default(0)) }}</span>
                                                <span class="variant-stock 
                                                    {% if variant_stock == 0 %}out
                                                    {% elif variant_stock < 5 %}low
                                                    {% elif variant_stock < 10 %}medium
                                                    {% else %}high{% endif %}">
                                                    {{ variant_stock }} pcs
                                                </span>
                                            </div>
                                        </div>
                                        {% endfor %}
                                        
                                        <!-- Summary Information -->
                                        <div class="mt-2 pt-2 border-top border-dashed">
                                            {% set total_variants = product.variants|length %}
                                            {% set low_stock_variants = [] %}
                                            {% set out_of_stock_variants = [] %}
                                            {% set healthy_stock_variants = [] %}
                                            
                                            {% for variant in product.variants %}
                                                {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                                {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                                
                                                {% if variant_stock == 0 %}
                                                    {% set out_of_stock_variants = out_of_stock_variants + [variant] %}
                                                {% elif variant_stock > 0 and variant_stock <= low_stock_threshold %}
                                                    {% set low_stock_variants = low_stock_variants + [variant] %}
                                                {% elif variant_stock > low_stock_threshold %}
                                                    {% set healthy_stock_variants = healthy_stock_variants + [variant] %}
                                                {% endif %}
                                            {% endfor %}
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="small text-muted">
                                                    <i class="fas fa-chart-pie me-1"></i> Variant Status:
                                                </div>
                                                <div class="d-flex gap-2">
                                                    {% if healthy_stock_variants|length > 0 %}
                                                    <span class="small text-success">
                                                        <i class="fas fa-check-circle"></i> {{ healthy_stock_variants|length }} OK
                                                    </span>
                                                    {% endif %}
                                                    {% if low_stock_variants|length > 0 %}
                                                    <span class="small text-warning">
                                                        <i class="fas fa-exclamation-triangle"></i> {{ low_stock_variants|length }} Low
                                                    </span>
                                                    {% endif %}
                                                    {% if out_of_stock_variants|length > 0 %}
                                                    <span class="small text-danger">
                                                        <i class="fas fa-times-circle"></i> {{ out_of_stock_variants|length }} Out
                                                    </span>
                                                    {% endif %}
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="small text-muted">
                                                    <i class="fas fa-calculator me-1"></i> Total Stock:
                                                </div>
                                                <div class="fw-bold">
                                                    {% set total_product_stock = namespace(value=0) %}
                                                    {% set total_product_stock.value = product.stock|int if product.stock is not none else 0 %}
                                                    {% for variant in product.variants %}
                                                        {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                                        {% set total_product_stock.value = total_product_stock.value + variant_stock %}
                                                    {% endfor %}
                                                    {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                                    <span class="{{ 'text-danger' if total_product_stock.value == 0 else 'text-warning' if total_product_stock.value > 0 and total_product_stock.value <= low_stock_threshold else 'text-success' }}">
                                                        {{ total_product_stock.value }} units
                                                    </span>
                                                    {% if total_product_stock.value > 0 and total_product_stock.value <= low_stock_threshold %}
                                                    <span class="low-stock-indicator ms-2" title="Low Stock Alert (≤ {{ low_stock_threshold }})">
                                                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                                                    </span>
                                                    {% endif %}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {% else %}
                                    <div class="variant-info">
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle me-1"></i> No variants available
                                        </div>
                                        <!-- Tampilkan stock untuk produk tanpa variant -->
                                        <div class="mt-2 pt-2 border-top border-dashed">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="small text-muted">
                                                    <i class="fas fa-calculator me-1"></i> Stock:
                                                </div>
                                                <div class="fw-bold">
                                                    {% set product_stock = product.stock|int if product.stock is not none else 0 %}
                                                    {% set low_stock_threshold = product.low_stock_alert or 10 %}
                                                    <span class="{{ 'text-danger' if product_stock == 0 else 'text-warning' if product_stock > 0 and product_stock <= low_stock_threshold else 'text-success' }}">
                                                        {{ product_stock }} units
                                                    </span>
                                                    {% if product_stock > 0 and product_stock <= low_stock_threshold %}
                                                    <span class="low-stock-indicator ms-2" title="Low Stock Alert (≤ {{ low_stock_threshold }})">
                                                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                                                    </span>
                                                    {% endif %}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {% endif %}
                                </div>
                            </div>
                        </td>

                        <!-- CATEGORY -->
                        <td>
                            {% if product.category %}
                            <span class="category-badge">
                                <i class="fas fa-tag"></i>
                                {{ product.category.name }}
                            </span>
                            {% else %}
                            <span class="text-muted">Uncategorized</span>
                            {% endif %}
                        </td>

                        <!-- STATUS -->
                        <td>
                            {% if product.status == 'active' %}
                            <span class="status-badge status-active">Active</span>
                            {% elif product.status == 'inactive' %}
                            <span class="status-badge status-inactive">Inactive</span>
                            {% elif product.status == 'draft' %}
                            <span class="status-badge status-draft">Draft</span>
                            {% endif %}
                        </td>

                        <!-- PRICE RANGE -->
                        <td>
                            {% if product.variants and product.variants|length > 0 %}
                                {% set prices = product.variants|map(attribute='price')|list %}
                                {% set min_price = (prices|reject('none')|list|min)|default(0) %}
                                {% set max_price = (prices|reject('none')|list|max)|default(0) %}
                                {% if min_price == max_price %}
                                <div class="price-value">$ {{ "{:,.2f}".format(min_price) }}</div>
                                {% else %}
                                <div class="price-value">$ {{ "{:,.2f}".format(min_price) }} - $ {{ "{:,.2f}".format(max_price) }}</div>
                                {% endif %}
                                <div class="text-muted small mt-1">
                                    <i class="fas fa-layer-group me-1"></i>
                                    {{ product.variants|length }} variant{% if product.variants|length != 1 %}s{% endif %}
                                </div>
                            {% else %}
                            <div class="price-value">$ {{ "{:,.2f}".format(product.price|default(0)) }}</div>
                            <div class="text-muted small mt-1">
                                <i class="fas fa-box me-1"></i>
                                Single product
                            </div>
                            {% endif %}
                        </td>

                        <!-- ACTIONS -->
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn view" onclick="viewProductDetails({{ product.id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit" onclick="openEditModal({{ product.id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" onclick="deleteProduct({{ product.id }}, '{{ product.name|replace("'", "\\'")|escape }}')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    {% else %}
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <h4 class="empty-state-title">No Products Found</h4>
                                <p class="empty-state-description">Create your first product to get started</p>
                                <a href="{{ url_for('admin_create_item') }}" class="btn-primary-custom">
                                    <i class="fas fa-plus me-2"></i> Create Product
                                </a>
                            </div>
                        </td>
                    </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Products Cards -->
    <div class="d-lg-none animate-fade-in" style="animation-delay: 0.5s">
        <div class="table-container">
            <div class="table-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h3 class="table-title">All Products</h3>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-success" onclick="exportToExcel()" title="Export to Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <span class="text-muted" id="mobileItemsCount">
                            {% if products.total > 0 %}
                            Showing {{ ((products.page - 1) * products.per_page) + 1 }} to 
                            {{ [products.page * products.per_page, products.total]|min }} 
                            of {{ products.total }} items
                            {% else %}
                            No items found
                            {% endif %}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-3">
            {% for product in products.items %}
            <div class="mobile-product-card">
                <div class="mobile-product-header">
                    <div class="mobile-product-info">
                        {% if product.image %}
                        <img src="{{ url_for('static', filename='uploads/' + product.image) }}" 
                             alt="{{ product.name }}" 
                             class="mobile-product-image">
                        {% else %}
                        <div class="mobile-product-image-placeholder">
                            <i class="fas fa-box"></i>
                        </div>
                        {% endif %}
                        <div>
                            <div class="mobile-product-name">{{ product.name }}</div>
                            {% if product.category %}
                            <span class="category-badge">
                                {{ product.category.name }}
                            </span>
                            {% endif %}
                        </div>
                    </div>
                    <div class="mobile-action-buttons">
                        <button class="action-btn view" onclick="viewProductDetails({{ product.id }})" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn edit" onclick="openEditModal({{ product.id }})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <div class="mobile-product-stats">
                    <div>
                        <div class="mobile-stat-label">Status</div>
                        <div class="mobile-stat-value">
                            {% if product.status == 'active' %}
                            <span class="status-badge status-active" style="font-size: 0.7rem;">Active</span>
                            {% elif product.status == 'inactive' %}
                            <span class="status-badge status-inactive" style="font-size: 0.7rem;">Inactive</span>
                            {% elif product.status == 'draft' %}
                            <span class="status-badge status-draft" style="font-size: 0.7rem;">Draft</span>
                            {% endif %}
                        </div>
                    </div>

                    <div>
                        <div class="mobile-stat-label">Price</div>
                        <div class="mobile-stat-value">
                            {% if product.variants and product.variants|length > 0 %}
                                {% set prices = product.variants|map(attribute='price')|list %}
                                {% set min_price = (prices|reject('none')|list|min)|default(0) %}
                                $ {{ "{:,.2f}".format(min_price) }}
                            {% else %}
                            $ {{ "{:,.2f}".format(product.price|default(0)) }}
                            {% endif %}
                        </div>
                    </div>

                    <div>
                        <div class="mobile-stat-label">Stock</div>
                        <div class="mobile-stat-value">
                            {% set total_variant_stock = 0 %}
                            {% set low_stock_variant_count = 0 %}
                            {% set low_stock_threshold = product.low_stock_alert or 10 %}
                            
                            {% set total_variant_stock = product.stock|int if product.stock is not none else 0 %}
                            {% if product.variants and product.variants|length > 0 %}
                                {% for variant in product.variants %}
                                    {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                                    {% set total_variant_stock = total_variant_stock + variant_stock %}
                                    {% if variant_stock > 0 and variant_stock <= low_stock_threshold %}
                                        {% set low_stock_variant_count = low_stock_variant_count + 1 %}
                                    {% endif %}
                                {% endfor %}
                            {% endif %}
                            
                            {% set is_low_stock = total_variant_stock > 0 and total_variant_stock <= low_stock_threshold %}
                            
                            <div class="d-flex flex-column align-items-center">
                                {% if total_variant_stock == 0 %}
                                    <span class="text-danger fw-bold">{{ total_variant_stock }}</span>
                                    <span class="small text-danger">Out of Stock</span>
                                {% elif is_low_stock %}
                                    <span class="text-warning fw-bold">{{ total_variant_stock }}</span>
                                    <span class="small text-warning">Low Stock</span>
                                {% else %}
                                    <span class="text-success fw-bold">{{ total_variant_stock }}</span>
                                    <span class="small text-success">In Stock</span>
                                {% endif %}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Stock per Variant di Mobile -->
                {% if product.variants and product.variants|length > 0 %}
                <div class="mt-2">
                    <div class="small text-muted mb-1">
                        <i class="fas fa-boxes me-1"></i> Stock per variant ({{ product.variants|length }}):
                    </div>
                    <div class="mobile-stock-details">
                        {% for variant in product.variants[:3] %}
                        <div class="mobile-stock-item">
                            {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                            {% set low_stock_threshold = product.low_stock_alert or 10 %}
                            <span class="variant-name">{{ variant.name }}:</span>
                            <span class="stock-count 
                                {% if variant_stock == 0 %}text-danger
                                {% elif variant_stock > 0 and variant_stock <= low_stock_threshold %}text-warning
                                {% else %}text-success{% endif %}">
                                {{ variant_stock }}
                            </span>
                        </div>
                        {% endfor %}
                        {% if product.variants|length > 3 %}
                        <div class="mobile-stock-item">
                            <span class="variant-name">+{{ product.variants|length - 3 }} more</span>
                        </div>
                        {% endif %}
                    </div>
                </div>
                {% endif %}

                <!-- Mobile Variants Section -->
                {% if product.variants and product.variants|length > 0 %}
                <div class="mobile-variant-info">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="text-muted small">
                            <i class="fas fa-layer-group me-1"></i> Variants ({{ product.variants|length }})
                        </div>
                        {% if product.variants|length > 2 %}
                        <a class="text-primary small" onclick="viewProductDetails({{ product.id }})">
                            View all <i class="fas fa-chevron-right"></i>
                        </a>
                        {% endif %}
                    </div>
                    
                    {% for variant in product.variants[:2] %}
                    <div class="mobile-variant-item">
                        <div class="mobile-variant-name">
                            <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                            <span>{{ variant.name }}</span>
                            <!-- Low Stock Indicator for Mobile -->
                            {% set variant_stock = variant.stock|int if variant.stock is not none else 0 %}
                            {% set low_stock_threshold = product.low_stock_alert or 10 %}
                            {% if variant_stock > 0 and variant_stock <= low_stock_threshold %}
                            <span class="badge bg-warning bg-opacity-10 text-warning ms-1" style="font-size: 0.5rem; padding: 1px 3px;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </span>
                            {% elif variant_stock == 0 %}
                            <span class="badge bg-danger bg-opacity-10 text-danger ms-1" style="font-size: 0.5rem; padding: 1px 3px;">
                                <i class="fas fa-times"></i>
                            </span>
                            {% endif %}
                        </div>
                        <div class="mobile-variant-details">
                            <span class="mobile-variant-price">$ {{ "{:,.2f}".format(variant.price|default(0)) }}</span>
                            <span class="mobile-variant-stock 
                                {% if variant_stock == 0 %}out
                                {% elif variant_stock < 5 %}low
                                {% elif variant_stock < 10 %}medium
                                {% else %}high{% endif %}">
                                {{ variant_stock }}
                            </span>
                        </div>
                    </div>
                    {% endfor %}
                    
                    {% if product.variants|length > 2 %}
                    <div class="mobile-variant-item">
                        <div class="mobile-variant-name">
                            <i class="fas fa-ellipsis-h"></i>
                            <span>+{{ product.variants|length - 2 }} more</span>
                        </div>
                        <div class="mobile-variant-details">
                            <a class="text-primary small" onclick="viewProductDetails({{ product.id }})">
                                See all
                            </a>
                        </div>
                    </div>
                    {% endif %}
                </div>
                {% endif %}

                <div class="date-display mt-2">
                    <i class="fas fa-calendar"></i>
                    {{ product.created_at.strftime('%d %b %Y') if product.created_at else 'N/A' }}
                </div>
            </div>
            {% else %}
            <div class="text-center py-5">
                <div class="empty-state-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4 class="empty-state-title">No Products Found</h4>
                <p class="empty-state-description">Create your first product to get started</p>
                <a href="{{ url_for('admin_create_item') }}" class="btn-primary-custom">
                    <i class="fas fa-plus me-2"></i> Create Product
                </a>
            </div>
            {% endfor %}
            </div>
        </div>
    </div>

    <!-- Pagination -->
    {% if products.pages > 1 %}
    <div class="pagination-container animate-fade-in" style="animation-delay: 0.6s">
        <div class="pagination-info">
            Page {{ products.page }} of {{ products.pages }}
        </div>
        <div class="pagination-buttons">
            {% if products.has_prev %}
<a href="{{ url_for('admin_items', page=products.prev_num) }}{% if request.args %}{% for key, value in request.args.items() %}{% if key != 'page' %}&{{ key }}={{ value }}{% endif %}{% endfor %}{% endif %}" 
   class="pagination-btn">
    <i class="fas fa-chevron-left"></i> Previous
</a>
{% else %}
            <span class="pagination-btn disabled">
                <i class="fas fa-chevron-left"></i> Previous
            </span>
            {% endif %}

            <div class="page-numbers d-none d-md-flex">
                {% for page_num in products.iter_pages(left_edge=2, right_edge=2, left_current=2, right_current=2) %}
                    {% if page_num %}
                        {% if page_num == products.page %}
                        <span class="pagination-btn active">{{ page_num }}</span>
                        {% else %}
                        <a href="{{ url_for('admin_items', page=page_num) }}{% if request.args %}{% for key, value in request.args.items() %}{% if key != 'page' %}&{{ key }}={{ value }}{% endif %}{% endfor %}{% endif %}" 
                           class="pagination-btn">{{ page_num }}</a>
                        {% endif %}
                    {% else %}
                        <span class="pagination-btn disabled">...</span>
                    {% endif %}
                {% endfor %}
            </div>

           {% if products.has_next %}
<a href="{{ url_for('admin_items', page=products.next_num) }}{% if request.args %}{% for key, value in request.args.items() %}{% if key != 'page' %}&{{ key }}={{ value }}{% endif %}{% endfor %}{% endif %}" 
   class="pagination-btn">
    Next <i class="fas fa-chevron-right"></i>
</a>
{% else %}
            <span class="pagination-btn disabled">
                Next <i class="fas fa-chevron-right"></i>
            </span>
            {% endif %}
        </div>
    </div>
    {% endif %}
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="productDetailsContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading product details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-light-custom" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn-primary-custom" id="editFromDetailsBtn">
                    <i class="fas fa-edit me-2"></i> Edit Product
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <input type="hidden" id="editProductId" name="product_id">
                    
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="{{ csrf_token() if csrf_token else '' }}">
                    
                    <!-- Product Information -->
                    <div class="mb-4">
                        <h6 class="mb-3 fw-600 text-dark">Product Information</h6>
                        
                        <!-- Product Image -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="product-image-upload-container text-center mb-3">
                                    <div id="currentImagePreview" class="mb-3" style="display: none;">
                                        <img src="" alt="Current Image" class="img-thumbnail" style="max-height: 150px; max-width: 150px;">
                                        <div class="mt-2 small text-muted">Current Image</div>
                                    </div>
                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div class="image-preview-placeholder" style="width: 150px; height: 150px; border: 2px dashed #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="document.getElementById('editProductImage').click()">
                                            <div class="text-center">
                                                <i class="fas fa-camera fa-2x text-muted mb-2"></i>
                                                <div class="text-muted small">Click to upload</div>
                                            </div>
                                        </div>
                                        <input type="file" class="form-control d-none" id="editProductImage" name="product_image" accept="image/*" onchange="previewImage(this)">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('editProductImage').click()">
                                                <i class="fas fa-upload me-1"></i> Change
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeProductImage()">
                                                <i class="fas fa-trash me-1"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-500">Product Name *</label>
                                <input type="text" class="form-control" id="editProductName" name="product_name" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-500">Status *</label>
                                <select class="form-select" id="editStatus" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-500">Brand</label>
                                <input type="text" class="form-control" id="editBrand" name="brand" placeholder="Optional">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-500">Category</label>
                                <select class="form-select" id="editCategory" name="category_id">
                                    <option value="">Select Category</option>
                                    {% for category in categories %}
                                    <option value="{{ category.id }}">{{ category.name }}</option>
                                    {% endfor %}
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-500">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3" placeholder="Product description..."></textarea>
                        </div>
                    </div>
                    
                    <!-- Product Variants -->
                    <div class="mb-4">
                        <h6 class="mb-3 fw-600 text-dark">Product Variants</h6>
                        
                        <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                            <table class="table table-sm" id="variantsTable">
                                <thead style="position: sticky; top: 0; background: var(--primary-blue-light); z-index: 1;">
                                    <tr>
                                        <th>Variant Name</th>
                                        <th>Price ($)</th>
                                        <th>Stock</th>
                                        <th>SKU</th>
                                        <th>Barcode</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="variantsBody">
                                    <!-- Variants will be added here dynamically -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-end mt-3">
                            <button type="button" class="btn-light-custom btn-sm" onclick="addVariantRow()">
                                <i class="fas fa-plus me-1"></i> Add Variant
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-light-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom" id="submitEditForm">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import/Export Modal -->
<div class="modal fade" id="importExportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Import / Export Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <h6 class="mb-3 fw-600 text-dark">Import Items</h6>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="importFile" accept=".csv,.xlsx,.xls">
                        <small class="text-muted mt-1 d-block">Upload CSV or Excel file with product data</small>
                    </div>
                    <button class="btn-light-custom" onclick="showComingSoon()">
                        <i class="fas fa-download me-1"></i> Download Template
                    </button>
                </div>
                
                <div>
                    <h6 class="mb-3 fw-600 text-dark">Export Items</h6>
                    <div class="d-grid gap-2">
                        <button class="btn-light-custom" onclick="showComingSoon('Export as CSV')">
                            <i class="fas fa-file-csv me-2"></i> Export as CSV
                        </button>
                        <button class="btn-light-custom" onclick="showComingSoon('Export as Excel')">
                            <i class="fas fa-file-excel me-2"></i> Export as Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manage Categories Modal -->
<div class="modal fade" id="manageCategoriesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-custom">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title">Manage Categories</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-600 text-dark">Add New Category</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="newCategoryName" placeholder="Category name">
                        <button class="btn-primary-custom" type="button" onclick="addCategory()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 class="mb-3 fw-600 text-dark">Existing Categories</h6>
                    <div id="categoriesList">
                        {% for category in categories %}
                        <div class="d-flex justify-content-between align-items-center mb-2 p-3 border rounded" id="category-{{ category.id }}">
                            <span class="fw-500">{{ category.name }}</span>
                            <div>
                                <button class="action-btn edit me-1" onclick="editCategory({{ category.id }}, '{{ category.name|escape }}')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete" onclick="deleteCategory({{ category.id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
<script>
    // ========== TAMBAHKAN FUNGSI INI DI AWAL ==========
    function getCSRFToken() {
        const tokenInput = document.querySelector('input[name="csrf_token"]');
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        return tokenInput ? tokenInput.value : (metaToken ? metaToken.content : '');
    }

    async function showConfirmDialog(title, message, icon = 'warning') {
        if (typeof Swal !== 'undefined') {
            const result = await Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            });
            return result.isConfirmed;
        } else {
            return confirm(message);
        }
    }

    function showNotification(message, type = 'info') {
        if (typeof Swal !== 'undefined') {
            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            toast.fire({
                icon: type === 'success' ? 'success' : type === 'error' ? 'error' : 'info',
                title: message
            });
        } else {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = `
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                max-width: 400px;
            `;
            
            notification.innerHTML = `
                <strong>${type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : 'Info!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
    }
    // ========== AKHIR FUNGSI TAMBAHAN ==========

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Item Library loaded');
        
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('.products-table tbody tr');
        const mobileCards = document.querySelectorAll('.mobile-product-card');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCount = 0;
                
                // Filter desktop table rows
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Filter mobile cards
                mobileCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Update count displays
                updateVisibleCounts(visibleCount);
            });
        }
        
        // Status filter
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const status = this.value.toLowerCase();
                let visibleCount = 0;
                
                tableRows.forEach(row => {
                    if (status === 'all') {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        const rowStatus = row.querySelector('.status-badge')?.textContent.toLowerCase();
                        if (rowStatus && rowStatus.includes(status)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                mobileCards.forEach(card => {
                    if (status === 'all') {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        const cardStatus = card.querySelector('.status-badge')?.textContent.toLowerCase();
                        if (cardStatus && cardStatus.includes(status)) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
                
                updateVisibleCounts(visibleCount);
            });
        }
        
        // Category filter buttons
        const filterButtons = document.querySelectorAll('#categoryFilters .category-filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (this.dataset.bsToggle) return;
                
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                const categoryId = this.dataset.category;
                filterItemsByCategory(categoryId);
            });
        });
        
        function filterItemsByCategory(categoryId) {
            console.log('Filtering by category:', categoryId);
            let visibleCount = 0;
            
            if (categoryId === 'all') {
                tableRows.forEach(row => {
                    row.style.display = '';
                    visibleCount++;
                });
                mobileCards.forEach(card => {
                    card.style.display = '';
                    visibleCount++;
                });
                updateVisibleCounts(visibleCount);
                return;
            }
            
            tableRows.forEach(row => {
                const categoryElement = row.querySelector('.category-badge');
                if (categoryElement) {
                    const categoryText = categoryElement.textContent.toLowerCase().trim();
                    const categoryName = categoryElement.querySelector('.category-name')?.textContent.toLowerCase() || categoryText;
                    const buttonCategory = document.querySelector(`[data-category="${categoryId}"] .category-name`)?.textContent.toLowerCase();
                    
                    if (buttonCategory && categoryName.includes(buttonCategory)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'none';
                }
            });
            
            updateVisibleCounts(visibleCount);
        }
        
        // Sort functionality
        const sortLinks = document.querySelectorAll('.dropdown-item[data-sort]');
        sortLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const sortBy = this.dataset.sort;
                sortProducts(sortBy);
            });
        });
        
        function sortProducts(sortBy) {
            // Sort desktop table rows
            const rows = Array.from(tableRows);
            
            rows.sort((a, b) => {
                switch(sortBy) {
                    case 'name':
                        const nameA = a.querySelector('.product-name').textContent.toLowerCase();
                        const nameB = b.querySelector('.product-name').textContent.toLowerCase();
                        return nameA.localeCompare(nameB);
                    
                    case 'stock':
                        const stockTextA = a.querySelector('.stock-value').textContent;
                        const stockTextB = b.querySelector('.stock-value').textContent;
                        const stockA = parseInt(stockTextA) || 0;
                        const stockB = parseInt(stockTextB) || 0;
                        return stockB - stockA;
                    
                    case 'newest':
                        const dateTextA = a.querySelector('.date-display')?.textContent || '';
                        const dateTextB = b.querySelector('.date-display')?.textContent || '';
                        return dateTextB.localeCompare(dateTextA);
                    
                    case 'oldest':
                        const dateTextA2 = a.querySelector('.date-display')?.textContent || '';
                        const dateTextB2 = b.querySelector('.date-display')?.textContent || '';
                        return dateTextA2.localeCompare(dateTextB2);
                    
                    default:
                        return 0;
                }
            });
            
            // Update desktop table
            const tbody = document.querySelector('.products-table tbody');
            rows.forEach(row => tbody.appendChild(row));
            
            // Sort mobile cards
            const cards = Array.from(mobileCards);
            cards.sort((a, b) => {
                switch(sortBy) {
                    case 'name':
                        const nameA = a.querySelector('.mobile-product-name').textContent.toLowerCase();
                        const nameB = b.querySelector('.mobile-product-name').textContent.toLowerCase();
                        return nameA.localeCompare(nameB);
                    
                    case 'stock':
                        const stockTextA = a.querySelector('.mobile-stat-value span').textContent;
                        const stockTextB = b.querySelector('.mobile-stat-value span').textContent;
                        const stockA = parseInt(stockTextA) || 0;
                        const stockB = parseInt(stockTextB) || 0;
                        return stockB - stockA;
                    
                    default:
                        return 0;
                }
            });
            
            // Update mobile cards container
            const mobileContainer = document.querySelector('.p-3');
            if (mobileContainer) {
                cards.forEach(card => mobileContainer.appendChild(card));
            }
        }
        
        function updateVisibleCounts(visibleCount) {
            const itemsCountEl = document.getElementById('itemsCount');
            const mobileItemsCountEl = document.getElementById('mobileItemsCount');
            const totalCount = {{ products.total }};
            
            if (visibleCount === 0) {
                if (itemsCountEl) itemsCountEl.textContent = `0 of ${totalCount} items`;
                if (mobileItemsCountEl) mobileItemsCountEl.textContent = `0 of ${totalCount} items`;
            } else {
                if (itemsCountEl) itemsCountEl.textContent = `${visibleCount} of ${totalCount} items`;
                if (mobileItemsCountEl) mobileItemsCountEl.textContent = `${visibleCount} of ${totalCount} items`;
            }
        }
        
        // Handle product details modal close event
        const productDetailsModal = document.getElementById('productDetailsModal');
        if (productDetailsModal) {
            productDetailsModal.addEventListener('hidden.bs.modal', function () {
                document.getElementById('productDetailsContent').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading product details...</p>
                    </div>
                `;
            });
        }
        
        // ========== PERBAIKI EDIT FORM SUBMISSION ==========
        const editProductForm = document.getElementById('editProductForm');
        if (editProductForm) {
            editProductForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = document.getElementById('submitEditForm');
                const originalText = submitBtn.innerHTML;
                
                try {
                    // Disable submit button and show loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                    
                    const formData = new FormData(this);
                    const productId = document.getElementById('editProductId').value;
                    
                    console.log('Form data being submitted:', Object.fromEntries(formData));
                    console.log('Product ID:', productId);
                    
                    // Gunakan endpoint API yang benar
                    const response = await fetch(`/api/product/edit/${productId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRFToken': getCSRFToken()
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Show success message
                        showNotification('Product updated successfully!', 'success');
                        
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
                        modal.hide();
                        
                        // Reload page after a short delay
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                        
                    } else {
                        throw new Error(result.message || result.error || 'Failed to update product');
                    }
                    
                } catch (error) {
                    console.error('Error:', error);
                    showNotification(error.message || 'Failed to update product', 'error');
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }
    });
    
    // Product Details Functions
    async function viewProductDetails(productId) {
        try {
            console.log('Loading product details for ID:', productId);
            
            // Show modal immediately with loading state
            const detailsModal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
            detailsModal.show();
            
            const response = await fetch(`/admin/items/get/${productId}`);
            
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            
            const product = await response.json();
            console.log('Product data received:', product);
            
            if (product.error) {
                throw new Error(product.error);
            }
            
            const detailsContent = generateProductDetailsHTML(product);
            document.getElementById('productDetailsContent').innerHTML = detailsContent;
            
            const editBtn = document.getElementById('editFromDetailsBtn');
            if (editBtn) {
                editBtn.onclick = function() {
                    detailsModal.hide();
                    setTimeout(() => openEditModal(productId), 300);
                };
            }
            
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('productDetailsContent').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error Loading Product Details</strong>
                    <div class="mt-2 small">${error.message}</div>
                    <div class="mt-3">
                        <button class="btn-light-custom me-2" onclick="viewProductDetails(${productId})">
                            <i class="fas fa-redo me-2"></i> Try Again
                        </button>
                        <button class="btn-primary-custom" onclick="openEditModal(${productId})">
                            <i class="fas fa-edit me-2"></i> Try Edit Directly
                        </button>
                    </div>
                </div>
            `;
        }
    }
    
    function generateProductDetailsHTML(product) {
        // Calculate total stock from variants only
        let totalStock = 0;
        if (product.variants && product.variants.length > 0) {
            totalStock = product.variants.reduce((sum, variant) => sum + (variant.stock || 0), 0);
        }
        
        // Get price range
        let priceRange = '$0.00';
        let priceRangeText = 'No Price';
        
        if (product.variants && product.variants.length > 0) {
            const prices = product.variants.map(v => v.price || 0).filter(p => p > 0);
            if (prices.length > 0) {
                const minPrice = Math.min(...prices);
                const maxPrice = Math.max(...prices);
                if (minPrice === maxPrice) {
                    priceRange = `$ ${minPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    priceRangeText = `$ ${minPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                } else {
                    priceRange = `$ ${minPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} - $ ${maxPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                    priceRangeText = `$ ${minPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} - $ ${maxPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                }
            }
        } else if (product.price && product.price > 0) {
            priceRange = `$ ${product.price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            priceRangeText = `$ ${product.price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        }
        
        // Stock status
        let stockStatusClass = 'text-danger';
        let stockStatusText = 'Out of Stock';
        let stockStatusIcon = 'fas fa-times-circle';
        
        if (totalStock > 10) {
            stockStatusClass = 'text-success';
            stockStatusText = 'In Stock';
            stockStatusIcon = 'fas fa-check-circle';
        } else if (totalStock > 0) {
            stockStatusClass = 'text-warning';
            stockStatusText = 'Low Stock';
            stockStatusIcon = 'fas fa-exclamation-triangle';
        }
        
        // Format date
        let createdDate = 'N/A';
        if (product.created_at) {
            try {
                const date = new Date(product.created_at);
                createdDate = date.toLocaleDateString('en-US', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch (e) {
                createdDate = product.created_at;
            }
        }
        
        // Escape HTML for safety
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        // Get category name
        const categoryName = product.category?.name || product.category?.name || 'Uncategorized';
        
        // Build image URL
        let imageUrl = '';
        if (product.image) {
            if (product.image.startsWith('http') || product.image.startsWith('/static')) {
                imageUrl = product.image;
            } else {
                imageUrl = `/static/uploads/${product.image}`;
            }
        }
        
        // Status badge class
        let statusBadgeClass = 'status-badge ';
        if (product.status === 'active') {
            statusBadgeClass += 'status-active';
        } else if (product.status === 'inactive') {
            statusBadgeClass += 'status-inactive';
        } else {
            statusBadgeClass += 'status-draft';
        }
        
        // Generate variants HTML
        let variantsHTML = '';
        if (product.variants && product.variants.length > 0) {
            variantsHTML = `
                <div class="variant-icon-grid">
                    ${product.variants.map(variant => {
                        const variantStock = variant.stock || 0;
                        const variantStockClass = variantStock === 0 ? 'out' : 
                                                variantStock < 5 ? 'low' : 
                                                variantStock < 10 ? 'medium' : 'high';
                        
                        // Choose icon based on variant type
                        let variantIcon = 'fas fa-box';
                        let variantColor = 'var(--primary-blue)';
                        
                        if (variant.name && variant.name.toLowerCase().includes('size')) {
                            variantIcon = 'fas fa-expand-alt';
                            variantColor = '#059669';
                        } else if (variant.name && variant.name.toLowerCase().includes('color')) {
                            variantIcon = 'fas fa-palette';
                            variantColor = '#d97706';
                        } else if (variant.name && variant.name.toLowerCase().includes('gender')) {
                            if (variant.name.toLowerCase().includes('male') || variant.name.toLowerCase().includes('men')) {
                                variantIcon = 'fas fa-male';
                                variantColor = '#2563eb';
                            } else if (variant.name.toLowerCase().includes('female') || variant.name.toLowerCase().includes('women')) {
                                variantIcon = 'fas fa-female';
                                variantColor = '#ec4899';
                            }
                        }
                        
                        return `
                        <div class="variant-icon-item">
                            <div class="variant-icon">
                                <i class="${variantIcon}" style="color: ${variantColor};"></i>
                            </div>
                            <div class="variant-icon-label">${escapeHtml(variant.name)}</div>
                            <div class="variant-icon-value">$ ${(variant.price || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</div>
                            <div class="mt-2">
                                <span class="variant-stock ${variantStockClass}" style="display: inline-block; padding: 2px 8px; border-radius: 4px;">
                                    ${variantStock} pcs
                                </span>
                            </div>
                            ${variant.sku ? `<div class="mt-1 small text-muted">SKU: ${escapeHtml(variant.sku)}</div>` : ''}
                        </div>
                        `;
                    }).join('')}
                </div>
                
                <!-- Variants Table -->
                <div class="mt-4">
                    <h6 class="mb-3 fw-600 text-dark">Detailed Variant Information</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Variant Name</th>
                                    <th>Price ($)</th>
                                    <th>Stock</th>
                                    <th>SKU</th>
                                    <th>Barcode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${product.variants.map(variant => {
                                    const variantStock = variant.stock || 0;
                                    const variantPrice = variant.price || 0;
                                    const variantStockClass = variantStock === 0 ? 'text-danger' : 
                                                            variantStock < 10 ? 'text-warning' : 'text-success';
                                    const variantStockIcon = variantStock === 0 ? 'fa-times-circle' : 
                                                           variantStock < 10 ? 'fa-exclamation-triangle' : 'fa-check-circle';
                                    const isLowStock = variantStock > 0 && variantStock < (variant.alert_at || 5);
                                    
                                    return `
                                    <tr>
                                        <td class="fw-medium">
                                            <i class="fas fa-circle me-2" style="font-size: 0.5rem; color: var(--primary-blue);"></i>
                                            ${escapeHtml(variant.name || 'No Name')}
                                        </td>
                                        <td class="fw-bold">$ ${variantPrice.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                                        <td>
                                            <span class="${variantStockClass}">
                                                <i class="fas ${variantStockIcon} me-1"></i>
                                                ${variantStock} units
                                            </span>
                                            ${isLowStock ? `<div class="small text-warning"><i class="fas fa-exclamation-circle me-1"></i>Low stock alert</div>` : ''}
                                        </td>
                                        <td><code class="small">${escapeHtml(variant.sku || 'N/A')}</code></td>
                                        <td><code class="small">${escapeHtml(variant.barcode || 'N/A')}</code></td>
                                        <td>
                                            ${variantStock > 0 ? 
                                                `<span class="badge bg-success bg-opacity-10 text-success">Available</span>` : 
                                                `<span class="badge bg-danger bg-opacity-10 text-danger">Out of Stock</span>`}
                                        </td>
                                    </tr>
                                    `;
                                }).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        } else {
            variantsHTML = `
                <div class="text-center py-4 bg-light rounded">
                    <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                    <h6 class="text-muted">No Variants Available</h6>
                    <p class="small text-muted">This product doesn't have any variants.</p>
                </div>
            `;
        }
        
        // Generate barcode HTML
        let barcodeHTML = '';
        if (product.variants && product.variants.length > 0) {
            // Product with variants
            barcodeHTML = `
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-barcode me-2"></i>Product Barcodes</h6>
                            </div>
                            <div class="card-body">
                                <!-- Variants Barcodes -->
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Variant Name</th>
                                                <th>SKU</th>
                                                <th>Barcode Number</th>
                                                <th>Visual Barcode</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${product.variants.map(variant => {
                                                const variantBarcode = variant.barcode || variant.sku || '';
                                                return `
                                                <tr>
                                                    <td>${escapeHtml(variant.name || 'N/A')}</td>
                                                    <td><code>${escapeHtml(variant.sku || 'N/A')}</code></td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control" 
                                                                   value="${escapeHtml(variantBarcode)}" readonly>
                                                            ${variantBarcode ? `
                                                            <button class="btn btn-sm btn-outline-secondary" 
                                                                    type="button"
                                                                    onclick="copyBarcode('${escapeHtml(variantBarcode)}')">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                            ` : ''}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        ${variantBarcode ? `
                                                        <div class="barcode-variant-visual" 
                                                             id="barcodeVariant${variant.id}"></div>
                                                        ` : '<span class="text-muted">N/A</span>'}
                                                    </td>
                                                    <td>
                                                        ${variantBarcode ? `
                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-outline-primary" 
                                                                    onclick="downloadVariantBarcode('${escapeHtml(variantBarcode)}', '${escapeHtml(product.name + ' - ' + variant.name)}')"
                                                                    title="Download Barcode">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                            <button class="btn btn-outline-secondary" 
                                                                    onclick="printBarcodeLabel('${escapeHtml(variantBarcode)}', '${escapeHtml(product.name)}', '${escapeHtml(variant.name)}')"
                                                                    title="Print Label">
                                                                <i class="fas fa-print"></i>
                                                            </button>
                                                        </div>
                                                        ` : '<span class="text-muted">No barcode</span>'}
                                                    </td>
                                                </tr>
                                                `;
                                            }).join('')}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Product without variants
            barcodeHTML = product.barcode ? `
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-barcode me-2"></i>Product Barcode</h6>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-500">Barcode Number:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="barcodeNumber" 
                                                       value="${escapeHtml(product.barcode)}" readonly>
                                                <button class="btn btn-outline-primary" type="button" 
                                                        onclick="copyBarcode('${escapeHtml(product.barcode)}')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <div class="barcode-visual mb-2" id="barcodeVisual"></div>
                                        <div class="barcode-action-buttons">
                                            <button class="btn btn-sm btn-outline-success" 
                                                    onclick="downloadBarcode('${escapeHtml(product.barcode)}', '${escapeHtml(product.name)}')">
                                                <i class="fas fa-download me-1"></i> Download Barcode
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary" 
                                                    onclick="printBarcodeLabel('${escapeHtml(product.barcode)}', '${escapeHtml(product.name)}', '')">
                                                <i class="fas fa-print me-1"></i> Print Label
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ` : '<div class="alert alert-info mt-4"><i class="fas fa-info-circle me-2"></i>No barcode available for this product.</div>';
        }
        
        return `
            <div class="product-details-content">
                <!-- Product Header with Image -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="product-image-container text-center">
                            ${imageUrl ? `
                                <img src="${imageUrl}" 
                                     alt="${escapeHtml(product.name || 'No Name')}" 
                                     class="img-fluid rounded" 
                                     style="max-height: 200px; object-fit: contain;">
                                <div class="mt-2 small text-muted">Click image to enlarge</div>
                            ` : `
                                <div class="d-flex align-items-center justify-content-center bg-light rounded" 
                                     style="height: 200px;">
                                    <div class="text-center">
                                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                        <div class="text-muted">No image available</div>
                                    </div>
                                </div>
                            `}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-1 fw-bold">${escapeHtml(product.name || 'No Name')}</h4>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="${statusBadgeClass}">
                                        ${product.status ? product.status.charAt(0).toUpperCase() + product.status.slice(1) : 'Draft'}
                                    </span>
                                    <span class="text-muted">•</span>
                                    <span class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        ${createdDate}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="display-5 fw-bold text-primary mb-1">${priceRangeText}</div>
                                <div class="text-muted">Price Range</div>
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="row g-3 mt-3">
                            <div class="col-4">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="h4 mb-1 fw-bold ${stockStatusClass}">${totalStock}</div>
                                    <div class="text-muted small">Total Stock (Variant)</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="h4 mb-1 fw-bold">${product.variants ? product.variants.length : 0}</div>
                                    <div class="text-muted small">Variants</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-center p-3 border rounded bg-light">
                                    <div class="h4 mb-1 fw-bold">${product.brand ? escapeHtml(product.brand) : 'N/A'}</div>
                                    <div class="text-muted small">Brand</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Information Tabs -->
                <div class="mt-4">
                    <ul class="nav nav-tabs" id="productDetailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">
                                <i class="fas fa-layer-group me-2"></i>Variants (${product.variants ? product.variants.length : 0})
                            </button>
                        </li>
                        ${product.description ? `
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                <i class="fas fa-file-alt me-2"></i>Description
                            </button>
                        </li>
                        ` : ''}
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="barcode-tab" data-bs-toggle="tab" data-bs-target="#barcode" type="button" role="tab">
                                <i class="fas fa-barcode me-2"></i>Barcodes
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content border-start border-end border-bottom p-4" id="productDetailTabContent">
                        <!-- Information Tab -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="border-0 text-muted" width="40%"><i class="fas fa-tag me-2"></i>Category:</td>
                                                <td class="border-0 fw-medium">
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        ${escapeHtml(categoryName)}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-muted"><i class="fas fa-industry me-2"></i>Brand:</td>
                                                <td class="border-0">${product.brand ? escapeHtml(product.brand) : 'N/A'}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="border-0 text-muted" width="40%"><i class="fas fa-barcode me-2"></i>Status:</td>
                                                <td class="border-0">
                                                    <span class="${statusBadgeClass}">
                                                        <i class="fas ${product.status === 'active' ? 'fa-check-circle' : product.status === 'inactive' ? 'fa-times-circle' : 'fa-pencil-alt'} me-1"></i>
                                                        ${product.status ? product.status.charAt(0).toUpperCase() + product.status.slice(1) : 'Draft'}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-muted"><i class="fas fa-cubes me-2"></i>Total Stock:</td>
                                                <td class="border-0 fw-bold ${stockStatusClass}">
                                                    <i class="fas ${stockStatusIcon} me-1"></i>
                                                    ${totalStock} units
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Variants Tab -->
                        <div class="tab-pane fade" id="variants" role="tabpanel">
                            ${variantsHTML}
                        </div>
                        
                        <!-- Description Tab -->
                        ${product.description ? `
                        <div class="tab-pane fade" id="description" role="tabpanel">
                            <div class="p-3 bg-light rounded">
                                <h6 class="mb-3"><i class="fas fa-align-left me-2"></i>Product Description</h6>
                                <div style="white-space: pre-line;">${escapeHtml(product.description)}</div>
                            </div>
                        </div>
                        ` : ''}
                        
                        <!-- Barcode Tab -->
                        <div class="tab-pane fade" id="barcode" role="tabpanel">
                            ${barcodeHTML}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // ========== FUNGSI BARCODE ==========
    
    // Fungsi untuk generate visual barcode
    function generateBarcodeVisual(barcode, elementId, options = {}) {
        if (!barcode || !elementId) return;
        
        const container = document.getElementById(elementId);
        if (!container) return;
        
        const defaultOptions = {
            format: "CODE128",
            width: 2,
            height: 60,
            displayValue: true,
            fontSize: 12,
            textMargin: 10,
            margin: 15,
            background: "#ffffff",
            lineColor: "#2c3e50"
        };
        
        const mergedOptions = { ...defaultOptions, ...options };
        
        // Jika JsBarcode tersedia
        if (typeof JsBarcode !== 'undefined') {
            try {
                const canvas = document.createElement('canvas');
                JsBarcode(canvas, barcode, mergedOptions);
                container.innerHTML = '';
                container.appendChild(canvas);
                
                // Trigger setelah barcode digenerate
                setTimeout(() => {
                    const canvasElement = container.querySelector('canvas');
                    if (canvasElement) {
                        canvasElement.style.maxWidth = '100%';
                        canvasElement.style.height = 'auto';
                    }
                }, 100);
            } catch (error) {
                console.error('Barcode generation error:', error);
                container.innerHTML = `
                    <div class="text-muted small">
                        <i class="fas fa-exclamation-triangle"></i> Error generating barcode
                    </div>
                `;
            }
        } else {
            // Fallback untuk text only
            container.innerHTML = `
                <div class="barcode-text-fallback">
                    <div class="text-center mb-1">
                        <span class="fw-bold">${barcode}</span>
                    </div>
                    <div class="d-flex justify-content-center">
                        ${barcode.split('').map(char => {
                            const height = 20 + (parseInt(char) || 0) * 3;
                            return `<div class="barcode-bar" style="height: ${height}px; width: 3px; background: #000; margin: 0 1px;"></div>`;
                        }).join('')}
                    </div>
                    <div class="text-center mt-1 small text-muted">
                        (EAN-13 Barcode)
                    </div>
                </div>
            `;
        }
    }
    
    // Fungsi untuk copy barcode ke clipboard
    function copyBarcode(barcode) {
        navigator.clipboard.writeText(barcode).then(() => {
            showNotification('Barcode copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy: ', err);
            showNotification('Failed to copy barcode', 'error');
        });
    }
    
    // Fungsi untuk download barcode sebagai gambar
    function downloadBarcode(barcode, productName) {
        if (!barcode) {
            showNotification('No barcode available to download', 'error');
            return;
        }
        
        if (typeof JsBarcode !== 'undefined') {
            const canvas = document.createElement('canvas');
            JsBarcode(canvas, barcode, {
                format: "CODE128",
                width: 3,
                height: 100,
                displayValue: true,
                fontSize: 16,
                textMargin: 15,
                margin: 20,
                background: "#ffffff",
                lineColor: "#000000"
            });
            
            // Convert canvas to blob
            canvas.toBlob(function(blob) {
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                
                link.href = url;
                link.download = `${productName.replace(/[^a-z0-9]/gi, '_')}_barcode.png`;
                
                document.body.appendChild(link);
                link.click();
                
                // Cleanup
                setTimeout(() => {
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                }, 100);
            }, 'image/png');
            
            showNotification('Barcode downloaded successfully!', 'success');
        } else {
            // Fallback untuk browser tanpa canvas support
            showNotification('Please install JsBarcode library for barcode download', 'info');
        }
    }
    
    // Fungsi khusus untuk variant barcode
    function downloadVariantBarcode(barcode, variantName) {
        downloadBarcode(barcode, variantName);
    }
    
    // Fungsi untuk print barcode label
    function printBarcodeLabel(barcode, productName, variantName) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Barcode Label - ${productName}</title>
                <style>
                    @media print {
                        body { margin: 0; padding: 20px; font-family: Arial, sans-serif; }
                        .label-container { width: 3in; height: 2in; border: 1px solid #000; 
                                          padding: 10px; text-align: center; }
                        .product-name { font-size: 12px; font-weight: bold; margin-bottom: 5px; }
                        .variant-name { font-size: 11px; color: #666; margin-bottom: 10px; }
                        .barcode-container { margin: 10px 0; }
                        .barcode-number { font-family: monospace; font-size: 14px; letter-spacing: 1px; }
                        .store-info { font-size: 9px; color: #999; margin-top: 10px; }
                    }
                </style>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"><\/script>
            </head>
            <body>
                <div class="label-container">
                    <div class="product-name">${productName}</div>
                    ${variantName ? `<div class="variant-name">${variantName}</div>` : ''}
                    <div class="barcode-container">
                        <canvas id="printBarcode"></canvas>
                    </div>
                    <div class="barcode-number">${barcode}</div>
                    <div class="store-info">
                        ${new Date().toLocaleDateString()} | BONUS CLOTHING
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof JsBarcode !== 'undefined') {
                            JsBarcode("#printBarcode", "${barcode}", {
                                format: "CODE128",
                                width: 2,
                                height: 50,
                                displayValue: false
                            });
                            setTimeout(() => window.print(), 500);
                        }
                    });
                <\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }
    
    // Update viewProductDetails untuk init barcode setelah load
    async function viewProductDetails(productId) {
        try {
            console.log('Loading product details for ID:', productId);
            
            // Show modal immediately with loading state
            const detailsModal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
            detailsModal.show();
            
            const response = await fetch(`/admin/items/get/${productId}`);
            
            if (!response.ok) {
                throw new Error(`Server error: ${response.status}`);
            }
            
            const product = await response.json();
            console.log('Product data received:', product);
            
            if (product.error) {
                throw new Error(product.error);
            }
            
            const detailsContent = generateProductDetailsHTML(product);
            document.getElementById('productDetailsContent').innerHTML = detailsContent;
            
            // Initialize barcode visuals setelah content dimuat
            setTimeout(() => {
                // Generate barcode untuk produk utama (jika tidak ada variant)
                if (!product.variants || product.variants.length === 0) {
                    if (product.barcode) {
                        generateBarcodeVisual(product.barcode, 'barcodeVisual');
                    }
                }
                
                // Generate barcode untuk tiap variant
                if (product.variants && product.variants.length > 0) {
                    product.variants.forEach(variant => {
                        if (variant.barcode || variant.sku) {
                            const barcode = variant.barcode || variant.sku;
                            generateBarcodeVisual(barcode, `barcodeVariant${variant.id}`, {
                                height: 40,
                                fontSize: 10,
                                width: 1.5
                            });
                        }
                    });
                }
            }, 100);
            
            const editBtn = document.getElementById('editFromDetailsBtn');
            if (editBtn) {
                editBtn.onclick = function() {
                    detailsModal.hide();
                    setTimeout(() => openEditModal(productId), 300);
                };
            }
            
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('productDetailsContent').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Error Loading Product Details</strong>
                    <div class="mt-2 small">${error.message}</div>
                    <div class="mt-3">
                        <button class="btn-light-custom me-2" onclick="viewProductDetails(${productId})">
                            <i class="fas fa-redo me-2"></i> Try Again
                        </button>
                        <button class="btn-primary-custom" onclick="openEditModal(${productId})">
                            <i class="fas fa-edit me-2"></i> Try Edit Directly
                        </button>
                    </div>
                </div>
            `;
        }
    }
    
    // ========== FUNGSI EKSPOR EXCEL ==========
    
   function exportToExcel() {
    const btn = document.querySelector('[onclick="exportToExcel()"]');
    const originalText = btn.innerHTML;

    try {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Preparing...';
        btn.disabled = true;

        window.location.href = '/api/products/export/excel';

        showNotification('Excel export started...', 'success');
    } catch (err) {
        showNotification('Export failed', 'error');
    } finally {
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 1500);
    }
}

    
    // ========== PERBAIKI FUNGSI openEditModal ==========
    async function openEditModal(productId) {
        try {
            console.log('Opening edit modal for product ID:', productId);
            
            const response = await fetch(`/api/product/edit/${productId}`);
            if (!response.ok) throw new Error('Failed to fetch product data');
            
            const result = await response.json();
            console.log('Product data for edit:', result);
            
            if (!result.success || !result.product) {
                throw new Error(result.message || 'Failed to load product data');
            }
            
            const product = result.product;
            
            // Populate basic product information
            document.getElementById('editProductId').value = product.id || '';
            document.getElementById('editProductName').value = product.name || '';
            document.getElementById('editDescription').value = product.description || '';
            document.getElementById('editBrand').value = product.brand || '';
            document.getElementById('editStatus').value = product.status || 'active';
            document.getElementById('editCategory').value = product.category_id || '';
            
            // Handle product image
            const currentImagePreview = document.getElementById('currentImagePreview');
            const currentImageImg = currentImagePreview.querySelector('img');
            if (product.image) {
                let imageUrl = '';
                if (product.image.startsWith('http') || product.image.startsWith('/static')) {
                    imageUrl = product.image;
                } else {
                    imageUrl = `/static/uploads/${product.image}`;
                }
                
                currentImageImg.src = imageUrl;
                currentImagePreview.style.display = 'block';
            } else {
                currentImagePreview.style.display = 'none';
            }
            
            // Populate variants
            const variantsBody = document.getElementById('variantsBody');
            variantsBody.innerHTML = '';
            
            if (product.variants && product.variants.length > 0) {
                product.variants.forEach((variant) => {
                    addVariantRow(variant);
                });
            } else {
                addVariantRow();
            }
            
            // Set form action
            const editForm = document.getElementById('editProductForm');
            editForm.action = `/api/product/edit/${productId}`;
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
            
        } catch (error) {
            console.error('Error:', error);
            showNotification(error.message || 'Failed to load product data', 'error');
            
            // Fallback: Show modal dengan form kosong
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            document.getElementById('editProductId').value = productId;
            document.getElementById('editProductForm').action = `/api/product/edit/${productId}`;
            
            // Clear variants table dan tambah satu row kosong
            const variantsBody = document.getElementById('variantsBody');
            variantsBody.innerHTML = '';
            addVariantRow();
            
            editModal.show();
        }
    }

    // Add variant row
    function addVariantRow(variant = null) {
        const variantsBody = document.getElementById('variantsBody');
        const index = variantsBody.children.length;
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="hidden" name="variant_ids[]" value="${variant?.id || ''}">
                <input type="text" class="form-control form-control-sm" 
                       name="variant_names[]" 
                       value="${variant?.name || ''}" 
                       placeholder="Variant name" required>
            </td>
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" 
                           name="variant_prices[]" 
                           value="${variant?.price || 0}" 
                           min="0" step="0.01" required>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       name="variant_stocks[]" 
                       value="${variant?.stock || 0}" 
                       min="0">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" 
                       name="variant_skus[]" 
                       value="${variant?.sku || ''}" 
                       placeholder="SKU">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" 
                       name="variant_barcodes[]" 
                       value="${variant?.barcode || ''}" 
                       placeholder="Barcode">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariantRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        variantsBody.appendChild(row);
    }

    // Remove variant row
    function removeVariantRow(button) {
        const row = button.closest('tr');
        const variantsBody = document.getElementById('variantsBody');
        
        // Don't remove if it's the only row
        if (variantsBody.children.length > 1) {
            row.remove();
        } else {
            showNotification('At least one variant is required', 'error');
        }
    }

    // Remove product image
    function removeProductImage() {
        const currentImagePreview = document.getElementById('currentImagePreview');
        currentImagePreview.style.display = 'none';
        
        // Add a hidden input to indicate image removal
        let removeImageInput = document.getElementById('removeImageFlag');
        if (!removeImageInput) {
            removeImageInput = document.createElement('input');
            removeImageInput.type = 'hidden';
            removeImageInput.id = 'removeImageFlag';
            removeImageInput.name = 'remove_image';
            removeImageInput.value = '1';
            document.getElementById('editProductForm').appendChild(removeImageInput);
        }
    }

    // Preview image when selected
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const currentImagePreview = document.getElementById('currentImagePreview');
                const currentImageImg = currentImagePreview.querySelector('img');
                currentImageImg.src = e.target.result;
                currentImagePreview.style.display = 'block';
                
                // Remove the remove image flag if exists
                const removeImageInput = document.getElementById('removeImageFlag');
                if (removeImageInput) {
                    removeImageInput.remove();
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ========== PERBAIKI FUNGSI deleteProduct ==========
    async function deleteProduct(productId, productName) {
        try {
            const confirmed = await showConfirmDialog(
                `Delete Product`,
                `Are you sure you want to delete "${productName}"? This action cannot be undone.`,
                'warning'
            );
            
            if (!confirmed) return;
            
            // Show loading on the delete button
            const deleteBtn = event?.target.closest('.action-btn') || event.target;
            const originalHtml = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            deleteBtn.disabled = true;
            
            const csrfToken = getCSRFToken();
            
            const response = await fetch(`/api/product/delete/${productId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRFToken': csrfToken
                }
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                showNotification('Product deleted successfully!', 'success');
                
                // Reload page after a short delay
                setTimeout(() => {
                    location.reload();
                }, 1000);
                
            } else {
                throw new Error(result.message || result.error || 'Failed to delete product');
            }
            
        } catch (error) {
            console.error('Error:', error);
            showNotification(error.message || 'Failed to delete product', 'error');
            
            // Reset button state
            const deleteBtn = event?.target.closest('.action-btn') || event.target;
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.disabled = false;
        }
    }

    // Helper functions
    function showComingSoon(feature = 'This feature') {
        alert(`${feature} is coming soon!`);
    }
    
    function addCategory() {
        const nameInput = document.getElementById('newCategoryName');
        if (!nameInput) return;
        
        const name = nameInput.value.trim();
        if (!name) {
            alert('Please enter a category name');
            return;
        }
        
        const categoryId = Date.now();
        const categoriesList = document.getElementById('categoriesList');
        if (!categoriesList) return;
        
        const newCategoryDiv = document.createElement('div');
        newCategoryDiv.className = 'd-flex justify-content-between align-items-center mb-2 p-3 border rounded';
        newCategoryDiv.id = `category-${categoryId}`;
        newCategoryDiv.innerHTML = `
            <span class="fw-500">${escapeHtml(name)}</span>
            <div>
                <button class="action-btn edit me-1" onclick="editCategory(${categoryId}, '${escapeHtml(name)}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="action-btn delete" onclick="deleteCategory(${categoryId})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        `;
        categoriesList.appendChild(newCategoryDiv);
        
        nameInput.value = '';
        alert(`Category "${name}" added successfully!`);
    }
    
    function editCategory(categoryId, currentName) {
        const newName = prompt('Edit category name:', currentName);
        if (newName && newName !== currentName) {
            const categoryDiv = document.getElementById(`category-${categoryId}`);
            if (categoryDiv) {
                categoryDiv.querySelector('span').textContent = newName;
            }
            alert('Category updated successfully!');
        }
    }
    
    function deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
            const categoryDiv = document.getElementById(`category-${categoryId}`);
            if (categoryDiv) {
                categoryDiv.remove();
            }
            alert('Category deleted successfully!');
        }
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Make functions globally available
    window.viewProductDetails = viewProductDetails;
    window.openEditModal = openEditModal;
    window.deleteProduct = deleteProduct;
    window.addVariantRow = addVariantRow;
    window.removeVariantRow = removeVariantRow;
    window.removeProductImage = removeProductImage;
    window.previewImage = previewImage;
    window.showNotification = showNotification;
    window.exportToExcel = exportToExcel;
    window.exportToCSV = exportToCSV;
    window.copyBarcode = copyBarcode;
    window.downloadBarcode = downloadBarcode;
    window.downloadVariantBarcode = downloadVariantBarcode;
    window.printBarcodeLabel = printBarcodeLabel;
    window.generateBarcodeVisual = generateBarcodeVisual;
</script>

<!-- Load external libraries -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection