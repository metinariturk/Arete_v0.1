<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            Gerekli Bilgiler
        </div>
        <div class="card-body">
            <div class="mb-2">
                <div class="col-form-label">Proje Kodu</div>
                <div class="input-group"><span class="input-group-text" id="inputGroupPrepend">PRJ</span>
                    <?php if (!empty(get_last_fn("project"))) { ?>
                        <input class="form-control <?php cms_isset(form_error("proje_kodu"), "is-invalid", ""); ?>"
                               type="number" placeholder="Proje Kodu" aria-describedby="inputGroupPrepend"
                               data-bs-original-title="" title="" name="proje_kodu"
                        value="<?php echo isset($form_error) ? set_value("proje_kodu") : increase_code_suffix("project"); ?>">
                        <?php
                    } else { ?>
                        <input class="form-control <?php cms_isset(form_error("proje_kodu"), "is-invalid", ""); ?>"
                               type="number" placeholder="Username" aria-describedby="inputGroupPrepend"
                               required="" data-bs-original-title="" title="" name="proje_kodu"
                        value="<?php echo isset($form_error) ? set_value("proje_kodu") : fill_empty_digits() . "1" ?>">
                    <?php } ?>

                    <?php if (isset($form_error)) { ?>
                        <div class="invalid-feedback"><?php echo form_error("proje_kodu"); ?></div>
                        <div class="invalid-feedback">* Önerilen Proje Kodu : <?php echo increase_code_suffix("project"); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="mb-2">
                <div class="col-form-label">Proje Adı</div>
                <input type="text"
                       class="form-control <?php cms_isset(form_error("durumu"), "is-invalid", ""); ?>"
                       placeholder="Proje Adı"
                       value="<?php echo isset($form_error) ? set_value("proje_ad") : ""; ?>" name="proje_ad">
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("proje_ad"); ?></div>
                <?php } ?>
            </div>


            <div class="mb-2">
                <div class="col-form-label">İşin Durumu</div>
                <select id="select2-demo-1"
                        class="form-control <?php cms_isset(form_error("durumu"), "is-invalid", ""); ?>"
                        data-plugin="select2" name="durumu">
                    <option value="<?php echo isset($form_error) ? set_value("durumu") : "" ?>"><?php echo isset($form_error) ? project_cond(set_value("durumu")) : "Seçiniz" ?></option>
                    <option value="1">Devam Eden</option>
                    <option value="0">Tamamlanan</option>
                </select>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("durumu"); ?></div>
                <?php } ?>
            </div>

            <div class="mb-2">
                <div class="col-form-label">Proje Etiketleri</div>
                <input type="text" name="etiketler" data-plugin="tagsinput"
                       data-role="tagsinput" style="  width: 100%;
  max-width: 100%;  "
                       placeholder="Etiket Ekleyin.."
                       value="<?php echo isset($form_error) ? set_value("etiketler") : ""; ?>"/>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("etiketler"); ?></div>
                <?php } ?>
            </div>

            <div class="mb-2">
                <div class="col-form-label">Yetkili Personeller</div>
                <select class="js-example-placeholder-multiple col-sm-12" multiple="multiple" name="yetkili_personeller[]" multiple data-options="{ tags: true, tokenSeparators: [',', ' '] }">
                    <?php if (isset($form_error)) { ?>
                        <?php $returns = set_value("yetkili_personeller[]");
                        foreach ($returns as $return){ ?>
                            <option selected value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
                        <?php } ?>
                    <?php } ?>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user->id; ?>"><?php echo $user->name." ".$user->surname; ?></option>
                    <?php } ?>
                </select>
                <?php if (isset($form_error)) { ?>
                    <div class="invalid-feedback"><?php echo form_error("yetkili_personeller"); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>