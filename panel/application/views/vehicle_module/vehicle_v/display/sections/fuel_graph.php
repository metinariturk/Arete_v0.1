<div class="widget">
    <header class="widget-header">
        <h4 class="widget-title">Litre / <?php echo km_saat($item->yakit_takip); ?></h4>
    </header><!-- .widget-header -->
    <hr class="widget-separator">
    <div class="widget-body">
        <div data-plugin="plot" data-options="
							[
								{
									data: [
									<?php if (!empty($fuels = get_from_any_array("fuel", "vehicle_id", $item->id))) {
            $i = 1;
            foreach ($fuels as $fuel) {
                echo "[" . $i++ . "," . ($fuel->ortalama * 100) . "],";
            }
        } ?>
                                            ],
									color: '#3f51b5',
									lines: { show: true, lineWidth: 6 },
									curvedLines: { apply: true }
								},
								{
									data: [
									<?php if (!empty($fuels = get_from_any_array("fuel", "vehicle_id", $item->id))) {
            $i = 1;
            foreach ($fuels as $fuel) {
                echo "[" . $i++ . "," . ($fuel->ortalama * 100) . "],";
            }
        } ?>
                                            ],
									color: '#3f51b5',
									points: { show: true }
								}
							],
							{
								series: {
									curvedLines: { active: true }
								},
								xaxis: {
									show: true,
									font: {size: 12, lineHeight: 10, style: 'normal', weight: '100',family: 'lato', variant: 'small-caps', color: '#a2a0a0' }
								},
								yaxis: {
									show: true,
									font: {size: 12, lineHeight: 10, style: 'normal', weight: '100',family: 'lato', variant: 'small-caps', color: '#a2a0a0' }
								},
								grid: { color: '#cccccc', hoverable: true, margin: 8, labelMargin: 8, borderWidth: 0, backgroundColor: '#fff' },
								tooltip: true,
								tooltipOpts: { content: 'X: %x.0, Y: %y.2',  defaultTheme: false, shifts: { x: 0, y: -40 } },
								legend: { show: false }
							}" style="height: 200px;width: 100%;">
        </div>
    </div><!-- .widget-body -->
</div><!-- .widget -->

