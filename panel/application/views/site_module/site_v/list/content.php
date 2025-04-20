<div class="card">
    <div class="card-header bg-dark text-white">
        <h3>Şantiyeler</h3>
    </div>
    <div class="card-body">
        <!-- Sekmeler -->
        <ul class="nav nav-tabs" id="siteTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#site_active" role="tab">Devam
                    Eden</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#site_inactive" role="tab">Biten</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#site_all" role="tab">Tümü</a>
            </li>
        </ul>

        <!-- Sekme İçerikleri -->
        <div class="tab-content mt-3" id="siteTabsContent">

            <!-- Devam Eden Sözleşmeler -->
            <div class="tab-pane fade show active" id="site_active" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("site_module/site_v/list/tabs/active"); ?>
                </div>
            </div>
            <!-- Biten Sözleşmeler -->
            <div class="tab-pane fade" id="site_inactive" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("site_module/site_v/list/tabs/inactive"); ?>
                </div>
            </div>
            <!-- Tüm Sözleşmeler -->
            <div class="tab-pane fade" id="site_all" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("site_module/site_v/list/tabs/all"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

