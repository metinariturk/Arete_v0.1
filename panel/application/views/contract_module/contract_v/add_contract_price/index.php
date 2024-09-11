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
                var contractId = '<?php echo $contract->id; ?>';
                var subGroupId = '<?php echo $sub_group->id; ?>';

                // Checkbox işaretlendiyse hemen AJAX ile veriyi gönder
                if (isChecked) {
                    $.ajax({
                        url: '<?php echo base_url("contract/update_leader_selection"); ?>',  // İşlemi yapacak URL
                        method: 'POST',
                        data: {
                            leader_id: leaderId,
                            is_checked: 1,  // Checkbox işaretli
                            contract_id: contractId,
                            sub_group_id: subGroupId
                        },
                        success: function (response) {
                            console.log('İşlem başarılı: ', response);
                        },
                        error: function (error) {
                            console.error('Hata oluştu: ', error);
                        }
                    });
                } else {
                    // Checkbox işareti kaldırıldıysa, onay almak için SweetAlert'i göster
                    Swal.fire({
                        title: 'Silmek İstediğinize Emin Misiniz?',
                        text: "Bu işlem geri alınamaz!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet, sil!',
                        cancelButtonText: 'Hayır, iptal et'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kullanıcı onayladıysa, AJAX ile veriyi gönder
                            $.ajax({
                                url: '<?php echo base_url("contract/update_leader_selection"); ?>',  // İşlemi yapacak URL
                                method: 'POST',
                                data: {
                                    leader_id: leaderId,
                                    is_checked: 0,  // Checkbox işareti kaldırıldı
                                    contract_id: contractId,
                                    sub_group_id: subGroupId
                                },
                                success: function (response) {
                                    console.log('İşlem başarılı: ', response);
                                },
                                error: function (error) {
                                    console.error('Hata oluştu: ', error);
                                    // Checkbox'ı tekrar işaretleyin
                                    checkbox.checked = false;
                                }
                            });
                        } else {
                            // Kullanıcı onaylamazsa, checkbox işaretini geri yükle
                            checkbox.checked = true;
                        }
                    });
                }
            });
        });
    });

</script>
</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>


