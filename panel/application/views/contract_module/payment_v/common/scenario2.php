<script>
    function calcular(){
        //1- Verilen avans bedeli mahsubu yapıyor, mahsup edilen avans tutarı iş bedelinden düşülerek hesaplanıyor,
        //2- Bu durum verilen avansın stopajdan muaf olmaması durumunda veya peşinen ödenmemesi durumunda geçerli oluyor.

        //TOPLAM İMALAT
        var valorA1 = Number(document.getElementById('A1').value, 10);
        if (valorA1) {
            var valorA1 = Number(document.getElementById('A1').value, 10);
        } else {
            var valorA1 = 0;
        }
        //TOPLAM İMALAT

        var valorX = Number(document.getElementById('X').value, 10);
        if (valorX) {
            var valorX = Number(document.getElementById('X').value, 10);
        } else {
            var valorX = 0;
        }

        var valorA3 = valorA1 - valorX;
        document.getElementById('A3').value = valorA3.toFixed(2);

        var valorA2 = Number(document.getElementById('A2').value, 10);
        if (valorA2) {
            var valorA2 = Number(document.getElementById('A2').value, 10);
        } else {
            var valorA2 = 0;
        }

        var valorY = Number(document.getElementById('Y').value, 10);
        if (valorY) {
            var valorY = Number(document.getElementById('Y').value, 10);
        } else {
            var valorY = 0;
        }


        var valorA4 = valorA2 - valorY; //C Hücresi Hesaplama
        document.getElementById('A4').value = valorA4.toFixed(2);

        var valorB1 = Number(document.getElementById('B1').value, 10);
        if (valorB1) {
            var valorB1 = Number(document.getElementById('B1').value, 10);
        } else {
            var valorB1 = 0;
        }

        var valorZ = Number(document.getElementById('Z').value, 10);
        if (valorZ) {
            var valorZ = Number(document.getElementById('Z').value, 10);
        } else {
            var valorZ = 0;
        }

        var valorB2 = valorB1 - valorZ; //C Hücresi Hesaplama
        document.getElementById('B2').value = valorB2.toFixed(2);

        var valorC = valorA1 +  valorA2 + valorB1;
        document.getElementById('C').value = valorC.toFixed(2);

        var valorD = Number(document.getElementById('D').value, 10);

        var valorE = valorC - valorD;
        document.getElementById('E').value = valorE.toFixed(2);

        var valorF_a = Number(document.getElementById('F_a').value, 10);

        var valorF = valorE * valorF_a /100;
        document.getElementById('F').value = valorF.toFixed(2);

        var valorG = valorE + valorF;
        document.getElementById('G').value = valorG.toFixed(2) ;

        var valorKES_g_1 = document.getElementById('KES_g_1').value;
        if (valorKES_g_1) {
            var valorKES_g_1 = document.getElementById('KES_g_1').value;
        } else {
            var valorKES_g_1 = 0;
        }

        var valorKES_g = (valorA3 + valorA4) * valorKES_g_1 / 100;
        document.getElementById('KES_g').value = valorKES_g.toFixed(2) ; //KES_g Hücresine Veri Göster


        var valorKES_j_1 = Number(document.getElementById('KES_j_1').value, 10);
        if (valorKES_j_1) {
            var valorKES_j_1 = Number(document.getElementById('KES_j_1').value, 10);
        } else {
            var valorKES_j_1 = 0;
        }

        var valorKES_j = valorKES_j_1 * valorB2 /100 ;
        document.getElementById('KES_j').value = valorKES_j.toFixed(2) ;

        var valorKES_a = valorE * document.getElementById('KES_a_1').value/100 ;
        document.getElementById('KES_a').value = valorKES_a.toFixed(2) ; //KES_b Hücresine Veri Göster

        var valorKES_b = valorE * document.getElementById('KES_b_1').value/1000 ;
        document.getElementById('KES_b').value = valorKES_b.toFixed(2) ; //KES_b Hücresine Veri Göster

        var valorKES_c = valorF * document.getElementById('KES_c_1').value ;
        document.getElementById('KES_c').value = valorKES_c.toFixed(2) ; //KES_c Hücresine Veri Göster

        var valorKES_k_1 = document.getElementById('KES_k_1').value;
        if (valorKES_k_1) {
            var valorKES_k_1 = document.getElementById('KES_k_1').value;
        } else {
            var valorKES_k_1 = 0;
        }


        var valorKES_k = ((valorA3 + valorA4)) * valorKES_k_1 / 100;
        document.getElementById('KES_k').value = valorKES_k.toFixed(2) ; //k Hücresine Veri Göster

        var valorKES_d = Number(document.getElementById('KES_d').value, 10);

        var valorKES_e = Number(document.getElementById('KES_e').value, 10);

        var valorKES_f = Number(document.getElementById('KES_f').value, 10);

        var valorKES_h = Number(document.getElementById('KES_h').value, 10);

        var valorKES_i = Number(document.getElementById('KES_i').value, 10);



        var valorH = valorKES_a + valorKES_b + valorKES_c + valorKES_d + valorKES_e + valorKES_f + valorKES_g + valorKES_h + valorKES_i + valorKES_j + valorKES_k;
        document.getElementById('H').value = valorH.toFixed(2) ; //H Hücresine Veri Göster

        var valorT = valorE + valorF - valorH ;

        document.getElementById('T').value = valorT.toFixed(2) ; //H Hücresine Veri Göster
    }
</script>