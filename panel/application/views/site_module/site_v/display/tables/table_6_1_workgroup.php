<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center">Tanımlı İş Grupları</h5>
            </div>
            <div class="row">
                <?php if (!empty($workgroups)) { ?>
                    <?php foreach ($workgroups as $workgroup => $subgroups) { ?>
                        <div class="col-md-12 col-xl-6 col-xl-4">
                            <h5>
                                <b>
                                    <baslik><?php echo group_name($workgroup); ?></baslik>
                                </b>
                            </h5>
                            <nav class="nav">
                                <ul class=list>
                                    <li>
                                        <ul>
                                            <?php foreach ($subgroups as $subgroup) { ?>

                                                <li><span url="<?php echo base_url("Site/delete_group/$item->id/$subgroup"); ?>"
                                                          onclick="add_group(this)"
                                                          onmouseover="this.style.cursor='pointer'">
                                                        <?php echo group_name($subgroup); ?></span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-light" role="alert">
                        <h5 class="alert-heading">İş Grubu Seçimi</h5>
                        <p>* Günlük Raporlarda Kullanacağınız İş Gruplarını Yandaki Listeden Seçiniz
                        </p>
                        <hr>
                        <p class="mb-0">Şu an tanımlı iş grubu yok. Günlük rapor girişinde iş grubu verisi
                            kullanamazsınız</p>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center">İş Grupları</h5>
            </div>
            <div class="row">
                <?php foreach ($main_categories as $main_category) { ?>
                    <div class="col-md-12 col-xl-6 col-xl-4">
                        <h5>
                            <b>
                                <baslik><?php echo $main_category->name; ?></baslik>
                            </b>
                        </h5>
                        <nav class="nav">
                            <ul class=list>
                                <li>
                                    <?php $sub_categories = $this->Workgroup_model->get_all(array(
                                        'sub_category' => 1,
                                        'parent' => $main_category->id
                                    )); ?>
                                    <ul>
                                        <?php foreach ($sub_categories as $sub_category): ?>
                                            <?php $search_array = isset($workgroups[$main_category->id]) ? $workgroups[$main_category->id] : []; ?>
                                            <?php if (in_array($sub_category->id, $search_array, true)): ?>
                                            <?php else: ?>
                                                <li><span url="<?php echo base_url("Site/add_group/$item->id/$sub_category->id"); ?>"
                                                          onclick="add_group(this)"
                                                          onmouseover="this.style.cursor='pointer'">
                                                        <?php echo $sub_category->name; ?></span>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
