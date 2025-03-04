<div class="card">
    <div class="cal-date-widget card-body">
        <div class="cal-info text-center">
            <h2><?php echo date("d"); ?></h2>
            <div class="d-inline-block mt-2"><span
                        class="b-r-dark pe-3"></span><?php echo ay_isimleri(date("m")); ?><span
                        class="ps-3"><?php echo date("Y"); ?></span></div>
            <p class="mt-4 f-16 text-muted">
                <?php $idiom = random_idioms(); ?>
                <?php echo get_from_any("idioms", "idiom", "id", $idiom); ?>
            </p>
            <p class="mt-3 f-14 text-muted" style="text-align: right">
                <?php echo get_from_any("idioms", "owner", "id", $idiom); ?>
            </p>
        </div>
    </div>
</div>
