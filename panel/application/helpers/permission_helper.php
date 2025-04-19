<?php
function user_has_permission($module, $actions) {
    $ci =& get_instance();

    // Eğer kullanıcı admin ise, hemen izin ver
    $session_user = $ci->session->userdata('user');
    if ($session_user && isset($session_user->is_Admin) && $session_user->is_Admin == 1) {
        return true;
    }

    // Kullanıcıyı veritabanından al
    if (!$session_user) return false;

    $user_data = $ci->User_model->get(["id" => $session_user->id]);
    if (!$user_data) return false;

    // Kullanıcının yetkilerini al
    $permissions = isset($user_data->permissions) ? json_decode($user_data->permissions, true) : [];

    // İlgili modül için yetki yoksa
    if (!isset($permissions[$module])) return false;

    // Kullanıcının o modüldeki yetkilerini al
    $user_perms = $permissions[$module];

    // Eğer aksiyonlar bir dizi ise, her birini kontrol et
    if (is_array($actions)) {
        foreach ($actions as $action) {
            if (strpos($user_perms, $action) !== false) {
                return true; // herhangi biri varsa yeterli
            }
        }
    }
    // Eğer aksiyon tek bir string ise, onu kontrol et
    elseif (is_string($actions)) {
        return strpos($user_perms, $actions) !== false;
    }

    return false;
}