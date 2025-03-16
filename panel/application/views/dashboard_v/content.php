<div class="card">
    <div class="card-header">
        <h5>Ana Sayfa</h5>
    </div>
    <?php $this->load->view("{$viewFolder}/list/01_favorite"); ?>
    <hr>
    <div class="row">
        <div class="col-xl-6 col-md-6 col-sm-12">
            <div id="notes_table">
                <?php $this->load->view("{$viewFolder}/notes/notes_table"); ?>
            </div>
            <div id="add_notes_modal">
                <?php $this->load->view("{$viewFolder}/notes/add_notes_modal"); ?>
            </div>
            <div id="edit_notes_modal">
                <?php $this->load->view("{$viewFolder}/notes/edit_notes_modal_form"); ?>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-12">
            <?php $this->load->view("{$viewFolder}/list/03_idioms"); ?>
        </div>
    </div>
</div>
