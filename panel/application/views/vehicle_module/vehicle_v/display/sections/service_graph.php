<?php

$bakim = sum_anything_and("service", "fiyat", "vehicle_id", $item->id,"gerekce", 1);
$ariza = sum_anything_and("service", "fiyat", "vehicle_id", $item->id,"gerekce", 2);
$muayene = sum_anything_and("service", "fiyat", "vehicle_id", $item->id,"gerekce", 3);
$toplamsbm = sum_anything("service", "fiyat", "vehicle_id", $item->id);
$grafik_gecen_yuzde = "100";
$grafik_kalan_yuzde = "0";
$toplams  = sum_anything_and_or("service", "fiyat", "vehicle_id", $item->id,"gerekce", 1,"");
$toplamb  = sum_anything_and_or("service", "fiyat", "vehicle_id", $item->id,"gerekce", 2,"");
$toplamm  = sum_anything_and_or("service", "fiyat", "vehicle_id", $item->id,"gerekce", 3,"");



?>


<div class="col-md-12">
    <div class="widget">
        <header class="widget-header">
            <h4 class="widget-title">Servis/Bakım/Muayene</h4>
            <table class="table">
                <tbody>
                <tr>
                    <td>
                        Toplam Servis
                    </td>
                    <td>
                        <?php echo money_format($toplams)." TL"; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Toplam Bakım
                    </td>
                    <td>
                        <?php echo money_format($toplamb)." TL"; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Toplam Muayene
                    </td>
                    <td>
                        <?php echo money_format($toplamm)." TL"; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Genel Toplam</b>
                    </td>
                    <td>
                        <b><?php echo money_format($toplams+$toplamm+$toplamb)." TL"; ?></b>
                    </td>
                </tr>
                </tbody>
            </table>
        </header><!-- .widget-header -->
        <div class="widget-body">
            <div data-plugin="chart" data-options="{
                tooltip : {
                    trigger: 'item',
                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                },
                legend: {
                    orient: 'vertical',
                    x: 'left',
                    data:['Bakım','Arıza','Muayene']
                },
                series : [
                    {
                        name: 'Gider',
                        type: 'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                             {value:<?php echo ceil($bakim); ?>, name:'Bakım'},
                            {value:<?php echo ceil($ariza); ?>, name:'Arıza'},
                            {value:<?php echo ceil($muayene); ?>, name:'Muayene'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            }" style="height: 300px;">
            </div>
        </div><!-- .widget-body -->
    </div><!-- .widget -->
</div><!-- END column -->
