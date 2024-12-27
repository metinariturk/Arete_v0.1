<?php

// Dizin içeriğini al
$files = scandir($sub_path);

// Klasör sayısını hesaplamak için bir değişken
$folder_count = 0;

// Dizin içindeki her dosyayı kontrol et
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
        // Eğer bu bir klasörse
        if (is_dir($file_path)) {
            $folder_count++;
        }
    }
}
?>
<div class="file-content">
    <div class="card">
        <div class="card-header">
            <div class="media">
                <form class="form-inline" action="#" method="get">
                    <div class="form-group mb-0"><i class="fa fa-search"></i>
                        <input class="form-control-plaintext" type="text" placeholder="Ara...">
                    </div>
                </form>
                <div class="media-body text-end">
                    <form class="d-inline-flex" action="#" method="POST" enctype="multipart/form-data" name="myForm">
                        <div class="btn btn-primary" onclick="getFile()"><i data-feather="plus-square"></i>Yeni Ekle</div>
                        <div style="height: 0px;width: 0px; overflow:hidden;">
                            <input id="upfile" type="file" onchange="sub(this)">
                        </div>
                    </form>
                    <div class="btn btn-outline-primary ms-2"><i data-feather="upload"> </i>Yükle</div>
                </div>
            </div>
        </div>

        <div class="card-body file-manager">
            <h4 class="mb-3">Tüm Dosyalar</h4>
            <h6>Toplam Klasör Sayısı: <?php echo $folder_count; ?> Klasör</h6>

            <!-- Klasörler Grubu (Yan Yana Görüntülenmesi için düzenleme) -->
            <h5>Klasörler</h5>
            <div class="row">
                <?php
                // Dizin içindeki klasörleri listele
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($file_path)) {
                            // Klasörse
                            $sub_files = scandir($file_path);
                            $sub_file_count = count($sub_files) - 2; // "." ve ".." dosyalarını çıkar

                            // Burada PHP değişkenlerini JavaScript'e düzgün şekilde iletebilmek için tırnakları dikkatlice kullanıyoruz
                            echo "<div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3'>
                    <div class='card folder-box' onclick='loadFolderContent(\"$file\")'>
                        <div class='card-body text-center'>
                            <i class='fa fa-folder f-36 txt-warning' onclick=\"sendFolderData('$folder_name', '$item->id', '$file')\"></i>
                            <h6 class='mt-3'>{$file}</h6>
                            <p>{$sub_file_count} dosya</p>
                        </div>
                    </div>
                  </div>";
                        }
                    }
                }
                ?>
            </div>

            <!-- Dosyalar Grubu -->
            <h5>Dosyalar</h5>
            <ul class="files">
                <?php
                // Dizin içindeki dosyaları listele
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        $file_path = $sub_path . DIRECTORY_SEPARATOR . $file;
                        if (is_file($file_path)) {
                            // Dosya ise
                            $file_size = filesize($file_path);
                            $creation_time = date("Y-m-d H:i:s", filectime($file_path)); // Dosyanın oluşturulma tarihi

                            echo "<li class='file-box'>
                                    <div class='file-top'><i class='fa fa-file-o txt-primary'></i><i class='fa fa-ellipsis-v f-14 ellips'></i></div>
                                    <div class='file-bottom'>
                                        <h6>{$file}</h6>
                                        <p class='mb-1'>" . round($file_size / 1024 / 1024, 2) . " MB</p>
                                        <p><b>Oluşturulma Tarihi: </b>{$creation_time}</p>
                                    </div>
                                </li>";
                        }
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>