<?php $user = get_active_user(); ?>

<div class="col-12">
    <div class="row">
        <div class="col-4">
            <h4 class="module-title"><?php echo $this->Module_Title; ?></h4>
        </div>
        <div class="col-8 d-flex justify-content-end">
            <div class="row">
                <div class="col-md-3 justify-content-end">
                    <div class="mode">
                        <a onclick="changeMode(this)"
                           url="<?php echo base_url("User/mode"); ?>"
                           id="myBtn">
                            <i class="fa fa-moon-o" style="font-size: 1.66em;"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 justify-content-end">
                    <a href="#!" onclick="javascript:toggleFullScreen()"><i
                                data-feather="maximize"></i></a>
                </div>
                <div class="col-md-3 justify-content-end" style="margin-top: -4px">
                    <a href="<?php echo base_url("user/file_form/$user->id"); ?>">
                        <img class="img-50 img-fluid m-r-20 rounded-circle update_img_1"
                            <?php echo get_avatar($user->id); ?> alt=""></a>
                </div>
                <div class="col-md-3 justify-content-end">
                    <a href="<?php echo base_url("logout"); ?>"><i
                                data-feather="log-in"> </i></a>
                </div>
            </div>
        </div>
    </div>
</div>

