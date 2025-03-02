<div class="refresh_group" id="refresh_group" name="refresh_group">
    <div class="container">
        <!-- Ana Grup Ekleme Alanı ve Ana Gruplar Aynı Satırda -->
        <form id="update_default" action="<?php echo base_url('Settings/update_default_group'); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="row mb-3">
                <!-- Ana Grup Ekleme -->
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <strong>Yeni Ana Grup</strong>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <input type="text" name="groups[new_main][code]" class="form-control form-control-sm" placeholder="Ana Grup Kodu">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="groups[new_main][name]" class="form-control form-control-sm" placeholder="Ana Grup Adı">
                                </div>
                                <div class="col-md-3 text-end">
                                    <!-- Bu butona tıklandığında AJAX fonksiyonu çalışacak -->
                                    <a href="javascript:void(0);" class="text-success" form-id="update_default" id="save_button" onclick="update_group(this)">
                                        <i class="fa fa-plus-circle fa-xl"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
