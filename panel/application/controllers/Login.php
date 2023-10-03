<?php

class login extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        $this->moduleFolder = "user_module";
        $this->viewFolder = "login_v";
        $this->load->model("user_model");
        $this->load->model("Settings_model");
        $this->load->model("Emailsettings_model");

        $this->Module_Name = "login";
        $this->Module_Title = "Oturum Aç";

        // Folder Structure
        $this->Module_Main_Dir = "users_v";
        $this->Module_Depended_Dir = "users";

    }

    public function login()
    {
        
        if (get_active_user()) {
            redirect(base_url("dashboard"));
        }

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);
    }

    public function do_login()
    {
        if (get_active_user()) {
            redirect(base_url("dashboard"));
        }


        $this->load->library('encryption');
        $this->load->library("form_validation");

        $user_name = $this->input->post("user_name");

        $password = $this->input->post("user_password");

        $users = $this->user_model->get_all(array(
            "isActive" => 1,
        ));

        $user_names = str_replace('"', '', (json_encode(array_column($users, 'user_name'))));

        $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "in_list$user_names|required|trim|min_length[6]|callback_name_control");

        $user = $this->user_model->get(
            array(
                "user_name" => $user_name,
            )
        );

        if (!empty($user)) {
            $decrypted_password = $this->encryption->decrypt($user->password);
            if ($decrypted_password != $password) {
                $this->form_validation->set_rules("user_password", "Şifre", "min_length[6]|matches[$decrypted_password]|required|trim");
            }
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "in_list" => "Kullanıcı Adı Bulunamadı",
                "name_control" => "Lürfen geçerli karakter kullanarak <b>{field}</b>ızı giriniz",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "charset_control" => "<b>{field}</b> $user_name Geçersiz Karakter İçeriyor",
                "matches" => "Hatalı Şifre",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {


            if ($user) {
                if ($decrypted_password == $password and $user->isActive == 1) {

                    $user_full_name = full_name($user->id);

                    $alert = array(
                        "title" => "HOŞ GELDİN <br> $user_full_name",
                        "text" => "<br>İyi Çalışmalar",
                        "type" => "success"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    $this->session->set_userdata("user", $user);

                    redirect(base_url("dashboard"));

                } elseif ($decrypted_password != $password and $user->isActive == 1) {
                    $unr_pw = "Hatalı Şifre";
                }
            } else {
                $unw = "Hatalı Kullanıcı Adı";
            }
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->form_error = true;
        if (isset($unr_pw)) {
            $viewData->unr_pw = $unr_pw;
        }
        if (isset($unw)) {
            $viewData->unw = $unw;
        }

        $alert = array(
            "title" => "İşlem Başarısız",
            "text" => "Form Bilgilerini Kontrol Ediniz",
            "type" => "danger"
        );

        $this->session->set_flashdata("alert", $alert);

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);

    }

    public function name_control($user_name)
    {
        return (!preg_match("/^([-a-z üğışçöÜĞİŞÇÖ])+$/i", $user_name)) ? FALSE : TRUE;
    }

    public function logout()
    {

        $this->session->unset_userdata("user");

        $alert = array(
            "title" => "ÇIKIŞ YAPILDI<br>",
            "text" => "İyi Çalışmalar",
            "type" => "primary"
        );

        $this->session->set_flashdata("alert", $alert);


        redirect(base_url("login"));

    }

    public function send_email()
    {

        $config = array(
            "protocol" => "smtp",

            "smtp_host" => "ssl://smtp.gmail.com",

            "smtp_port" => "465",

            "smtp_timeout" => "7",

            "smtp_user" => "metinariturk@gmail.com",

            "smtp_pass" => "zvfbswmuldonpnol", // please take this from google app password services...

            "starttls" => TRUE,

            "charset" => "utf-8",

            "mailtype" => "html", // or text/plain

            "wordwrap" => TRUE,

            "newline" => "\r\n",

            "validate" => FALSE,

            "smtp_keep_alive" => TRUE
        );

        $this->load->library("email", $config);

        $this->email->from("metinariturk@gmail.com", "CMS Photon");
        $this->email->to("nagihanariturk@gmail.com", "CMS Photon");
        $this->email->subject("CMS Photon Çalışmaları");
        $this->email->message("Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.");

        $send = $this->email->send();

        if ($send) {
            echo "başarılı gönderildi";
        } else {
            echo $this->email->print_debugger();
        }


    }

    public function forget_password()
    {
        if (get_active_user()) {
            redirect(base_url("dashboard"));
        }

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "forget_password";

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);
    }

    public function reset_password()
    {

        $this->load->library("form_validation");


        $this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "valid_email" => "Lütfen geçerli bir <b>e-posta</b> adresi giriniz",
            )
        );

        if ($this->form_validation->run() === FALSE) {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = "forget_password";

            $viewData->form_error = true;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);

        } else {

            $user = $this->user_model->get(
                array(
                    "isActive" => 1,
                    "email" => $this->input->post("email")
                )
            );

            if ($user) {


                $this->load->helper("string");

                $temp_password = random_string();

                $email_settings = $this->Emailsettings_model->get(
                    array(
                        "isActive" => 1
                    )
                );

                $topic = "Şifremi Unuttum";

                $message = "</table>
                                <tbody>
                                    <tr>
                                        <td>
                                            Merhaba <b>$user_fullname </b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Arete Sistem Kullanıcısı Hesabınız için bir şifre sıfırlama talebi aldık .
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            $temp_password Sıfırlamayı tamamlamak için bu kodu kullanabilirsiniz .
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Hesabınızı korumak için bize verdiğiniz destek için teşekkür ederiz .
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Böyle bir işlem yapmadınız mı ? Şifrenizi hemen değiştirdiğinizden emin olun .
                                        </td>
                                    </tr>
                                </tbody>        
                            </table>";


                $send = cms_email("$user->email", $topic, "$message");

                if ($send) {
                    echo "E - posta başarılı bir şekilde gonderilmiştir ..";

                    $this->load->library('encryption');


                    $update = $this->user_model->update(
                        array(
                            "id" => $user->id
                        ),
                        array(
                            "password" => $this->encryption->encrypt($temp_password),
                            "temp_password" => "1",
                        )
                    );

                    $alert = array(
                        "title" => "Şifre Sıfırlama İşlemi Başarılı",
                        "text" => "Yeni şifreniz e-posta adresinize yönlendirilmiştir.",
                        "type" => "success"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("login"));

                } else {

                    $alert = array(
                        "title" => "Şifre Sıfırlama İşlemi Başarısız",
                        "text" => "Şifreniz Yönlendirilemedi, Lütfen Sistem Yöneticisi ile İletişime Geçiniz",
                        "type" => "alert"
                    );

                    $this->session->set_flashdata("alert", $alert);

                    redirect(base_url("sifremi-unuttum"));

                }
                die();


            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Böyle bir kullanıcı bulunamadı!!!",
                    "type" => "danger"
                );

                $this->session->set_flashdata("alert", $alert);

                redirect(base_url("sifremi - unuttum"));


            }


        }

    }

    public function temp_password()
    {

        $viewData = new stdClass();

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "temp_password";

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);
    }

    public function renew_password()
    {

        $this->load->library('encryption');
        $this->load->library("form_validation");


        $password = $this->input->post("user_password");
        $conf = $this->input->post("confirm_password");

        $this->form_validation->set_rules("user_password", "Şifre", "required|trim|min_length[8]");
        if (!empty($this->input->post("user_password"))) {
            $this->form_validation->set_rules("confirm_password", "Şifre Kontrol", "matches[user_password]|required|trim");
        }

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "min_length" => "<b>{field}</b> en az {param} karakter uzunluğunda olmalıdır",
                "matches" => "Şifreler eşleşmedi, kontrol ediniz",
            )
        );

        $validate = $this->form_validation->run();

        if ($validate) {

            $user = get_active_user();

            $update = $this->user_model->update(
                array(
                    "id" => $user->id
                ),
                array(
                    "temp_password" => 0,
                    "password" => $this->encryption->encrypt($password),
                )
            );

            $user_full_name = full_name($user->id);

            $alert = array(
                "title" => "$user_full_name",
                "text" => "<br>Şifreniz Başarıyla Değiştirildi",
                "type" => "success"
            );

            $this->session->set_flashdata("alert", $alert);

            $this->session->set_userdata("user", $user);

            $this->session->unset_userdata("user");

            $re_user = $this->user_model->get(
                array(
                    "user_name" => $user->user_name,
                )
            );
            $this->session->set_userdata("user", $re_user);

            redirect(base_url());

        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = "temp_password";
        $viewData->form_error = true;

        $alert = array(
            "title" => "İşlem Başarısız",
            "text" => "Form Bilgilerini Kontrol Ediniz",
            "type" => "danger"
        );

        $this->session->set_flashdata("alert", $alert);

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/index", $viewData);

    }


}
