<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
</head>
<body onload="startTime()" class="<?php echo  $this->Theme_mode; ?>"> 
<div class="page-body-wrapper">
    <div class="page-body">
        <!-- tap on top starts-->
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <!-- tap on tap ends-->
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <!-- error-400 start-->
            <div class="error-wrapper">
                <div class="container"><img class="img-100" src="<?php echo base_url(); ?>/assets/images/other-images/sad.png" alt="">
                    <div class="error-heading">
                        <img width="500px" src="<?php echo base_url(); ?>/assets/images/logo/login.png" alt="">
                    </div>
                    <div class="col-md-8 offset-md-2">
                        <p class="sub-content">Bu Sayfaya Erişim Yetkiniz Bulunmamaktadır</p>
                    </div>
                    <div><a class="btn btn-info-gradien btn-lg" href="<?php echo base_url(); ?>">Ana Sayfaya Geri Dön</a></div>
                </div>
            </div>
            <!-- error-400 end-->
        </div>
    </div>
    <?php $this->load->view("includes/footer"); ?>
</div>
</body>
</html>


