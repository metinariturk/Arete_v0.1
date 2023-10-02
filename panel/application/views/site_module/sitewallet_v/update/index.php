<!DOCTYPE html>
<html lang="tr">
<head>
    <?php $this->load->view("includes/head"); ?>
</head>

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
<script>
    function deleteRow(rowid)
    {
        var row = document.getElementById(rowid);
        row.parentNode.removeChild(row);
    }
</script>



</body>
</html>