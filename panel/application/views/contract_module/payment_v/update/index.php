<!DOCTYPE html>
<html lang="tr">
<head>
    <?php $this->load->view("includes/head"); ?>
s</head>

<body class="<?php theme_settings(); ?>">
<!--============= start main area -->

<!-- APP NAVBAR ==========-->
<?php $this->load->view("includes/navbar"); ?>
<!--========== END app navbar -->

<!-- APP ASIDE ==========-->
<?php $this->load->view("includes/aside"); ?>
<!--========== END app aside -->



<!-- APP MAIN ==========-->
<main id="app-main" class="app-main">
    <div class="wrap">
        <section class="app-content">


            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </section><!-- #dash-content -->
    </div><!-- .wrap -->

    <!-- APP FOOTER -->
    <?php $this->load->view("includes/footer"); ?>
    <!-- /#app-footer -->
</main>
<!--========== END app main -->

<?php $this->load->view("includes/include_script"); ?>
<?php if ($contract->avans_stopaj == 1) { ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/scenario1.php"); ?>
<?php } else { ?>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/scenario2.php"); ?>
<?php } ?>


</body>
</html>