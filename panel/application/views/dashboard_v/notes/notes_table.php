<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="card email-body radius-left">
                    <div class="ps-0">
                        <div class="card mb-0">
                            <div class="card-header d-flex">
                                <h5 class="mb-0">Notlar</h5>
                                <i data-feather="trash" style="cursor: pointer;" class="ms-auto"
                                   onclick="confirmDelete('<?php echo base_url("Dashboard/delete_all_notes/"); ?>', 'Tüm Notları' ,'#notes_table')"
                                >Tümünü Sil</i>
                                <i data-feather="plus" style="cursor: pointer;" data-bs-toggle="modal"
                                   id="openNotesModal"
                                   data-bs-target="#AddNotesModal"></i>
                            </div>
                            <div class="card-body p-4">
                                <table id="notesTable" class="table" style="width:100%">
                                    <?php foreach ($notes as $note) { ?>
                                        <tr>
                                            <td class="w5">
                                                <h6 class="task_title_0">
                                                    <a href="javascript:void(0);"
                                                       onclick="changeStat('<?php echo base_url("Dashboard/change_status/$note->id"); ?>', '#notes_table')"
                                                       title="Sil">
                                                        <?php cms_if_echo($note->isActive, "1", "<i data-feather='x'></i>", "<i data-feather='check'></i>"); ?>                                                    </a>
                                                </h6>
                                            </td>
                                            <td class="w10">
                                                <h6 class="task_title_0 <?php echo ($note->isActive == 0) ? 'cizili' : ''; ?>">
                                                    <?php echo $note->title; ?>
                                                </h6>
                                                <p class="project_name_0 <?php echo ($note->isActive == 0) ? 'cizili' : ''; ?>">
                                                    <?php echo $note->topic; ?>
                                                </p>
                                            </td>
                                            <td class="w60">
                                                <p class="task_desc_0 <?php echo ($note->isActive == 0) ? 'cizili' : ''; ?>">
                                                    <?php echo $note->note; ?>
                                                </p>
                                                <p class="project_name_0 <?php echo ($note->isActive == 0) ? 'cizili' : ''; ?>">
                                                    <?php echo dateFormat_dmy($note->reminder); ?>
                                                </p>
                                            </td>
                                            <td class="w30c">
                                                <a data-bs-toggle="modal" class="text-primary"
                                                   id="open_edit_notes_modal_<?php echo $note->id; ?>"
                                                   onclick="edit_modal_form('<?php echo base_url("Dashboard/open_edit_notes_modal/$note->id"); ?>','edit_notes_modal','EditNotesModal')">
                                                    <i data-feather="edit"></i>
                                                </a>
                                                <i data-feather="share"></i>
                                                <a href="javascript:void(0);"
                                                   onclick="confirmDelete('<?php echo base_url("Dashboard/delete_notes/$note->id"); ?>', '#notes_table')"
                                                   title="Sil">
                                                    <i data-feather="trash-2"></i>
                                                </a>
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

