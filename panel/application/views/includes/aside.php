<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper" style="height: 74px;">
            <a href="<?php echo base_url(); ?>"><img class="mg-fluid for-light" width="100px"
                                                     src="<?php echo base_url("assets"); ?>/images/logo/logo.png"
                                                     alt=""><img
                        class="img-fluid for-dark" width="100px"
                        src="<?php echo base_url("assets"); ?>/images/logo/logo_dark.png"
                        alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
            </div>
        </div>
        <div class="logo-icon-wrapper"><a href="<?php echo base_url(); ?>">
                <img class="img-fluid"
                     src="<?php echo base_url("assets"); ?>/images/logo/logo-icon.png"
                     alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="<?php echo base_url(); ?>">
                            <img class="img-fluid"
                                 src="<?php echo base_url("assets"); ?>/images/logo/logo-icon.png"
                                 alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>
                    <?php $this->load->view("includes/aside_array"); ?>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>