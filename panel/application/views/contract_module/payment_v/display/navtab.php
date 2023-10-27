<div class="email-left-aside">
    <div class="card">
        <div class="card-body">
            <div class="email-app-sidebar left-bookmark">
                <ul class="nav main-menu" role="tablist">
                    <?php if (isset($boq)){ ?>
                        <a class="btn btn-primary" href="<?php echo base_url("boq/new_form/$contract->id/$item->hakedis_no"); ?>">
                            <i class="fa fa-plus"></i> Metraj Düzenle
                        </a>
                    <?php } else { ?>
                        <a class="btn btn-primary" href="<?php echo base_url("boq/new_form/$contract->id/$item->hakedis_no"); ?>">
                            <i class="fa fa-plus"></i> Metraj Yap
                        </a>
                    <?php } ?>
                    <li>
                        <a class="show"
                           id="calculate-tab"
                           data-bs-toggle="pill"
                           href="#calculate"
                           role="tab"
                           aria-controls="calculate"
                           aria-selected="true">
                            <span class="title">Metraj Cetveli</span>
                        </a>
                    </li>
                    <li>
                        <a class="show"
                           id="green-tab"
                           data-bs-toggle="pill"
                           href="#green"
                           role="tab"
                           aria-controls="green"
                           aria-selected="false">
                            <span class="title">Metraj İcmali</span>
                        </a>
                    </li>
                    <li>
                        <a id="works_done-tab"
                           data-bs-toggle="pill"
                           href="#works_done"
                           role="tab"
                           aria-controls="works_done"
                           aria-selected="false">
                            <span class="title">Yapılan İşler</span>
                        </a>
                    </li>
                    <li>
                        <a class="show"
                           id="group_total-tab"
                           data-bs-toggle="pill"
                           href="#group_total"
                           role="tab"
                           aria-controls="group_total"
                           aria-selected="false">
                            <span class="title">Grup İcmali</span>
                        </a>
                    </li>
                    <li>
                        <a class="show"
                           id="report-tab"
                           data-bs-toggle="pill"
                           href="#report"
                           role="tab"
                           aria-controls="report"
                           aria-selected="false">
                            <span class="title">Hakediş Raporu</span>
                        </a>
                    </li>
                    <li>
                        <a id="genel-tab"
                           data-bs-toggle="pill"
                           href="#genel"
                           role="tab"
                           aria-controls="genel"
                           aria-selected="false">
                            <span class "title">Hakediş Kapağı</span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="graph-tab"
                           data-bs-toggle="pill"
                           href="#graph"
                           role="tab"
                           aria-controls="graph"
                           aria-selected="false">
                            <span class="title">Grafikler</span>
                        </a>
                    </li>
                    <li>
                        <a class="show" id="sign-tab"
                           data-bs-toggle="pill"
                           href="#sign"
                           role="tab"
                           aria-controls="sign"
                           aria-selected="false">
                            <span class="title">İmzalar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
