<form id="add_title"
      action="<?php echo base_url("$this->Module_Name/add_title/$sub->id"); ?>"
      method="post"
      enctype="multipart/form-data" autocomplete="off">
        <table class="table" style="font-size: 12px;">
            <thead>
            <tr>
                <th colspan="3" style="text-align:center; width: 50px;"><?php echo $sub->sub_code." - ".$sub->sub_name; ?> GRUBU<p>BAŞLIKLARI</p></th>
            </tr>
            <tr>
                <th style="width: 50px;">Alt Grup Kodu</th>
            </tr>
            </thead>
            <tbody class="sortable">
            <?php $titles = $this->Books_title_model->get_all(
                array(
                    "book_id" => $book_id,
                    "sub_id" => $sub->id,
                    "isActive" => 1,
                )
            ); ?>
            <?php if (isset($titles)) { ?>
                <?php foreach ($titles as $title) { ?>
                    <tr>
                        <td>
                            <a id="category" href="#"
                               url="<?php echo base_url("$this->Module_Name/show_item/$title->id"); ?>"
                               onclick="show_item(this)" method="post" enctype="multipart">
                                <?php echo $title->title_code; ?>.<?php echo $title->title_name; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    <div class="div">
        <div class="mb-2">
            <div class="col-form-label">Yeni Başlık</div>
            <input step="any" class="form-control <?php cms_isset(form_error("title_code"), "is-invalid", ""); ?>"
                   name="title_code" value="<?php echo isset($form_error) ? set_value("title_code") : ""; ?>"
                   placeholder="Başlık Kodu 01 - A - I vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("title_code"); ?></div>
            <?php } ?>
            <input step="any" class="form-control <?php cms_isset(form_error("title_name"), "is-invalid", ""); ?>"
                   name="title_name" value="<?php echo isset($form_error) ? set_value("title_name") : ""; ?>"
                   placeholder="Başlık Adı - Döşeme İşleri - Duvar İşleri vs."/>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("title_name"); ?></div>
            <?php } ?>
        </div>
    </div>
    <a  form-id="add_title" id="save_button" onclick="add_title(this)"
            class="btn btn-success">
        <i class="fa fa-plus fa-lg"></i> Ekle
    </a>
</form>
