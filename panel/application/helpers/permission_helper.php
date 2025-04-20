<?php
function user_has_permission($module, $actions) {
    $ci =& get_instance();

    // Eğer kullanıcı admin ise, tüm yetkilere sahiptir
    $session_user = $ci->session->userdata('user');
    if ($session_user && isset($session_user->is_Admin) && $session_user->is_Admin == 1) {
        return true;
    }

    // Giriş yapılmamışsa veya kullanıcı verisi yoksa
    if (!$session_user) return false;

    $user_data = $ci->User_model->get(["id" => $session_user->id]);
    if (!$user_data) return false;

    // Yetkileri al ve JSON'dan diziye çevir
    $permissions = isset($user_data->permissions) ? json_decode($user_data->permissions, true) : [];

    // Modül yetkisi yoksa false
    if (!isset($permissions[$module])) return false;

    // Modül için kullanıcının yetkilerini al
    $user_perms = $permissions[$module];

    // Yetkiler dizi olarak değilse (hatalı kayıt), düzelt
    if (!is_array($user_perms)) {
        $user_perms = str_split((string) $user_perms); // örn: "rwu" => ['r','w','u']
    }

    // Kontrol edilecek aksiyonlar bir dizi mi?
    if (is_array($actions)) {
        foreach ($actions as $action) {
            if (in_array($action, $user_perms)) {
                return true; // herhangi bir eşleşme yeterli
            }
        }
    } elseif (is_string($actions)) {
        return in_array($actions, $user_perms);
    }

    return false;
}