<script src="<?php echo base_url("assets"); ?>/assets/js/news.js"></script>

<?php foreach (getControllerList() as $controllerName) {

    echo "<script>
    $('input.check".array_search($controllerName, getControllerList())."').click(function(){
        $('input.".array_search($controllerName, getControllerList())."').prop('checked',this.checked)
    })
</script>";


} ?>

