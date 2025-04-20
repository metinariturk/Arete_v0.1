<h5 class="mb-0">
    <?php echo mb_strtoupper($item->dosya_no . " / " . $item->project_name); ?>
    <small style="font-size: 14px;">(
        <?php
        if ($item->isActive == 1) {
            echo "Devam eden proje";
        } elseif ($item->isActive == 2) {
            echo "Tamamlanan proje";
        } else {
            echo "Durum Bilinmiyor";
        }
        ?>)
    </small>
</h5>
<div class="container mt-5">
    <div class="row">
        <!-- Sağ Alt Sözleşmeler -->
        <div class="col-md-6">
            <div class="tabs mb-4">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <b>Proje Ana Sözleşmeler<br> <?php echo count($main_contracts); ?> Adet Sözleşme Mevcut</b>
                    <i class="fa fa-plus me-0" style="cursor: pointer;"
                       id="openContractModal"
                       onclick="open_modal('AddContractModal')"></i>
                </div>
            </div>
            <div class="custom-card-body">
                <div id="contract_table">
                    <?php $this->load->view("project_v/display/contract/contract_table"); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tabs mb-4">
                <div class="tab-item" style="background-color: rgba(199,172,134,0.43);">
                    <b>Şantiyeler<br> <?php echo count($sites); ?> Adet Şantiye Mevcut</b>
                    <i class="fa fa-plus me-0" style="cursor: pointer;"
                       id="openSiteModal"
                       onclick="open_modal('AddSiteModal')"></i>
                </div>
            </div>
            <div class="custom-card-body">
                <div id="site_table">
                    <?php $this->load->view("project_v/display/site/site_table"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
