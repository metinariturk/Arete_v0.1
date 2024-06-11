<form action="<?php echo base_url("settings/update/$item->id"); ?>" method="post" id="settings_form"
      enctype="multipart/form-data"
      autocomplete="off">
    <div class="col-sm-12 col-xl-12 xl-100">
        <div class="card">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>
                                Sistem Ayarları
                            </h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li>
                                    <button type="submit" form="settings_form"
                                            class="btn btn-success">
                                        <i class="fa fa-floppy-o fa-lg"></i> Kaydet
                                    </button>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2 col-xs-12">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <a class="nav-link active"
                               id="v-pills-home-tab" data-bs-toggle="pill"
                               href="#v-pills-home" role="tab"
                               aria-controls="v-pills-home"
                               aria-selected="true">Genel</a>
                            <?php $setting_tabs = array("finance", "project", "contract", "site", "auction"); ?>
                            <?php foreach ($setting_tabs as $setting_tab) { ?>
                                <a class="nav-link"
                                   id="v-pills-<?php echo $setting_tab; ?>-tab"
                                   data-bs-toggle="pill"
                                   href="#v-pills-<?php echo $setting_tab; ?>" role="tab"
                                   aria-controls="v-pills-<?php echo $setting_tab; ?>"
                                   aria-selected="false"><?php echo module_name($setting_tab); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <?php $this->load->view("{$viewFolder}/{$subViewFolder}/structure/general"); ?>
                            </div>
                            <?php foreach ($setting_tabs as $setting_tab) { ?>
                                <div class="tab-pane fade" id="v-pills-<?php echo $setting_tab; ?>" role="tabpanel"
                                     aria-labelledby="v-pills-<?php echo $setting_tab; ?>-tab">
                                    <?php $this->load->view("{$viewFolder}/{$subViewFolder}/structure/$setting_tab"); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>