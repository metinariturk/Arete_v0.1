<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_style"); ?>
    <?php $this->load->view("includes/drag_drop_style"); ?>

    <?php $this->load->view("includes/head"); ?>
</head>
<body class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<?php $this->load->view("includes/wrapper"); ?>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">
            <?php $this->load->view("{$viewModule}/{$viewFolder}/display/content"); ?>
        </div>
    </div>
</div>
<?php $this->load->view("includes/footer"); ?>

<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("includes/include_datatable"); ?>

<?php $this->load->view("{$viewModule}/{$viewFolder}/common/page_script"); ?>

<?php
// Modül adları ve karşılık gelen tab ve modal ID'lerini tanımlayın
$tabMapping = [
    "Payment" => ['tab' => '#pills-payments-tab', 'modal' => '#modalPayment'],
    "Collection" => ['tab' => '#pills-collection-tab', 'modal' => '#modalCollection'],
    "Advance" => ['tab' => '#pills-advance-tab', 'modal' => '#modalAdvance'],
    "Update" => ['tab' => '#pills-info-tab', 'modal' => '#updateFormModal'],
    "Bond" => ['tab' => '#pills-bond-tab', 'modal' => '#modalBond'],
    "Price" => ['tab' => '#pills-price-tab', 'modal' => null],
    "Contract_price" => ['tab' => '#ppills-contract_price-tab', 'modal' => '#modalAdvance']
];

// Aktif modül için tab ve modal ayarlarını belirleyin
$activeTab = isset($tabMapping[$active_module]) ? $tabMapping[$active_module]['tab'] : null;
$activeModal = isset($tabMapping[$active_module]) ? $tabMapping[$active_module]['modal'] : null;
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tabId = '<?php echo $activeTab; ?>';
        var modalId = '<?php echo $activeModal; ?>';
        var errorForm = '<?php echo $form_error; ?>';

        // Tab'ı göster
        if (tabId) {
            var tabTrigger = new bootstrap.Tab(document.querySelector(tabId));
            tabTrigger.show();
        }

        // Modal'ı göster (sadece modalId null değilse)
        if (errorForm === '1' && modalId && modalId !== 'null') {
            if ($(modalId).length) {
                $(modalId).modal('show');
            } else {
                console.error('Modal not found:', modalId);
            }
        }
    });
</script>




</body>
</html>
<?php $this->session->set_flashdata("alert", null); ?>





