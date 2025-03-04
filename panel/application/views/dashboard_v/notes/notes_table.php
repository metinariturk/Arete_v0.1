<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="card email-body radius-left">
                    <div class="ps-0">
                        <div class="card mb-0">
                            <div class="card-header d-flex">
                                <h5 class="mb-0">Notlar</h5>
                                <i data-feather="trash" class="ms-auto">Tümünü Sil</i>
                            </div>
                            <div class="card-body p-4">
                                <table class="table">
                                    <?php foreach ($notes as $note) { ?>
                                        <tr>
                                            <td class="w5">
                                                <h6 class="task_title_0">
                                                    <?php cms_if_echo($note->isActive, "1", "<i data-feather='x'></i>", "<i data-feather='check'></i>"); ?>
                                                </h6>
                                            </td>
                                            <td class="w10">
                                                <h6 class="task_title_0">Başlık</h6>
                                                <p class="project_name_0">Konu</p>
                                            </td>
                                            <td class="w60">
                                                <p class="task_desc_0"><?php echo $note->note; ?></p>
                                            </td>
                                            <td class="w30c">
                                                <i data-feather="edit"></i>
                                                <i data-feather="share"></i>
                                                <i data-feather="trash-2"></i>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

