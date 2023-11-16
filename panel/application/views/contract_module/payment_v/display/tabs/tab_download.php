<div class="fade tab-pane <?php if ($active_tab == "download") {
    echo "active show";
} ?>"
     id="download" role="tabpanel"
     aria-labelledby="download-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-5" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">01 - Metrajlar</h6>
                    <div style="height: 100px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="radio22"
                                   data-url="<?php echo base_url("payment/print_calculate/$item->id/0"); ?>"
                                   type="radio" name="calculate" value="option1" checked="">
                            <label class="form-check-label" for="radio22">Tüm Metrajlar</label>
                        </div>
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="radio55"
                                   data-url="<?php echo base_url("payment/print_calculate/$item->id/1"); ?>"
                                   type="radio" name="calculate" value="option1">
                            <label class="form-check-label" for="radio55">Ana Gruplardan Ayır</label>
                        </div>
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="radio33"
                                   data-url="<?php echo base_url("payment/print_calculate/$item->id/2"); ?>"
                                   type="radio" name="calculate" value="option2">
                            <label class="form-check-label" for="radio33">Alt Gruplardan Ayır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="calculate"
                                            onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="calculate"
                                            onclick="handleButtonClick(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">02 - Metraj İcmali</h6>
                    <div style="height: 100px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="green1"
                                   data-url="<?php echo base_url("payment/print_green_all/$item->id"); ?>"
                                   type="radio" name="green" value="green" checked="">
                            <label class="form-check-label" for="green1">Sıralı Yazdır</label>
                        </div>
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="green2"
                                   data-url="<?php echo base_url("payment/print_green_hide_zero/$item->id"); ?>"
                                   type="radio" name="green" value="green">
                            <label class="form-check-label" for="green2">Toplamı Sıfır Olanları Gösterme</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="green" onclick="handleButtonClick(1)"
                                            type="button"><i class="fa fa-download"></i> İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="green" onclick="handleButtonClick(0)"
                                            type="button"><i class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">03 - Yapılan İşler Listesi</h6>
                    <div style="height: 100px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="wd1"
                                   data-url="<?php echo base_url("payment/print_works_done_hide_zero/$item->id"); ?>"
                                   type="radio" name="wd" value="green" checked="">
                            <label class="form-check-label" for="wd1">Sıfır Olanları Gizle</label>
                        </div>
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="wd2"
                                   data-url="<?php echo base_url("payment/print_works_done_print_all/$item->id"); ?>"
                                   type="radio" name="wd" value="green">
                            <label class="form-check-label" for="wd2">Tümünü Yazdır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="wd"
                                            onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="wd"
                                            onclick="handleButtonClick(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">04 - Yapılan İşler Grup İcmalleri</h6>
                    <div style="height: 50px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="gt1"
                                   data-url="<?php echo base_url("payment/print_group_total/$item->id"); ?>"
                                   type="radio" name="gt" value="green" checked="">
                            <label class="form-check-label" for="gt1">Tümünü Yazdır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="gt"
                                            onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="gt"
                                            onclick="handleButtonClick(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">05 - Yapılan İşler İcmali</h6>
                    <div style="height: 50px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="mt1"
                                   data-url="<?php echo base_url("payment/print_main_total/$item->id"); ?>"
                                   type="radio" name="mt" value="main" checked="">
                            <label class="form-check-label" for="mt1">Tümünü Yazdır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="mt"
                                            onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="mt"
                                            onclick="handleButtonClick(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6" style="height: 200px;">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">06 - Hakediş Raporu (Hesap Cetveli)</h6>
                    <div style="height: 50px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="rep1"
                                   data-url="<?php echo base_url("payment/print_report/$item->id"); ?>"
                                   type="radio" name="report" value="report" checked="">
                            <label class="form-check-label" for="rep1">Tümünü Yazdır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="report"
                                            onclick="handleButtonClick(1)" type="button"><i class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="report"
                                            onclick="handleButtonClick(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="h-100 checkbox-checked">
                    <h6 class="sub-title">07 - Hakediş Raporu (Kapak)</h6>
                    <div style="height: 50px;">
                        <div class="form-check radio radio-success">
                            <input class="form-check-input" id="cover1"
                                   data-url="<?php echo base_url("payment/print_cover/$item->id"); ?>"
                                   type="radio" name="cover" value="cover" checked="">
                            <label class="form-check-label" for="cover1">Tümünü Yazdır</label>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="cover" onclick="handleButtonClick(1)"
                                            type="button"><i class="fa fa-download"></i> İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="cover" onclick="handleButtonClick(0)"
                                            type="button"><i class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


