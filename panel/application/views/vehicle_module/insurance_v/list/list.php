<div class="widget p-lg">
    <?php if (empty($items)) { ?>
        <div class="alert alert-info text-center">
            <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
                <a href="<?php echo base_url("$this->Module_Name/new_form"); ?>"> Buradan
                    Yeni <?php echo $this->Module_Title; ?> Ekleyiniz</a>
            </p>
        </div>
    <?php } else { ?>
    <div class="table-responsive">
        <a class="pager-btn btn btn-purple btn-outline"
           href="<?php echo base_url("$this->Module_Name/new_form/"); ?>">
            <i class="fas fa-plus-circle"></i>
            Yeni Sigorta/Kasko
        </a>
        <hr>
        <table id="default-datatable"  data-plugin="DataTable" class="table table-striped content-container">
            <thead>
                <th class="w5">#id</th>
                <th class="w5">Plaka</th>
                <th class="w5">Poliçe No</th>
                <th class="w15">Sigorta Firması</th>
                <th class="w15">Kapsam</th>
                <th class="w5">Bitiş Tarihi</th>
                <th class="w10">Sigorta Primi</th>
                <th class="w10">Aktif</th>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr id="center_row">
                    <td><a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">#<?php echo $item->id; ?></a></td>
                    <td><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id"); ?>"><?php echo get_from_any("vehicle","plaka","id",$item->vehicle_id); ?></a></td>
                    <td><a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>"><?php echo $item->police_no; ?></a></td>
                    <td><?php echo $item->sigorta_firma; ?></a></td>
                    <td><?php echo kapsam($item->kapsam); ?></td>
                    <td><?php echo $item->bitis; ?></td>
                    <td><?php echo money_format($item->prim_bedel)." TL"; ?></td>
                    <td>
                        <input
                                data-url="<?php echo base_url("Insurance/isActiveSetter/$item->id"); ?>"
                                class="isActive"
                                type="checkbox"
                                data-switchery
                                data-color="#10c469"
                            <?php echo ($item->isActive) ? "checked" : ""; ?>
                        />
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>

