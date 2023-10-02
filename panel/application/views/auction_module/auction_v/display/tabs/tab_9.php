<div class="fade tab-pane <?php if ($active_tab == "qualify"){echo "active show"; } ?>" id="yeterlilik" role="tabpanel"
     aria-labelledby="yeterlilik-tab">

            <div class="col-sm-12 xl-100">
                <div class="card height-equal">
                    <div class="card-header">
                        <h5>Ön Yeterlilik</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills" id="pills-icontab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="qualify-list-tab" data-bs-toggle="pill" href="#qualify-list" role="tab" aria-controls="qualify-list" aria-selected="true"><i class="fa fa-list"></i>Yeterlilik Özeti</a></li>
                            <li class="nav-item"><a class="nav-link" id="qualify-data-tab" data-bs-toggle="pill" href="#qualify-data" role="tab" aria-controls="qualify-data" aria-selected="false"><i class="fa fa-check-circle"></i></i>Yeterlilik</a></li>
                            <li class="nav-item"><a class="nav-link" id="quailfy-file-tab" data-bs-toggle="pill" href="#quailfy-file" role="tab" aria-controls="quailfy-file" aria-selected="false"><i class="fa fa-folder-open-o"></i></i>Evraklar</a></li>
                        </ul>
                        <div class="tab-content" id="pills-icontabContent">
                            <div class="tab-pane fade show active" id="qualify-list" role="tabpanel" aria-labelledby="qualify-list-tab">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/qualify_table"); ?>
                            </div>
                            <div class="tab-pane fade" id="qualify-data" role="tabpanel" aria-labelledby="qualify-data-tab">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/qualify"); ?>
                            </div>
                            <div class="tab-pane fade" id="quailfy-file" role="tabpanel" aria-labelledby="quailfy-file-tab">
                                <?php $this->load->view("{$viewModule}/{$viewFolder}/{$subViewFolder}/modules/qualify_file"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</div>

