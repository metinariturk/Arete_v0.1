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
            Yeni Yakıt Bilgisi
        </a>
        <hr>
        <table id="default-datatable"  data-plugin="DataTable" class="table table-striped content-container">
            <thead>
                <th class="w5">#id</th>
                <th class="w5">Plaka</th>
                <th class="w15">İkmal Tarihi</th>
                <th class="w15">Yakıt Türü</th>
                <th class="w5">Miktar</th>
                <th class="w5">Birim Fiyat</th>
                <th class="w5">Toplam</th>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr id="center_row">
                    <td><a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">#<?php echo $item->id; ?></a></td>
                    <td><a href="<?php echo base_url("vehicle/file_form/$item->vehicle_id"); ?>"><?php echo get_from_any("vehicle","plaka","id",$item->vehicle_id); ?></a></td>
                    <td><?php echo dateFormat($format = 'd-m-Y', $item->ikmal_tarih); ?></td>
                    <td><?php echo fuel($item->fuel_type); ?></td>
                    <td><?php echo $item->ikmal_miktar; ?> Litre</td>
                    <td><?php echo $item->ikmal_bf; ?> TL</td>
                    <td><?php echo $item->ikmal_tutar; ?> TL</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>

