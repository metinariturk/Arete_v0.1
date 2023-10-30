<?php if (isset($book_items)) { ?>
    <table class="table table-sm table-striped" style="width: 100%;">
        <thead>
        <tr>
            <th style="width: 5%;">Sıra No</th>
            <th style="width: 5%;">Grup No</th>
            <th style="width: 85%;">Grup Adı</th>
            <th style="width: 5%;">Poz Sayısı</th>
        </tr>
        </thead>
        <tbody class="sortable">
        <?php $main_groups = get_main_categories($book_name); ?>
        <?php foreach ($main_groups as $main_group) { ?>
            <tr>
                <td>
                    <?php echo $main_group->sort; ?>
                </td>
                <td>
                    <a id="category" href="#"
                       url="<?php echo base_url("$this->Module_Name/show_item/$book_name/$main_group->id"); ?>"
                       onclick="show_sub(this)"
                       method="post" enctype="multipart">
                        <?php echo $main_group->poz_no; ?>
                    </a>
                </td>
                <td><?php echo $main_group->name; ?></td>
                <td><?php echo count(get_from_any_array($book_name, "parent", "$main_group->id")); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>