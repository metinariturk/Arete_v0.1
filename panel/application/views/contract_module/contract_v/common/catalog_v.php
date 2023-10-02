<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Katalog Görselleri
                        <a onclick="deleteConfirmationModule(this)"
                           text = "Kategorideki Tüm Görselleri"
                           data-url="<?php echo base_url("$this->Module_Name/catalogDelete_all/$item->id"); ?>"
                        <i style="font-size: 18px; color: Tomato;" class="fa fa-times-circle-o" aria-hidden="true"></i>
                        </a>
                    </h5>
                </div>
                <div class="gallery my-gallery card-body row" itemscope="">
                    <?php
                    $path = "$this->File_Dir_Prefix/$project->proje_kodu/$item->dosya_no/catalog";

                    $support_ext = array("jpg", "jpeg", "gif", "png");
                    $files = directory_map($path, 1);
                    $i = 1;
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $ext = pathinfo($file, PATHINFO_EXTENSION);
                            if (in_array($ext, $support_ext)) { ?>
                                <figure class="col-xl-3 col-md-4 col-6" itemprop="associatedMedia" itemscope="">
                                    <a href="<?php echo base_url("$path/$file"); ?>"
                                       itemprop="contentUrl"
                                       data-size="1950x<?php
                                       $boyutlar = getimagesize("$path/$file");
                                       $ratio = 1950 / $boyutlar[0];
                                       echo ceil($boyutlar[1] * $ratio);
                                       ?>">

                                        <img class="img-thumbnail"
                                             src="<?php $thumb_name = get_thumb_name($file);
                                             echo base_url("$path/thumb/$thumb_name"); ?>"
                                             itemprop="thumbnail" alt="Image description">
                                    </a>

                                    <figcaption itemprop="caption description">
                                        <?php echo $i++; ?><br>
                                        <a onclick="deleteConfirmationCatalog(this)"
                                           url="<?php echo base_url("$this->Module_Name/catalogDelete/$item->id/$file"); ?>"
                                        <i style="font-size: 30px; color: Tomato;" class="fa fa-times-circle-o"
                                           aria-hidden="true"></i>
                                        </a>
                                    </figcaption>
                                </figure>
                            <?php }
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- Root element of PhotoSwipe. Must have class pswp.-->
            <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="pswp__bg"></div>
                <div class="pswp__scroll-wrap">
                    <div class="pswp__container">
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                        <div class="pswp__item"></div>
                    </div>
                    <div class="pswp__ui pswp__ui--hidden">
                        <div class="pswp__top-bar">
                            <div class="pswp__counter"></div>
                            <button class="pswp__button pswp__button--close" title="Kapat (Esc)"></button>
                            <button class="pswp__button pswp__button--share" title="İndir"></button>
                            <button class="pswp__button pswp__button--fs" title="Tam Ekran"></button>
                            <div class="pswp__preloader">
                                <div class="pswp__preloader__icn">
                                    <div class="pswp__preloader__cut">
                                        <div class="pswp__preloader__donut"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                            <div class="pswp__share-tooltip"></div>
                        </div>
                        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                        <div class="pswp__caption">
                            <div class="pswp__caption__center">asdasd</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

