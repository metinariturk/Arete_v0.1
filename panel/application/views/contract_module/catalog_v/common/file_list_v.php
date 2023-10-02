<div class="card">
    <div class="card-header">
        <h5>Katalog Görselleri</h5>
    </div>
    <div class="card-body photoswipe-pb-responsive">
        <div class="my-gallery row grid gallery" id="aniimated-thumbnials" itemscope="">

            <?php
            $path = "uploads/project_v/$project_code/$contract_code/Catalog/$item->dosya_no";
            $support_ext = array("jpg", "jpeg", "gif", "png");
            $files = directory_map($path, 1);
            $i = 1;
            if (!empty($files)) {
                foreach ($files as $file) {
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($ext, $support_ext)) { ?>
                        <figure class="col-md-3 col-sm-6 grid-item" itemprop="associatedMedia" itemscope="">
                            <a href="<?php echo base_url("$path/$file"); ?>"
                               data-size="
                                <?php
                               $boyutlar = getimagesize("$path/$file");
                               echo $boyutlar[0] . "x" . $boyutlar[1];
                               ?>"
                               itemprop="contentUrl">
                                <img class="img-thumbnail"
                                     src="<?php $thumb_name = get_thumb_name($file);
                                     echo base_url("$path/thumb/$thumb_name"); ?>" itemprop="thumbnail"
                                     alt="Image description">
                            </a>
                        </figure>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <!-- Root element of PhotoSwipe. Must have class pswp.-->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <!--
        Background of PhotoSwipe.
        It's a separate element, as animating opacity is faster than rgba().
        -->
        <div class="pswp__bg"></div>
        <!-- Slides wrapper with overflow:hidden.-->
        <div class="pswp__scroll-wrap">
            <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory.-->
            <!-- don't modify these 3 pswp__item elements, data is added later on.-->
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed.-->
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <!-- Controls are self-explanatory. Order can be changed.-->
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Kapat (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="İndir"></button>
                    <button class="pswp__button pswp__button--fs" title="Tam Ekran"></button>
                    <button class="pswp__button pswp__button--zoom" title="Yaklaş / Uzaklaş"></button>
                    <button class="pswp__button pswp__button--zoom" title="Sil"></button>
                    <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR-->
                    <!-- element will get class pswp__preloader--active when preloader is running-->
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
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
</div>
