<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <!-- Sekmeler -->
                <ul class="nav nav-tabs" id="rerportsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#rerports_active" role="tab">Tüm Şantiyeler</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#rerports_inactive"
                           role="tab">Biten Şantiyeler</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#rerports_all" role="tab">Devam Eden Şantiyeler</a>
                    </li>
                </ul>

                <!-- Sekme İçerikleri -->
                <div class="tab-content mt-3" id="rerportsTabsContent">
                    <!-- Devam Eden Sözleşmeler -->
                    <div class="tab-pane fade show active" id="rerports_active" role="tabpanel">
                        <div class="table-responsive">
                            <?php $this->load->view("site_module/report_v/list/tabs/all"); ?>
                        </div>
                    </div>
                    <!-- Biten Sözleşmeler -->
                    <div class="tab-pane fade" id="rerports_inactive" role="tabpanel">
                        <div class="table-responsive">
                            <?php $this->load->view("site_module/report_v/list/tabs/inactive"); ?>
                        </div>
                    </div>
                    <!-- Tüm Sözleşmeler -->
                    <div class="tab-pane fade" id="rerports_all" role="tabpanel">
                        <div class="table-responsive">
                            <?php $this->load->view("site_module/report_v/list/tabs/active"); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="wrapper">
            <header>
                <p class="current-date"></p>
                <div class="icons">
                    <span id="prev">&#8249;</span>
                    <span id="next">&#8250;</span>
                </div>
            </header>
            <div class="calendar">
                <ul class="weeks">
                    <li>Pzt</li>
                    <li>Sal</li>
                    <li>Çar</li>
                    <li>Per</li>
                    <li>Cum</li>
                    <li>Cmt</li>
                    <li>Paz</li>
                </ul>
                <ul class="days"></ul>
            </div>
        </div>
    </div>
</div>
