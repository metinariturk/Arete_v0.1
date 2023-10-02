<script src="<?php echo base_url("assets"); ?>/js/datatable/datatables/datatable.custom.js"></script>

<script>
    function calcular(){
        var valorA = parseFloat(document.getElementById('calA').value, 10); //A Hücresi Veri Giriş
        var valorB = parseFloat(document.getElementById('calB').value, 10); //B Hücresi Veri Giriş
        var valorC = valorA/valorB*100; //C Hücresi Hesaplama
        var valorD = valorA/valorB*100; //C Hücresi Hesaplama
        if (valorB > 0 ) {
            document.getElementById('calC').innerHTML= valorC.toFixed(2);
            document.getElementById('calD').value = valorD.toFixed(2);
        } else {
            document.getElementById('calC').innerHTML= 0;
            document.getElementById('calD').value = 0;
        }
    }

    function myFunction(e) {
        e.value=e.value.replace(/,/g, '.')
    }

</script>

<script> function enable() {
        document.getElementById('bond_control').onchange = function() {
            document.getElementById('bond_limit').disabled = this.checked;
        };

    }
</script>