<?php

function convertToSEO($text)
{

    $turkce = array("ç", "Ç", "ğ", "Ğ", "ü", "Ü", "ö", "Ö", "ı", "İ", "ş", "Ş", ".", ",", "!", "'", "\"", " ", "?", "*", "_", "|", "=", "(", ")", "[", "]", "{", "}");
    $convert = array("c", "c", "g", "g", "u", "u", "o", "o", "i", "i", "s", "s", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "", "", "-", "-", "-", "-");

    return strtolower(str_replace($turkce, $convert, $text));

}

function upper_tr($text)
{
    $convert = array(
        "ç" => "Ç",
        "ğ" => "Ğ",
        "i" => "İ",
        "ı" => "I",
        "ö" => "Ö",
        "ş" => "Ş",
        "ü" => "Ü",
    );

    $convertedString = strtr($text, $convert);

// Küçük harfleri büyük harfe çevir
    $convertedString = mb_strtoupper($convertedString, 'UTF-8');

    return $convertedString;

}


function delete_comma_spaces($text)
{

    $turkce = array(", ");
    $convert = array(",");

    return str_replace($turkce, $convert, $text);

}

function durum_name($text)
{

    $turkce = array("ç", "Ç", "ğ", "Ğ", "ü", "Ü", "ö", "Ö", "ı", "İ", "ş", "Ş", ".", "!", "'", "\"", " ", "?", "*", "_", "|", "=", "(", ")", "[", "]", "{", "}");
    $convert = array("c", "c", "g", "g", "u", "u", "o", "o", "i", "i", "s", "s", "-", "-", "-", "-", "-", "-", "-", "-", "-", "-", "", "", "-", "-", "-", "-");

    return strtolower(str_replace($turkce, $convert, $text));

}

function filenamedisplay($text)
{
    $turkce = array("-");
    $convert = array(" ");

    $bring_spaces = str_replace($turkce, $convert, $text);
    $case_url = mb_convert_case($bring_spaces, MB_CASE_TITLE);

    if (strlen($case_url) > 20) {
        if (function_exists("mb_substr")) {
            $case_url = mb_substr($case_url, 0, 20, "UTF-8") . '..' . substr($case_url, -5, 5);
        } else {
            $case_url = substr($case_url, 0, 20) . '..' . substr($case_url, -5, 5);
        }
    }
    return $case_url;
}

function file_size($file_size)
{

    return bcdiv($file_size, 1048576, 2) . " Mb";

}

function date_minus($date1, $date2)
{
    $format_date1 = dateFormat('Y-m-d', "$date1");
    $format_date2 = dateFormat('Y-m-d', "$date2");
    $a = strtotime($format_date1);
    $b = strtotime($format_date2);
    $c = $a - $b;
    return $c;
}

function date_minus_day($date1, $date2)
{
    $format_date1 = dateFormat('Y-m-d', "$date1");
    $format_date2 = dateFormat('Y-m-d', "$date2");
    $a = strtotime($format_date1);
    $b = strtotime($format_date2);
    $c = $a - $b;
    return $c / 60 / 60 / 24;
}

function datetime_minus($date1, $date2)
{
    $format_date1 = dateFormat('Y-m-d H:i', "$date1");
    $format_date2 = dateFormat('Y-m-d H:i', "$date2");
    $a = strtotime($format_date1);
    $b = strtotime($format_date2);
    $c = $a - $b;
    return $c;
}

function date_to_str($date1)
{
    $str_date = strtotime(dateFormat('Y-m-d', "$date1"));
    return $str_date;
}

function dateFormat($format = 'd-m-Y', $givenDate = null)
{
    return date($format, strtotime($givenDate));
    //gelen tarih verisini YY-mm-dd -> dd-mm-YYYY şekline çeviriyor
}

function dateFormat_dmy($givenDate = null)
{
    if (!empty($givenDate)){
        return date('d-m-Y', strtotime($givenDate));
    } else {
        return "";
    }
    //gelen tarih verisini YY-mm-dd -> dd-mm-YYYY şekline çeviriyor
}

function dateFormat_dmy_hi($givenDate = null)
{

    return date('d-m-Y h:i', strtotime($givenDate));

}

function date_plus_days($date, $days = "")
{
    return date('d-m-Y', strtotime($date . ' +' . $days . ' days'));
}

function datetime_plus_days($date, $days = "")
{
    return strtotime($date . ' +' . $days . ' days');
}

function ay_isimleri($ay)
{
    $array = array('Ocak' => '1', 'Şubat' => '2', 'Mart' => '3', 'Nisan' => '4', 'Mayıs' => '5', 'Haziran' => '6', 'Temmuz' => '7', 'Ağustos' => '8', 'Eylül' => '9', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12');

    $key = array_search($ay, $array); // $key = 2;

    return $key;
}

function tr_gun($gun)
{
    switch ($gun) {
        case 'Monday':
            return "Pazartesi";
            break;
        case 'Tuesday':
            return "Salı";
            break;
        case 'Wednesday':
            return "Çarşamba";
            break;
        case 'Thursday':
            return "Perşembe";
            break;
        case 'Friday':
            return "Cuma";
            break;
        case 'Saturday':
            return "Cumartesi";
            break;
        case 'Sunday':
            return "Pazar";
            break;
    }
}

function fark_tarih($date)
{
// Creates DateTime objects
    $today = date("Y/m/d");
    $datetime1 = date_create($today);
    $datetime2 = date_create($date);

    // Calculates the difference between DateTime objects
    $interval = date_diff($datetime2, $datetime1);

    return $interval->format('%d');

}

function calistigi_gun($date)
{
// Creates DateTime objects
    $today = date("Y/m/d");
    $datetime1 = date_create($today);
    $datetime2 = date_create($date);

    // Calculates the difference between DateTime objects
    $interval = date_diff($datetime2, $datetime1);

    // Printing result in years & months format
    return $interval->format('%R%y Yıl  %m Ay  %d Gün');
}

function date_control($date)
{
    if (($date == (0000 - 00 - 00)) or $date == null) {
        return FALSE;
    } else {
        return TRUE;
    }

}


function yayin_kalan_sure($date)
{
// Creates DateTime objects
    $today = date("Y/m/d");
    $datetime1 = date_create($today);
    $datetime2 = date_create($date);

    // Calculates the difference between DateTime objects
    $interval = date_diff($datetime2, $datetime1);

    // Printing result in years & months format
    echo $interval->format('%d Gün %h Saat');
}

function fark_gun($givenDate)
{
// Creates DateTime objects
    $bugun = new DateTime();

    // Verilen tarihi DateTime nesnesine çevir
    $verilenTarih = new DateTime($givenDate);

    // Tarihler arasındaki farkı hesapla
    $fark = $bugun->diff($verilenTarih);

    // Farkı gün olarak al ve döndür
    return $fark->format('%a');

}


function money_format($value = NULL, $decimals = '2', $decimal_sep = ',', $thousand_sep = '.')
{
    $numeric_value = is_numeric($value) ? $value : 0; // Convert to a number or set to 0 if not numeric
    return number_format($numeric_value, $decimals, $decimal_sep, $thousand_sep);
}

function deleteDirectory($dir)
{
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

function cms_if_echo($item, $equal, $true, $false)
{
    if ($item == $equal) {
        echo $true;
    } else {
        echo $false;
    }
}

function cms_if_return($item, $equal, $true, $false)
{
    if ($item == $equal) {
        return $true;
    } else {
        return $false;
    }
}

function cms_elseif($item, $equal1, $val1, $equal2, $val2, $other)
{
    if ($item == $equal1) {
        echo $val1;
    } elseif ($item == $equal2) {
        echo $val2;
    } else {
        echo $other;
    }
}

function two_digits($number)
{
    $rounded = sprintf("%.2f", $number);
    return $rounded;
}

function two_digits_percantage($number)
{
    $rounded = sprintf("%.2f", $number * 100);
    return "% " . $rounded;
}

function demir_fiyat()
{
    $str = file_get_html('https://www.gulecdemir.com.tr/');
    $html = str_get_html($str);
    $ince_demir = $html->find('ul li a', 2)->innertext; // result: "ok"
    $fiyat = explode(" ", $ince_demir);
    echo "<strong>İnşaat Demiri = </strong>" . $fiyat[2] . " TL";

}

function ext_img($file_name)
{

    $ext = mb_strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $file_types =
        array(
            'xls' => base_url("assets") . "/images/file_img/excel.png",
            'xlsx' => base_url("assets") . "/images/file_img/excel.png",
            'csv' => base_url("assets") . "/images/file_img/excel.png",

            'doc' => base_url("assets") . "/images/file_img/word.png",
            'docx' => base_url("assets") . "/images/file_img/word.png",
            'rtf' => base_url("assets") . "/images/file_img/word.png",

            'ppt' => base_url("assets") . "/images/file_img/ppt.png",
            'pptx' => base_url("assets") . "/images/file_img/ppt.png",

            'txt' => base_url("assets") . "/images/file_img/txt.png",
            'pdf' => base_url("assets") . "/images/file_img/pdf.png",

            'png' => base_url("assets") . "/images/file_img/img.png",
            'gif' => base_url("assets") . "/images/file_img/img.png",
            'jpeg' => base_url("assets") . "/images/file_img/img.png",
            'jpg' => base_url("assets") . "/images/file_img/img.png",

            'mp3' => base_url("assets") . "/images/file_img/video.png",
            'mp4' => base_url("assets") . "/images/file_img/video.png",
            'wma' => base_url("assets") . "/images/file_img/video.png",
            'flv' => base_url("assets") . "/images/file_img/video.png",
            'avi' => base_url("assets") . "/images/file_img/video.png",

            'zip' => base_url("assets") . "/images/file_img/zip.png",
            'rar' => base_url("assets") . "/images/file_img/rar.png",

            'dwg' => base_url("assets") . "/images/file_img/acad.png",
            'dxf' => base_url("assets") . "/images/file_img/acad.png",
            'skp' => base_url("assets") . "/images/file_img/sketchup.png",
            'kmz' => base_url("assets") . "/images/file_img/kmz.png",
        );

    foreach ($file_types as $file_type => $value) {
        if ($file_type == $ext) {
            return ' <img src="' . $value . '" style="width:35px">';
        }
    }

}

function weather_icon($weather)
{

    $weather_types =
        array(
            'Açık' => '<i class="fa-solid fa-sun"></i>',
            'Kapalı' => '<i class="fa-solid fa-cloud-bolt"></i>',
            'Sağanak Yağışlı' => '<i class="fa-solid fa-cloud-showers-heavy"></i>',
            'Yağmurlu' => '<i class="fa-solid fa-cloud-rain"></i>',
            'Kar Yağışlı' => '<i class="fa-regular fa-snowflake"></i>',
            'Sisli' => '<i class="fa-solid fa-smog"></i>',
            'Rüzgarlı' => '<i class="fa-solid fa-smog"></i>',
        );

    foreach ($weather_types as $weather_type => $value) {
        if ($weather_type == $weather) {
            return $value;
        }
    }

}

function pgb_color($number)
{

    $number_rounded = round($number);

    if (in_array($number, range(1, 10))) {
        return 'success';
    } elseif (in_array($number, range(11, 30))) {
        return 'primary';
    } elseif (in_array($number, range(31, 50))) {
        return 'info';
    } elseif (in_array($number, range(51, 70))) {
        return 'warning';
    } elseif (in_array($number, range(71, 90))) {
        return 'dark';
    } elseif (in_array($number, range(91, 100))) {
        return 'danger';
    }
}

function module_name($module_name)
{
    $module_types = array(
        "Proje" => "project",
        "Hakediş Metraj" => "boq",
        "Avans" => "advance",
        "Teminat" => "bond",
        "Görsel Katalogları" => "catalog",
        "Sözleşme" => "contract",
        "Keşif Artışı" => "costinc",
        "Teknik Çizimler" => "drawings",
        "Süre Uzatımı" => "extime",
        "Yeni Birim Fiyat" => "newprice",
        "Hakediş" => "payment",
        "Teklif" => "auction",
        "Teklif Teknik Çizimler" => "aucdraw",
        "Metraj" => "compute",
        "Şartnameler" => "condition",
        "Yaklaşık Maliyet" => "cost",
        "Teşvik/Hibe" => "incentive",
        "Yayın" => "notice",
        "Teklif Formu" => "offer",
        "Rapor" => "report",
        "Şantiye" => "site",
        "Şantiye Depo" => "sitestock",
        "Şantiye Kasa" => "sitewallet",
        "İş Grupları" => "workgroup",
        "İş Makineleri" => "workmachine",
        "İSG" => "safety",
        "Kaza" => "accident",
        "Sağlık" => "checkup",
        "Demirbaş" => "debit",
        "Eğitim" => "education",
        "Güvenlik" => "safety",
        "Puantaj" => "score",
        "Ekipman Stok" => "safetystock",
        "Çalışan" => "workman",
        "Yakıt" => "fuel",
        "Sigorta" => "insurance",
        "Kiralama" => "rent",
        "Servis" => "service",
        "Araç" => "vehicle",
        "Firma" => "company",
        "E-Posta Ayarları" => "emailsettings",
        "Sistem Ayarları" => "settings",
        "Kullanıcılar" => "user",
        "Finansal" => "finance",
        "Kullanıcı Rolleri" => "user_roles"

    );

    $ext = array_search(mb_strtolower($module_name), $module_types);
    return empty($ext) ? 'Varsayılan' : $ext;

}

function cms_isset($var, $true, $false)
{
    if (!empty($var)) {
        echo $true;
    } else {
        echo $false;
    }
}

function yazim_duzen($var)
{
    return mb_convert_case($var, MB_CASE_TITLE, "UTF-8");
}

function compare_color_dot($settings, $durumu)
{
    if (strstr($settings, $durumu)) {
        match_value("$durumu");
    } else {
        echo "";
    }
}

function increase_code_suffix($module)
{
    $module_name = mb_strtolower($module);
    $last_file_code = get_last_fn("$module_name");
    if (!empty($last_file_code)) {
        $dilimler = explode("-", $last_file_code);
        return str_pad(($dilimler[1] + 1), 4, "0", STR_PAD_LEFT);
    } else {
        return "0001";
    }
}

function file_name_len()
{
    $last_file_code = get_last_record();
    $dilimler = explode("-", $last_file_code);
    $dilimler[1]; // dilim2
    $digits = strlen($dilimler[1]);
    return $digits;
}

function convert_array($not_array)
{
    $a = json_encode($not_array);
    $trash = array('"', ":", "[", "]", "{", "}", "id", ",");
    $remove = array('', "", "", "", "", "", "", ", ");
    $b = strtolower(str_replace($trash, $remove, $a));
    $c = str_getcsv($b);
    return $c;
}

function db_name($module_name)
{
    $module_names =
        array(
            'projects' => 'project',
            'contract' => 'contract',
            'bond' => 'bond',
        );

    $ext = array_search(mb_strtolower($module_name), $module_names);
    if (empty($ext)) {
        echo 'None';
    } else {
        echo $ext;
    }

}

function tevkifat($seperated)
{
    $aranacak_string = "/";
    $arama_sonucu = strstr($seperated, $aranacak_string);
    if ($arama_sonucu !== FALSE) {
        $value = explode("/", $seperated);
        return $value[0] / $value[1];
    } else {
        return 0;
    }
}

function price_gap($gap)
{
    if ($gap == "0") {
        echo "Yok";
    } elseif ($gap == "1") {
        echo "Genel Endeks";
    } elseif ($gap == "2") {
        echo "Ağırlık Endeksleri";
    } else {
        echo "Yok";
    }
}

function project_type($deger)
{
    if ($deger == "1") {
        return "Resmi İş";
    } elseif ($deger == "2") {
        return "Özel İş";
    } else {
        return "Diğer";
    }
}

function project_cond($deger)
{
    if ($deger == 1) {
        return "Devam Eden";
    } elseif ($deger == 2) {
        return "İptal Olan";
    } elseif ($deger == 0) {
        return "Tamamlanan";
    } else {
        return "Diğer";
    }
}

function condition_type($type)
{

    if ($type == "1") {
        echo "İdari Şartname";
    } elseif ($type == "2") {
        echo "Teknik Şartname";
    } elseif ($type == "3") {
        echo "İş Sağlığı Güvenliği";
    } else {
        echo "Yok";
    }

}

function currency_symbol($type)
{

    if ($type == "pct") {
        echo "%";
    } elseif ($type == "Dolar") {
        echo "$";
    } elseif ($type == "Euro") {
        echo "€";
    } else {
        echo "Yok";
    }

}

function kapsam($code)
{

    if ($code == "1") {
        echo "Zorunlu Trafik Sigoratası";
    } elseif ($code == "2") {
        echo "Kasko";
    } else {
        echo "Seçiniz";
    }

}

function liability($code)
{
    if ($code == "1") {
        echo "Kiralayan'a Ait";
    } elseif ($code == "2") {
        echo "Kiraya Veren'e Ait ";
    } else {
        echo "Seçiniz";
    }
}

function kiralama_turu($code)
{

    if ($code == "1") {
        echo "Aylık";
    } elseif ($code == "2") {
        echo "Yıllık";
    } elseif ($code == "3") {
        echo "Günlük";
    } elseif ($code == "4") {
        echo "Saatlik";
    } elseif ($code == "5") {
        echo "Götürü Bedel";
    } else {
        echo "Seçiniz";
    }

}

function km_saat($code)
{
    if ($code == "1") {
        echo "Saat";
    } elseif ($code == "2") {
        echo "Km";
    } else {
        null;
    }
}

function servis_gerekce($code)
{
    if ($code == "1") {
        echo "Periyodik Bakım";
    } elseif ($code == "2") {
        echo "Arıza";
    } elseif ($code == "3") {
        echo "Muayene (TÜV-TSE)";
    } else {
        null;
    }
}

function fuel($code)
{
    if ($code == "1") {
        echo "Dizel";
    } elseif ($code == "2") {
        echo "Benzin";
    } else {
        null;
    }
}

function islem_turu($code)
{
    if ($code == "1") {
        echo "Lastik Hasar";
    } elseif ($code == "2") {
        echo "Motor Hasar";
    } elseif ($code == "3") {
        echo "Kaporta Hasar";
    } elseif ($code == "4") {
        echo "Genel Bakım";
    } elseif ($code == "5") {
        echo "Periyodik Kontrol";
    } elseif ($code == "6") {
        echo "Hidrolik";
    } elseif ($code == "7") {
        echo "Şanzuman";
    } elseif ($code == "8") {
        echo "Diğer";
    } else {
        echo "";
    }
}

function danger_class($code)
{
    if ($code == "1") {
        return "<i class='fa-solid fa-shield fa-lg' style='color:green'></i> Az Tehlikeli";
    } elseif ($code == "2") {
        return "<i class='fa-solid fa-triangle-exclamation fa-lg' style='color:orange'></i> Tehlikeli";
    } elseif ($code == "3") {
        return "<i class='fa-solid fa-radiation fa-lg' style='color:red'></i> Çok Tehlikeli";
    } else {
        return "";
    }
}

function member($code)
{
    if ($code == "1") {
        echo "Başkan";
    } elseif ($code == "0") {
        echo "Üye";
    } else {
        echo "";
    }
}

function get_thumb_name($file_name)
{
    $get_thumb = explode(".", "$file_name");
    $file_name = $get_thumb[0];
    $ext = $get_thumb[1];
    return $file_name . '_thumb.' . $ext;
}

function fractional($decimal)
{
    if ($decimal != 0 or $decimal != null) {
        $a = explode(".", $decimal);
        $b = $a[1] / 10;
        $c = "/10";
        return $b . $c;
    } else {
        return "0";
    }
}

function dateDifference($date_1, $date_2)
{
    $differenceFormat = '%r%a';
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}

function time_warning($date_1, $date_2, $criteria = null)
{
    $fark = dateDifference($date_1, $date_2);

    if ($criteria == null) {
        $criteria == 0;
    }

    if ($fark <= $criteria) {
        return TRUE;
    }
    if ($fark > $criteria) {
        return FALSE;
    }
}

function yazim_duzeni($str)
{
    return Transliterator::create('tr-title')->transliterate($str); // İstanbul Çok Güzel Bir Şehir
}

function qualify($deger)
{
    if ($deger == "0") {
        return '<i class="fa-solid fa-circle-xmark" style="color:red"></i>';
    } elseif ($deger == "1") {
        return '<i class="fa-solid fa-circle-check" style="color:green"></i>';
    } elseif ($deger == "2") {
        return '<i class="fa-solid fa-triangle-exclamation" style="color:darkorange"></i>';
    }
}

function qualify_stiuation($deger)
{
    if ($deger == "0") {
        return "Yok";
    } elseif ($deger == "1") {
        return "Var";
    } elseif ($deger == "2") {
        return "İstenmiyor";
    }
}

function cmp($a, $b)
{
    return $a['Teminat Mektubu'] <=> $b['Teminat Mektubu'];
}

function uclu($uclu)
{
    $uclu = trim($uclu);
    $yazi = array(
        "0" => array("2" => "", "1" => "", "0" => ""),
        "1" => array("2" => "Bir ", "1" => "On", "0" => "Yüz "),
        "2" => array("2" => "İki ", "1" => "Yirmi ", "0" => "İkiyüz "),
        "3" => array("2" => "Üç ", "1" => "Otuz ", "0" => "Üçyüz "),
        "4" => array("2" => "Dört ", "1" => "Kırk ", "0" => "Dörtyüz "),
        "5" => array("2" => "Beş ", "1" => "Elli ", "0" => "Beşyüz "),
        "6" => array("2" => "Altı ", "1" => "Altmış ", "0" => "Altıyüz "),
        "7" => array("2" => "Yedi ", "1" => "Yetmiş ", "0" => "Yediyüz "),
        "8" => array("2" => "Sekiz ", "1" => "Seksen ", "0" => "Sekizyüz "),
        "9" => array("2" => "Dokuz ", "1" => "Doksan ", "0" => "Dokuzyüz "));

    $ucluyazi = "";
    for ($i = 0; $i <= 2; $i++) {
        @$ucluyazi .= $yazi[(substr($uclu, $i, 1))][$i];
    }
    return ($ucluyazi);
}

function yaziyacevir($sayi)
{
    $olay = array("0" => " ", "1" => " ", "2" => "Bin ", "3" => "Milyon ", "4" => "Milyar ", "5" => "Trilyon ");
    $sayi = trim($sayi);
    $uzunluk = strlen($sayi);
    if ($uzunluk > 15) exit("Girdiğiniz Sayı Çok Büyük...");
    $kalan = $uzunluk - 3 * ($tane = floor($uzunluk / 3));
    if ($kalan != 0) {
        $tane++;
        for ($i = 0; $i <= $kalan; $i++) {
            $sayi = "0" . $sayi;
            $uzunluk++;
        }
    }
    $yazi = "";

    for ($i = $tane; $i >= 1; $i--) {
        if (!($i == 2 and (substr($sayi, ($uzunluk - ($i * 3)), 3) == "001")))
            $yazi .= uclu(substr($sayi, ($uzunluk - ($i * 3)), 3));
        if ((substr($sayi, ($uzunluk - ($i * 3)), 3) != "000")) $yazi .= $olay[$i];
    }
    return ($yazi);
}

function yaziyla_para($sayi, $currency = null, $currency_little = null)
{
    if (empty($currency)) {
        $currency = "TL";
    }
    if (empty($currency_little)) {
        $currency_little = "KRŞ";
    }

    // Sayısal bir değeri temsil eden bir dizge kontrolü yapılır.
    if (!is_numeric($sayi)) {
        return "-";
    }

    // Sayı formatı düzenlenir.
    $para = str_replace(",", ".", $sayi);
    $para = round($para, 2);
    $parca = explode(".", $para);
    $tampara = $parca[0];

    // Kuruş kısmı kontrol edilir.
    $kurus = isset($parca[1]) ? $parca[1] : "00";

    // Kuruşun uzunluğu kontrol edilir ve gerekirse düzenlenir.
    $kurusuzunluk = strlen($kurus);
    if ($kurusuzunluk == 1) {
        $kurus = $kurus * 10;
    }

    // Tam ve ondalık kısmın yazıyla ifade edilmesi.
    $tam = (int)$tampara > 0 ? yaziyacevir($tampara) . " " . $currency : "";
    $onda = (int)$kurus > 0 ? yaziyacevir($kurus) . " " . $currency_little : "";

    // İki kısım birleştirilir ve boşluklar temizlenir.
    $yazili = trim("$tam $onda");

    // Sonuç döndürülür.
    return $yazili;
}

function searcharray($value, $key, $array)
{
    foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
            return $k;
        }
    }
    return null;
}

function searchinarray($value, $array)
{
    return (array_search($value, $array, false));
}

function get_as_array($coloumn)
{
    return str_getcsv($coloumn);
}

function cms_arr_diff($large, $small)
{
    return array_diff($large, ["$small"]);
}

function remaining_day($last_day)
{
    return date_minus($last_day, date("d-m-Y")) / 86400;;
}

function foreach_loop($array, $column)
{
    foreach ($array as $data) {
        return $data->$column;
    }
}


function max_selection($array, $val)
{
    if (!is_array($array)) {
        return FALSE;
    }

    // Lets check for empty array elements and remove them
    foreach ($array as $key => $value) {
        if (mb_strlen($value) <= 0) {
            unset($array[$key]);
        }
    }

    return ($val >= count($array));
}


function display_tab($tab_index = array(), $active_tab = null)
{

    $tab_count = count($tab_index);
    $tab_range = range(1, $tab_count);
    $tab_construct = array_combine($tab_range, $tab_index);
    foreach ($tab_construct as $number => $tab) {
        if ($number == $active_tab) {
            echo "<li role='presentation' class='active'><a href='#tab-" . $number . "' aria-controls='tab-" . $number . "' role='tab'
       data-toggle='tab'>" . $tab . "</a></li>";
        } else {
            echo "<li role='presentation'><a href='#tab-" . $number . "' aria-controls='tab-" . $number . "' role='tab'
       data-toggle='tab'>" . $tab . "</a></li>";
        }
    }
}

function tags($tags = null)
{

    $etiketler = str_getcsv($tags);
    foreach ($etiketler as $etiket) {
        echo '<code>' . $etiket . '</code>&nbsp;&nbsp;';
    }
}

function get_active_user()
{
    $t = &get_instance();

    $session_user = $t->session->userdata("user");

    if ($session_user)
        return $session_user;
    else
        return false;
}

function active_user_id()
{
    $t = &get_instance();

    $session_user = $t->session->userdata("user");

    if ($session_user)
        return $session_user->id;
    else
        return false;
}

function temp_pass_control()
{
    $t = &get_instance();

    $active_user = $t->session->userdata("user");

    if ($active_user->temp_password == 1)
        return true;
    else
        return false;
}

function cms_email($to_email = "", $subject = "", $message = "")
{

    $t = &get_instance();

    $t->load->model("emailsettings_model");

    $t->load->helper("string");

    $email_settings = $t->Emailsettings_model->get(
        array(
            "isActive" => 1
        )
    );

    $config = array(

        "protocol" => $email_settings->protocol,

        "smtp_host" => $email_settings->host,

        "smtp_port" => $email_settings->port,

        "smtp_timeout" => "7",

        "smtp_user" => $email_settings->user,

        "smtp_pass" => $email_settings->password, // please take this from google app password services...

        "starttls" => TRUE,

        "charset" => "utf-8",

        "mailtype" => "html", // or text/plain

        "wordwrap" => TRUE,

        "newline" => "\r\n",

        "validate" => FALSE,

        "smtp_keep_alive" => TRUE

    );

    $t->load->library("email", $config);

    $t->email->from($email_settings->from, $email_settings->user_name);
    $t->email->to($to_email);
    $t->email->subject($subject);
    $t->email->message($message);

    return $t->email->send();

}

function isAdmin()
{
    $t = &get_instance();

    $session_user = $t->session->userdata("user");

    if ($session_user->is_Admin == 1)
        return true;
    else
        return false;
}

function getModuleList()
{
    $modules = array(
        "project" => array(
            "project"
        ),
        "contract" => array(
            "advance",
            "bond",
            "catalog",
            "contract",
            "costinc",
            "drawings",
            "extime",
            "newprice",
            "payment"
        ),
        "auction" => array(
            "auction",
            "aucdraw",
            "compute",
            "condition",
            "cost",
            "incentive",
            "notice",
            "offer"
        ),
        "site" => array(
            "report",
            "site",
            "sitestock",
            "sitewallet",
            "workgroup",
            "workmachine"
        ),
        "safety" => array(
            "accident",
            "checkup",
            "debit",
            "education",
            "safety",
            "score",
            "safetystock",
            "workman"
        ),
        "vehicle" => array(
            "fuel",
            "insurance",
            "rent",
            "service",
            "vehicle"
        ),
        "settings" => array(
            "company",
            "emailsettings",
            "settings",
            "user",
            "user_roles"
        )
    );

    return $modules;

}

function get_user_roles()
{

    $t = &get_instance();
    return $t->session->userdata("user_roles");
}


function send_email($toEmail = "", $subject = "", $message = "")
{

    $t = &get_instance();

    $t->load->model("emailsettings_model");

    $email_settings = $t->emailsettings_model->get(
        array(
            "isActive" => 1
        )
    );

    $config = array(

        "protocol" => $email_settings->protocol,
        "smtp_host" => $email_settings->host,
        "smtp_port" => $email_settings->port,
        "smtp_user" => $email_settings->user,
        "smtp_pass" => $email_settings->password,
        "starttls" => true,
        "charset" => "utf-8",
        "mailtype" => "html",
        "wordwrap" => true,
        "newline" => "\r\n"
    );

    $t->load->library("email", $config);

    $t->email->from($email_settings->from, $email_settings->user_name);
    $t->email->to($toEmail);
    $t->email->subject($subject);
    $t->email->message($message);

    return $t->email->send();

}

function get_category_title($category_id = 0)
{

    $t = &get_instance();

    $t->load->model("portfolio_category_model");

    $category = $t->portfolio_category_model->get(
        array(
            "id" => $category_id
        )
    );

    if ($category)
        return $category->title;
    else
        return "<b style='color:red'>Tanımlı Değil</b>";

}

function upload_picture($file, $uploadPath, $width, $height, $name)
{

    $t = &get_instance();
    $t->load->library("simpleimagelib");


    if (!is_dir("{$uploadPath}/{$width}x{$height}")) {
        mkdir("{$uploadPath}/{$width}x{$height}");
    }

    $upload_error = false;
    try {

        $simpleImage = $t->simpleimagelib->get_simple_image_instance();

        $simpleImage
            ->fromFile($file)
            ->thumbnail($width, $height, 'center')
            ->toFile("{$uploadPath}/{$width}x{$height}/$name", null, 75);

    } catch (Exception $err) {
        $error = $err->getMessage();
        $upload_error = true;
    }

    if ($upload_error) {
        echo $error;
    } else {
        return true;
    }


}

function get_picture($path = "", $picture = "", $resolution = "50x50")
{

    if ($picture != "") {

        if (file_exists(FCPATH . "uploads/$path/$resolution/$picture")) {
            $picture = base_url("uploads/$path/$resolution/$picture");
        } else {
            $picture = base_url("assets/assets/images/default_image.png");

        }

    } else {

        $picture = base_url("assets/assets/images/default_image.png");

    }

    return $picture;

}

function get_page_list($page)
{

    $page_list = array(
        "home_v" => "Anasayfa",
        "about_v" => "Hakkımızda Sayfası",
        "news_list_v" => "Haberler Sayfası",
        "galleries" => "Galeri Sayfası",
        "portfolio_list_v" => "Portfolyo Sayfası",
        "reference_list_v" => "Referanslar Sayfası",
        "service_list_v" => "Hizmetler Sayfası",
        "course_list_v" => "Eğitimler Sayfası",
        "brand_list_v" => "Markalar Sayfası",
        "contact_v" => "İletişim Sayfası",
    );


    return (empty($page)) ? $page_list : $page_list[$page];
}

function var_yok_option($field, $form_error)
{
    if (isset($form_error)) {
        if (set_value($field) == 1) {
            echo '<option selected value="1">Var</option>
                <option value="0">Yok</option>';
        } elseif (set_value($field) == 0) {
            echo '<option selected value="0">Yok</option>
                <option value="1">Var</option>';
        } elseif (set_value($field) == 2) {
            echo '<option selected value="2" >Seçiniz</option>
                <option value="1">Var</option>
                <option value="0">Yok</option>';
        } elseif (set_value($field) == null) {
            echo '<option selected value="2" >Seçiniz</option>
                <option value="1">Var</option>
                <option value="0">Yok</option>';
        }
    } else {
        echo '<option value="2" >Seçiniz</option>
                <option value="1">Var</option>
                <option value="0">Yok</option>';
    }

}

function var_yok_name($var_yok)
{
    $vay_yok_name =
        array(
            'Yok' => 0,
            'Boş' => null,
            'Var' => 1,
            'Seçiniz' => 2,
        );

    $ext = array_search($var_yok, $vay_yok_name);
    if (empty($ext)) {
        return 'HATA';
    } else {
        return $ext;
    }

}

function all_array_keys($arr)
{
    static $keys = [];
    foreach ($arr as $key => $val) {
        $keys[] = $key;
        if (is_array($val))
            return all_array_keys($val);
    }
    return $keys;
}

function get_ids_for_delete($modules)
{
    $ids = array();
    foreach ($modules as $module) {
        $ids[] = $module->id;
    }
    return $ids;
}

function bid_file_name($file_name)
{
    $slice = explode("---", $file_name);
    return company_name($slice[0]) . " " . $slice[1];
}

function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}

function random_idioms()
{
    $ci =& get_instance();
    $ci->load->database();
    $query = $ci->db->get("idioms")->result_array();
    return array_rand($query);
}

function array_uunique(array $array, callable $comparator): array
{
    $unique_array = [];
    do {
        $element = array_shift($array);
        $unique_array[] = $element;

        $array = array_udiff(
            $array,
            [$element],
            $comparator
        );
    } while (count($array) > 0);

    return $unique_array;
}

function favorite($array)
{

    $favorite_in_database = get_favorite();

    if (empty($favorite_in_database)) {
        $favorite_in_database = array();
    }
    $i = 0;
    foreach ($favorite_in_database as $x) {
        $similarty = count(array_diff($x, $array));
        if ($similarty == 0) {
            $i++;
        }
    }

    return $i;
}

function array_search_id($search_value, $array, $id_path)
{

    if (is_array($array) && count($array) > 0) {

        foreach ($array as $key => $value) {

            $temp_path = $id_path;

            // Adding current key to search path
            array_push($temp_path, $key);

            // Check if this value is an array
            // with atleast one element
            if (is_array($value) && count($value) > 0) {
                $res_path = array_search_id(
                    $search_value, $value, $temp_path);

                if ($res_path != null) {
                    return $res_path;
                }
            } else if ($value == $search_value) {
                return join(" --> ", $temp_path);
            }
        }
    }

    return null;
}

function pick_random_color()
{

    $colors = array(
        'rgba(211, 198, 157, 0.79)',
        'rgba(164, 195, 205, 0.79)',
        'rgba(174, 178, 227, 0.79)',
        'rgba(201, 201, 158, 0.79)',
        'rgba(171, 187, 197, 0.79)',
        'rgba(195, 138, 141, 0.79)',
        'rgba(179, 125, 144, 0.79)',
        'rgba(156, 205, 183, 0.79)',
        'rgba(211, 191, 175, 0.79)',
        'rgba(194, 162, 205, 0.79)',
        'rgba(202, 165, 206, 0.79)',
        'rgba(161, 194, 183, 0.79)',
        'rgba(158, 202, 205, 0.79)',
        'rgba(170, 202, 211, 0.79)',
        'rgba(213, 205, 156, 0.79)',
        'rgba(201, 199, 162, 0.79)',
        'rgba(156, 203, 176, 0.79)',
        'rgba(122, 132, 153, 0.79)',
        'rgba(166, 202, 194, 0.79)',
        'rgba(194, 191, 229, 0.79)',
        'rgba(193, 138, 146, 0.79)',
        'rgba(193, 164, 209, 0.79)',
        'rgba(205, 199, 166, 0.79)',
        'rgba(203, 156, 206, 0.79)',
        'rgba(205, 169, 205, 0.79)',
        'rgba(199, 195, 159, 0.79)',
        'rgba(196, 192, 170, 0.79)',
        'rgba(175, 175, 225, 0.79)',
        'rgba(172, 195, 208, 0.79)',
        'rgba(190, 174, 228, 0.79)',
        'rgba(193, 129, 148, 0.79)',
        'rgba(158, 196, 200, 0.79)',
        'rgba(117, 136, 149, 0.79)',
        'rgba(183, 194, 229, 0.79)',
        'rgba(184, 192, 224, 0.79)',
        'rgba(183, 122, 147, 0.79)',
        'rgba(161, 197, 211, 0.79)',
        'rgba(192, 163, 193, 0.79)',
        'rgba(201, 179, 159, 0.79)',
        'rgba(183, 136, 136, 0.79)',
        'rgba(191, 190, 215, 0.79)',
        'rgba(170, 206, 167, 0.79)',
        'rgba(205, 205, 171, 0.79)',
        'rgba(166, 208, 163, 0.79)',
        'rgba(197, 158, 205, 0.79)',
        'rgba(203, 173, 205, 0.79)',
        'rgba(191, 133, 139, 0.79)',
        'rgba(193, 159, 197, 0.79)',
        'rgba(167, 197, 198, 0.79)'
    );
    $randomColor = $colors[array_rand($colors)];
    return $randomColor;
}

function formatPhoneNumber($phoneNumber)
{
    // Türkiye'deki telefon numarası formatı: (xxx) xxx-xxxx
    // xxx, alan kodu ve numara kısmını temsil eder.

    // Telefon numarasındaki gereksiz karakterleri kaldırma
    $cleanedNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Eğer numara uzunluğu 10 karaktere eşit değilse, geçersiz numara olarak kabul et
    if (strlen($cleanedNumber) !== 10) {
        return false;
    }

    // Numarayı uygun formata dönüştürme
    $formattedNumber = '(' . substr($cleanedNumber, 0, 3) . ') ' . substr($cleanedNumber, 3, 3) . ' ' . substr($cleanedNumber, 6, 2) . ' ' . substr($cleanedNumber, 8, 2);

    return $formattedNumber;
}

// Örnek kullanım
$phoneNumber = "5551234567";
$formattedPhoneNumber = formatPhoneNumber($phoneNumber);
if ($formattedPhoneNumber) {
    return "Formatted Phone Number: " . $formattedPhoneNumber;
} else {
    return "Invalid Phone Number!";
}

function recursive_count($array)
{
    $count = 0;
    foreach ($array as $element) {
        if (is_array($element)) {
            $count += recursive_count($element);
        } else {
            $count++;
        }
    }
    return $count;
}

function sortArrayByCriteria($array, $criteria)
{
    usort($array, function ($a, $b) use ($criteria) {
        foreach ($criteria as $key => $order) {
            if ($a->$key != $b->$key) {
                if ($order === 'asc') {
                    return ($a->$key < $b->$key) ? -1 : 1;
                } else {
                    return ($a->$key > $b->$key) ? -1 : 1;
                }
            }
        }
        return 0;
    });

    return $array;
}

function get_days_in_month($year, $month) {
    // Belirtilen yıl ve ayda kaç gün olduğunu döndürür
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}