<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php foreach ($main_categories as $main_category) { ?>
                <div class="col-md-3">
                    <h4><b><baslik><?php echo $main_category->name; ?></baslik></b></h4>
                    <nav class="nav">
                        <ul class=list>
                            <li>
                                <?php $sub_categories = $this->Workgroup_model->get_all(array(
                                    'sub_category'=> 1,
                                    'parent'=> $main_category->id
                                )); ?>
                                <b></b>
                                <ul>
                                    <?php foreach ($sub_categories as $sub_category) { ?>
                                        <li><?php echo $sub_category->name; ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


