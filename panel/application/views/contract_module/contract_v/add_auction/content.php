<?php
if (empty($auction)) { ?>
    <div class="alert alert-info text-center">
        <p>Lütfen Yeni <?php echo $this->Module_Title; ?> İlgili İhale veya Proje Seçiniz <a
                    href="<?php echo base_url("$this->Module_Name"); ?>">tıklayınız</a></p>
    </div>
<?php } else { ?>
    <form id="save_<?php echo $this->Module_Name; ?>_auction" action="<?php echo base_url("$this->Module_Name/save_auction/$auction->id"); ?>" method="post"
          enctype="multipart/form-data" autocomplete="off">
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/input_form_2"); ?>
        </div>
        <div class="row">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/error_form"); ?>
        </div>
    </form>
<?php } ?>