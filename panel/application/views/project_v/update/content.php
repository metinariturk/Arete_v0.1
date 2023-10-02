<form id="update_project" action="<?php echo base_url("$this->Module_Name/update/$item->id"); ?>" method="post" autocomplete="off">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $item->proje_kodu; ?> - <?php echo $item->proje_ad; ?></h5>
                </div>

                <div class="card-body">
                    <?php $this->load->view("{$viewFolder}/{$subViewFolder}/input_form"); ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"> Dosya Yönetimi</h5>
                </div>
                <div class="card-body">
                    <?php $this->load->view("{$viewFolder}/$this->Common_Files/add_document"); ?>
                    <?php $this->load->view("{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/error_form"); ?>
    </div>
</form>


