<script src="<?php echo base_url("assets"); ?>/js/todo/todo.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/tooltip-init.js"></script>
<script>
    function asd() {
        document.getElementById('task_form').submit();
    }

    function todoCheck(btn) {
        var $url = btn.getAttribute('url');
        $.post($url, {}, function (response) {
        })
    }
</script>
