<div class="card-body">
    <button
            class="btn btn-primary"
            data-url="<?php echo base_url('user/show_update_form/' . $item->id); ?>"
            data-target="#update-form"
            onclick="loadDynamicContent(this)">
        Güncelle
    </button>

    <table class="table">
        <tbody>
        <tr>
            <th>Ad</th>
            <td><?php echo $item->name; ?></td>
        </tr>
        <tr>
            <th>Soyad</th>
            <td><?php echo $item->surname; ?></td>
        </tr>
        <tr>
            <th>Meslek</th>
            <td><?php echo $item->profession; ?></td>
        </tr>
        <tr>
            <th>Ünvan</th>
            <td><?php echo $item->unvan; ?></td>
        </tr>
        <tr>
            <th>Giriş Tarihi</th>
            <td><?php echo date("d-m-Y", strtotime($item->createdAt)); ?></td>
        </tr>
        <tr>
            <th>Telefon</th>
            <td><?php echo $item->phone; ?></td>
        </tr>
        <tr>
            <th>Kullanıcı Adı</th>
            <td><?php echo $item->user_name; ?></td>
        </tr>
        <tr>
            <th>E-Posta</th>
            <td><?php echo $item->email; ?></td>
        </tr>
        <tr>
            <th>Banka</th>
            <td><?php echo $item->bank; ?></td>
        </tr>
        <tr>
            <th>IBAN</th>
            <td><?php echo $item->IBAN; ?></td>
        </tr>
        <tr>
            <th>Sistem Kullanıcısı</th>
            <td><?php echo ($item->user_role == 1) ? "Evet" : "Hayır"; ?></td>
        </tr>
        </tbody>
    </table>
</div>