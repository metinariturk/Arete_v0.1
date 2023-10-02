<style type="text/css">
  table, th, td {
    border: 1px solid black;
  }
  #dosyalar {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }
  #dosyalar td, #dosyalar th {
    border: 1px solid #ddd;
    padding: 8px;
  }
  #dosyalar tr:nth-child(even){background-color: #f2f2f2;}
  #dosyalar tr:hover {background-color: #ddd;}
  #dosyalar th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }
  .sagyasla {
    text-align: left;
    padding-left: 10px;
  }
  .btn {
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 3px 10px;
    cursor: pointer;
    font-size: 15px;
  }
  .btn1 {
    background-color: Red;
    border: none;
    color: white;
    padding: -1px 10px;
    cursor: pointer;
    font-size: 15px;
  }
/* Darker background on mouse-over */
.btn:hover {
  background-color: RoyalBlue;
}
.btn1:hover {
  background-color: DarkRed;
}
</style>


<!-- Gelen İşlemi Parçaya Ayırma Başı-->
<?php
$id_islem = explode("/",$_POST['id'],2);
?>
<!-- Gelen İşlemi Parçaya Ayırma Sonu-->

<!-- Tekli Dosya Silme Başı-->
<?php
$delete_file = 'uploads/hakedisler/'.$project->id.'/'.$_POST['hak_no'].'/'.$_POST['delete_file_path'].'';
$fh = fopen($delete_file);
fwrite($fh, '<h1>Menhaba Dünya!</h1>');
fclose($fh);
unlink($delete_file);
?>
<!-- Tekli Dosya Silme Sonu-->


<?php
$avans_durum = get_custom_field_value($project->id, 23, 'projects');
$avans_oran = get_custom_field_value($project->id, 24, 'projects');
$stop_durum = get_custom_field_value($project->id, 8, 'projects');

?>

<!-- Hakediş Düzenleme Butonu İle Gelirse Yapılan Düzenleme İşlemleri-->
<?php
if(isset($_POST['id']) && $id_islem[1]=="edit"){
  $tevkifat_oran = get_custom_field_value($project->id, 7, 'projects');
  if ($tevkifat_oran =="2/10") {
    $tevkifat_oran_digit = 0.2;
  }
  elseif ($tevkifat_oran =="3/10") {
    $tevkifat_oran_digit = 0.3;
  }
  elseif ($tevkifat_oran =="4/10") {
    $tevkifat_oran_digit = 0.4;
  }
  elseif ($tevkifat_oran =="5/10") {
    $tevkifat_oran_digit = 0.5;
  }
  elseif ($tevkifat_oran =="7/10") {
    $tevkifat_oran_digit = 0.7;
  }
  elseif ($tevkifat_oran =="9/10") {
    $tevkifat_oran_digit = 0.9;
  }
  elseif ($tevkifat_oran =="10/10") {
    $tevkifat_oran_digit = 1;
  }
  if ($stop_durum=="Yok" && $avans_durum== "Yok") {
    $stop_deger = "0.00";
    $stop_ad = "(E x %0)";
    $stopaciklama = "İlgili İş Yıllara Sari Olmadığı İçin Stopaj Kesintisi Uylanmayacaktır.";
  }
  elseif ($stop_durum!="Yok" && $row1['kesin_durum'] =="1") {
    $stop_deger = "0.00";
    $stop_ad = "(E x %0";
    $stopaciklama = "Kesin Hakedişten Stopaj Kesintisi Yapılmaz";
  }
  elseif ($stop_durum!="Yok" && $avans_durum == "Var") {
    $stop_deger = $stop_durum/100;
    $stop_ad = 'E-E*%'.$avans_oran;
    $stopaciklama = "Avans stopajı avans içinden mahsup edilmelidir, avans stopajı peşinen ödendiği için avans kesintisi oranında stopaj kesintisi eksiltilmiştir.";
  }
  else  {
    $stop_deger = $stop_durum/100;
    $stop_ad = '(E x %'.get_custom_field_value($project->id, 8, 'projects');
    $stopaciklama = 'İlgili İş Yıllara Sari Oludğu İçin %'.get_custom_field_value($project->id, 8, 'projects').' Stopaj Kesintisi Uylanacaktır.';
  }
  $hak_id = $id_islem[0];
  $query = $this->db->query('SELECT * FROM hakedis where id='.$hak_id.'');
  foreach ($query->result_array() as $row1)
  {
    $hak_no = $row1['hak_no'];
    $kesin_durum =$row1['kesin_durum'];
    if ($kesin_durum == 1) {
      $baslik = $row1['hak_no'].' ve Kesin Hakediş Düzenle';}
      else {
        $baslik = $row1['hak_no'].' Nolu Ara Hakedişi Düzenle';
      }
      $hak_date = $row1['hak_date'];
      $bedel = $row1['bedel'];
      $fark = $row1['fark'];
      $ara_toplam = $row1['ara_toplam'];
      $fark = $row1['fark'];
      $oncekihak = $row1['oncekihak'];
      $bu_imalat_ihzarat = $row1['bu_imalat_ihzarat'];
      $kdv_oran = $row1['kdv_oran'];
      $kdv_tutar = $row1['kdv_tutar'];
      $kdv_durum = get_custom_field_value($project->id, 6, 'projects');
      $taahhuk = $row1['taahhuk'];
      $krm_vergi_oran = $row1['krm_vergi_oran'];
      $krm_vergi_tutar = $row1['krm_vergi_tutar'];
      $damga_vergi_oran = $row1['damga_vergi_oran'];
      $damga_vergi_tutar = $row1['damga_vergi_tutar'];
      $tevkifat_oran = get_custom_field_value($project->id, 7, 'projects');
      $tevkifat_bedel = $row1['tevkifat_bedel'];
      $sgk = $row1['sgk'];
      $makine = $row1['makine'];
      $gecikme = $row1['gecikme'];
      $avans_oran = get_custom_field_value($project->id, 24, 'projects');
      $avans_tutar = $row1['avans_tutar'];

      $diger_1 = $row1['diger_1'];
      $diger_2 = $row1['diger_2'];
      $kes_toplam = $row1['kes_toplam'];
      $netbedel = $row1['netbedel'];
      $button_name = "DÜZENLE";
      $db_process="edit";
      $eski_hak_no = $row1['hak_no'];
      $cant_edit = "disabled";
      if (get_custom_field_value($project->id, 6, 'projects')=="KDV Muaf") {
        $kdv_durum = "0.00";
        $kdv_ad = "% 0";
        $kdv_aciklama_1 = "3065 Sayılı Kanunun 13. Maddesinin birinci fıkrası 'j' bendi kapsamında KDV'den istisnadır.";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 18%") {
        $kdv_durum = "0.18";
        $kdv_ad = "% 18";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 8%") {
        $kdv_durum = "0.08";
        $kdv_ad = "% 8";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 1%") {
        $kdv_durum = "0.01";
        $kdv_ad = "% 1";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="Kısmi KDV Muafiyeti"){
        $kdv_durum = "asd";
        $kdv_ad = "Karma Oran Hakedişi";
        $kdv_aciklama_2 = "Karma KDV Oranı Seçildiği İçin Lütfen Bu Hakedişte Uygulanacak KDV Oranını Seçiniz";
      }
    }
  }
  // $id_islem[1] iş emrini veriyor.
  elseif (isset($_POST['id']) && $id_islem[1]=="show"){
    $hak_id = $id_islem[0];
    $query = $this->db->query('SELECT * FROM hakedis where id='.$hak_id.'');
    foreach ($query->result_array() as $row1)
    {
      $hak_no = $row1['hak_no'];
      $kesin_durum =$row1['kesin_durum'];
      if ($kesin_durum == 1) {
        $baslik = $row1['hak_no'].' ve Kesin Hakedişi Görüntüle';}
        else {
          $baslik = $row1['hak_no'].' Nolu Ara Hakedişi Görüntüle';
        }
        $hak_date = $row1['hak_date'];
        $bedel = $row1['bedel'];
        $fark = $row1['fark'];
        $ara_toplam = $row1['ara_toplam'];
        $fark = $row1['fark'];
        $oncekihak = $row1['oncekihak'];
        $bu_imalat_ihzarat = $row1['bu_imalat_ihzarat'];
        $kdv_oran = $row1['kdv_oran'];
        $kdv_tutar = $row1['kdv_tutar'];
        $taahhuk = $row1['taahhuk'];
        $krm_vergi_oran = $row1['krm_vergi_oran'];
        $krm_vergi_tutar = $row1['krm_vergi_tutar'];
        $damga_vergi_oran = $row1['damga_vergi_oran'];
        $damga_vergi_tutar = $row1['damga_vergi_tutar'];
        $tevkifat_oran = $row1['tevkifat_oran'];
        $tevkifat_bedel = $row1['tevkifat_bedel'];
        $sgk = $row1['sgk'];
        $makine = $row1['makine'];
        $gecikme = $row1['gecikme'];
        $avans_oran = get_custom_field_value($project->id, 24, 'projects');
        $avans_bedel = "";
        $diger_1 = $row1['diger_1'];
        $diger_2 = $row1['diger_2'];
        $kes_toplam = $row1['kes_toplam'];
        $netbedel = $row1['netbedel'];
        $button_name = "DÜZENLE";
        $item_visibility = "hidden";
        $item_editable = "disabled";
        $db_process="show";
      }
    }
    elseif ($_POST['islem']=="create"){
      $pid = $project->id;
      $query = $this->db->query('SELECT * FROM hakedis where project_id='.$pid.'');
      $onceki = 0;
      foreach ($query->result_array() as $row)
      {
        $onceki += is_numeric($row['bu_imalat_ihzarat'])?$row['bu_imalat_ihzarat']:0;
      }
      if (get_custom_field_value($project->id, 6, 'projects')=="KDV Muaf") {
        $kdv_durum = "0.00";
        $kdv_ad = "% 0";
        $kdv_aciklama_1 = "3065 Sayılı Kanunun 13. Maddesinin birinci fıkrası 'j' bendi kapsamında KDV'den istisnadır.";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 18%") {
        $kdv_durum = "0.18";
        $kdv_ad = "% 18";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 8%") {
        $kdv_durum = "0.08";
        $kdv_ad = "% 8";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="KDV - 1%") {
        $kdv_durum = "0.01";
        $kdv_ad = "% 1";
      } elseif (get_custom_field_value($project->id, 6, 'projects')=="Kısmi KDV Muafiyeti"){
        $kdv_durum = "asd";
        $kdv_ad = "Karma Oran Hakedişi";
        $kdv_aciklama_2 = "Karma KDV Oranı Seçildiği İçin Lütfen Bu Hakedişte Uygulanacak KDV Oranını Seçiniz";
      }
      if ($stop_durum=="Yok" && $avans_durum== "Yok") {
        $stop_deger = "0.00";
        $stop_ad = "(E x %0)";
        $stopaciklama = "İlgili İş Yıllara Sari Olmadığı İçin Stopaj Kesintisi Uylanmayacaktır.";
      }
      elseif ($stop_durum!="Yok" && $row1['kesin_durum'] =="1") {
        $stop_deger = "0.00";
        $stop_ad = "(E x %0";
        $stopaciklama = "Kesin Hakedişten Stopaj Kesintisi Yapılmaz";
      }
      elseif ($stop_durum!="Yok" && $avans_durum == "Var") {
        $stop_deger = $stop_durum/100;
        $stop_ad = 'E-E*%'.$avans_oran;
        $stopaciklama = "Avans stopajı avans içinden mahsup edilmelidir, avans stopajı peşinen ödendiği için avans kesintisi oranında stopaj kesintisi eksiltilmiştir.";
      }
      else  {
        $stop_deger = $stop_durum/100;
        $stop_ad = '(E x %'.get_custom_field_value($project->id, 8, 'projects');
        $stopaciklama = 'İlgili İş Yıllara Sari Oludğu İçin %'.get_custom_field_value($project->id, 8, 'projects').' Stopaj Kesintisi Uylanacaktır.';
      }
      if (get_custom_field_value($project->id, 9, 'projects')=="Evet") {
        $damga_deger = get_custom_field_value($project->id, 10, 'projects');
        $damga_ad = "‰".get_custom_field_value($project->id, 10, 'projects')*1000;
        $damga_aciklama = "Damga vergisi sözleşme gereği hakedişlerden kesilecektir.";

      }
      elseif (get_custom_field_value($project->id, 9, 'projects')=="Hayır") {
        $damga_deger = "";
        $damga_ad = "";
        $damga_aciklama = "Sözleşme gereği damga vergisi peşinen ödenmiş ve hakedişlerden mahsup edilmemiştir. Ödendi makbuzunu sisteme eklemeyi unutmayınız.";
      }
      $tevkifat_oran = get_custom_field_value($project->id, 7, 'projects');
      if ($tevkifat_oran =="2/10") {
        $tevkifat_oran_digit = 0.2;
      }
      elseif ($tevkifat_oran =="3/10") {
        $tevkifat_oran_digit = 0.3;
      }
      elseif ($tevkifat_oran =="4/10") {
        $tevkifat_oran_digit = 0.4;
      }
      elseif ($tevkifat_oran =="5/10") {
        $tevkifat_oran_digit = 0.5;
      }
      elseif ($tevkifat_oran =="7/10") {
        $tevkifat_oran_digit = 0.7;
      }
      elseif ($tevkifat_oran =="9/10") {
        $tevkifat_oran_digit = 0.9;
      }
      elseif ($tevkifat_oran =="10/10") {
        $tevkifat_oran_digit = 1;
      }
      $hak_no = $_POST['sonhakno'];
      $hak_date = $_POST['hak_date'];
      $kesin_durum =$_POST['kesin_durum'];
      if ($kesin_durum == 1) {
        $baslik = $_POST['sonhakno'].' ve Kesin Hakediş Oluştur';}
        else {
          $baslik = $_POST['sonhakno'].' Nolu Ara Hakediş Oluştur';
        }
        $bedel = "";
        $fark = "";
        $toplam = "";
        $fark = "";
        $oncekihak = $onceki;
        $bu_imalat_ihzarat = "";
        $kdv_oran = get_custom_field_value($project->id, 6, 'projects');
        $kdv_tutar = "";
        $taahhuk = "";
        $krm_vergi_oran ="" ;
        $krm_vergi_tutar = "";
        $damga_vergi_oran ="" ;
        $damga_vergi_tutar = "";
        $tevkifat_oran = get_custom_field_value($project->id, 7, 'projects');
        $tevkifat_bedel = "";
        $sgk = "0";
        $makine = "0";
        $gecikme = "0";
        $avans_oran = get_custom_field_value($project->id, 24, 'projects');
        $avans_tutar = "";
        $diger_1 = "0";
        $diger_2 = "0";
        $kes_toplam = "";
        $netbedel = "";
        $button_name = "OLUŞTUR";
        $db_process="create";
        $hide_item_create="hidden";
      }
      ?>





<div class="container-fluid">
  <div class="row">
    <div class="col-md-2">
      <table>
        <thead>
          <tr>
            <th colspan="2">Hakedişe Ait Bilgiler</th>
          </tr>
          <tbody>
            <tr>
                <td>Sözleşme Tutarı</th>
                <td><?php echo app_format_money($project->project_cost,$currency) ; ?></td>
            </tr>
            <tr>
                <td>KDV Oranı</th>
                <td><?php echo get_custom_field_value($project->id, 6, 'projects'); ; ?></td>
            </tr>
            <tr>
                <td>KDV Tevkifatı</th>
                <td><?php echo get_custom_field_value($project->id, 7, 'projects'); ; ?></td>
            </tr>
            <tr>
                <td>Stopaj Oranı</th>
                <td><?php echo "%".get_custom_field_value($project->id, 8, 'projects'); ; ?></td>
            </tr>
            <tr>
                <td>Damga Vergisi Oranı</th>
                <td><?php echo "‰".get_custom_field_value($project->id, 10, 'projects')*1000; ; ?></td>
            </tr>
            <tr>
                <td>Avans Miktarı</th>
                <td><?php
                  $verilen_avans= get_custom_field_value($project->id, 26, 'projects');
                  echo  app_format_money($verilen_avans,$currency); ?></td>
            </tr>
            <tr>
                <td>Avans Mahsup Oranı</th>
                <td><?php echo '% '.get_custom_field_value($project->id, 24, 'projects'); ; ?></td>
            </tr>
            <tr>
              <td>Mahsup Edilen Avans</td>
              <td>
                 <?php
                  $query = $this->db->query("SELECT SUM(avans_tutar) as sum_avans FROM hakedis where project_id='$pid'");
                           foreach($query->result_array() as $row){
                           echo app_format_money($row['sum_avans'],$currency);
                           }
                  ?>
              </td>
            </tr>
          </tbody>

        </thead>
      </table>
    </div>
    <div class="col-md-8">
       <div  id="table">
        <div class="container-fluid">
          <form class="" style="margin-top: 20px;" method="post" action="<?php echo $project->id.'?group=project_tickets'?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="db_process"  hidden value="<?php echo $db_process; ?>">
            <input type="text" name="hak_id"  hidden value="<?php echo $hak_id; ?>"  >
            <input type="text" name="eski_hak_no" hidden  value="<?php echo $eski_hak_no; ?>"  >


            <div class="container paddings-mini">
              <div class="row">
                <div class="col-lg-12">
                  <table class="text-center" style="width:595pt;">
                    <tbody>
                      <tr>
                        <td colspan="3"><h3 class="text-center"><?php echo $baslik; ?></h3>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="sagyasla" ><?php echo $project->name; ?></td>
                        <td><label>Hakediş No:</label><br>
                          <input type="text" id="quantity"   <?php echo $item_editable;  ?> style="width: 30px" name="hak_no" value="<?php echo $hak_no; ?>" >
                          <select name="kesin_durum"  >
                            <option value="<?php if ($kesin_durum==1){echo 1;} else { echo 0;} ?>"><?php if ($kesin_durum==1){echo "KESİN";} else { echo "ARA";} ?></option>
                            <option value="<?php if ($kesin_durum==1){echo 0;} else { echo 1;} ?>"><?php if ($kesin_durum==1){echo "ARA";} else { echo "KESİN";} ?></option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                          <input type="date" id="hak_date" name="hak_date" <?php echo $item_visibility.$hide_item_create;  ?> value = "<?php echo $hak_date; ?>">
                          <?php echo _d($hak_date); ?>
                          <label for="birthday">Tarihine Kadar Yapılan İmalatın</label>
                        </td>
                      </tr>
                      <tr>
                        <td style="width:50pt;">A</td>
                        <td style="width:400pt;" class="sagyasla">Sözleşme Fiyatları İle Yapılan İşlerin Toplam Tutarı</td>
                        <td style="width:145pt;">
                          <input type="text" id="A"   name="bedel" value="<?php echo $bedel; ?>"onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)" onkeypress="numberWithCommas(x)">
                        </td>
                      </tr>
                      <tr>
                        <td>B</td>
                        <td class="sagyasla">Fiyat Farkı Tutarı</td>
                        <td>
                          <input type="text" id="B"   name="fark" value="<?php if ($fark > 0) {echo $fark;} else {echo $fark+0;}?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)" onkeypress="numberWithCommas(x)">
                        </td>
                      </tr>
                      <tr>
                        <td>C</td>
                        <td class="sagyasla">Toplam Tutar (A+B)</td>
                        <td>
                          <label><input id="C"   type="text" name="toplam" value="<?php echo $toplam;?> " onblur="calcular()" onfocus="calcular()"></label>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>D</td>
                        <td class="sagyasla">Bir Önceki Hakedişlerin Toplam Tutarı</td>
                        <td>
                          <input type="text" name="oncekihak" hidden id="D"   value="<?php echo $oncekihak; ?>" />
                          <label> <?php echo $oncekihak; ?></label>
                        </td>
                      </tr>
                      <tr>
                        <td>E</td>
                        <td class="sagyasla">Bu Hakedişin Tutarı (C-D)</td>
                        <td><input type="text" name="bu_imalat_ihzarat" id="E"   value="<?php echo $bu_imalat_ihzarat; ?>"  onblur="calcular()" onfocus="calcular()"></td>
                      </tr>
                      <tr>
                        <td>F</td>
                        <td class="sagyasla">KDV (E x
                          <select name="kdv_oran" id="F_a" onblur="calcular()" onfocus="calcular()"   >
                            <option value="<?php echo $kdv_durum; ?>" onblur="calcular()"  onfocus="calcular()"><?php echo $kdv_ad; ?></option>
                            <option value="0.18" onblur="calcular()" onfocus="calcular()">% 18</option>
                            <option value="0.08" onblur="calcular()" onfocus="calcular()">% 8</option>
                            <option value="0.01" onblur="calcular()" onfocus="calcular()">% 1</option>
                            <option value="0.00" onblur="calcular()" onfocus="calcular()">% 0 (Muaf)</option>
                          </select>)
                        </td>
                        <td>
                          <input type="text" name="kdv_tutar"  id="F"   value="<?php echo $kdv_tutar; ?>" onblur="calcular()" onfocus="calcular()">
                        </td>
                      </tr>
                      <tr>
                        <td>G</td>
                        <td class="sagyasla">Taahhuk Tutarı (E + F)</td>
                        <td>
                          <input type="text" id ="G" name="taahhuk"   value="<?php echo $taahhuk; ?>" onblur="calcular()" onfocus="calcular()">
                        </td>
                      </tr>
                      <tr>
                        <td rowspan="9" style="writing-mode: tb-rl; filter: flipv fliph;">KESİNTİ VE MAHSUPLAR TOPLAMI</td>
                        <td class="sagyasla">a)Gelir / Kurumlar Vergisi (<?php echo $stop_ad; ?>) (Stopaj % <?php echo $stop_durum; ?>)
                          <input name="krm_vergi_oran" id="KES_a_1"   onblur="calcular()" onfocus="calcular()"  value="<?php echo $stop_deger; ?>" style="width:100px;">
                        </td>
                        <td>
                          <input type="text" name="krm_vergi_tutar"   value="0"  id="KES_a" onblur="calcular()" onfocus="calcular()" >
                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">b)Damga Vergisi (E x <?php if (empty($damga_ad)) {echo "‰0";} else {echo $damga_ad; } ?>)
                          <input name="damga_vergi_oran" id="KES_b_1"   onblur="calcular()" onfocus="calcular()" hidden value="<?php echo $damga_deger; ?>" style="width:100px;">
                        </td>
                        <td>
                          <input type="text" name="damga_vergi_tutar"   id="KES_b" value="<?php echo $damga_vergi_tutar; ?>"   onblur="calcular()" onfocus="calcular()">
                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">c)KDV Tevkifatı (F x
                          <select name="tevkifat_oran" id="KES_c_1"   onblur="calcular()" onfocus="calcular()">
                            <option value="<?php echo $tevkifat_oran_digit; ?>"><?php echo $tevkifat_oran; ?></option>
                            <option value="0">Yok</option>
                            <option value="0.5">5/10</option>
                            <option value="0.9">9/10</option>
                            <option value="0.3">3/10</option>
                            <option value="1">10/10</option>
                          </select>)
                        </td>
                        <td><input type="text" name="tevkifat_bedel" value="0"  id="KES_c"   onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)"></td>
                      </tr>
                      <tr>
                        <td class="sagyasla">d)Sosyal Sigortalar Kurumu Kesintisi</td>
                        <td>
                          <input type="text" name="sgk" id="KES_d"   value="<?php echo $sgk; ?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)">
                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">e)İş Makinesi Kesintisi</td>
                        <td>
                          <input type="text" name="makine" id="KES_e"   value="<?php echo $makine; ?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)">
                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">f)Gecikme Cezası</td>
                        <td>
                          <input type="text" name="gecikme" id="KES_f"   value="<?php echo $gecikme; ?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)">
                        </td>
                      </tr>

                      <tr>
                        <td class="sagyasla">g)Avans Mahsubu %
                          <input name="avans_oran" id="KES_g_1"   onblur="calcular()" onfocus="calcular()"  value="<?php echo $avans_oran; ?>" style="width:100px;">
                        </td>
                        <td>
                          <input type="text" name="avans_tutar"  id="KES_g" value="<?php echo $avans_tutar; ?>"   onblur="calcular()" onfocus="calcular()">

                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">g)Avans Mahsubu %
                          <input name="avans_oran" id="KES_g_2"   onblur="calcular()" onfocus="calcular()"  value="<?php echo $avans_oran; ?>" style="width:100px;">
                        </td>
                        <td>
                          <input type="text" name="avans_tutar"  id="Kes_g_2"value="<?php echo $row['sum_avans']; ?>"  onblur="calcular()" onfocus="calcular()" >
                      </tr>
                      <tr>
                        <td class="sagyasla">g)Avans Mahsubu %
                          <input name="avans_oran" id="KES_g_3"   onblur="calcular()" onfocus="calcular()"  value="<?php echo $avans_oran; ?>" style="width:100px;">
                        </td>
                        <td>
                          <input type="text" name="avans_tutar"  id="Kes_g_3" value="<?php echo $verilen_avans; ?>"  onblur="calcular()" onfocus="calcular()" ></td>
                      </tr>

                      <tr>
                        <td class="sagyasla">h)Diğer Kesinti (1)</td>
                        <td>
                          <input type="text" name="diger_1" id="KES_h"   value="<?php echo $diger_1; ?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)">
                        </td>
                      </tr>
                      <tr>
                        <td class="sagyasla">i)Diğer Kesinti (2)</td>
                        <td>
                          <input type="text" name="diger_2" id="KES_i"   value="<?php echo $diger_2; ?>" onblur="calcular()" onfocus="calcular()" onkeypress="isInputNumber(event)">
                        </td>
                      </tr>
                      <tr>
                        <td>H</td>
                        <td class="sagyasla">Kesinti ve Mahsuplar Toplamı
                        </td>
                        <td>
                          <input type="text" name="kes_toplam"   value="<?php echo $kes_toplam; ?>" id="H" onblur="calcular()" onfocus="calcular()" >
                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="sagyasla">Yükleniciye Ödenecek Tutar (G-H)
                        </td>
                        <td>
                          <input type="text" name="netbedel"   value="<?php echo $netbedel; ?>" id="netbedel"  onblur="calcular()" onfocus="calcular()" >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Dosya Yükleme Alanı Başı-->
                  <div class="row "  <?php echo  $item_visibility; ?>>
                    <div class="form-group col-md-12 no-print">
                      <label for="files">Dosyaları Seçiniz</label>
                      <input class="no-print" type="file" name="image[]" multiple="multiple" >
                    </div>
                  </div>
                  <!-- Dosya Yükleme Alanı Sonu-->
                  <span style='font-size: 10px; color: red;'><?php echo $kdv_aciklama_1; ?></span><br>
                  <span style='font-size: 10px; color: red;'><?php echo $kdv_aciklama_2; ?></span><br>
                  <span style='font-size: 10px; color: red;'><?php echo $stopaciklama; ?></span><br>
                  <div class="row mt-4">
                    <button type="submit" class="btn btn-success" <?php echo  $item_visibility; ?> style="width: 100%; margin-top: 10px;"><?php echo  $button_name; ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-2">
    </div>
  </div>
</div>





      <!-- Form Yazdırma Butonu -->
      <div class="form-check">
        <hr>
        <center>
          <input type="button" onclick="printDiv('table')" value="YAZDIR veya PDF KAYDET" />
        </center>
      </hr>
    </div>
    <!-- Form Yazdırma Butonu -->

    <form class="" style="margin-top: 20px;" method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>" enctype="multipart/form-data">
      <div class="row" <?php echo $hide_item_create; ?>>
        <div class="form-group col-md-12">
          <input type="text" name="hak_no" hidden value="<?php echo $hak_no; ?>">
          <input type="text" name="id" hidden value="<?php echo $row1['id']; ?>/edit">
          <div class="container-fluid">
            <div class="container paddings-mini">
              <div class="row text-center">
                <?php
                if(isset($_POST['path']))
                {
              //Read the filename
                  $filename = $_POST['path'];
              //Check the file exists or not
                  if(file_exists($filename)) {

              //Define header information
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header("Cache-Control: no-cache, must-revalidate");
                    header("Expires: 0");
                    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                    header('Content-Length: ' . filesize($filename));
                    header('Pragma: public');
              //Clear system output buffer
                    flush();
              //Read the size of the file
                    readfile($filename);
              //Terminate from the script
                    die();
                  }
                  else{
                    echo "İndirmeye Çalıştığınız Dosya Yolu Bulunamadı.";
                  }
                }
                ?>
                <div class="d-flex justify-content-center bd-highlight mb-3">
                  <div class="col-md-12 text-center" >
                    <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fa fa-file"></i>  Hakediş Evrakları</button>
                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <table id="dosyalar" class="text-center " >
                            <tbody>
                              <tr>
                                <th>No</th>
                                <th>Dosya Adı</th>
                                <th>Sil</th>
                                <th>İndir</th>
                                <?php
                                $yol = "uploads/hakedisler/".$project->id."/".$hak_no;
                                $files = glob($yol."/*.*");
                                for ($i = 0; $i < count($files); $i++) {
                                  $docs = $files[$i];
                                  $path_parts = pathinfo($docs);
                                  $dosya_adi = mb_strtoupper($path_parts['filename']);
                                  $uzanti = mb_strtoupper($path_parts['extension']) ;
                                  $boyut =  filesize($docs);
                                  $mb = $boyut/1048576;
                                  $mb_2=number_format($mb, 2, '.', '');
                                  echo '<tr ><td class="text-center" style="white-space: nowrap;">'.($i+1).'</td>';
                                  echo '<td><a name="path" href="../../../'.$docs.'"  target="_blank">'.$dosya_adi.'     ('.$uzanti.')    '.$mb_2.' Mb</a></td>';
                                  echo '<td  width ="40px"><button type="submit" class="btn1 " name="delete_file_path" value="'.$dosya_adi.'.'.$uzanti.'"
                                  ><i class="fa fa-times">SİL</i></button></td>';
                                  echo '<td  width ="40px"><button class="btn"><i class="fa fa-download"><a name="path" href="../../../'.$docs.'" download="">İndir</a></i></button></td></tr>';
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

<script>
  function calcular(){
var valorA = parseFloat(document.getElementById('A').value, 10); //A Hücresi Veri Giriş
var valorB = parseFloat(document.getElementById('B').value, 10); //B Hücresi Veri Giriş
var valorC = valorA + valorB; //C Hücresi Hesaplama
document.getElementById('C').value = valorC.toFixed(2); // C Hücresi 2 Basamak Ayarı
var valorD = parseFloat(document.getElementById('D').value, 10); //D Hücresi Veri Tabanından Otomatik (Son Hak Bedeli)
var valorE = valorC - valorD; //E Hücresi Veri Hesapla
document.getElementById('E').value = valorE.toFixed(2); //E Hücresine Veri Göster
var valorF = document.getElementById('F_a').value * document.getElementById('E').value ;
document.getElementById('F').value = valorF.toFixed(2) ; //F Hücresine Veri Göster
var valorG = valorE + valorF ;
document.getElementById('G').value = valorG.toFixed(2) ; //G Hücresine Veri Göster

var valorKES_b = valorE * document.getElementById('KES_b_1').value ;
document.getElementById('KES_b').value = valorKES_b.toFixed(2) ; //KES_b Hücresine Veri Göster
var valorKES_c = valorF * document.getElementById('KES_c_1').value ;
document.getElementById('KES_c').value = valorKES_c.toFixed(2) ; //KES_c Hücresine Veri Göster
var valorKES_d = parseFloat(document.getElementById('KES_d').value, 10);
var valorKES_e = parseFloat(document.getElementById('KES_e').value, 10);
var valorKES_f = parseFloat(document.getElementById('KES_f').value, 10);


var valorKES_g_1 = document.getElementById('KES_g_1').value;

var valorKES_g = valorE *  valorKES_g_1/100 ;
document.getElementById('KES_g').value = valorKES_g.toFixed(2) ; //KES_g Hücresine Veri Göster




var valorKES_h = parseFloat(document.getElementById('KES_h').value, 10);
var valorKES_i = parseFloat(document.getElementById('KES_i').value, 10);



var valorKES_a = (valorE-valorKES_g) * document.getElementById('KES_a_1').value ;
document.getElementById('KES_a').value = valorKES_a.toFixed(2) ; //KES_a Hücresine Veri Göster


var valorH = valorKES_a + valorKES_b + valorKES_c + valorKES_d + valorKES_e + valorKES_f + valorKES_g + valorKES_h + valorKES_i;
document.getElementById('H').value = valorH.toFixed(2) ; //H Hücresine Veri Göster
var valornetbedel = valorG - valorH ;


document.getElementById('netbedel').value = valornetbedel.toFixed(2) ; //H Hücresine Veri Göster

//-----------------------------//

}
</script>
<script>
function isInputNumber(evt){

var ch = String.fromCharCode(evt.which);

if(!(/^[0-9]*\.?[0-9]*$/.test(ch))){
evt.preventDefault();
}

}
</script>

<script type="text/javascript">

function printDiv() {
var divToPrint = document.getElementById('table');
var htmlToPrint = '' +
'<style type="text/css">' +
'table th, table td {' +
'border:1px solid #000;' +
'padding:0.5em;' +
'}' +
'</style>';
htmlToPrint += divToPrint.outerHTML;
newWin = window.open("");
newWin.document.write(htmlToPrint);
newWin.print();
newWin.close();
}
</script>


