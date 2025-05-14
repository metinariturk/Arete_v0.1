<div class="container-fluid">
    <div class="email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-12 col-md-12 box-col-12">
                <div class="card email-body radius-left">
                    <div class="ps-0">
                        <div class="card mb-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Notlar</h5>

                                <div class="todo-list-footer mb-3 text-end">
                                      <span class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('<?php echo base_url("Dashboard/delete_all_notes/"); ?>', 'Tüm Notları', '#notes_table')">
                                    <i class="icon-trash"></i> Tümünü Sil
                                </span>
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                            id="openNotesModal"
                                            data-bs-target="#AddNotesModal">
                                        <i class="icon-plus"></i> Yeni Not
                                    </button>

                                </div>
                            </div>

                            <div class="card-body">
                                <div class="todo">
                                    <div class="todo-list-wrapper">


                                        <div class="todo-list-body">
                                            <ul id="todo-list">
                                                <?php foreach ($notes as $note) { ?>
                                                    <li class="<?php echo ($note->isActive == 0) ? 'completed' : ''; ?> task">
                                                        <div class="task-container">
                                                            <div class="task-label">
                                                                <div class="mb-2">
                                                                    <h5 class="mb-1"><?php echo $note->title; ?></h5>
                                                                    <p class="mb-1">
                                                                        <strong>Konu
                                                                            : </strong> <?php echo $note->topic; ?>
                                                                    </p>
                                                                    <p class="mb-0"><strong>Not
                                                                            : </strong><?php echo $note->note; ?></p>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                                <?php if (!empty($note->reminder)) { ?>
                                                                    <span class="badge badge-light-primary">
                                                                    <?php echo dateFormat_dmy($note->reminder); ?>
                                                                </span>
                                                                <?php } ?>
                                                                <div class="task-action-btn d-flex gap-2">
                                                                    <!-- Sil -->
                                                                    <span class="action-box delete-btn" title="Sil">
                                                                        <i class="icon-trash"
                                                                           onclick="confirmDelete('<?php echo base_url("Dashboard/delete_notes/$note->id"); ?>', 'Bu Notu', '#notes_table')">
                                                                        </i>
                                                                    </span>

                                                                    <!-- Tamamla -->
                                                                    <span class="action-box complete-btn"
                                                                          title="Tamamlandı">
                                                                        <i class="icon-check"
                                                                           onclick="changeStat('<?php echo base_url("Dashboard/change_status/$note->id"); ?>', '#notes_table')">
                                                                        </i>
                                                                    </span>

                                                                    <!-- Düzenle -->
                                                                    <span class="action-box edit-btn" title="Düzenle">
                                                                        <i class="icon-pencil"
                                                                           id="open_edit_notes_modal_<?php echo $note->id; ?>"
                                                                           onclick="edit_modal_form('<?php echo base_url("Dashboard/open_edit_notes_modal/$note->id"); ?>','edit_notes_modal','EditNotesModal')">
                                                                        </i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
