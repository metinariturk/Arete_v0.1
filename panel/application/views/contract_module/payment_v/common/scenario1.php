<script>
    function calcular() {


        var valorE = Number(document.getElementById('E').value, 10); //Bu Hakedişin Tutarı Seç

        var valorF_a = Number(document.getElementById('F_a').value, 10); //KDV Oranı Seç

        var valorF = valorE * valorF_a / 100; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('F').value = valorF.toFixed(2); // KDV Tutarı Yaz

        var valorG = valorF + valorE; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('G').value = valorG.toFixed(2); // KDV Tutarı Yaz

        var valorKES_a_s = Number(document.getElementById('KES_a_s').value, 10); //Stopaj Oranı Seç
        var valorKES_a = valorKES_a_s * valorE / 100; // Stopaj Oranı Hesap
        document.getElementById('KES_a').value = valorKES_a.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_b_s = Number(document.getElementById('KES_b_s').value, 10); //Stopaj Oranı Seç
        var valorKES_b = valorKES_b_s * valorE / 100; // Stopaj Oranı Hesap
        document.getElementById('KES_b').value = valorKES_b.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_c_s = Number(document.getElementById('KES_c_s').value, 10); //Stopaj Oranı Seç
        var valorKES_c = valorKES_c_s * valorF; // Stopaj Oranı Hesap
        document.getElementById('KES_c').value = valorKES_c.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_d = Number(document.getElementById('KES_d').value, 10); //Stopaj Oranı Seç

        var valorKES_e_s = Number(document.getElementById('KES_e_s').value, 10); //Stopaj Oranı Seç
        var valorKES_e = valorKES_e_s * valorE / 100; // Stopaj Oranı Hesap
        document.getElementById('KES_e').value = valorKES_e.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_f = Number(document.getElementById('KES_f').value, 10); //Stopaj Oranı Seç
        var valorKES_g = Number(document.getElementById('KES_g').value, 10); //Stopaj Oranı Seç
        var valorKES_h = Number(document.getElementById('KES_h').value, 10); //Stopaj Oranı Seç
        var valorKES_i = Number(document.getElementById('KES_i').value, 10); //Stopaj Oranı Seç
        var valorH = valorKES_c_s + valorKES_a + valorKES_b + valorKES_c + valorKES_d + valorKES_e + valorKES_f + valorKES_g + valorKES_h + valorKES_i; // Stopaj Oranı Hesap
        document.getElementById('H').value = valorH.toFixed(2); //  Stopaj Oranı Yaz

        var valorI_s = Number(document.getElementById('I_s').value, 10); //Avans Mahsup Oranı Seç
        var valorI = valorI_s * valorE / 100; // Avans Mahsup Hesap
        document.getElementById('I').value = valorI.toFixed(2); // Avans Mahsup Yaz

        var valorX = valorG - valorH - valorI; // Stopaj Oranı Hesap
        document.getElementById('X').value = valorX.toFixed(2); // Avans Mahsup Yaz

        var valorA = Number(document.getElementById('A').value, 10); //Bu Hakedişin Tutarı Seç

        var valorB = Number(document.getElementById('B').value, 10); //Bu Hakedişin Tutarı Seç

        var valorC = valorA + valorB; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('C').value = valorC.toFixed(2); // KDV Tutarı Yaz


    }
</script>