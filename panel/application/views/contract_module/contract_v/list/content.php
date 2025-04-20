<div class="card">
    <div class="card-header bg-dark text-white">
        <h3>Sözleşmeler</h3>
    </div>
    <div class="card-body">
        <!-- Sekmeler -->
        <ul class="nav nav-tabs" id="contractTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#contract_active" role="tab">Devam
                    Eden</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#contract_inactive"
                   role="tab">Biten</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="all-tab" data-bs-toggle="tab" href="#contract_all" role="tab">Tümü</a>
            </li>
        </ul>

        <!-- Sekme İçerikleri -->
        <div class="tab-content mt-3" id="contractTabsContent">

            <!-- Devam Eden Sözleşmeler -->
            <div class="tab-pane fade show active" id="contract_active" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("contract_module/contract_v/list/tabs/active"); ?>
                </div>
            </div>
            <!-- Biten Sözleşmeler -->
            <div class="tab-pane fade" id="contract_inactive" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("contract_module/contract_v/list/tabs/inactive"); ?>
                </div>
            </div>
            <!-- Tüm Sözleşmeler -->
            <div class="tab-pane fade" id="contract_all" role="tabpanel">
                <div class="table-responsive">
                    <?php $this->load->view("contract_module/contract_v/list/tabs/all"); ?>
                </div>
            </div>
        </div>
    </div>
</div>
