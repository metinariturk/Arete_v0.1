<?php

class Book extends CI_Controller
{
    public $viewFolder = "";

    public $moduleFolder = "";

    public function __construct()
    {
        parent::__construct();

        if (!get_active_user()) {
            redirect(base_url("login"));
        }
        $this->Theme_mode = get_active_user()->mode;
        if (temp_pass_control()) {
            redirect(base_url("sifre-yenile"));
        }

        $this->moduleFolder = "book_module";
        $this->viewFolder = "book_v";
        $this->load->model("Book_model");
        $this->load->model("Books_model");
        $this->load->model("Books_main_model");
        $this->load->model("Books_sub_model");
        $this->load->model("Books_title_model");
        $this->load->model("Books_item_model");
        $this->load->model("Contract_model");

        $this->Module_Name = "book";
        $this->Module_Title = "Poz Kitabı";
        $this->Display_route = "file_form";
        $this->Add_Folder = "add";
        $this->Display_Folder = "display";
        $this->List_Folder = "list";
        $this->Select_Folder = "select";
        $this->Update_Folder = "update";
        $this->Common_Files = "common";
    }

    public function index()
    {
        $viewData = new stdClass();

        $all_books = $this->Books_model->get_all(array(),"rank ASC");

        $viewData->all_books = $all_books;

        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_book()
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "new_book";

        $book_items = $this->Books_model->get_all(array(),"rank ASC");

        $criteria = array(
            'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
        );

        $sortedBooks = sortArrayByCriteria($book_items, $criteria);

        $viewData->sortedBooks = $sortedBooks;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function new_item()
    {

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "new_item";

        $book_items = $this->Books_model->get_all(array("isActive" => 1),"rank ASC");

        $criteria = array(
            'isActive' => 1,  // isActive özelliğine göre büyükten küçüğe sırala
        );

        $sortedBooks = sortArrayByCriteria($book_items, $criteria);

        $viewData->sortedBooks = $sortedBooks;

        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

    }

    public function file_form()
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewModule = $this->moduleFolder;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->subViewFolder = "$this->Display_Folder";
        $main_categories = $this->Book_model->get_all(array(
            'main_category' => 1
        ));


        $viewData->main_categories = $main_categories;
        $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }

    public function show_book($book_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $book_name = strtolower(get_from_any("books", "db_name", "id", $book_id));

        $viewData->book_name = $book_name;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

        echo $render_html;

    }

    public function show_main($book_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->book_id = $book_id;

        $book = $this->Books_model->get(array(
            'id' => $book_id,
            "isActive" => 1
        ));

        $main_groups = $this->Books_main_model->get_all(array(
                "book_id" => $book->id,
                "isActive" => 1
            ), "rank ASC"
        );

        $viewData->main_groups = $main_groups;
        $viewData->book = $book;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/main_group", $viewData, true);

        echo $render_html;
    }

    public function show_sub($main_id)
    {
        $book_id = get_from_any("books_main", "book_id", "id", "$main_id");
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $book = $this->Books_model->get(array(
            'id' => $book_id,
        ));

        $main = $this->Books_main_model->get(array(
            'id' => $main_id,
        ));

        $sub_groups = $this->Books_sub_model->get_all(array(
                "main_id" => $main->id,
                "book_id" => $main->book_id,
                "isActive" => 1
            ) , "rank ASC"
        );

        $viewData->book_id = $book_id;
        $viewData->main_id = $main_id;
        $viewData->book = $book;
        $viewData->sub_groups = $sub_groups;
        $viewData->main = $main;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/sub_group", $viewData, true);

        echo $render_html;
    }

    public function show_title($sub_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $sub = $this->Books_sub_model->get(array(
            'id' => $sub_id,
        ));


        $book = $this->Books_model->get(array(
            'id' => $sub->book_id,
        ));

        $main = $this->Books_main_model->get(array(
            'id' => $sub->main_id,
        ));

        $titles = $this->Books_title_model->get_all(array(
            'sub_id' => $sub->id,
            'book_id' => $book->id,
        ), "rank ASC");

        $viewData->book = $book;
        $viewData->titles = $titles;
        $viewData->main = $main;
        $viewData->sub = $sub;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/title", $viewData, true);

        echo $render_html;
    }

    public function show_item($title_id)
    {
        $title = $this->Books_title_model->get(array(
            'id' => $title_id,
        ));
        $sub = $this->Books_sub_model->get(array(
            'id' => $title->sub_id,
        ));
        $main = $this->Books_main_model->get(array(
            'id' => $title->main_id,
        ));
        $book = $this->Books_model->get(array(
            'id' => $title->book_id,
        ));

        $items = $this->Books_item_model->get_all(array(
            'title_id' => $title->id,
        ), "rank ASC");

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->book = $book;
        $viewData->main = $main;
        $viewData->sub = $sub;
        $viewData->title = $title;
        $viewData->items = $items;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/item", $viewData, true);

        echo $render_html;
    }

    public function show_detail($item_id)
    {
        $detail = $this->Books_item_model->get(array(
            'id' => $item_id,
        ));

        $title = $this->Books_title_model->get(array(
            'id' => $detail->title_id,
        ));
        $sub = $this->Books_sub_model->get(array(
            'id' => $detail->sub_id,
        ));
        $main = $this->Books_main_model->get(array(
            'id' => $detail->main_id,
        ));
        $book = $this->Books_model->get(array(
            'id' => $detail->book_id,
        ));


        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->book = $book;
        $viewData->main = $main;
        $viewData->sub = $sub;
        $viewData->title = $title;
        $viewData->detail = $detail;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/detail", $viewData, true);

        echo $render_html;
    }


    public function add_book()
    {

        if (!isAdmin()) {
            redirect(base_url("error"));
        }


        $code = $this->input->post("code");
        $table_name = "book_" . $code;
        $book_name = $this->input->post("book_name");
        $year = $this->input->post("year");
        $owner = $this->input->post("owner");

        $this->load->library("form_validation");


        $this->form_validation->set_rules("code", "Kitap Kodu", "max_length[4]|alpha_numeric|trim|callback_duplicate_code_check");
        $this->form_validation->set_rules("book_name", "Kitap Adı", "required|trim");
        $this->form_validation->set_rules("year", "Yıl", "required|trim|numeric|exact_length[4]");
        $this->form_validation->set_rules("owner", "Kurum / Kuruluş", "required|trim");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "is_natural" => "<b>{field}</b> natural alanı rakamlardan oluşmalıdır",
                "numeric" => "<b>{field}</b> numeric alanı rakamlardan oluşmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "exact_length" => "<b>{field}</b> alanı <b>{param}</b> karakter uzunluğunda olmalıdır 2023 gibi",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
                "duplicate_code_check" => "<b>{field}</b> {param} $code daha önce kullanılmış.",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            $insert = $this->Books_model->add(
                array(
                    "book_name" => $book_name,
                    "book_year" => $year,
                    "isActive" => 1,
                    "db_name" => $table_name,
                    "owner" => $owner,
                    "code" => $code,
                )
            );

            // TODO Alert sistemi eklenecek...
            if ($insert) {
                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde eklendi",
                    "type" => "success"
                );
            } else {
                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                    "type" => "danger"
                );
            }
            // İşlemin Sonucunu Session'a yazma işlemi...
            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("$this->Module_Name/new_book"));
            //kaydedilen elemanın id nosunu döküman ekleme sayfasına post ediyoruz
        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Form verilerinde eksik veya hatalı giriş var.",
                "type" => "danger"
            );
            $this->session->set_flashdata("alert", $alert);

            $book_items = $this->Books_model->get_all(array(),"rank ASC");

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewModule = $this->moduleFolder;
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "new_book";
            $viewData->form_error = true;

            $viewData->book_items = $book_items;

            $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }


    }

    public function add_main($book_id)
    {

        $book = $this->Books_model->get(array(
            'id' => $book_id,
        ));

        $main_code = $this->input->post("main_group_code");
        $main_name = $this->input->post("group_name");

        $isset_control = get_from_any_and_and("books_main", "main_code", "$main_code", "main_name", "$main_name", "book_id", $book_id);

        $this->load->library("form_validation");


        $this->form_validation->set_rules("main_group_code", "Grup Kodu", "min_length[1]|max_length[3]|required|alpha_numeric|trim");
        $this->form_validation->set_rules("group_name", "Grup Adı", "min_length[3]|required|trim");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            if (empty($isset_control)) {
                $insert = $this->Books_main_model->add(
                    array(
                        "book_id" => $book->id,
                        "main_code" => mb_convert_case($main_code, MB_CASE_UPPER, 'UTF-8'),
                        "main_name" => mb_convert_case($main_name, MB_CASE_UPPER, 'UTF-8'),
                        "isActive" => 1,
                    )
                );
                $error = "Kayıt Eklendi";
            } else {
                $error = "Bu Kod ve İsim Daha Önce Kullanılmış";
            }

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;

            $main_groups = $this->Books_main_model->get_all(array(
                    "book_id" => $book->id,
                    "isActive" => 1
                ), "rank ASC"
            );

            $viewData->book = $book;
            $viewData->main_groups = $main_groups;
            $viewData->error = $error;


            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/main_group", $viewData, true);

            echo $render_html;

        } else {

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;

            $error = "Kayıt Eklenemedi";
            $main_groups = $this->Books_main_model->get_all(array(
                    "book_id" => $book->id,
                    "isActive" => 1
                ) , "rank ASC"
            );
            $viewData->main_groups = $main_groups;
            $viewData->book = $book;
            $viewData->error = $error;
            $viewData->form_error = true;

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/main_group", $viewData, true);

            echo $render_html;

        }


    }

    public function add_sub($main_id)
    {
        $main = $this->Books_main_model->get(array(
            'id' => $main_id,
        ));

        $book = $this->Books_model->get(array(
            'id' => $main->book_id,
        ));


        $sub_code = $this->input->post("sub_group_code");
        $sub_name = $this->input->post("sub_group_name");

        $isset_control = get_from_any_and_and("books_sub", "sub_code", "$sub_code", "sub_name", "$sub_name", "book_id", $book->id);

        $this->load->library("form_validation");


        $this->form_validation->set_rules("sub_group_code", "Alt Grup Kodu", "min_length[1]|max_length[3]|required|alpha_numeric|trim");
        $this->form_validation->set_rules("sub_group_name", "Alt  Grup Adı", "min_length[3]|required|trim");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            if (empty($isset_control)) {
                setlocale(LC_ALL, 'tr_TR.UTF-8');

                $insert = $this->Books_sub_model->add(
                    array(
                        "book_id" => $book->id,
                        "main_id" => $main->id,
                        "sub_code" => mb_convert_case($sub_code, MB_CASE_UPPER, 'UTF-8'),
                        "sub_name" => mb_convert_case($sub_name, MB_CASE_UPPER, 'UTF-8'),
                        "isActive" => 1,
                    )
                );

                $sub_groups = $this->Books_sub_model->get_all(array(
                        "main_id" => $main->id,
                        "book_id" => $main->book_id,
                        "isActive" => 1
                    ) , "rank ASC"
                );

                $viewData = new stdClass();

                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->viewModule = $this->moduleFolder;
                $viewData->subViewFolder = "new_item";
                $error = "Kayıt Eklendi";

                $viewData->sub_groups = $sub_groups;
                $viewData->book = $book;
                $viewData->main = $main;
                $viewData->error = $error;

                $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$viewData->subViewFolder/sub_group", $viewData, true);

                echo $render_html;
            } else {

                $sub_groups = $this->Books_sub_model->get_all(array(
                    'main_id' => $main->id,
                    'book_id' => $main->book_id,
                    'isActive' => 1,
                ) , "rank ASC");

                $viewData = new stdClass();

                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->viewModule = $this->moduleFolder;
                $viewData->subViewFolder = "new_item";
                $viewData->form_error = true;
                $error = "Bu Kayıt Mevcut";

                $viewData->sub_groups = $sub_groups;
                $viewData->book = $book;
                $viewData->main = $main;
                $viewData->error = $error;

                $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$viewData->subViewFolder/sub_group", $viewData, true);

                echo $render_html;
            }
        } else {
            $sub_groups = $this->Books_sub_model->get_all(array(
                'main_id' => $main->id,
                'book_id' => $main->book_id,
                'isActive' => 1,
            ) , "rank ASC");

            $viewData = new stdClass();

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->viewModule = $this->moduleFolder;
            $viewData->subViewFolder = "new_item";
            $viewData->form_error = true;
            $error = "Kayıt Eklenemedi";

            $viewData->sub_groups = $sub_groups;
            $viewData->book = $book;
            $viewData->main = $main;
            $viewData->error = $error;

            $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$viewData->subViewFolder/sub_group", $viewData, true);

            echo $render_html;
        }
    }

    public function add_title($sub_id)
    {
        $sub = $this->Books_sub_model->get(array('id' => $sub_id));
        $main = $this->Books_main_model->get(array('id' => $sub->main_id, 'book_id' => $sub->book_id));
        $book = $this->Books_model->get(array('id' => $sub->book_id));

        $title_code = $this->input->post("title_group_code");
        $title_name = $this->input->post("title_group_name");

        $isset_control = get_from_any_and_and("books_title", "title_code", "$title_code", "title_name", "$title_name", "book_id", $book->id);

        $this->load->library("form_validation");


        $this->form_validation->set_rules("title_group_code", "Başlık Kodu", "min_length[1]|max_length[3]|required|alpha_numeric|trim");
        $this->form_validation->set_rules("title_group_name", "Başlık Adı", "min_length[3]|required|trim");


        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> geçersiz karakter içeriyor üğişçö gibi",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            if (empty($isset_control)) {
                setlocale(LC_ALL, 'tr_TR.UTF-8');

                $insert = $this->Books_title_model->add(
                    array(
                        "book_id" => $book->id,
                        "main_id" => $main->id,
                        "sub_id" => $sub->id,
                        "title_code" => mb_convert_case($title_code, MB_CASE_UPPER, 'UTF-8'),
                        "title_name" => mb_convert_case($title_name, MB_CASE_UPPER, 'UTF-8'),
                        "isActive" => 1,
                    )
                );
                $error = "Kayıt Eklendi";
            } else {
                $error = "Bu Kayıt Mevcut";
            }
        } else {
            $error = "Kayıt Eklenemedi";
        }

        $titles = $this->Books_title_model->get_all(array(
                "sub_id" => $sub->id,
                "book_id" => $book->id,
                "isActive" => 1
            ), "rank ASC"
        );

        $viewData = new stdClass();
        $viewData->form_error = true;
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "new_item";
        $viewData->sub = $sub;
        $viewData->book = $book;
        $viewData->titles = $titles;
        $viewData->main = $main;
        $viewData->error = $error;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$viewData->subViewFolder/title", $viewData, true);

        echo $render_html;
    }

    public function add_item($title_id)
    {
        $title = $this->Books_title_model->get(array('id' => $title_id));
        $sub = $this->Books_sub_model->get(array('id' => $title->sub_id));
        $main = $this->Books_main_model->get(array('id' => $title->main_id));
        $book = $this->Books_model->get(array('id' => $title->book_id));

        $item_code = $this->input->post("item_code");
        $item_name = $this->input->post("item_name");
        $item_unit = $this->input->post("item_unit");
        $item_price = $this->input->post("item_price");
        $item_explain = $this->input->post("item_explain");

        $isset_control = get_from_any_and_and("books_item", "item_code", "$item_code", "item_name", "$item_name", "book_id", $book->id);

        $this->load->library("form_validation");

        $this->form_validation->set_rules("item_code", "Poz Kodu", "min_length[1]|max_length[3]|required|alpha_numeric|trim");
        $this->form_validation->set_rules("item_name", "Poz Adı", "min_length[3]|required|trim");
        $this->form_validation->set_rules("item_unit", "Birim", "max_length[7]|required|trim");
        $this->form_validation->set_rules("item_price", "Birim Fiyat", "trim");
        $this->form_validation->set_rules("item_explain", "Poz Tarifi", "trim");

        $this->form_validation->set_message(
            array(
                "required" => "<b>{field}</b> alanı doldurulmalıdır",
                "max_length" => "<b>{field}</b> en fazla <b>{param}</b> karakter uzunluğunda olmalıdır",
                "min_length" => "<b>{field}</b> en az <b>{param}</b> karakter uzunluğunda olmalıdır",
                "alpha_numeric" => "<b>{field}</b> Sadece harf ve rakam kullanınız. Geçersiz karakterler (üğişöç)",
            )
        );

        // Form Validation Calistirilir..
        $validate = $this->form_validation->run();

        if ($validate) {
            if (empty($isset_control)) {
                setlocale(LC_ALL, 'tr_TR.UTF-8');

                $insert = $this->Books_item_model->add(
                    array(
                        "book_id" => $book->id,
                        "main_id" => $main->id,
                        "sub_id" => $sub->id,
                        "title_id" => $title->id,
                        "item_code" => mb_convert_case($item_code, MB_CASE_UPPER, 'UTF-8'),
                        "item_name" => mb_convert_case($item_name, MB_CASE_UPPER, 'UTF-8'),
                        "item_unit" => $item_unit,
                        "item_price" => $item_price,
                        "item_explain" => $item_explain,
                        "isActive" => 1,
                    )
                );
                $error = "Kayıt Eklendi";
                $form_error = 0;
            } else {
                $error = "Bu Kayıt Mevcut";
                $form_error = 0;
            }
        } else {
            $error = "Kayıt Eklenemedi";
            $form_error = 1;
        }

        $items = $this->Books_item_model->get_all(array(
                "title_id" => $title->id,
                "book_id" => $book->id,
                "isActive" => 1
            ), "rank ASC"
        );

        $viewData = new stdClass();
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->subViewFolder = "new_item";
        $viewData->title = $title;
        if ($form_error == 1) {
            $viewData->form_error = true;
        }
        $viewData->sub = $sub;
        $viewData->book = $book;
        $viewData->items = $items;
        $viewData->main = $main;
        $viewData->error = $error;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/$viewData->subViewFolder/item", $viewData, true);

        echo $render_html;
    }

    public function delete_main($main_id)
    {
        $book = $this->Books_model->get(array(
            'id' => $main->book_id,
        ));

        $main = $this->Books_main_model->get(array("id" => $main_id));

        $delete = $this->Books_main_model->delete(
            array(
                "id" => $main->id
            ),
        );

        $delete_sub = $this->Books_sub_model->delete(
            array(
                "main_id" => $main->id,
                "book_id" => $main->book_id
            ),
        );

        if ($delete and $delete_sub) {
            $error = "Tüm Alt Gruplarıyla Birlikte Kayıt Silindi";
        } else {
            $error = "Kayıt Silinemedi";
        }

        $viewData = new stdClass();

        $main_groups = $this->Books_main_model->get_all(
            array(
                "book_id" => $main->book_id,
                "isActive" => 1,
            ), "rank ASC"
        );

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->book = $book;
        $viewData->main_groups = $main_groups;
        $viewData->main = $main;
        $viewData->error = $error;


        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/main_group", $viewData, true);

        echo $render_html;


    }

    public function delete_sub($sub_id)
    {

        $sub = $this->Books_sub_model->get(array("id" => $sub_id));


        $book = $this->Books_model->get(array(
            'id' => $sub->book_id,
        ));

        $main = $this->Books_main_model->get(array(
            'id' => $sub->main_id,
        ));

        $delete_sub = $this->Books_sub_model->delete(
            array(
                "id" => $sub->id
            ),
        );

        $delete_title = $this->Books_title_model->delete(
            array(
                "book_id" => $sub->book_id,
                "sub_id" => $sub->id
            ),
        );

        if ($delete_title and $delete_sub) {
            $error = "Tüm Alt Başlıklarıyla Birlikte Kayıt Silindi";
        } else {
            $error = "Kayıt Silinemedi";
        }

        $sub_groups = $this->Books_sub_model->get_all(
            array(
                "book_id" => $sub->book_id,
                "main_id" => $sub->main_id,
                "isActive" => 1,
            ) , "rank ASC"
        );
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $viewData->book = $book;
        $viewData->sub_groups = $sub_groups;
        $viewData->main = $main;
        $viewData->sub = $sub;
        $viewData->error = $error;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/sub_group", $viewData, true);

        echo $render_html;

    }

    public function delete_title($title_id)
    {
        $title_id;

        $title = $this->Books_title_model->get(array(
                "id" => $title_id
            )
        );

        $book = $this->Books_model->get(array(
            'id' => $title->book_id,
        ));

        $main = $this->Books_main_model->get(array(
            'id' => $title->main_id,
        ));

        $sub = $this->Books_sub_model->get(array(
            'id' => $title->sub_id,
        ));

        $delete_item = $this->Books_item_model->delete(
            array(
                "book_id" => $title->book_id,
                "title_id" => $title->id
            ),
        );

        $delete_title = $this->Books_title_model->delete(
            array(
                "id" => $title->id
            ),
        );

        if ($delete_title and $delete_item) {
            $error = "Tüm Alt Başlıklarıyla Birlikte Kayıt Silindi";
        } else {
            $error = "Kayıt Silinemedi";
        }

        $titles = $this->Books_title_model->get_all(
            array(
                "book_id" => $title->book_id,
                "main_id" => $title->main_id,
                "isActive" => 1,
            ), "rank ASC"
        );

        $viewData = new stdClass();
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->book = $book;
        $viewData->titles = $titles;
        $viewData->main = $main;
        $viewData->sub = $sub;
        $viewData->error = $error;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/title", $viewData, true);
        echo $render_html;
    }

    public function delete_item($item_id)
    {
        $item = $this->Books_item_model->get(array(
                "id" => $item_id
            )
        );

        $title = $this->Books_title_model->get(array(
                "id" => $item->title_id
            )
        );

        $book = $this->Books_model->get(array(
            'id' => $title->book_id,
        ));

        $main = $this->Books_main_model->get(array(
            'id' => $title->main_id,
        ));

        $sub = $this->Books_sub_model->get(array(
            'id' => $title->sub_id,
        ));

        $delete_item = $this->Books_item_model->delete(
            array(
                "id" => $item_id
            ),
        );

        if ($delete_item) {
            $error = "Kayıt Silindi";
        } else {
            $error = "Kayıt Silinemedi";
        }

        $items = $this->Books_item_model->get_all(
            array(
                "book_id" => $title->book_id,
                "title_id" => $title->id,
                "isActive" => 1,
            ), "rank ASC"
        );

        $viewData = new stdClass();
        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $viewData->book = $book;
        $viewData->items = $items;
        $viewData->main = $main;
        $viewData->title = $title;
        $viewData->sub = $sub;
        $viewData->error = $error;
        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/new_item/item", $viewData, true);
        echo $render_html;
    }

    public function book_rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order["book"];

        foreach ($items as $rank => $id) {
            $this->Books_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function main_rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order["ord"];

        foreach ($items as $rank => $id) {
            $this->Books_main_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function sub_rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order["sub"];

        foreach ($items as $rank => $id) {
            $this->Books_sub_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function title_rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order["sub"];

        foreach ($items as $rank => $id) {
            $this->Books_title_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function item_rankSetter()
    {
        $data = $this->input->post("data");
        parse_str($data, $order);
        $items = $order["sub"];

        foreach ($items as $rank => $id) {
            $this->Books_item_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "rank" => $rank,
                )
            );
        }
    }

    public function duplicate_code_check($table_name)
    {
        $table_name = "book_" . $table_name;

        $var = count_data("books", "db_name", $table_name);
        if (($var > 0)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function isActiveSetter($id)
    {

        if ($id) {

            $isActive = ($this->input->post("data") === "true") ? 1 : 0;

            $this->Books_model->update(
                array(
                    "id" => $id
                ),
                array(
                    "isActive" => $isActive
                )
            );
        }
    }

}
