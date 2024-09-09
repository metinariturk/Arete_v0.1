<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
</head>
<body  class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/title"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    // Arama kutusuna yazıldığında filtreleme işlemi
    $('#searchInput').on('keyup', function() {
        let query = $(this).val().toLowerCase();
        $('.leader-item').each(function() {
            let kalemText = $(this).text().toLowerCase();
            if (kalemText.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Tümünü Seç/Tümünü Seçimi Kaldır mantığı
    let isAllSelected = false;
    $('#selectAllBtn').on('click', function() {
        if (isAllSelected) {
            $('.form-check-input').prop('checked', false);
            $(this).text('Tümünü Seç');
        } else {
            $('.form-check-input').prop('checked', true);
            $(this).text('Tüm Seçimleri Kaldır');
        }
        isAllSelected = !isAllSelected;
    });

    // Seçimleri Kaydet
    function saveSelection() {
        let selectedLeaders = [];
        $('input[name="leaders[]"]:checked').each(function() {
            selectedLeaders.push($(this).val());
        });

        // AJAX ile verileri gönder
        $.ajax({
            url: '<?php echo base_url("controller/save_leader_selection"); ?>',
            type: 'POST',
            data: {leaders: selectedLeaders},
            success: function(response) {
                // Başarı mesajı veya başka bir işlem
                alert('Seçimler kaydedildi!');
            },
            error: function() {
                alert('Bir hata oluştu.');
            }
        });
    }
</script>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


