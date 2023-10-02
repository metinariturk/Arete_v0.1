<script>
    <?php if (isset($_SESSION['alert'])) { ?>
    $(document).ready(function(){
        var notify = $.notify('<i class="fa fa-bell-o"></i><strong><?php echo $_SESSION['alert']['title']; ?></strong> <?php echo $_SESSION['alert']['text']; ?>', {
            type: '<?php echo $_SESSION['alert']['type']; ?>',
            allow_dismiss: true,
            delay: 2000,
            showProgressbar: true,
            timer: 300,
            placement: {
                from: 'top',
                align: 'center'
            },
            animate:{
                enter:'animated fadeInDown',
                exit:'animated fadeOutUp'
            }
        });
    });
    <?php } ?>
</script>