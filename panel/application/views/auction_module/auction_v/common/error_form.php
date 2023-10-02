<div class="col-md-12">
    <?php if (isset($form_error)) { ?>
        <?php $errors = $this->form_validation->error_array();
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        ?>
    <?php } ?>
</div>