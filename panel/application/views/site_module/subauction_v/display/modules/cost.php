<div class="col-sm-8">
    <div class="text-center">
        <h4>


        </h4>
        <table class="table">
            <thead>
            <tr>
                <th colspan="4">
                    <h3>Yaklaşık Maliyet Grubu Ekle
                        <a data-tooltip-location="right" data-tooltip="Yaklaşık Maliyet Ekle" class=""
                           href="<?php echo base_url("cost/new_form/auction_display/$item->id"); ?>">
                            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i> </a>
                    </h3>
                </th>
            </tr>

            <tr>
                <th class="w5"><i class="fa fa-reorder"></i></th>
                <th class="w20">Grubu</th>
                <th class="w30">Tutar</th>
                <th class="w30">İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($ymler)) { ?>
                <?php foreach ($ymler as $ym) { ?>
                    <tr data-toggle="collapse" data-target="#_cost<?php echo $ym->id; ?>" class="clickable"
                        id="center_row">
                        <td>
                            <a data-tooltip-location="right" data-tooltip="Yaklaşık Maliyet Grubu Ekle" class=""
                               href="">
                                <?php echo $ym->id; ?>
                            </a>
                        </td>
                        <td><?php echo $ym->ym_grup . " - " . $ym->ym_ad; ?></td>
                        <td><?php echo money_format($ym->cost) . " " . $item->para_birimi; ?></td>
                        <td>
                            <a class="pager-btn btn btn-info btn-outline" onclick="page_forward(this)" data-text="Bu Poliçe"
                               data-note="Sayfadan Çıkmak Üzeresiniz"
                               data-url="<?php echo base_url("cost/file_form/$ym->id"); ?>">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i> Görüntüle
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <div id="accordion_cost<?php echo $ym->id; ?>" class="collapse">
                                <?php if (!empty($ym->id)) {
                                    $ym_files = get_module_files("cost_files", "cost_id", "$ym->id");
                                    if (!empty($ym_files)) {
                                        $i = 1;
                                        foreach ($ym_files as $ym_file) { ?>
                                            <div class="container-fluid text-left m-t-sm">
                                                <a class="pager-btn btn btn-purple btn-outline"
                                                   href="<?php echo base_url("cost/file_download/$ym_file->id/file_form"); ?>">
                                                    <?php echo $i++; ?> - <?php echo filenamedisplay($ym_file->img_url); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="div-table">
                                            <div class="div-table-row">
                                                <div class="div-table-col">
                                                    Dosya Yok, Eklemek İçin Görüntüle Butonundan Şartname Sayfasına
                                                    Gidiniz
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (!empty($ymler)) { ?>
<div class="col-sm-4">
    <div data-plugin="chart" data-options="{
                tooltip : {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    x: 'right',
                    data:[
                        <?php foreach ($ymler as $ym) { echo "'" . $ym->ym_grup . "',"; } ?>
                        ]
                        },
                calculable : true,
                series : [
                    {
                        name:'Yaklaşık Maliyet',
                        type:'pie',
                        radius : [40, 110],
                        center : ['30%', 160],
                        roseType : 'radius',
                        label: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        lableLine: {
                            normal: {
                                show: true
                            },
                            emphasis: {
                                show: true
                            }
                        },
                        data:[
                        <?php foreach ($ymler as $ym) {echo "{value:" . ceil($ym->cost) . ", name:'" . $ym->ym_grup . "'},"; } ?>
                        ]
                    }
                ]
            }" style="height: 300px;">
    </div>
</div>
<?php } ?>



