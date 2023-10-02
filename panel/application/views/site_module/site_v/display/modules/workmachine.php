<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center">Tanımlı İş Makineleri</h5>
            </div>
            <div class="row">
                <?php if (!empty($workmachines)) { ?>
                    <?php foreach ($workmachines as $workmachine => $subgroups) { ?>
                        <div class="col-md-12 col-xl-6 col-xl-4">
                            <h5>
                                <b>
                                    <baslik><?php echo machine_name($workmachine); ?></baslik>
                                </b>
                            </h5>
                            <nav class="nav">
                                <ul class=list>
                                    <li>
                                        <ul>
                                            <?php foreach ($subgroups as $subgroup) { ?>

                                                <li><span url="<?php echo base_url("Site/delete_machine_group/$item->id/$subgroup"); ?>"
                                                          onclick="add_group_machine(this)"
                                                          onmouseover="this.style.cursor='pointer'">
                                                        <?php echo machine_name($subgroup); ?></span>
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
                        <h5 class="alert-heading">İş Makinesi Seçimi</h5>
                        <p>* Günlük Raporlarda Kullanacağınız İş Makinalarını Yandaki Listeden Seçiniz
                        </p>
                        <hr>
                        <p class="mb-0">Şu an tanımlı iş makinesi yok. Günlük rapor girişinde iş makinesi verisi kullanamazsınız</p>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="card-body">
            <div class="card-header">
                <h5 class="text-center">İş Makineleri</h5>
            </div>
            <div class="row">
                <?php foreach ($main_categories_workmachine as $main_category) { ?>
                    <div class="col-md-12 col-xl-6 col-xl-4">
                        <h5>
                            <b>
                                <baslik><?php echo $main_category->name; ?></baslik>
                            </b>
                        </h5>
                        <nav class="nav">
                            <ul class=list>
                                <li>
                                    <?php $sub_categories = $this->Workmachine_model->get_all(array(
                                        'sub_category' => 1,
                                        'parent' => $main_category->id
                                    )); ?>
                                    <ul>
                                        <?php foreach ($sub_categories as $sub_category): ?>
                                            <?php $search_array = isset($workmachines[$main_category->id]) ? $workmachines[$main_category->id] : []; ?>
                                            <?php if (in_array($sub_category->id, $search_array, true)): ?>
                                            <?php else: ?>
                                                <li><span url="<?php echo base_url("Site/add_machine_group/$item->id/$sub_category->id"); ?>"
                                                          onclick="add_group_machine(this)"
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
