<script>
    function calcular() {
        var valorA = Number(document.getElementById('A').value, 10); //Bu Hakedişin Tutarı Seç

        var valorA1 = Number(document.getElementById('A1').value, 10); //Bu Hakedişin Tutarı Seç

        var valorB = Number(document.getElementById('B').value, 10); //Bu Hakedişin Tutarı Seç

        var valorB1 = Number(document.getElementById('B1').value, 10); //Bu Hakedişin Tutarı Seç

        var valorC = valorA + valorA1 + valorB + valorB1; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('C').value = valorC.toFixed(2); // KDV Tutarı Yaz

        var valorD = Number(document.getElementById('D').value, 10); //Bir önceki hakedişleri toplamı yaz

        var valorE = valorC - valorD; //Bu Hakediş Tutarı Hesapla

        document.getElementById('E').value = valorE.toFixed(2); // Bu Hakediş Tutarı Yazı

        var valorF_a = Number(document.getElementById('F_a').value, 10); //KDV Oranı Seç

        var valorF = valorE * valorF_a / 100; //Bu Hakediş*KDV Oranı Hesapla
        document.getElementById('F').value = valorF.toFixed(2); // KDV Tutarı Yaz

        var valorG = valorF + valorE; //Taahhuk Hesapla
        document.getElementById('G').value = valorG.toFixed(2); // Taahhuk Tutarı Yaz

        var valorI_s = Number(document.getElementById('I_s').value, 10); //Avans Mahsup Oranı Seç
        var valorI = valorI_s * valorA / 100; // Avans Mahsup Hesap
        document.getElementById('I').value = valorI.toFixed(2); // Avans Mahsup Yaz

        var valorKES_a_s = Number(document.getElementById('KES_a_s').value, 10); //Stopaj Oranı Seç
        <?php if ($payment_settings->avans_stopaj == 1){ ?>
        var valorKES_a = valorKES_a_s * (valorE - valorI) / 100; // Stopaj Oranı Hesap
        <?php } else { ?>
        var valorKES_a = valorKES_a_s * valorE / 100; // Stopaj Oranı Hesap
        <?php } ?>
        document.getElementById('KES_a').value = valorKES_a.toFixed(2); //  Stopaj Oranı Yaz

        var valorKES_b_s = Number(document.getElementById('KES_b_s').value, 10); //Damga Vergisi Oranı Seç
        var valorKES_b = valorKES_b_s * valorE / 1000; // Damga Vergisi Hesapla
        document.getElementById('KES_b').value = valorKES_b.toFixed(2); //  Damga Vergisi Yaz

        var valorKES_c_s = Number(document.getElementById('KES_c_s').value, 10); //KDV Tevkifatı Oranı Seç
        var valorKES_c = valorKES_c_s * valorF; // KDV Tevkifatı Hesap
        document.getElementById('KES_c').value = valorKES_c.toFixed(2); //  KDV Tevkifatı Yaz

        var valorKES_d = Number(document.getElementById('KES_d').value, 10); //SGK Kesintisi Seç

        var valorKES_e_s = Number(document.getElementById('KES_e_s').value, 10); //Geçici Kabul Oranı Seç
        var valorKES_e = valorKES_e_s * valorE / 100; // Geçici Kabul Hesap
        document.getElementById('KES_e').value = valorKES_e.toFixed(2); //  Geçici Kabul Yaz

        var valorKES_f = Number(document.getElementById('KES_f').value, 10); //Makine Kesinti
        var valorKES_g = Number(document.getElementById('KES_g').value, 10); //Gecikme
        var valorKES_h = Number(document.getElementById('KES_h').value, 10); //İSG
        var valorKES_i = Number(document.getElementById('KES_i').value, 10); //Diğer
        var valorH = valorKES_a + valorKES_b + valorKES_c + valorKES_d + valorKES_e + valorKES_f + valorKES_g + valorKES_h + valorKES_i; // Toplam Kesinti Hesapla
        document.getElementById('H').value = valorH.toFixed(2); //  Toplam Kesinti Yaz


        var valorX = valorG - valorH - valorI; // Net Bedel Hesapla
        document.getElementById('X').value = valorX.toFixed(2); // Net Bedel Yaz
    }
</script>