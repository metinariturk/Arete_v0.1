<div class="mb-2">
    <div class="col-form-label">İşin Durumu</div>
    <select id="select2-demo-1"
            class="form-control <?php cms_isset(form_error("durumu"), "is-invalid", ""); ?>"
            data-plugin="select2" name="durumu">
        <option value="<?php echo isset($form_error) ? set_value("durumu") : "$item->durumu" ?>"><?php echo isset($form_error) ? project_cond(set_value("durumu")) : project_cond($item->durumu) ?></option>
        <option value="1">Devam Eden</option>
        <option value="0">Tamamlanan</option>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("durumu"); ?></div>
    <?php } ?>
</div>
<div class="mb-2">
    <div class="col-form-label">Bağlı Olduğu Birim</div>
    <select class="form-control <?php cms_isset(form_error("department"), "is-invalid", ""); ?>" data-plugin="select2"
            name="department">
        <option value="<?php echo $item->department; ?>"><?php echo $item->department; ?></option>
        <option value="genel">Genel</option>
        <?php
        $departments = get_as_array($settings->department);
        foreach ($departments as $departments) {
            echo "<option value='$departments'>$departments</option>";
        }
        ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("department"); ?></div>
    <?php } ?>
</div>

<div class="mb-2">
    <div class="col-form-label">Proje Adı</div>
    <input type="text"
           class="form-control <?php cms_isset(form_error("proje_ad"), "is-invalid", ""); ?>"
           placeholder="Proje Adı"
           value="<?php echo $item->proje_ad; ?>" name="proje_ad"/>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("proje_ad"); ?></div>
    <?php } ?>&nbsp;
</div>
<div class="mb-2">
    <div class="col-form-label">Bütçe Bedeli (Varsa)</div>
    <input type="number" step="any"
           class="form-control <?php cms_isset(form_error("butce_bedel"), "is-invalid", ""); ?> money"
           name="butce_bedel"
           value="<?php echo $item->butce_bedel; ?>">
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("proje_ad"); ?></div>
    <?php } ?>
</div>
<div>
    <div class="col-form-label">Bütçe Para Birimi</div>
    <select id="select2-demo-1" style="width: 100%;"
            class="form-control <?php cms_isset(form_error("butce_para_birimi"), "is-invalid", ""); ?>"
            data-plugin="select2"
            name="butce_para_birimi">
        <option selected="selected"
                value="<?php echo $item->butce_para_birimi; ?>"><?php echo $item->butce_para_birimi; ?></option>
        <?php
        $para_birimleri = get_as_array($settings->para_birimi);
        foreach ($para_birimleri as $para_birimi) {
            echo "<option value='$para_birimi'>$para_birimi</option>";
        }
        ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("butce_para_birimi"); ?></div>
    <?php } ?>
</div>
<div>
    <div class="col-form-label">Bağlı Olduğu Proje</div>
    <select class="form-control <?php cms_isset(form_error("ilgi"), "is-invalid", ""); ?>"
            data-plugin="select2"
            name="ilgi">

        <?php if ($item->ilgi == 0 or $item->ilgi == null) { ?>
            <option selected value="0">Ana Proje</option>
        <?php } else { ?>
            <option selected
                    value="<?php echo $item->ilgi; ?>"><?php echo get_from_id("projects", "proje_ad", $item->ilgi); ?></option>
        <?php } ?>

        <?php foreach ($active_projects as $active_project) { ?>
            <option value="<?php echo $active_project->id; ?>"><?php echo $active_project->proje_ad; ?></option>
        <?php } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("proje_ad"); ?></div>
    <?php } ?>
</div>
<div>
    <div class="col-form-label">Proje Etiketleri</div>
    <input type="text"
           value="<?php echo $item->etiketler; ?>"
           name="etiketler"
           style="height: 4em !important;"
           data-role="tagsinput"
           class="<?php cms_isset(form_error("etiketler"), "is-invalid", ""); ?>"
           placeholder="Etiket Ekleyin.."/>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("ilgi"); ?></div>
    <?php } ?>
</div>
<div>
    <div class="col-form-label">Yetkili Personeller</div>
    <select class="js-example-basic-multiple col-sm-12 <?php cms_isset(form_error("yetkili_personeller"), "is-invalid", ""); ?> "
            multiple="multiple" name="yetkili_personeller[]"
            data-options="{ tags: true, tokenSeparators: [',', ' '] }"">
    <?php
    if (!empty($item->yetkili_personeller)) { ?>
        <?php $yetkililer = get_as_array($item->yetkili_personeller);
        foreach ($yetkililer as $yetkili) { ?>
            <option selected='selected'
                    value='<?php echo $yetkili; ?>'><?php echo full_name($yetkili); ?></option>";
        <?php } ?>
    <?php } ?>
    <?php if (isset($form_error)) { ?>
        <?php $returns = set_value("yetkili_personeller[]");
        foreach ($returns as $return) { ?>
            <option selected value="<?php echo $return; ?>"><?php echo full_name($return); ?></option>
        <?php } ?>
    <?php } ?>
    <?php foreach ($users as $user) { ?>
        <option value="<?php echo $user->id; ?>"><?php echo $user->name . " " . $user->surname; ?></option>
    <?php } ?>
    </select>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("yetkili_personeller"); ?></div>
    <?php } ?>
</div>
<div>
    <div class="col-form-label">Genel Açıklama - Kapsam</div>
    <textarea class="form-control <?php cms_isset(form_error("genel_bilgi"), "is-invalid", ""); ?>" id="textarea1"
              name="genel_bilgi"
              placeholder="Kapsam"><?php echo $item->genel_bilgi; ?></textarea>
    <?php if (isset($form_error)) { ?>
        <div class="invalid-feedback"><?php echo form_error("genel_bilgi"); ?></div>
    <?php } ?>
</div>



