<?php $count = 0; ?>
<?php if (empty($item->sitedel_date)) { ?>

    <li>
        <?php $count++; ?>
        <a href="<?php echo base_url("contract/file_form/$item->id/sitedel"); ?>">
            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>Yer Teslimi Yok
        </a>
    </li>
<?php } ?>

<?php if (empty($item->workplan_payment)) { ?>
    <li>
        <?php $count++; ?>
        <a href="<?php echo base_url("contract/file_form/$item->id/workplan"); ?>">
            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>İş Programı Yok
        </a>
    </li>
<?php } ?>

<?php if (empty($main_bond)) { ?>
    <li>
        <?php $count++; ?>
        <a href="<?php echo base_url("bond/new_form_contract/$item->id"); ?>">
            <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>Sözleşme Teminatı Yok
        </a>
    </li>
<?php } ?>

<?php if ($item->fiyat_fark == 1) { ?>
    <?php if ($item->fiyat_fark_teminat != 1) { ?>
        <?php
        $payment_fiyat_fark = sum_anything("payment", "bu_fiyat_fark", "contract_id", "$item->id");
        $bond_fiyat_fark = sum_anything_and("bond", "teminat_miktar", "contract_id", "$item->id", "teminat_gerekce", "price_diff");
        $min_bond = $payment_fiyat_fark * $item->teminat_oran / 100;
        if ($bond_fiyat_fark < $min_bond) { ?>
            <li>
                <?php $count++; ?>
                <a href="<?php echo base_url("bond/new_form_contract/$item->id"); ?>">
                    <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>Fiyat Farkı Teminatı
                    Yok
                </a>
            </li>
        <?php }
        ?>
    <?php } ?>
<?php } ?>

<?php foreach ($advances as $advance) { ?>
    <?php $teminat = get_from_any_and("bond", "contract_id", "$item->id", "teminat_avans_id", "$advance->id");
    if (empty($teminat)) { ?>
        <li>
            <?php $count++; ?>
            <a href="<?php echo base_url("bond/new_form_advance/$advance->id"); ?>">
                <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>Avans Teminatı Yok
            </a>
        </li>
    <?php } ?>
<?php } ?>
<?php foreach ($costincs as $costinc) { ?>
    <?php if (empty($teminat = get_from_any_and("bond", "contract_id", "$item->id", "teminat_kesif_id", "$costinc->id"))) { ?>
        <li><?php $count++; ?>
            <a href="<?php echo base_url("bond/new_form_costinc/$costinc->id"); ?>">
                <i class="menu-icon fa fa-plus-circle fa-lg" aria-hidden="true"></i>Keşif Artışı Teminatı
                Yok
            </a>
        </li>
    <?php } ?>
<?php } ?>

