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

function filenamedisplay_long($text)
{
    $turkce = array("-");
    $convert = array(" ");

    $bring_spaces = str_replace($turkce, $convert, $text);
    $case_url = mb_convert_case($bring_spaces, MB_CASE_TITLE);

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

function YM_to_M($tarih) {
    // Türkçe ay isimlerini ve sayıları içeren dizi
    $aylar = array(
        '01' => 'Ocak',
        '02' => 'Şubat',
        '03' => 'Mart',
        '04' => 'Nisan',
        '05' => 'Mayıs',
        '06' => 'Haziran',
        '07' => 'Temmuz',
        '08' => 'Ağustos',
        '09' => 'Eylül',
        '10' => 'Ekim',
        '11' => 'Kasım',
        '12' => 'Aralık'
    );

    // Gelen tarih "Y-m" formatında, yılı ve ayı ayırma
    list($yil, $ay) = explode('-', $tarih);

    // Ay ismini al
    $ayIsmi = $aylar[$ay];

    // Sonucu döndür
    return $ayIsmi . " " . $yil;
}

function gun_sayisi() {
    $ilk_gun = date('Y-m-01');
    $son_gun = date('Y-m-t');
    $gun_sayisi = (int)date('d', strtotime($son_gun));

    return $gun_sayisi;
}

function dateFormat_dmy_hi($givenDate = null)
{

    return date('d-m-Y h:i', strtotime($givenDate));

}

function date_plus_days($date, $days = "")
{
    return date('d-m-Y', strtotime($date . ' +' . $days . ' days'));
}

function ay_isimleri($ay)
{
    $array = array('Ocak' => '1', 'Şubat' => '2', 'Mart' => '3', 'Nisan' => '4', 'Mayıs' => '5', 'Haziran' => '6', 'Temmuz' => '7', 'Ağustos' => '8', 'Eylül' => '9', 'Ekim' => '10', 'Kasım' => '11', 'Aralık' => '12');

    $key = array_search($ay, $array); // $key = 2;

    return $key;
}

function tarihFormatla($tarih) {
    // Türkçe ay ve gün adlarını içeren bir dizi
    $turkce_aylar = array(
        "January"   => "Ocak",
        "February"  => "Şubat",
        "March"     => "Mart",
        "April"     => "Nisan",
        "May"       => "Mayıs",
        "June"      => "Haziran",
        "July"      => "Temmuz",
        "August"    => "Ağustos",
        "September" => "Eylül",
        "October"   => "Ekim",
        "November"  => "Kasım",
        "December"  => "Aralık"
    );

    $turkce_gunler = array(
        "Sunday"    => "Pazar",
        "Monday"    => "Pazartesi",
        "Tuesday"   => "Salı",
        "Wednesday" => "Çarşamba",
        "Thursday"  => "Perşembe",
        "Friday"    => "Cuma",
        "Saturday"  => "Cumartesi"
    );

    // Verilen tarihin ay ve gün adlarını İngilizce'den Türkçe'ye çevirme
    $ingilizce_ay = date("F", strtotime($tarih));
    $ingilizce_gun = date("l", strtotime($tarih));

    $turkce_ay = $turkce_aylar[$ingilizce_ay];
    $turkce_gun = $turkce_gunler[$ingilizce_gun];

    // Türkçe tarih formatını oluşturma
    $turkce_tarih = date("d", strtotime($tarih)) . ' ' . $turkce_ay . ' ' . date("Y", strtotime($tarih)) . ' ' . $turkce_gun;

    return $turkce_tarih;
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

function two_digits_percantage($number)
{
    $rounded = sprintf("%.2f", $number * 100);
    return "% " . $rounded;
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
            'skb' => base_url("assets") . "/images/file_img/sketchup.png",
            'kmz' => base_url("assets") . "/images/file_img/kmz.png",
        );

    foreach ($file_types as $file_type => $value) {
        if ($file_type == $ext) {
            return ' <img src="' . $value . '" style="width:35px">';
        }
    }

}


function module_name($module_name)
{
    $module_types = array(
        "Proje" => "project",
        "Hakediş Metraj" => "boq",
        "Avans" => "advance",
        "Teminat" => "bond",
        "Sözleşme" => "contract",
        "Keşif Artışı" => "costinc",
        "Teknik Çizimler" => "drawings",
        "Süre Uzatımı" => "extime",
        "Yeni Birim Fiyat" => "newprice",
        "Hakediş" => "payment",
        "Rapor" => "report",
        "Şantiye" => "site",
        "Şantiye Depo" => "sitestock",
        "Şantiye Kasa" => "sitewallet",
        "İş Grupları" => "workgroup",
        "İş Makineleri" => "workmachine",
        "Puantaj" => "score",
        "Çalışan" => "workman",
        "Firma" => "company",
        "E-Posta Ayarları" => "emailsettings",
        "Sistem Ayarları" => "settings",
        "Teklifler" => "offer",
        "Kullanıcılar" => "user",
        "Finansal" => "finance",
        "Ödemeler" => "collection",
        "Kullanıcı Rolleri" => "user_roles",
        "Varsayılan İş Grupları" => "default_workgroup"
    );

    $ext = array_search(mb_strtolower($module_name), $module_types);
    return empty($ext) ? $module_name : $ext;
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


function increase_code_suffix($module)
{
    echo "Dosya No Hatalı";
}

function file_name_len()
{
    $last_file_code = get_last_record();
    $dilimler = explode("-", $last_file_code);
    $dilimler[1]; // dilim2
    $digits = strlen($dilimler[1]);
    return $digits;
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

function dateDifference($date_1, $date_2)
{
    $differenceFormat = '%r%a';
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

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

function get_as_array($coloumn)
{
    return str_getcsv($coloumn);
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
            "contract",
            "offer",
            "payment"
        ),
        "site" => array(
            "site",
        ),
        "settings" => array(
            "company",
            "settings",
            "user",
            "user_roles"
        )
    );

    return $modules;

}

function get_dir_contents($path, $type = 'both') {
    if (!is_dir($path)) return [];

    $items = scandir($path);
    if ($items === false) return [];

    return array_filter($items, function ($item) use ($path, $type) {
        $fullPath = $path . DIRECTORY_SEPARATOR . $item;
        if (in_array($item, ['.', '..'])) return false;

        if ($type === 'dir') return is_dir($fullPath);
        if ($type === 'file') return is_file($fullPath);
        return true; // both
    });
}

function createDirectories($basePath, $subdirectories) {
    foreach ($subdirectories as $dir) {
        $path = $basePath . '/' . $dir;
        if (!is_dir($path) && !mkdir($path, 0777, true)) {
            log_message('error', "Directory creation failed: {$path}");
            // Hata yönetimi ekleyebilirsiniz
        }
    }
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

function get_ids_for_delete($modules)
{
    $ids = array();
    foreach ($modules as $module) {
        $ids[] = $module->id;
    }
    return $ids;
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
function get_days_in_month($year, $month) {
    // Belirtilen yıl ve ayda kaç gün olduğunu döndürür
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}
function roundToNearest($number, $nearestValues) {
    $nearest = $nearestValues[0];
    foreach ($nearestValues as $value) {
        if ($value >= $number) {
            $nearest = $value;
            break;
        }
    }
    return $nearest;

}

// Boyutları okunabilir formata dönüştürmek için fonksiyon
function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
    return number_format($bytes / pow(1024, $power), 2) . ' ' . $units[$power];
}

// Klasörün toplam boyutunu hesaplamak için fonksiyon
function getFolderSize($dir) {
    $size = 0;

    // Klasördeki tüm dosya ve alt klasörleri gez
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $file) {
        $size += $file->getSize(); // Her dosyanın boyutunu ekle
    }

    return $size;
}

function permission_control($module, $permission)
{
    // CodeIgniter instansı al
    $ci =& get_instance();

    // Oturumdaki kullanıcı verilerini al
    $session_user = $ci->session->userdata('user');

    $user_data = $ci->User_model->get(
        array(
            "id" => $session_user->id
        )
    );


    if (!$user_data) {
        return false; // Kullanıcı oturumu yoksa yetkisiz
    }

    // Kullanıcının izinlerini kontrol et
    $permissions = isset($user_data->permissions) ? json_decode($user_data->permissions, true) : [];

    // İlgili modül ve izin kontrolü
    if (isset($permissions[$module][$permission]) && $permissions[$module][$permission] === 'on') {
        return true; // Yetki var
    }

    return false; // Yetki yok
}

function getExcelColumn($index) {
    $columnName = '';
    while ($index > 0) {
        $index--;
        $columnName = chr($index % 26 + 65) . $columnName;
        $index = intdiv($index, 26);
    }
    return $columnName;
}


