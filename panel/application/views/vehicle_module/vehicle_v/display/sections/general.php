<div class="row">
    <div class="col-sm-8">
        <div class="widget">
            <hr class="widget-separator">
            <div class="widget-body">
                <div class="profile-header">
                    <div id="center" class="text-center">
                        <div>
                            <?php $avatars = (directory_map("$this->File_Dir_Prefix/$item->id/avatar"));
                            if (!empty($avatars)) { ?>
                                <a href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                    <img width="350" style="border-radius: 25px;"
                                         src="<?php $avatars = (directory_map("$this->File_Dir_Prefix/$item->id/avatar"));
                                         echo base_url("$this->File_Dir_Prefix/$item->id/avatar/$avatars[0]"); ?>"
                                         alt="avatar"/>
                                </a>
                            <?php } else { ?>
                                <a href="<?php echo base_url("$this->Module_Name/update_form/$item->id"); ?>">
                                    <i class="fas fa-tractor fa-7x"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="text-center">
                        <h4><a href="javascript:void(0)" class="title-color"><?php echo $item->plaka; ?></a></h4>
                        <h4><a href="javascript:void(0)" class="title-color"><?php echo $item->marka; ?>
                                - <?php echo $item->ticari_ad; ?></a></h4>
                        <div>
                            <?php cms_if_echo($item->kiralik, "1", "Kiralık", "Sahibi"); ?>
                            <br>
                            <?php cms_if_echo($item->kiralik, "1", company_name($item->sahibi), ""); ?>
                            <br>
                            <?php if ($item->yakit == 0) {
                                echo "Benzin";
                            } elseif ($item->yakit == 1) {
                                echo "Dizel";
                            } ?>
                        </div>
                    </div>

                </div><!-- .profile-cover -->
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="widget">
            <hr class="widget-separator">
            <div class="widget-body">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/add_document"); ?>
            </div>
            <div class="widget-body image_list_container">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/$this->Common_Files/ruhsat_list_v"); ?>
            </div>
        </div>
    </div>
</div>
