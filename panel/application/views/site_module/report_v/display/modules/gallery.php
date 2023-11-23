<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php $i = 1; ?>
        <?php $date = dateFormat_dmy($item->report_date); ?>
        <?php foreach ($item_files as $item_file) { ?>
        <?php $path = base_url("uploads/project_v/$project->proje_kodu/$site->dosya_no/Reports/$date/thumbnails/$item_file->img_url"); ?>
            <div class="carousel-item <?php if ($i=1){ echo "active";} ?>" style="height: 400px;">
                <img src="<?php echo "$path";?>" class="d-block w-100" alt="<?php echo "$item_file->img_url";?>">
            </div>
       <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>