<div class="card">
    <div class="card-body">
        <div class="col-12">
            <h4 class="text-center">Şartname Hükümleri</h4>
        </div>

        <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/type/idari"); ?>
        <div class="mb-2">
            <div class="col-form-label">Onay</div>
            <select style="width: 100%" id="select2-demo-1"
                    class="form-control <?php cms_isset(form_error("onay"), "is-invalid", ""); ?>"
                    data-plugin="select2"
                    name="onay">
                <option selected="selected"
                        value="<?php echo isset($form_error) ? cms_if_echo(set_value("onay"), null, "", set_value("onay")) : $item->onay; ?>">
                    <?php echo isset($form_error) ? full_name(set_value("onay")) : full_name($item->onay); ?>
                </option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?php echo $user->id; ?>"><?php echo full_name($user->id); ?></option>
                <?php } ?>
            </select>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("onay"); ?></div>
            <?php } ?>
        </div>
        <div class="mb-2">
            <div class="col-form-label">Açıklama</div>
            <textarea class="form-control" name="aciklama"
                      placeholder="Proje Notları, Revizyon, Versiyon, Eksik Listesi Vs."><?php echo isset($form_error) ? set_value("aciklama") : $item->aciklama; ?></textarea>
            <?php if (isset($form_error)) { ?>
                <div class="invalid-feedback"><?php echo form_error("aciklama"); ?></div>
            <?php } ?>
        </div>
    </div>
</div>


