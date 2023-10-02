<?php
if (empty($project_id)) { ?>
    <div class="alert alert-info text-center">
        <p>Lütfen Yeni <?php echo $this->Module_Title; ?> Ekle Menüsünden Proje Seçiniz <a
                    href="<?php echo base_url("$this->Module_Name"); ?>">tıklayınız</a></p>
    </div>
<?php } else { ?>
    <form id="save_auction" action="<?php echo base_url("$this->Module_Name/save/$project_id"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
        </div>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/error_form"); ?>
        </div>
    </form>
<?php } ?>






