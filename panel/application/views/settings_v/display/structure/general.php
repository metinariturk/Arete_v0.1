<div class="box p-md">
    <div class="col-12 text-center"><h3>Şirket Bilgileri</h3></div>
    <div class="row">
        <div class="form-group col-sm-12">
            <label>Şirket Adı</label>
            <input class="form-control" placeholder="Şirketin ya da Sitenizin adı"
                   name="sirket_adi"
                   value="<?php echo isset($form_error) ? set_value("sirket_adi") : $item->sirket_adi; ?>">
            <?php if (isset($form_error)) { ?>
                <small
                    class="pull-right input-form-error"> <?php echo form_error("sirket_adi"); ?></div>
            <?php } ?>
        </div>
    </div><!-- Şirket Kuruluş Adı -->
    <div class="row">
        <div class="form-group col-sm-12">
            <label>Faaliyet Alanı</label>
            <select id="select2-demo-1" class="form-control" data-plugin="select2" name="faaliyet">
                <option value="<?php echo isset($form_error) ? set_value("faaliyet") : $item->faaliyet; ?>">
                    <?php echo $item->faaliyet; ?>
                </option>
                <option value="Yüklenici">Yüklenici</option>
                <option value="Taşeron">Taşeron</option>
                <option value="İş Veren">İş Veren</option>
            </select>
        </div>
    </div><!-- Faaliyet Alanı -->
    <div class="row">
        <div class="form-group col-sm-6">
            <label>Vergi No</label>
            <input class="form-control" placeholder="Vergi No"
                   name="vergi_no"
                   value="<?php echo isset($form_error) ? set_value("vergi_no") : $item->vergi_no; ?>">
            <?php if (isset($form_error)) { ?>
                <small
                    class="pull-right input-form-error"> <?php echo form_error("vergi_no"); ?></div>
            <?php } ?>
        </div>
        <div class="form-group col-sm-6">
            <label>Vergi Dairesi</label>
            <input class="form-control" placeholder="Vergi Dairesi"
                   name="vergi_daire"
                   value="<?php echo isset($form_error) ? set_value("vergi_daire") : $item->vergi_daire; ?>">
            <?php if (isset($form_error)) { ?>
                <small
                    class="pull-right input-form-error"> <?php echo form_error("vergi_daire"); ?></div>
            <?php } ?>
        </div>
    </div><!-- Vergi no / Daire -->
    <div class="row">
        <div class="form-group col-sm-12">
            <label>Adres</label>
            <input class="form-control"  placeholder="Adres" name="adres"
                   value="<?php echo $item->adres; ?>">
        </div>
    </div><!-- Adres -->
    <div class="row">
        <div class="form-group col-sm-6">
            <label>Tel No 1</label>
            <input class="form-control" placeholder="0532 987 65 43" name="tel_no_1"
                   value="<?php echo $item->tel_no_1; ?>">
        </div>
        <div class="form-group col-sm-6">
            <label>Tel No 2</label>
            <input class="form-control" placeholder="0532 987 65 43" name="tel_no_2"
                   value="<?php echo $item->tel_no_2; ?>">
        </div>
    </div><!-- Telefon İrtibat -->
    <div class="row">
        <div class="form-group col-sm-12">
            <label>E Mail</label>
            <input class="form-control" placeholder="E Posta"
                   name="email"
                   value="<?php echo isset($form_error) ? set_value("email") : $item->email; ?>">
            <?php if (isset($form_error)) { ?>
                <small
                    class="pull-right input-form-error"> <?php echo form_error("email"); ?></div>
            <?php } ?>
        </div>
    </div><!-- E Mail -->
</div>