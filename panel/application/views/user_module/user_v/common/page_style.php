<style>.table-responsive {
        overflow-x: auto;
        position: relative;
    }

    .table-responsive table {
        position: relative;
    }

    .table-responsive th:first-child,
    .table-responsive td:first-child {
        position: sticky;
        left: 0;
        background-color: #fff; /* Sütun için arka plan rengi */
        z-index: 2; /* Diğer hücrelerin üzerine çıkmasını sağlamak için */
    }

    .table-responsive thead th:first-child {
        z-index: 3; /* Başlık hücresinin daha da önde olması için */
    }</style>