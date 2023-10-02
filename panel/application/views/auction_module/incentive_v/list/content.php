<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display" id="basic-1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Teşvik Adı</th>
                        <th>Teşvik Veren Kurum</th>
                        <th>Kapsam</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->id; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->tesvik_grup; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->tesvik_kurum; ?>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo base_url("$this->Module_Name/file_form/$item->id"); ?>">
                                    <?php echo $item->kapsam; ?>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





