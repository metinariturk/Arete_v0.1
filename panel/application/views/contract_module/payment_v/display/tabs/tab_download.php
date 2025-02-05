<div class="fade tab-pane <?php if ($active_tab == "download") {
    echo "active show";
} ?>"
     id="download" role="tabpanel"
     aria-labelledby="download-tab">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <form name="print_all" method="post" target="_blank">
                    <div class="col-md-12">
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary1">00 - Sözleşme Özeti</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="contract_report" style="margin-left: 20px"
                                           checked
                                           id="checkbox-primary1" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary1">Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary2">01 - Hakediş Raporu
                                    (Kapak)</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="report_cover" style="margin-left: 20px"
                                           checked
                                           id="checkbox-primary2" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary2">Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary3">02 - Hakediş Raporu (Hesap
                                    Cetveli)</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="report_calculate" style="margin-left: 20px"
                                           checked
                                           id="checkbox-primary3" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary3">Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary4">03 - Yapılan İşler
                                    İcmali</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="main_total" style="margin-left: 20px" checked
                                           id="checkbox-primary4" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary4">Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary5">04 - Yapılan İşler Grup
                                    İcmalleri</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="group_total" style="margin-left: 20px" checked
                                           id="checkbox-primary5" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary5">Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label">05 - Yapılan İşler Listesi</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="wd_hide_zero" style="margin-left: 20px"
                                           checked
                                           id="checkbox-primary6" type="checkbox"
                                           onchange="wd_toggleCheckbox(this)">
                                    <label class="form-check-label" for="checkbox-primary6">Sıfır Olanları Gizle</label>
                                </div>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="wd_all" style="margin-left: 20px"
                                           id="checkbox-primary7" type="checkbox"
                                           onchange="wd_toggleCheckbox(this)">
                                    <label class="form-check-label" for="checkbox-primary7">Tümünü Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary8">06 - Metraj İcmali</label>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="green_hide_zero" style="margin-left: 20px"
                                           checked
                                           onchange="green_toggleCheckbox(this)"
                                           id="checkbox-primary8"  type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary8">Sıfır Olanları
                                        Gösterme</label>
                                </div>
                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="green_all" style="margin-left: 20px"
                                           onchange="green_toggleCheckbox(this)"
                                           id="checkbox-primary9" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary9">Tümünü Yazdır</label>
                                </div>
                            </h6>
                        </div>
                        <div class="h-100 checkbox-checked">
                            <h6>
                                <label class="form-check-label" for="checkbox-primary10">07 - Metrajlar</label>


                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="calculate_all" style="margin-left: 20px"
                                           checked
                                           onchange="calculate_toggleCheckbox(this)"
                                           id="checkbox-primary10" type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary10">Tüm Metrajlar</label>
                                </div>

                                <div class="form-check checkbox checkbox-success mb-0">
                                    <input class="form-check-input" name="calculate_seperate_sub"
                                           onchange="calculate_toggleCheckbox(this)"
                                           style="margin-left: 20px" id="checkbox-primary12"
                                           type="checkbox">
                                    <label class="form-check-label" for="checkbox-primary12">Alt Gruplardan Ayır</label>
                                </div>
                            </h6>
                        </div>
                    </div>
                    <div class="form-check radio radio-success">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div class="btn-group btn-group-pill" role="group" aria-label="Basic example">
                                    <button class="btn btn-outline-success" name="calculate"
                                            onclick="asd(1)" type="button"><i
                                                class="fa fa-download"></i>
                                        İndir
                                    </button>
                                    <button class="btn btn-outline-success" name="calculate"
                                            onclick="asd(0)" type="button"><i
                                                class="fa fa-file-pdf-o"></i>Önizle
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

