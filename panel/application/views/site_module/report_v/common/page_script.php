<script src="<?php echo base_url("assets");?>/js/owlcarousel/owl.carousel.js"></script>
<script src="<?php echo base_url("assets");?>/js/ecommerce.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/jquery.repeater.js"></script><!--Form Inputs-->

<script>
    $(document).ready(function () {
        $('.repeater').repeater({
            // (Required if there is a nested repeater)
            // Specify the configuration of the nested repeaters.
            // Nested configuration follows the same format as the base configuration,
            // supporting options "defaultValues", "show", "hide", etc.
            // Nested repeaters additionally require a "selector" field.
            repeaters: [{
                // (Required)
                // Specify the jQuery selector for this nested repeater
                selector: '.inner-repeater'
            }],
            hide: function (deleteElement) {
                if(confirm('Bu satırı Silmek İstediğinize Emin Misiniz?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });
    });
</script>


<script>
    $(document).ready(function(){
        var owl = $('#sync1');
        owl.owlCarousel({
            // Owl Carousel ayarlarını buraya ekleyin
        });

        // Klavye olayları
        $(document).on('keydown', function(e) {
            if (e.keyCode == 37) {
                owl.trigger('prev.owl.carousel'); // Sol ok (geri git)
            } else if (e.keyCode == 39) {
                owl.trigger('next.owl.carousel'); // Sağ ok (ileri git)
            }
        });
    });
</script>
