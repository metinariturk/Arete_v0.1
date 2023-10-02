<div class="col-sm-12">
    <div class="text-center">
        <table class="table">
            <thead>
            <tr>
                <th class="w10">id</th>
                <th class="w20">Grubu</th>
                <th class="w30">Teşvik Veren Kurum</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($tesvikler)) { ?>
                <?php foreach ($tesvikler as $tesvik) { ?>
                    <tr>
                        <td>
                            <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>" target="_blank">
                                <?php echo $tesvik->id; ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("incentive/file_form/$tesvik->id"); ?>" target="_blank">
                                <?php echo $tesvik->tesvik_grup; ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo base_url("condition/file_form/$tesvik->id"); ?>" target="_blank">
                                <?php echo $tesvik->tesvik_kurum; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>








