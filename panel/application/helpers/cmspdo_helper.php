<?php
function get_last_record()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('file_order');
    $ci->db->order_by('id', "desc");
    $ci->db->limit(1);
    $last_row = $ci->db->get('file_order');

    foreach ($last_row->result() as $row) {
        return $row->file_order;
    }
}

//İLgili modülde yapılan son kaydı 1 arttırıyor. Her modl kendi ön ekinde arttırılacak. SOZ-01 KA-002 TMN-001 Gibi
function get_last_fn($module)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('file_order');
    $ci->db->where('module', $module);
    $ci->db->order_by('id', "desc");
    $ci->db->limit(1);
    $last_row = $ci->db->get('file_order');

    foreach ($last_row->result() as $row) {
        return $row->file_order;
    }
}


function get_from_id($table, $column, $id)
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->db->select($column);
    $ci->db->where('id', $id);
    $q = $ci->db->get($table);

    return ($q->num_rows() > 0) ? $q->row()->$column : null;
}

function get_from_any($table, $column, $where, $item)
{
    $ci = &get_instance();
    $ci->load->database();


    $ci->db->select($column);
    $ci->db->where($where, $item);
    $q = $ci->db->get(mb_strtolower($table));

    return ($q->num_rows() > 0) ? $q->row()->$column : null;
}

function get_from_any_and($table, $where_first, $equal_first, $where_second, $equal_second)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where($where_first, $equal_first);
    $ci->db->where($where_second, $equal_second);
    $query = $ci->db->get($table);
    foreach ($query->result() as $data) {
        return $data->id;
    }
}

function get_from_any_and_and($table, $where_first, $equal_first, $where_second, $equal_second, $where_third, $equal_third)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where($where_first, $equal_first);
    $ci->db->where($where_second, $equal_second);
    $ci->db->where($where_third, $equal_third);
    $query = $ci->db->get($table);
    foreach ($query->result() as $data) {
        return $data->id;
    }
}

function get_module_files($table, $dependet_id_name, $dependet_id)
{

    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM " . $table . " where " . $dependet_id_name . " =" . $dependet_id;
    $array = $ci->db->query($sql);
    if ($array->num_rows() > 0) {
        return $array->result();
    }
}

function get_from_any_array($table, $column, $id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM " . $table . " where " . $column . " =" . $id;
    $array = $ci->db->query($sql);
    if ($array->num_rows() > 0) {
        return $array->result();
    }
}


function get_from_any_array_select_ci($select, $table, $column, $id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select($select);
    $ci->db->where($column, $id);
    $query = $ci->db->get($table)->result_array();
    return array_column($query, 'id');
}


function get_settings()
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();
    return $settings;
}

function get_currency($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM contract where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->para_birimi;
        }
    }
}


function project_code($id)
{
    $t = &get_instance();

    $t->load->model("Project_model");

    $project = $t->Project_model->get(array(
        "id" => $id
    ));

    return $project->dosya_no;
}

function all_projects()
{
    $t = get_instance();
    $t->load->model("Project_model");
    $projects = $t->Project_model->get_all(array());

    return $projects;
}

function all_contracts()
{
    $t = get_instance();
    $t->load->model("Contract_model");
    $contracts = $t->Contract_model->get_all(array());

    return $contracts;
}

function all_subcontracts()
{
    $t = get_instance();
    $t->load->model("Contract_model");
    $subcontracts = $t->Contract_model->get_all(array(
        "parent >" => 0
    ));

    return $subcontracts;
}

function all_sites()
{
    $t = get_instance();
    $t->load->model("Site_model");
    $sites = $t->Site_model->get_all(array());

    return $sites;
}

function project_id_cont($contract_id)
{
    $t = get_instance();
    $t->load->model("Contract_model");
    $contract = $t->Contract_model->get(array(
        "id" => $contract_id
    ));

    return $contract->proje_id;
}

function project_id_site($site_id)
{
    $t = get_instance();
    $t->load->model("Site_model");
    $site = $t->Site_model->get(array(
        "id" => $site_id
    ));

    return $site->proje_id;
}

function contract_id_module($module, $id)
{
    $model_name = ucfirst($module) . "_model";
    $t = get_instance();
    $t->load->model("Contract_model");
    $module = $t->$model_name->get(array(
        "id" => $id
    ));

    return $module->contract_id;
}


function contract_code($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `contract` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->dosya_no;
        }
    }
}

function contract_price($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `contract` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->sozlesme_bedel;
        }
    }
}

function project_code_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `project` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            $project_name = $data->project_name;
            $project_code = $data->dosya_no;
        }
    }
    return $project_code . " / " . $project_name;
}

function contract_code_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `contract` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            $contract_name = $data->contract_name;
            $contract_code = $data->dosya_no;
        }
    }
    return $contract_name . " / " . $contract_code;
}


function project_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `project` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            $project_name = $data->project_name;
        }
    }
    if (isset($project_name)) {
        return $project_name;
    } else {
        return "Silinmiş Proje";
    }
}

function site_name($id)
{
    if ($id == 0) {
        return "Fire";
    } elseif ($id == 99999) {
        return "Depo";
    } else {
        $t = get_instance();
        $site = $t->Site_model->get(
            array(
                'id' => $id
            )
        );
        if (!empty($id)) {
            return $site->santiye_ad;
        } else {
            return "Tanımsız Şantiye";
        }
    }
}

function site_code($id)
{
    $t = get_instance();
    $site = $t->Site_model->get(
        array(
            'id' => $id
        )
    );
    if (!empty($id)) {
        return $site->dosya_no;
    } elseif ($id == 0) {
        return "Bağımsız Şantiye";
    } else {
        return "Bağımsız Şantiye";
    }
}

function site_code_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `site` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            $site_name = $data->santiye_ad;
            $site_code = $data->dosya_no;
        }
    }
    return $site_code . " / " . $site_name;
}

function fill_empty_digits()
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();
    $settings_digits = 4;
    return str_repeat("0", $settings_digits - 1);
}

function default_table()
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();
    $settings_digits = $settings->default_table;
    return $settings_digits;
}

function work_groups()
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();

    $work_groups = str_getcsv($settings->is_grubu);
    foreach ($work_groups as $work_group) {
        echo "<option value='$work_group'>$work_group</option>";
    }
}

function file_name_digits()
{
    return "4";
}

function match_value($surec_durum)
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();
    $settings_color = $settings->surec_color;
    $obj = json_decode($settings_color);
    if (!empty($obj->{$surec_durum})) {
        echo $obj->{$surec_durum};
    } else {
        echo "";
    }
}

function count_data($table, $where, $id)
{
    $t = get_instance();
    $t->db->where($where, $id);
    $t->db->from($table);
    return $t->db->count_all_results();
}

function count_data_multi($table, $where1, $key1, $where2, $key2)
{
    $t = get_instance();
    $t->db->where($where1, $key1);
    $t->db->where($where2, $key2);
    $t->db->from($table);
    return $t->db->count_all_results();
}


function sum_selected($table, $where_first, $where_second, $id, $currency, $sum)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($sum);
    $ci->db->where($where_first, $id);
    $ci->db->where($where_second, $currency);
    $query = $ci->db->get($table);
    foreach ($query->result() as $data) {
        return $data->sozlesme_bedel;
    }
}

function contract_name($id)
{
    if ($id == 0) {
        return "Sözleşmesiz";
    } else {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `contract` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->contract_name;
            }
        }
    }
}

function vehicle_plate($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `vehicle` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->plaka;
        }
    }
}

function vehicle_detail($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `vehicle` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->plaka . "-" . $data->marka . "-" . $data->ticari_ad;
        }
    }
}


function full_name($id = null)
{
    if ($id != null) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM users where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->name . " " . $data->surname;
            }
        }
    } else {
        echo "Seçiniz";
    }
}

function worker_name($id = null)
{
    if ($id != null) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM workman where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->name . " " . $data->surname;
            }
        }
    } else {
        echo "Seçiniz";
    }
}

function get_avatar($id)
{
    if (!empty($id)) {
        $avatars = (directory_map("uploads/users_v/system_users/$id"));
        if (!empty($avatars)) {
            return 'src="' . base_url() . 'uploads/users_v/system_users/' . $id . '/' . $avatars[0] . '"';
        } else {
            return 'src="' . base_url() . 'assets/images/avtar/empty.png"';
        }
    }
}

function get_company_avatar($id)
{
    if (!empty($id)) {
        $avatars = (directory_map("uploads/companys_v/system_companys/$id"));
        if (!empty($avatars)) {
            return 'src="' . base_url() . 'uploads/companys_v/system_companys/' . $id . '/' . $avatars[0] . '"';
        } else {
            return 'src="' . base_url() . 'assets/images/avtar/empty.png"';
        }
    }
}

function company_avatar_isset($id)
{
    if (!empty($id)) {
        $avatars = (directory_map("uploads/companys_v/system_companys/$id"));
        if (!empty($avatars)) {
            return true;
        } else {
            return false;
        }
    }
}


function company_name($id)
{

    if (is_numeric($id) && !empty($id)) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `companys` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->company_name;
            }
        }
    } else {
        echo "Seçilmemiş";
    }
}

function city_name($id = null)
{
    if ($id != null) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `city` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                echo mb_strtoupper($data->city_name, "UTF-8");
            }
        }
    } else {
        echo "Seçiniz";
    }
}

function tax_office_name($id = null)
{
    if ($id != null) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `tax_office` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                echo $data->tax_office;
            }
        }
    } else {
        echo "Seçiniz";
    }
}

function district_name($id = null)
{
    if ($id != null) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `district` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                echo $data->district;
            }
        }
    } else {
        echo "Seçiniz";
    }
}

function limit_cost($contract_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum('artis_miktar');
    $ci->db->where('contract_id', $contract_id);
    $query = $ci->db->get('costinc');
    foreach ($query->result() as $data) {
        $costinc = $data->artis_miktar;
    }

    $ci->db->select('sozlesme_bedel');
    $ci->db->where('id', $contract_id);
    $query2 = $ci->db->get('contract');
    foreach ($query2->result() as $data2) {
        $contract = $data2->sozlesme_bedel;
    }

    return $costinc + $contract;
}


function count_payments($contract_id)
{
    $ci =& get_instance();
    $ci->load->database();
    return $ci->db->select('id')->from('payment')->where('contract_id', $contract_id)->count_all_results();
}

function last_payment($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_max('hakedis_no');
    $ci->db->where('contract_id', $id);
    $result = $ci->db->get('payment')->row();
    return $result->hakedis_no;
}

function sum_payments($spect, $id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($spect);
    $ci->db->where('contract_id', $id);
    $query = $ci->db->get('payment');
    foreach ($query->result() as $data) {
        return $data->$spect;
    }
}

function sum_anything($tablo, $toplanacak_veri, $vt_id, $id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($toplanacak_veri);
    $ci->db->where($vt_id, $id);
    $query = $ci->db->get($tablo);
    foreach ($query->result() as $data) {
        return $data->$toplanacak_veri;
    }
}

function sum_anything_and($tablo, $toplanacak_veri, $cond1, $conn1, $cond2, $conn2)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($toplanacak_veri);
    $ci->db->where($cond1, $conn1);
    $ci->db->where($cond2, $conn2);
    $query = $ci->db->get($tablo);
    foreach ($query->result() as $data) {
        return $data->$toplanacak_veri;
    }
}

function sum_anything_and_and($tablo, $toplanacak_veri, $cond1, $conn1, $cond2, $conn2, $cond3, $conn3)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($toplanacak_veri);
    $ci->db->where($cond1, $conn1);
    $ci->db->where($cond2, $conn2);
    $ci->db->where($cond3, $conn3);
    $query = $ci->db->get($tablo);
    foreach ($query->result() as $data) {
        return $data->$toplanacak_veri;
    }
}

function sum_anything_and_and_or($tablo, $toplanacak_veri, $cond1, $conn1, $cond2, $conn2, $cond3, $conn3, $conn4)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($toplanacak_veri);
    $ci->db->where($cond1, $conn1);
    $ci->db->where($cond2, $conn2);
    $ci->db->group_start();
    $ci->db->where($cond3, $conn3);
    $ci->db->or_where($cond3, $conn4);
    $ci->db->group_end();
    $query = $ci->db->get("$tablo");
    foreach ($query->result() as $data) {
        return $data->$toplanacak_veri;
    }
}

function sum_anything_and_or($tablo, $toplanacak_veri, $cond1, $conn1, $cond2, $conn2, $conn3)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($toplanacak_veri);
    $ci->db->where($cond1, $conn1);
    $ci->db->group_start();
    $ci->db->where($cond2, $conn2);
    $ci->db->or_where($cond2, $conn3);
    $ci->db->group_end();
    $query = $ci->db->get("$tablo");
    foreach ($query->result() as $data) {
        return $data->$toplanacak_veri;
    }
}

function sum_from_table($table, $spect, $id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_sum($spect);
    $ci->db->where('contract_id', $id);
    $query = $ci->db->get($table);
    foreach ($query->result() as $data) {
        return $data->$spect;
    }
}


function group_name($id)
{
    if (!empty($id)) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `workgroup` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->name;
            }
        }
    } else {
        return null;
    }
}

function boq_name($id)
{
    if (!empty($id)) {
        $ci =& get_instance();
        $ci->load->database();
        $sql = "SELECT * FROM `book` where `id` =" . $id;
        $q = $ci->db->query($sql);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $data) {
                return $data->name;
            }
        }
    } else {
        return null;
    }
}

function machine_name($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT * FROM `workmachine` where `id` =" . $id;
    $q = $ci->db->query($sql);
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $data) {
            return $data->name;
        }
    }
}


function theme_settings()
{
    $t = get_instance();
    $t->load->model("Settings_model");
    $settings = $t->Settings_model->get();
    $colour = $settings->theme_colour;
    $fold = $settings->theme_panelfold;

    if ($colour == 1) {
        $colour_set = "menubar-left theme-inverse menubar-light";
    } else {
        $colour_set = "menubar-left theme-inverse menubar-dark";
    }

    if ($fold == 1 or $fold = null) {
        $fold_set = "menubar-unfold";
    } else {
        $fold_set = "menubar-fold";
    }

    echo $colour_set . " " . $fold_set;

}


function get_last_date($contract_id, $table, $date_criter)
{
    $ci =& get_instance();
    $ci->load->database();

    $query = $ci->db->select("$date_criter")->where("contract_id", $contract_id)->order_by("id", "desc")->limit(1)->get("$table");
    foreach ($query->result() as $data) {
        return $data->$date_criter;
    }
}

function get_next_file_code($module_name)
{
    // CodeIgniter'nin global $CI nesnesini yükle
    $CI =& get_instance();

    // Model adını belirle
    $model_name = ucfirst($module_name) . '_model';

    // Belirtilen modül için model yüklenmiş mi kontrol et, yüklenmemişse yükle
    if (!isset($CI->$model_name)) {
        $CI->load->model($model_name);
    }

    // İlgili modelin get_all() metodunu çağır
    if (!method_exists($CI->$model_name, 'get_all')) {
        throw new Exception("Model '$model_name' içinde 'get_all' metodu bulunamadı.");
    }

    $all_records = $CI->$model_name->get_all();

    // Dosya numaralarını işlemek için array_map kullan
    $file_numbers = array_map(function ($record) {
        $parts = explode('-', $record->dosya_no);
        return isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : 0;
    }, $all_records);

    // Dosya numaralarını sırala ve maksimum değeri bul
    sort($file_numbers);
    $max_value = empty($file_numbers) ? 0 : max($file_numbers);

    // Bir sonraki dosya numarasını oluştur
    $max_value++;
    $next_file_code = str_pad($max_value, 4, '0', STR_PAD_LEFT);

    return $next_file_code;
}


