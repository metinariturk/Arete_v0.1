<script>
    function calcular(){
        //scenario1
        //1- Verilen avans bedeli mahsubu yapıyor, mahsup edilen avans tutarı iş bedelinden düşülerek hesaplanıyor,
        //2- Bu durum verilen avansın stopajdan muaf olmaması durumunda veya peşinen ödenmemesi durumunda geçerli oluyor.


        //ÖNCEKİ İHZARAT BEDELİ Y
        var valorY = Number(document.getElementById('Y').value, 10);
        //ÖNCEKİ İHZARAT BEDELİ


        //ÖNCEKİ İMALAT TOPLAM X
        var valorX = Number(document.getElementById('X').value, 10);
        //ÖNCEKİ İMALAT TOPLAM



        //BU İMALAT BEDELİ A3
        var valorA3 = Number(document.getElementById('A3').value, 10);
        //BU İMALAT BEDELİ

        //TOPLAM İMALAT A1
        var valorA1 = valorA3 + valorX;
        document.getElementById('A1').value = valorA1.toFixed(2);
        //TOPLAM İMALAT

        //BU İHZARAT BEDELİ A4
        var valorA4 = Number(document.getElementById('A4').value, 10);
        //BU İHZARAT BEDELİ

        //TOPLAM İHZARAT BEDELİ A2
        var valorA2 = valorA4 + valorY;
        document.getElementById('A2').value = valorA2.toFixed(2);
        //TOPLAM İHZARAT BEDELİ


        //ÖNCEKİ FİYAT FARKI BEDELİ Z
        var valorZ = Number(document.getElementById('Z').value, 10);
        //ÖNCEKİ FİYAT FARKI BEDELİ

        //BU FİYAT FARKI BEDELİ B2
        var valorB2 = Number(document.getElementById('B2').value, 10);
        //BU FİYAT FARKI BEDELİ

        //TOPLAM FİYAT FARKI BEDELİ B1
        var valorB1 = valorB2 + valorZ; //C Hücresi Hesaplama
        document.getElementById('B1').value = valorB1.toFixed(2);
        //TOPLAM FİYAT FARKI BEDELİ


        //TOPLAM TUTAR C
        var valorC = valorA1 + valorA2 + valorB1;
        document.getElementById('C').value = valorC.toFixed(2);
        //TOPLAM TUTAR C

        //ÖNCEKİ HAKEDİŞLERİN TOPLAMI D
        var valorD = Number(document.getElementById('D').value, 10);
        //ÖNCEKİ HAKEDİŞLERİN TOPLAMI

        //BU HAKEDİŞİN TOPLAMI E
        var valorE = valorC - valorD;
        document.getElementById('E').value = valorE.toFixed(2);
        //BU HAKEDİŞİN TOPLAMI E

        //HAKEDİŞ KDV ORANI F_A
        var valorF_a = Number(document.getElementById('F_a').value, 10);
        //HAKEDİŞ KDV ORANI

        //HAKEDİŞ KDV TUTARI F
        var valorF = valorE * valorF_a /100;
        document.getElementById('F').value = valorF.toFixed(2);
        //HAKEDİŞ KDV TUTARI

        //TAAHHUK TUTARI G
        var valorG = valorE + valorF;
        document.getElementById('G').value = valorG.toFixed(2) ;
        //TAAHHUK TUTARI

        //AVANS MAHSUBU ORANI KES_g_1
        var valorKES_g_1 = document.getElementById('KES_g_1').value;
        //AVANS MAHSUBU ORANI

        //AVANS MAHSUBU TUTARI KES_g
        var valorKES_g = (valorA3 + valorA4) * valorKES_g_1 / 100;
        document.getElementById('KES_g').value = valorKES_g.toFixed(2) ; //KES_g Hücresine Veri Göster
        //AVANS MAHSUBU TUTARI

        //STOPAJ ORANI KES_a_1
        var valorKES_a_1 = document.getElementById('KES_a_1').value;
        //STOPAJ ORANI KES_a_1

        //AVANS MAHSUBU TUTARI KES_g_2
        var valorKES_g_2 = Number(document.getElementById('KES_g_2').value, 10);
        console.log(valorKES_g_2);

        if (valorKES_g_2 == 1) {
            //STOPAJ HESABI KES_a
            var valorKES_a = ( valorE - valorKES_g ) * valorKES_a_1 / 100 ;
            document.getElementById('KES_a').value = valorKES_a.toFixed(2) ; //KES_b Hücresine Veri Göster
            //STOPAJ HESABI
        } else {
            //STOPAJ HESABI KES_a
            var valorKES_a = valorE * valorKES_a_1 / 100 ;
            document.getElementById('KES_a').value = valorKES_a.toFixed(2) ; //KES_b Hücresine Veri Göster
            //STOPAJ HESABI
        }


        var valorKES_j_1 = Number(document.getElementById('KES_j_1').value, 10);

        var valorKES_j = valorKES_j_1 * valorB2 /100 ;
        document.getElementById('KES_j').value = valorKES_j.toFixed(2) ;

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


        var valorKES_k = valorA3 * valorKES_k_1 / 100;
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