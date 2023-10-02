<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="file-sidebar">
                        <ul>
                            <li>
                                <div class="btn btn-light">
                                    <a href="<?php echo base_url("project/file_form/$project_id"); ?>">
                                        <i data-feather="home"></i>
                                        <?php echo project_code_name($project_id); ?>
                                    </a>

                                </div>
                            </li>
                            <li>
                                <div class="btn btn-light">
                                <span style="padding-left: 20px">
                                    <i class="icon-gallery"></i>
                                     <a href="<?php echo base_url("contract/file_form/$contract_id"); ?>">
                                         <?php echo contract_code_name($contract_id); ?>
                                    </a>

                                </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-6">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Aşağıdaki İçerikler Silinmeden Bu İşlemi Yapamazsınız</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <?php $errors = json_decode($item->error_list); ?>
            <?php foreach ($errors as $error) { ?>
                <?php $error_parts = explode("*", $error); ?>
                <?php $module_name = $error_parts[0]; ?>
                <?php $module_id = $error_parts[1]; ?>
                <?php $file_name = get_from_any("$module_name", "dosya_no", "id", "$module_id"); ?>
                <div class="col-md-3">
                    <a href="<?php echo base_url("$module_name/file_form/$module_id"); ?>">
                        <div class="card" style="margin-center: 10px; !important;">
                            <div style="margin: 20px">
                                <?php echo $file_name; ?><br>
                                <?php echo module_name($module_name); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>



