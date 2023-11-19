<div class="todo-list-wrapper">
    <div class="todo-list-container">
        <div class="mark-all-tasks">
            <button onclick="todoCheck(this)"
                    url="<?php echo base_url("dashboard/delete_all"); ?>"
                    class="btn btn-pill btn-outline-danger btn-air-danger btn-xs"
                    type="button">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="todo-list-body">
            <ul id="todo-list" class="image_list_container">
                <?php foreach ($notes as $note) { ?>
                    <li class="task <?php cms_if_echo($note->isActive, "1", "", "completed"); ?>">
                        <div class="task-container">
                            <span class="task-label"><?php echo $note->note; ?></span>
                            <span class="task-action-btn">
                                <button
                                        url="<?php echo base_url("dashboard/delete/$note->id"); ?>"
                                        onclick="todoCheck(this)"
                                        class="btn btn-pill btn-outline-danger btn-air-danger btn-xs"
                                        type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <form id="task_form" name="task_form"
              action="<?php echo base_url("$this->Module_Name/save_note"); ?>"
              method="post">
            <input id="new_task" name="note" class="form-control" placeholder="Buraya yeni not yazınız"/>
        </form>
        <button form-id="task_form" onclick="add_note(this)" class="btn btn-primary">Notu Ekle</button>
    </div>
</div>




