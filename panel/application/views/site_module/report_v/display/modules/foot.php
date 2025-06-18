<div class="card mb-3 shadow-sm">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0 fw-bold">Genel Notlar</h5>
    </div>
    <div class="card-body p-4"> <?php if (!empty($item->aciklama)) { ?>
            <p class="mb-0 text-muted">
                <?php echo $item->aciklama; ?>
            </p>
        <?php } else { ?>
            <div class="text-center text-muted py-2">
                <i class="fas fa-clipboard me-2"></i> Genel Not Yok.
            </div>
        <?php } ?>
    </div>
</div>