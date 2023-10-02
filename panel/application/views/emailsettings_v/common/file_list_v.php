<div class="image_list_container">
    <div class="widget">
        <div class="widget-body">
            <table class="table">
                <thead>
                <tr>
                    <th class="w10c">id</th>
                    <th class="w10c">Not Adı</th>
                    <th>Açıklama</th>
                    <th class="w10c">Aktif</th>
                    <th class="w10c">Sil</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($notes as $note) { ?>
                    <tr>
                        <td><?php echo $note->id; ?></td>
                        <td><?php cms_if_echo($note->isActive, "1", "", "<del>") ?> <?php echo $note->not_ad; ?></del></td>
                        <td><?php cms_if_echo($note->isActive, "1", "", "<del>") ?><?php echo $note->aciklama; ?></del></td>
                        <td class="w5c">
                            <input
                                    data-url="<?php echo base_url("dashboard/isActiveSetter/$note->id"); ?>"
                                    class="isActive"
                                    type="checkbox"
                                    data-switchery
                                    data-color="#10c469"
                                <?php echo ($note->isActive) ? "checked" : ""; ?>
                            />
                        </td>

                        <td class="w10c">
                            <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                               data-url="<?php echo base_url("dashboard/delete/$note->id"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="image_list_container">

    <div class="widget">
        <div class="widget-body">
            <table class="table">
                <thead>
                <tr>
                    <th class="w10c">id</th>
                    <th class="w10c">Not Adı</th>
                    <th>Açıklama</th>
                    <th class="w10c">Aktif</th>
                    <th class="w10c">Sil</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($notes_done as $note_done) { ?>
                    <tr>
                        <td><?php echo $note_done->id; ?></td>
                        <td><?php cms_if_echo($note_done->isActive, "1", "", "<del>") ?> <?php echo $note_done->not_ad; ?></del></td>
                        <td><?php cms_if_echo($note_done->isActive, "1", "", "<del>") ?><?php echo $note_done->aciklama; ?></del></td>
                        <td class="w5c">
                            <input
                                    data-url="<?php echo base_url("dashboard/isActiveSetter/$note_done->id"); ?>"
                                    class="isActive"
                                    type="checkbox"
                                    data-switchery
                                    data-color="#10c469"
                                <?php echo ($note_done->isActive) ? "checked" : ""; ?>
                            />
                        </td>
                        <td class="w10c">
                            <a onclick="deleteConfirmationFile(this)" data-text="Bu Dosyayı"
                               data-url="<?php echo base_url("dashboard/delete/$note_done->id"); ?>">
                                <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o"
                                   aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
