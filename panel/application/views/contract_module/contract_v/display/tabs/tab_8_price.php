<div id="leader_list">
    <div class="card-body">
        <form class="row g-1 needs-validation custom-input" method="post"
              action="<?php echo base_url("contract/add_leader/$item->id"); ?>">
            <div class="col-md-2 position-relative">
                <label class="form-label" for="validationTooltip01">Kodu</label>
                <input name="leader_code" class="form-control" id="validationTooltip01" type="text"
                       placeholder="01, 1A vs..." required="">
            </div>
            <div class="col-md-4 position-relative">
                <label class="form-label" for="validationTooltip02">Poz Adı</label>
                <input class="form-control" id="validationTooltip02" type="text" placeholder="" required="">
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label" for="validationTooltipUsername">Birimi</label>
                <div class="input-group has-validation">
                    <input class="form-control" id="validationTooltipUsername" type="text"
                           aria-describedby="validationTooltipUsernamePrepend" required="">
                </div>
            </div>
            <div class="col-md-2 position-relative">
                <label class="form-label" for="validationTooltip03">Fiyat</label>
                <input class="form-control" id="validationTooltip03" type="text" required="">
            </div>
            <div class="col-2">
                <label class="form-label" for="validationTooltip04">&nbsp;</label>
                <br>
                <a class="button" id="validationTooltip04" onclick="save_leader()" type="text" required=""><i
                            class="fa fa-plus-circle fa-2x"></i></a>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Poz Listesi</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Poz Adı</th>
                    <th>Birimi</th>
                    <th>Fiyat</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($leaders as $leader) { ?>
                    <tr>
                        <td><?php echo $leader->code; ?></td>
                        <td><?php echo $leader->name; ?> </td>
                        <td><?php echo $leader->unit; ?></td>
                        <td><?php echo $leader->price; ?></td>
                        <td>
                            <a onclick="delete_price_item(this)" id="<?php echo $leader->id; ?>">
                                <i style="color: tomato" class="fa fa-minus-circle fa-2x"
                                   aria-hidden="true"></i>
                            </a>
                        </td>

                    </tr>
                <?php }; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>