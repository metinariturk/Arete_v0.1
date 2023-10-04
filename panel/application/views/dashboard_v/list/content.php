<div class="row">

    <div class="col-xl-6 xl-100 box-col-12">
        <div class="card">
            <div class="card-header">
                <h5>Hızlı Erişim</h5>
            </div>
            <div class="card-body">
                <ol>
                    <?php foreach ($favorites as $favorite) { ?>
                        <li>
                            <a href="<?php echo base_url("$favorite->module/$favorite->view/$favorite->module_id"); ?>">
                                <?php echo $favorite->title; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ol>

            </div>
        </div>
    </div>
    <div class="col-xl-6 xl-100 box-col-12">
        <div class="card">
            <div class="cal-date-widget card-body">
                <div class="row">
                    <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
                        <div class="cal-info text-center">
                            <h2><?php echo date("d"); ?></h2>
                            <div class="d-inline-block mt-2"><span
                                        class="b-r-dark pe-3"></span><?php echo ay_isimleri(date("m")); ?><span
                                        class="ps-3"><?php echo date("Y"); ?></span></div>
                            <p class="mt-4 f-16 text-muted">
                                <?php $idiom = random_idioms(); ?>
                                <?php echo get_from_any("idioms", "idiom", "id", $idiom); ?>
                            </p>
                            <p class="mt-3 f-14 text-muted" style="text-align: right">
                                <?php echo get_from_any("idioms", "owner", "id", $idiom); ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xs-12 col-md-6 col-sm-6">
                        <div class="cal-datepicker">
                            <div class="datepicker-here float-sm-end" data-language="tr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 xl-100 box-col-12">
        <div class="card">
            <div class="card-header">
                <h5>Not Defteri</h5>
            </div>
            <div class="card-body">
                <div class="todo">
                    <div class="todo-list-wrapper">
                        <div class="todo-list-container">
                            <div class="mark-all-tasks">
                                <div>
                                    <a>
                                    <span class="mark-all-btn"
                                          id="mark-all-finished"
                                          url="<?php echo base_url("dashboard/checkall/0"); ?>"
                                          role="button"
                                          onclick="todoCheck(this)">
                                        <span class="btn-label">
                                           Tümü Tamamlandı İşaretle
                                        </span>
                                        <span class="action-box">
                                            <i class="fa fa-times fa-lg"></i>
                                        </span>
                                    </span>
                                    </a>
                                </div>
                                <span class="mark-all-btn"
                                      url="<?php echo base_url("dashboard/checkall/1"); ?>"
                                      onclick="todoCheck(this)"
                                      id="mark-all-incomplete"
                                      role="button">
                                        <span class="btn-label">
                                           Tümü Tamamlanmadı İşaretle
                                        </span>
                                        <span class="action-box">
                                            <i class="icon"><i class="icon-check"></i></i>
                                        </span>
                                    </span>
                            </div>
                            <div class="todo-list-body">
                                <?php $this->load->view("{$viewFolder}/list/todo"); ?>
                            </div>

                            <div class="todo-list-footer">
                                <div class="add-task-btn-wrapper"><span class="add-task-btn">
                                <button class="btn btn-primary"><i class="icon-plus"></i>Yeni Not Ekle</button></span>
                                </div>
                                <div class="new-task-wrapper">
                                    <form id="task_form" name="task_form"
                                          action="<?php echo base_url("$this->Module_Name/save_note"); ?>"
                                          method="post">
                                        <textarea id="new_task" name="note"
                                                  placeholder="Buraya yeni not yazınız"></textarea>
                                    </form>
                                    <span
                                            class="btn btn-danger cancel-btn" id="close-task-panel">Vazgeç</span>

                                    <button class="btn btn-primary" onclick="asd()">Notu Ekle</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notification-popup hide">
                        <p><span class="task"></span><span class="notification-text"></span></p>
                    </div>
                </div>
                <!-- HTML Template for tasks-->
                <script id="task-template" type="tect/template">
                    <li class="task">
                        <div class="task-container">
                            <h4 class="task-label"></h4>
                            <span class="task-action-btn">
                      <span class="action-box large delete-btn" title="Delete Task">
                      <i class="icon"><i class="icon-trash"></i></i>
                      </span>
                      <span class="action-box large complete-btn" title="Mark Complete">
                      <i class="icon"><i class="icon-check"></i></i>
                      </span>
                      </span>
                        </div>
                    </li>
                </script>
            </div>
        </div>
    </div>

    <div class="col-xl-6 xl-100 box-col-12">
        <div class="card">
            <div class="card-header">
                <h5>Son İşlemler</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Dosya</th>
                        <th>Türü</th>
                        <th colspan="3" class="text-center">Adı</th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <th class="text-center">Sözleşme/Teklif</th>
                        <th class="text-center">Proje</th>
                        <th class="text-center">İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;
                    foreach ($last_created_elements as $last_created_element) { ?>
                        <tr>
                            <td>
                                <?php echo module_name($last_created_element->module); ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$last_created_element->module/file_form/$last_created_element->connected_module_id"); ?>">
                                    <?php echo $last_created_element->file_order; ?>
                                </a>
                            </td>
                            <td class="text-center"><?php
                                if (isset($last_created_element->connected_contract_id)) { ?>
                                    <a href="<?php echo base_url("contract/file_form/$last_created_element->connected_contract_id"); ?>"> <?php echo contract_name($last_created_element->connected_contract_id); ?></a>
                                <?php } elseif (isset($last_created_element->connected_auction_id)) { ?>
                                    <a href="<?php echo base_url("auction/file_form/$last_created_element->connected_auction_id"); ?>"><?php echo auction_name($last_created_element->connected_auction_id); ?></a>
                                <?php } ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if (isset($last_created_element->connected_contract_id)) { ?>
                                    <a href="<?php echo base_url("project/file_form/" . project_id_cont($last_created_element->connected_contract_id) . ""); ?>">
                                        <?php echo project_name(project_id_cont($last_created_element->connected_contract_id)); ?>
                                    </a>
                                <?php } elseif (isset($last_created_element->connected_auction_id)) { ?>
                                    <a href="<?php echo base_url("project/file_form/" . project_id_auc($last_created_element->connected_auction_id) . ""); ?>">
                                        <?php echo project_name(project_id_auc($last_created_element->connected_auction_id)); ?>
                                    </a>
                                <?php } elseif ($last_created_element->module == "project") { ?>
                                    <a href="<?php echo base_url("project/file_form/$last_created_element->connected_module_id"); ?>">
                                        <?php echo project_name($last_created_element->connected_module_id); ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center"><?php
                                if (isset($last_created_element->deletedAt)) {
                                    echo "Silindi";
                                } elseif ((isset($last_created_element->updatedAt)) and (empty($last_created_element->deletedAt))) {
                                    echo "Güncellendi";
                                } else {
                                    echo "Oluşturuldu";
                                }
                                ?>
                            </td>


                        </tr>
                        <?php if (++$i == 5) break; ?>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="card-body">

            </div>
        </div>
    </div>

</div>