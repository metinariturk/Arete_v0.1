<?php
 $lastik = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 1,"gerekce",1,2);
 $motor = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 2,"gerekce",1,2);
 $kaporta = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 3,"gerekce",1,2);
 $genel = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 4,"gerekce",1,2);
 $periyodik = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 5,"gerekce",1,2);
 $hidrolik = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 6,"gerekce",1,2);
 $sanzuman = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 7,"gerekce",1,2);
 $diger = sum_anything_and_and_or("service", "fiyat", "vehicle_id", $item->id,"islem_turu", 8,"gerekce",1,2);

 $toplam  = sum_anything_and_or("service", "fiyat", "vehicle_id", $item->id,"gerekce", 2,1);
?>

<div class="widget">
    <header class="widget-header">
        <h4 class="widget-title">Arıza/Bakım Maliyet Dağılımı</h4>
        <table class="table">
            <tbody>
            <?php if ($lastik>0) { ?>
                <tr>
                    <td>Lastik Gideri</td>
                    <td> <?php echo $lastik." TL"; ?></td>
                </tr>
            <?php } ?>
            <?php if ($motor>0) { ?>
                <tr>
                    <td>Motor Gideri</td>
                    <td><?php echo $motor." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($kaporta>0) { ?>
                <tr>
                    <td>Kaporta Gideri</td>
                    <td><?php echo $kaporta." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($genel>0) { ?>
                <tr>
                    <td>Genel Gideri</td>
                    <td><?php echo $genel." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($periyodik>0) { ?>
                <tr>
                    <td>Periyodik Gideri</td>
                    <td><?php echo $periyodik." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($hidrolik>0) { ?>
                <tr>
                    <td>Hidrolik Gideri</td>
                    <td><?php echo $hidrolik." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($sanzuman>0) { ?>
                <tr>
                    <td>Şanzuman Gideri</td>
                    <td><?php echo $sanzuman." TL" ; ?></td>
                </tr>
            <?php } ?>
            <?php if ($diger>0) { ?>
                <tr>
                    <td>Diğer Gideri</td>
                    <td><?php echo $diger." TL" ; ?></td>
                </tr>
            <?php } ?>
                <tr>
                    <td><b>Genel Toplam</b></td>
                    <td><b><?php echo money_format($toplam)." TL"; ?></b></td>
                </tr>
            </tbody>
        </table>
    </header><!-- .widget-header -->
    <hr class="widget-separator">
    <div class="widget-body">
        <div data-plugin="chart" data-options="{
                tooltip : {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data:[<?php if ($lastik>0) { echo "'Lastik',"; } ?>
                        <?php if ($motor>0) { echo "'Motor',"; } ?>
                        <?php if ($kaporta>0) { echo "'Kaporta',"; } ?>
                        <?php if ($genel>0) { echo "'Genel',"; } ?>
                        <?php if ($periyodik>0) { echo "'Periyodik',"; } ?>
                        <?php if ($hidrolik>0) { echo "'Hidrolik',"; } ?>
                        <?php if ($sanzuman>0) { echo "'Şanzuman',"; } ?>
                        <?php if ($diger>0) { echo "'Diğer',"; } ?>]
                        },
                calculable : true,
                series : [
                    {
                        name:'Gider',
                        type:'pie',
                        radius : [40, 110],
                        center : ['60%', 160],
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
                            <?php if ($lastik>0) { ?>
                            {value:<?php echo ceil($lastik); ?>, name:'Lastik'},
                            <?php } ?>
                            <?php if ($motor>0) { ?>
                            {value:<?php echo ceil($motor); ?>, name:'Motor'},
                            <?php } ?>
                            <?php if ($kaporta>0) { ?>
                            {value:<?php echo ceil($kaporta); ?>, name:'Kaporta'},
                            <?php } ?>
                            <?php if ($genel>0) { ?>
                            {value:<?php echo ceil($genel); ?>, name:'Genel'},
                            <?php } ?>
                            <?php if ($periyodik>0) { ?>
                            {value:<?php echo ceil($periyodik); ?>, name:'Periyodik'},
                            <?php } ?>
                            <?php if ($hidrolik>0) { ?>
                            {value:<?php echo ceil($hidrolik); ?>, name:'Hidrolik'},
                            <?php } ?>
                            <?php if ($sanzuman>0) { ?>
                            {value:<?php echo ceil($sanzuman); ?>, name:'Şanzuman'},
                            <?php } ?>
                            <?php if ($diger>0) { ?>
                            {value:<?php echo ceil($diger); ?>, name:'Diğer'},
                            <?php } ?>
                        ]
                    }
                ]
            }" style="height: 300px;">
        </div>
    </div><!-- .widget-body -->
</div><!-- .widget -->


