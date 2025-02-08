<?php
$folders = [];

// Eğer geçerli dizinse ve okunabilirse
if (is_dir($main_path)) {
    $scannedFiles = scandir($main_path); // Klasörü tarar

    foreach ($scannedFiles as $folder) {
        // "." ve ".." hariç ve yalnızca klasör ise
        if ($folder !== '.' && $folder !== '..' && is_dir($main_path . DIRECTORY_SEPARATOR . $folder)) {
            // Klasör boyutunu hesapla
            $folderPath = $main_path . DIRECTORY_SEPARATOR . $folder;

            $files = scandir($folderPath);
            $fileCount = count($files) - 2;

            $folderSize = getFolderSize($main_path . DIRECTORY_SEPARATOR . $folder);


            // Eğer klasör boyutu sıfırsa, 'Boş Klasör' olarak göster
            if ($folderSize == 4096) {
                $folderSizeText = '';
            } else {
                $folderSizeText = formatSize($folderSize);
            }

            $folders[] = [
                'name' => $folder,
                'size' => $folderSize,
                'file_count' => $fileCount,
                'size_text' => $folderSizeText // Boyut metnini ekliyoruz
            ];
        }
    }

    // İsim sırasına göre klasörleri sırala
    usort($folders, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
} else {
    echo "Dizin geçerli değil: $main_path"; // Dizin hatalıysa bu mesajı verir
}


// Boyutları okunabilir formata dönüştürmek için fonksiyon

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 box-col-6 pe-0">
            <div class="md-sidebar">
                <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                    <div class="file-sidebar">
                        <div class="card">
                            <div class="card-body">
                                <ul>
                                    <li>
                                        <div class="btn btn-primary">
                                            <i data-feather="home"></i>Ana Klasör
                                        </div>
                                    </li>
                                    <?php if (!empty($folders)): ?>
                                        <?php foreach ($folders as $folder): ?>
                                            <li>
                                                <div class="btn btn-light d-flex justify-content-between"
                                                     data-folder-name="<?= htmlspecialchars($folder['name'], ENT_QUOTES, 'UTF-8') ?>"
                                                     data-contract-id="<?= $item->id ?>"
                                                     onclick="sendFolderData(this)">
                                                    <div>
                                                        <i data-feather="folder"></i>
                                                        <?= module_name(htmlspecialchars($folder['name'], ENT_QUOTES, 'UTF-8')) ?>
                                                        (<?= $folder['file_count'] ?>)
                                                    </div>
                                                    <div style="margin-left: auto; font-size: 0.9em;">
                                                        <?= $folder['size_text'] ?>
                                                    </div>
                                                </div>

                                            </li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>
                                            <div class="btn btn-light">Klasör bulunamadı</div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-12 box-col-12">
            <div class="file-content" id="sub_folder">
                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/folder/sub_folder"); ?>
            </div>
        </div>
    </div>
</div>
