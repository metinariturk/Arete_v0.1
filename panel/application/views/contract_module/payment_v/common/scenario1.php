<script>
    function calcular(){

        var valorE = Number(document.getElementById('E').value, 10); //Bu Hakedişin Tutarı Seç

        var valorF_a = Number(document.getElementById('F_a').value, 10); //KDV Oranı Seç

        var valorF = valorE * valorF_a /100; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('F').value = valorF.toFixed(2); // KDV Tutarı Yaz

        var valorG = valorF + valorE; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('G').value = valorG.toFixed(2); // KDV Tutarı Yaz

        var valorKES_a_s = Number(document.getElementById('KES_a_s').value, 10); //Stopaj Oranı Seç
        var valorKES_a = valorKES_a_s * valorE / 100; // Stopaj Oranı Hesap
        document.getElementById('KES_a').value = valorKES_a.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_b_s = Number(document.getElementById('KES_b_s').value, 10); //Stopaj Oranı Seç
        var valorKES_b = valorKES_b_s * valorE / 100; // Stopaj Oranı Hesap
        document.getElementById('KES_b').value = valorKES_b.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_c_s = document.getElementById('KES_c_s').value; // Örneğin: "4/10"
        var kesirParcalari = valorKES_c_s.split('/'); // Kesir ifadesini parçalar
        if (valorKES_c_s === "" || valorKES_c_s === "0") {
            valorKES_c_s = 0; // Boş veya 0 değeri için varsayılan olarak 0 atanır.
        } else if (kesirParcalari.length === 2) {
            var pay = parseFloat(kesirParcalari[0]);
            var payda = parseFloat(kesirParcalari[1]);
            if (!isNaN(pay) && !isNaN(payda) && payda !== 0) {
                var sonuc = pay / payda; // Kesiri sayıya dönüştür
                valorKES_c_s = sonuc;
                var valorKES_c = valorKES_c_s * valorF; // Stopaj Oranı Hesap
                document.getElementById('valorKES_c').value = valorKES_c.toFixed(2); //  Stopaj Oranı Yaz
            } else {
                console.error("Geçersiz kesir ifadesi");
            }
        } else {
            console.error("Kesir ifadesini çözme hatası");
        }
    }
</script>