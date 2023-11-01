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

        $this->moduleFolder = "contract_module";
        $this->viewFolder = "book_v";
        $this->load->model("Book_model");
        $this->load->model("Books_model");
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

        $all_books = $this->Books_model->get_all(array());

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

        $book_items = $this->Books_model->get_all(array());

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

    public function save()
    {
        $main_category = $this->input->post("main_category");

        $sub_category = $this->input->post("sub_category");

        if (!empty($main_category)) {
            $insert2 = $this->Book_model->add(
                array(
                    "name" => $this->input->post("main_category"),
                    "main_category" => "1",
                )
            );
        }

        if (!empty($sub_category)) {
            $insert2 = $this->Book_model->add(
                array(
                    "name" => $this->input->post("sub_category"),
                    "sub_category" => "1",
                    "parent" => $this->input->post("parent"),
                )
            );
        }

        if ($insert or $insert2) {

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" => "Kayıt başarılı bir şekilde eklendi",
                "type" => "success"
            );

        } else {

            $alert = array(
                "title" => "İşlem Başarısız",
                "text" => "Lütfen Form Verilerini Doldurunuz",
                "type" => "danger"
            );
        }

        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);
        redirect(base_url("$this->Module_Name/new_form"));

        $alert = array(
            "title" => "İşlem Başarısız",
            "text" => "Form verilerinde eksik veya hatalı giriş var.",
            "type" => "danger"
        );
        $this->session->set_flashdata("alert", $alert);

    }

    public function add_sub()
    {
        $parent_id = $this->input->post('main_group');
        $sub_group_name = $this->input->post('sub_group');


        if ((!empty($sub_group_name)) and (!ctype_digit($sub_group_name))) {

            $insert = $this->Book_model->add(
                array(
                    "parent" => "$parent_id",
                    "name" => "$sub_group_name",
                    "unit" => $this->input->post("unit"),
                    "sub_category" => 1,
                )
            );
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $main_categories = $this->Book_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories = $main_categories;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

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
            $this->load->dbforge();

            $fields = array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => FALSE,
                    'collation' => 'utf8_turkish_ci'
                ),
                'parent' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
                'sub_category' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
                'main_category' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
                'deleted' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
                'unit' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE,
                    'default' => NULL,
                    'collation' => 'utf8_turkish_ci'
                ),
                'book' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
                'tarif' => array(
                    'type' => 'LONGTEXT',
                    'null' => TRUE,
                    'collation' => 'utf8_general_ci'
                ),
                'poz_no' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 40,
                    'null' => TRUE,
                    'default' => NULL,
                    'collation' => 'utf8_general_ci'
                ),
                'sort' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ),
            );

            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('name', TRUE);

// Tabloyu InnoDB ile oluşturur ve karakter setini ayarlar
            $this->dbforge->create_table("$table_name", TRUE, array(
                'ENGINE' => 'InnoDB',
                'AUTO_INCREMENT' => 298,
                'CHARACTER SET' => 'utf8',
                'COLLATE' => 'utf8_general_ci',
                'ROW_FORMAT' => 'DYNAMIC'
            ));

// Yabancı anahtar kontrollerini etkinleştir
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

            $insert = $this->Books_model->add(
                array(
                    "book_name" => $book_name,
                    "book_year" => $year,
                    "isActive" => 1,
                    "db_name" => $table_name,
                    "owner" => $owner,
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

            $book_items = $this->Books_model->get_all(array());

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

    public function add_main()
    {
        $parent_name = $this->input->post('main_group');

        if ((!empty($parent_name)) and (!ctype_digit($parent_name))) {

            $insert = $this->Book_model->add(
                array(
                    "name" => "$parent_name",
                    "main_category" => 1,
                )
            );
        }

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $main_categories = $this->Book_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories = $main_categories;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

        echo $render_html;


    }

    public function delete_sub($id)
    {
        $delete = $this->Book_model->update(
            array(
                "id" => $id
            ),
            array(
                "deleted" => 1,
                "main_category" => null,
                "sub_category" => null,
                "parent" => null
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $main_categories = $this->Book_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories = $main_categories;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

        echo $render_html;

    }

    public function delete_main($id)
    {
        $delete = $this->Book_model->update(
            array(
                "id" => $id
            ),
            array(
                "deleted" => 1,
                "main_category" => null,
                "sub_category" => null,
                "parent" => null
            )
        );

        $delete = $this->Book_model->delete(
            array(
                "id" => $id
            )
        );

        $delete = $this->Book_model->delete(
            array(
                "parent" => $id
            )
        );

        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $main_categories = $this->Book_model->get_all(array(
            'main_category' => 1
        ));

        $viewData->main_categories = $main_categories;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

        echo $render_html;

    }

    public function show_book($book_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;
        $book_name = strtolower(get_from_any("books", "db_name", "id", $book_id));
        $book_items = get_book($book_name);

        $viewData->book_items = $book_items;
        $viewData->book_name = $book_name;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/list", $viewData, true);

        echo $render_html;

    }

    public function show_item($book_name, $category_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $sub_items = sub_item($book_name, $category_id);

        $viewData->book_name = $book_name;

        $viewData->sub_items = $sub_items;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/poz", $viewData, true);

        echo $render_html;

    }

    public function show_explain($book_name, $item_id)
    {
        $viewData = new stdClass();

        /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
        $viewData->viewFolder = $this->viewFolder;
        $viewData->viewModule = $this->moduleFolder;

        $item = item_explain($book_name, $item_id);
        $viewData->book_name = $book_name;
        $viewData->item = $item;

        $render_html = $this->load->view("{$viewData->viewModule}/{$viewData->viewFolder}/common/explain", $viewData, true);

        echo $render_html;

    }

    public function rankSetter($table)
    {

        $data = $this->input->post("data");
        parse_str($data, $order);

        $items = $order['ord'];
        foreach ($items as $rank => $id) {
            $where = array(
                "id" => $id,
            );
            $data = array(
                "sort" => $rank,
            );
            rank_group($table, $where, $data);
        }
        print_r($items);
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

    public
    function isActiveSetter($id)
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
