

<div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h3 class="text-white">Projeler</h3>
        <!-- Buton ve modal content -->
        <div>
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgetbootstrap">
                <i class="fa fa-plus"></i> Yeni Proje
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalgetbootstrap" tabindex="-1" role="dialog" aria-labelledby="exampleModalgetbootstrap" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-toggle-wrapper social-profile text-start dark-sign-up">
                            <h3 class="modal-header justify-content-center border-0">Yeni Proje Oluştur</h3>
                            <div class="modal-body">
                                <form class="row g-3 needs-validation" novalidate="" action="<?php echo base_url('Project/save/'); ?>" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <div class="col-form-label">Proje Kodu</div>
                                        <div class="input-group">
                                            <span class="input-group-text">PRJ - </span>
                                            <input type="text" class="form-control <?php cms_isset(form_error('project_code'), 'is-invalid', ''); ?>" placeholder="Proje Kodu" readonly value="<?php echo isset($form_error) ? set_value('project_code') : $next_project_name; ?>" name="project_code">
                                        </div>
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error('project_code'); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <input class="form-control <?php echo cms_isset(form_error('project_name'), 'is-invalid', ''); ?>" placeholder="Proje Adı" aria-describedby="inputGroupPrepend" name="project_name" value="<?php echo isset($form_error) ? set_value('project_name') : ''; ?>">
                                        <?php if (isset($form_error)) { ?>
                                            <div class="invalid-feedback"><?php echo form_error('project_name'); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="mb-3">
                                        <select id="select2-demo-1" style="width: 100%;" class="form-control <?php echo cms_isset(form_error('department'), 'is-invalid', ''); ?>" data-plugin="select2" name="department">
                                            <option selected="selected">Seçiniz</option>
                                            <?php $departments = get_as_array($this->settings->department);
                                            foreach ($departments as $department) { ?>
                                                <option><?php echo $department; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="notes" placeholder="Genel Açıklama">
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">Proje Oluştur</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Sekmeler -->
        <ul class="nav nav-tabs" id="projectTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#project_active" role="tab">Tüm Projeler</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#project_inactive"
                   role="tab">Biten Projeler</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#project_all" role="tab">Devam Eden Projeler</a>
            </li>
        </ul>

        <!-- Sekme İçerikleri -->
        <div class="tab-content mt-3" id="projectTabsContent">

            <!-- Devam Eden Sözleşmeler -->
            <div class="tab-pane fade show active" id="project_active" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("project_v/list/tabs/all"); ?>
                </div>
            </div>
            <!-- Biten Sözleşmeler -->
            <div class="tab-pane fade" id="project_inactive" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("project_v/list/tabs/inactive"); ?>
                </div>
            </div>
            <!-- Tüm Sözleşmeler -->
            <div class="tab-pane fade" id="project_all" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("project_v/list/tabs/active"); ?>
                </div>
            </div>
        </div>
    </div>
</div>


