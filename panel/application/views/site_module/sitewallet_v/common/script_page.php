<script>
function addSelect() {
  var T = document.getElementById('xTable');

  var R = document.querySelectorAll('tbody .row')[0];

  var C = R.cloneNode(true);

  T.appendChild(C);

}
</script>

<script>
    function calcular(){
        var valorA = parseFloat(document.getElementById('calA').value, 10); //A Hücresi Veri Giriş
        var valorB = parseFloat(document.getElementById('calB').value, 10); //B Hücresi Veri Giriş
        var valorC = valorB-valorA; //C Hücresi Hesaplama
        if (valorB > 0 ) {
            document.getElementById('calC').innerHTML= valorC.toFixed(2);
        } else {
            document.getElementById('calC').innerHTML= 0;
        }
    }

    function myFunction(e) {
        e.value=e.value.replace(/,/g, '.')
    }

</script>