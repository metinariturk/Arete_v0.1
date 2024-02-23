<div class="fade tab-pane <?php if ($active_tab == "puantaj") {
    echo "active show";
} ?>"
     id="puntaj" role="tabpanel"
     aria-labelledby="workgroup-tab">
    <div class="card mb-0">
        <div class="card-body">
            <div class="puantaj_list">
                <form id="puantaj_form"
                      action="<?php echo base_url("$this->Module_Name/update_puantaj"); ?>" method="post"
                      enctype="multipart/form-data" autocomplete="off">
                    <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/puantaj_liste"); ?>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function savePuantaj(btn) {
        var formId = "puantaj_form"; // doğru form ID'si olduğundan emin olun
        var formData = new FormData(document.getElementById(formId));
        var url = document.getElementById(formId).getAttribute('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Assuming the response contains the updated content
                $(".puantaj_list").html(response);

                // Clear input fields after successful submission
                document.getElementById(formId).reset();
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>