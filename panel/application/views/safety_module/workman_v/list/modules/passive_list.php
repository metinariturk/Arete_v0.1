<div class="widget-body clearfix">
    <div class="pull-left">
        <div class="table-responsive">

            <table class="table table-striped content-container tablecenter">
                <tbody>
                <tr>
                    <th>id</th>
                    <th>Personel Adı</th>
                    <th>Ekip</th>
                    <th>Yaşı</th>
                    <th>Çalışma Süresi</th>
                    <th>Durumu</th>
                </tr>
                <?php $all_workgroups = get_from_any_array("workgroup", "sub_category", "1"); ?>
                <?php foreach ($all_workgroups as $all_workgroup) { ?>
                    <?php foreach ($passiveworkers as $worker) { ?>
                        <?php if ($all_workgroup->id == $worker->group) { ?>
                            <tr>
                                <td>
                                    <?php echo "$worker->id"; ?>
                                </td>
                                <td>
                                    <?php echo $worker->name . " " . $worker->surname; ?>
                                </td>
                                <td>
                                    <?php echo group_name($worker->group); ?>
                                </td>
                                <td>

                                </td>
                                <td>

                                    <?php
                                    echo calistigi_gun($worker->start_date);
                                    ?>
                                </td>
                                <td class="w5c">
                                    <input
                                            data-url="<?php echo base_url("Workman/isActiveSetter/$worker->id"); ?>"
                                            class="isActive"
                                            type="checkbox"
                                            data-switchery
                                            data-color="#10c469"
                                        <?php echo ($worker->isActive) ? "checked" : ""; ?>
                                    />
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>

                </tbody>

            </table>
        </div>
    </div>
</div><!-- .widget-body -->
