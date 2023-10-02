<div class="card">
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <h3 class="text-center">
                İş Grupları<button class="btn" type="button" data-bs-toggle="modal" data-bs-target="#main_category" data-whatever="@getbootstrap">
                    <i class="fa fa-plus"></i>
                </button>
                <div class="modal fade" id="main_category" tabindex="-1" role="dialog" aria-labelledby="main_category" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Yeni İş Grubu</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="category" action="<?php echo base_url("$this->Module_Name/add_main"); ?>"
                                      url="<?php echo base_url("$this->Module_Name/add_main"); ?>"
                                      method="post" enctype="multipart" autocomplete="off">
                                    <div class="mb-3">
                                        <label class="col-form-label" for="recipient-name">Ana İş Grubu:</label>
                                        <input type="text" name="main_group" placeholder="İş Grubu Adı" class="form-control"/>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">İptal</button>
                                <span class="btn btn-primary" type="button" id="submitBtn" data-bs-dismiss="modal" onclick="main(this)" form-id="category">Kaydet
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </h3>
            <hr>
        </div>


        <div class="refresh_list">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/list"); ?>
        </div>
    </div>
</div>

