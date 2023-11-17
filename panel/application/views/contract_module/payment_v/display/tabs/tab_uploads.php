<div class="fade tab-pane <?php if ($active_tab == "uploads") {
    echo "active show";
} ?>"
     id="uploads" role="tabpanel"
     aria-labelledby="uploads-tab">
    <div class="card">
        <div class="row">
            <div class="col-xl-4 col-md-5 box-col-6">
                <div class="card-body">
                    <div class="file-content">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-md-7 box-col-6">
                <div class="card-body">
                    <div class="file-content">
                        <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/file_list_v"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





