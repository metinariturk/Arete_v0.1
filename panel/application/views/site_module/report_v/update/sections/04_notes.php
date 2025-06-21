<div class="card-body">
    <label>Genel Notlar</label>
    <textarea class="form-control" name="note"
              rows="3"><?php echo isset($form_error) ? set_value("note") : $report->aciklama; ?></textarea>
</div>
