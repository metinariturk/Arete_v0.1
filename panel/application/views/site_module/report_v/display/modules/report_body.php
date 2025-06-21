<div class="dropdown" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
    <div class="light-square" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-h fa-2x"></i>
    </div>
    <ul class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
        <li>
            <a class="dropdown-item" target="_blank"
               href="<?php echo base_url("report/print_report/$item->id/1"); ?>">
                <i class="fa fa-file-pdf-o"></i> PDF'e Aktar
            </a>
        </li>
        <li>
            <a class="dropdown-item"
               href="<?php echo base_url("Report/update_form/$item->id"); ?>">
                <i class="fa fa-edit"></i> Güncelle
            </a>
        </li>
        <li>
            <a class="dropdown-item"
               href="<?php echo base_url("Report/delete/$item->id"); ?>">
                <i class="fa fa-trash"></i> Sil
            </a>
        </li>
    </ul>
</div>

<?php $this->load->view("site_module/report_v/display/modules/weather_creator"); ?>


<hr class="my-4">
<div class="row">
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/workgroup"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/workmachine"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/supplies"); ?>
    </div>
    <div class="col-12 mb-3">
        <?php $this->load->view("site_module/report_v/display/modules/foot"); ?> </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <?php $this->load->view("site_module/report_v/common/add_document"); ?>
    </div>
</div>