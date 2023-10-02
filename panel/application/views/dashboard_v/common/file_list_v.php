<?php
$projects = all_projects();
$project_type_name_id = array();
foreach ($projects as $project) {
    $project_type_name_id[] = $project->id . " - " . $project->proje_ad . " - Proje";
}

$contracts = all_contracts();
$contract_type_name_id = array();
foreach ($contracts as $contract) {
    $contract_type_name_id[] = $contract->id . " - " . $contract->sozlesme_ad . " - Sözleşme";
}

$subcontracts = all_contracts();
$subcontract_type_name_id = array();
foreach ($subcontracts as $subcontract) {
    $subcontract_type_name_id[] = $subcontract->id . " - " . $subcontract->sozlesme_ad . " - Alt Sözleşme";
}

$sites = all_sites();
$site_type_name_id = array();
foreach ($sites as $site) {
    $site_type_name_id[] = $site->id . " - " . $site->santiye_ad . " - Şantiye";
}

$all_data = array_merge($project_type_name_id, $contract_type_name_id, $subcontract_type_name_id, $site_type_name_id);
print_r($all_data);
?>

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
