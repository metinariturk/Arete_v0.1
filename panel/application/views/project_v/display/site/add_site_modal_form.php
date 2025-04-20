<div class="modal fade" id="AddSiteModal" role="dialog" aria-labelledby="AddSiteModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Şantiye</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSiteForm"
                      data-form-url="<?php echo base_url("Project/create_site/$item->id"); ?>"
                      method="post" enctype="multipart/form-data" autocomplete="off">
                    <div id="add_Site_input">
                        <?php $this->load->view("project_v/display/site/add_site_form_input"); ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary"
                        onclick="submit_modal_form('addSiteForm', 'AddSiteModal', 'site_table' ,'add_Site_input')">
                    Gönder
                </button>
            </div>
        </div>
    </div>
</div>
