<div id="formContainer">
    <div class="card">
        <div class="card-body">
            <form id="reportForm" method="post"
                  autocomplete="off">
                <?php $this->load->view("site_module/report_v/add/sections/00_head"); ?>
                <hr>
                <div id="work_sections">
                    <?php $this->load->view("site_module/report_v/add/sections/01_workgroup"); ?>
                    <?php $this->load->view("site_module/report_v/add/sections/02_workmachine"); ?>
                    <?php $this->load->view("site_module/report_v/add/sections/03_supplies"); ?>
                    <?php $this->load->view("site_module/report_v/add/sections/04_notes"); ?>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="modern-save-btn" type="button" id="submitBtn"><i class="fa fa-save me-2"></i> Formu
                        Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

