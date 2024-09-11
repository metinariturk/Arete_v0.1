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

    document.addEventListener('DOMContentLoaded', function () {
        // Tüm checkbox'ları dinleyelim
        document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                var leaderId = this.value;
                var isChecked = this.checked;
                var subGroupId = '<?php echo $sub_group->id; ?>';

                // AJAX ile backend'e durumu gönderelim
                $.ajax({
                    url: '<?php echo base_url("contract/update_leader_selection"); ?>',  // İşlemi yapacak URL
                    method: 'POST',
                    data: {
                        leader_id: leaderId,
                        is_checked: isChecked ? 1 : 0,  // 1 = checked, 0 = unchecked
                        sub_group_id: subGroupId
                    },
                    success: function (response) {
                        console.log('İşlem başarılı: ', response);
                    },
                    error: function (error) {
                        console.error('Hata oluştu: ', error);
                    }
                });
            });
        });
    });

</script>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


