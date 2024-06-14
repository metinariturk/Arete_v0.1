<table class="table">
    <thead>
    <tr>
        <th>Proje Adı</th>
        <th>Proje Düzenle</th>
        <th>Proje Favoriye Ekle</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $item->project_code . "/" . $item->project_name; ?></td>
        <td>

        </td>
        <td>
            <a onclick="changeIcon(this)"
               url="<?php echo base_url("$this->Module_Name/favorite/$item->id"); ?>"
               id="myBtn">
                <i class="fa <?php echo $fav ? 'fa-star' : 'fa-star-o'; ?> fa-2x">
                </i>
            </a>

        </td>
    </tr>
    </tbody>
</table>