<ul id="todo-list" class="image_list_container">
    <?php foreach ($notes as $note) { ?>
        <li class="task <?php cms_if_echo($note->isActive, "1", "", "completed"); ?>">
            <div class="task-container">
                <span class="task-label"><?php echo $note->note; ?></span>
                <span class="task-action-btn">
                    <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                       url="<?php echo base_url("dashboard/delete/$note->id"); ?>">
                        <span class="action-box large delete-btn" title="Delete Task">
                          <i class="icon">
                              <i class="icon-trash"></i>
                          </i>
                        </span>
                    </a>
                    <a>
                        <span class="action-box large complete-btn isActive"
                              url="<?php echo base_url("dashboard/isActiveSetter/$note->id"); ?>"
                              onclick="todoCheck(this)"
                              title="Mark <?php cms_if_echo($note->isActive, "1", "Incomplete", "Complete"); ?>">
                              <i class="icon">
                                <i class="icon-check"></i>
                              </i>
                        </span>
                    </a>
                  </span>
            </div>
        </li>
    <?php } ?>
</ul>
