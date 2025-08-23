<style>
    /* 1. Genel Ayarlar ve Box Sizing */
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -o-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
    }

    /* 2. Temel Kart ve Sekme Stilleri */
    .custom-card {
        border-radius: 0 0 15px 15px;
        border: 1px solid #dcdcdc;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .custom-card-header {
        font-size: 0.8rem;
        font-weight: bold;
        border-radius: 15px 15px 0 0;
        background-color: #f8f9fa;
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .custom-card-body {
        padding: 1rem;
        border: 1px solid #dcdcdc;
    }

    /* 3. Animasyon ve Uyarı Mesajları */
    @keyframes shake {
        0% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        50% { transform: translateX(4px); }
        75% { transform: translateX(-4px); }
        100% { transform: translateX(0); }
    }
    .shake-success {
        animation: shake 0.5s ease;
        background-color: #d4edda !important;
        transition: background-color 1s ease;
    }
    .shake-error {
        animation: shake 0.5s ease;
        background-color: #f8d7da !important;
        transition: background-color 1s ease;
    }
    .update-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 5px;
        font-weight: bold;
        display: none;
        z-index: 9999;
    }
    .update-alert.show { display: block; }
    .update-alert.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .update-alert.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* 4. Sözleşme Kartı Stilleri */
    .contract-card {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        padding: 24px;
        margin: 20px auto;
    }
    .parent-contract-info {
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0f0f0;
    }
    .contract-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    .contract-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 0;
        line-height: 1.4;
    }
    .contract-status {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        color: #fff;
        text-transform: uppercase;
    }
    .status-active { background-color: #28a745; }
    .status-completed { background-color: #6c757d; }
    .contract-details { font-size: 0.9rem; }

    .card-label {
        color: #888;
        font-weight: 400;
        flex-shrink: 0;
        margin-right: 15px;
    }
    .card-text {
        font-weight: 500;
        color: #555;
        text-align: left;
        flex-grow: 1;
    }

    /* 5. Sekmeler (Tabs) */
    .tabs {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        border-bottom: 2px solid #ccc;
    }
    .tab-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        flex: 1;
        border-radius: 15px 15px 0 0;
        text-align: center;
        border-bottom: none;
        padding: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        max-width: 250px;
    }
    .tab-item:not(:last-child) { margin-right: -1px; }
    .tab-item:hover {
        background-color: #e9ecef;
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .tab-item a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        line-height: 1.4;
        display: block;
    }
    .tab-item a .tab-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #555;
        margin-bottom: 4px;
    }
    .tab-item a .tab-code {
        font-size: 1.1rem;
        font-weight: 700;
        color: #111;
    }

    /* 6. Alt Sözleşme Başlık ve Tablo Stilleri */
    .card-header-with-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    .card-header-with-action .table-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }
    .header-action {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .sub-contract-count {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .add-icon { cursor: pointer; }
    .contract-details-table .table td {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .contract-details-table .table tr:last-child td { border-bottom: none; }
    .contract-details-table .detail-row td.card-label {
        font-weight: 600;
        color: #888;
        width: 50px;
    }
    .contract-details-table .detail-row td.card-text a {
        text-decoration: none;
        color: #007bff;
    }
    .contract-details-table .detail-row td.card-text a:hover { text-decoration: underline; }
</style>