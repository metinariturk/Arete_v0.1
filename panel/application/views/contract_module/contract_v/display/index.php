<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets"); ?>/css/vendors/photoswipe.css">
    <?php $this->load->view("includes/head"); ?>
</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
            <?php $this->load->view("includes/navbar_right"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/common/title"); ?>
            <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<script>
    var list = document.getElementById("ollist");
    var itemCount = list.getElementsByTagName("li").length;
    document.getElementById("result").innerHTML = itemCount;
</script>

<?php if (isset($form_errors)) { ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sayfa yüklendiğinde modalı aç
            $("#modal_payment").modal("show");
        });
    </script>
<?php } ?>
<script>
    // Sürükleyici öğeleri seç
    var dragSources = document.querySelectorAll('#dragSource');
    // Hedef alanları seç
    var dropTargets = document.querySelectorAll('.dropTarget');

    // Her bir sürükleyici öğe için sürükleme başlatma olayını ekle
    dragSources.forEach(function(dragSource) {
        dragSource.addEventListener('dragstart', function(event) {
            // Veri aktarımı sırasında taşınacak veriyi belirt
            event.dataTransfer.setData('text/plain', event.target.dataset.info);
        });
    });

    // Her bir hedef alanı için bırakma olayını ekle
    dropTargets.forEach(function(dropTarget) {
        dropTarget.addEventListener('drop', function(event) {
            // Varsayılan davranışı engelle (örneğin, bağlantıyı açmayı engelle)
            event.preventDefault();
            // Sürüklenen öğenin veri bilgisini al
            var draggedItemData = event.dataTransfer.getData('text/plain');
            // Hedef alanın veri bilgisini al
            var dropTargetData = dropTarget.dataset.info;
            // Alert ile bilgileri ekrana bastır

            var formAction = '<?php echo base_url("contract/drag_drop_price/$item->id/"); ?>' + draggedItemData + "/" + dropTargetData;

            $.post(formAction, function (response) {
                $(".price_update").html(response);
                hesaplaT();
                addInputListeners("q");
                addInputListeners("p");
            });

        });

        // Bırakma olayının varsayılan davranışını engelle
        dropTarget.addEventListener('dragover', function(event) {
            event.preventDefault();
        });
    });
</script>

</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





