<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            Ek Bilgiler
        </div>

        <div class="card-body">
            <div class="mb-2">
                <div class="col-form-label">Bağlı Olduğu Birim</div>
                <select
                        class="form-control <?php cms_isset(form_error("department"), "is-invalid", ""); ?>"
                        data-plugin="select2"
                        name="department">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("department") : ""; ?>">
                        <?php echo isset($form_error) ? set_value("department") : "Seçiniz"; ?>
                    </option>

                    <?php
                    $departments = get_as_array($settings->department);
                    foreach ($departments as $department) { ?>
                        <option value="<?php echo $department; ?>"><?php echo $department; ?></option>";
                   <?php } ?>
                    ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("department"); ?></div>
                <?php } ?>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Bütçe Bedel</div>
                <input type="number" min="1" step="any" onblur="" class="form-control"
                       name="butce_bedel"
                       value="<?php echo isset($form_error) ? set_value("butce_bedel") : ""; ?>">
            </div>
            <div class="mb-2">
                <div class="col-form-label">Para Birimi</div>
                <select id="select2-demo-1" style="width: 100%;" class="form-control" data-plugin="select2"
                        name="butce_para_birimi">
                    <option selected="selected"
                            value="<?php echo isset($form_error) ? set_value("butce_para_birimi") : "TL"; ?>">
                        <?php echo isset($form_error) ? set_value("butce_para_birimi") : "TL"; ?>
                    </option>
                    <?php
                    $para_birimleri = get_as_array($settings->para_birimi);
                    foreach ($para_birimleri as $para_birimi) {
                        echo "<option value='$para_birimi'>$para_birimi</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-2">
                <div class="col-form-label">Genel Açıklama</div>
                <textarea class="form-control" id="textarea1" name="genel_bilgi" placeholder="Kapsam"></textarea>
            </div>
        </div>
    </div>
</div>