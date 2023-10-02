<script>
    function calcular(){
        var valorA = Number(document.getElementById('A').value, 10);
        var valorB = Number(document.getElementById('B').value, 10);
        var valorC = valorA * valorB;
        document.getElementById('C').value = valorC.toFixed(2);
        var valorX = Number(document.getElementById('X').value, 10);
        var valorY = Number(document.getElementById('Y').value, 10);
        valorQ = valorY - valorX;
        document.getElementById('Q').value = valorQ.toFixed(2);

        var valorZ = valorA / (valorY - valorX);
        document.getElementById('Z').value = valorZ.toFixed(6);

    }
</script>