<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-center">
                    <h4><i class="fa fa-exclamation-triangle"></i> Dikkat! Silme İşlemi</h4>
                </div>
                <div class="card-body">
                    <p class="text-danger fw-bold">
                        Aşağıdaki tüm veriler ve sözleşmeye ait dosyanın tamamı <u>kalıcı olarak</u> silinecektir!
                    </p>
                    <p>
                        <i class="fa fa-download text-primary"></i> Dosyanın yedeğini almak için
                        <a href="<?php echo base_url("project/download_backup/$item->id"); ?>" class="fw-bold">buraya
                            tıklayın</a>.
                    </p>
                    <hr>

                    <!-- Alt Sözleşmeler -->
                    <?php renderModule('Sözleşmeye Bağlı Alt Sözleşmeler', $sub_contracts, 'contract/file_form', 'dosya_no', "contract_name"); ?>
                    <hr>

                    <!-- Avanslar -->
                    <?php renderModule('Sözleşmeye Bağlı Avanslar', $advances, 'advance/file_form', 'dosya_no', "Avans"); ?>
                    <hr>

                    <!-- Teminatlar -->
                    <?php renderModule('Sözleşmeye Bağlı Teminatlar', $bonds, 'bond/file_form', 'dosya_no', "Teminat"); ?>
                    <hr>

                    <!-- Keşif Artışları -->
                    <?php renderModule('Sözleşmeye Bağlı Keşif Artışları', $costincs, 'costinc/file_form', 'dosya_no', "Keşif Artışı"); ?>
                    <hr>

                    <!-- Tahsilatlar -->
                    <?php renderModule('Sözleşmeye Bağlı Tahsilatlar', $collections, 'collection/file_form', 'dosya_no', "Tahsilat"); ?>
                    <hr>

                    <!-- Süre Uzatımları -->
                    <?php renderModule('Sözleşmeye Bağlı Süre Uzatımları', $extimes, 'extime/file_form', 'dosya_no', "Süre Uzatımı"); ?>
                    <hr>

                    <!-- Yeni Birim Fiyatlar -->
                    <?php renderModule('Sözleşmeye Bağlı Yeni Birim Fiyatlar', $newprices, 'newprice/file_form', 'dosya_no', "YBF - YFT"); ?>
                    <hr>

                    <!-- Hakedişler -->
                    <?php renderModule('Sözleşmeye Bağlı Hakedişler', $payments, 'payment/file_form', 'hakedis_no', "Hakediş"); ?>
                    <hr>

                    <!-- Şantiyeler -->
                    <?php renderModule('Sözleşmeye Bağlı Şantiyeler', $sites, 'site/file_form', 'dosya_no', "santiye_ad"); ?>
                    <hr>

                </div>

                <div class="text-center">
                    <?php if ($sub_contracts) { ?>
                        <p class="text-danger fw-bold"> Alt Sözleşmeler Silinmeden Bu Sözleşmeyi Silemezsiniz</p>
                    <?php } else { ?>
                        <p class="text-danger fw-bold">Bu işlem geri alınamaz. Lütfen dikkatli olun!</p>
                        <a href="<?php echo base_url("contract/hard_delete/$item->id"); ?>"
                           class="btn btn-lg btn-danger">
                            <i class="fa fa-trash-alt"></i> Sözleşmeyi Kalıcı Olarak Sil
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
function renderModule($title, $data, $url, $label, $name = null)
{
    if (empty($data)) {
        echo "<hr><h5>$title (0)</h5>";
        echo "<div class='alert alert-success'><i class='fa fa-check-circle'></i> $title Yok</div>";
        return;
    }

    echo "<hr><h5><i class='fa fa-hard-hat text-secondary'></i> $title (" . count($data) . ")</h5>";


    // Diğer modüller için standart listeleme
    echo "<ul class='list-group'>";
    foreach ($data as $item) {
        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
        echo "<span>" . $item->$label . " - " . (isset($item->$name) ? $item->$name : $name) . "</span>";
        echo "<a href='" . base_url("$url/$item->id") . "' target='_blank' class='btn btn-sm btn-outline-success'>";
        echo "<i class='fa fa-arrow-circle-right'></i> Görüntüle";
        echo "</a></li>";
    }
    echo "</ul>";

}

?>


