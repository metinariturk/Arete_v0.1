<div class="row content-container">
    <div id="right" class="text-right">
        <a class="pager-btn btn btn-info btn-outline"
           href="<?php echo base_url("$this->Module_Name/select"); ?>">
            <i class="fa fa-plus-square"></i> Yeni Şantiye
        </a>
    </div>
</div>

<div class="col-md-12">
    <div class="widget">
        <div class="widget-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/list"); ?>
        </div>
    </div>
</div>


