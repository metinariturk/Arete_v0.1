<script src="<?php echo base_url("assets"); ?>/js/chart/apex-chart/apex-chart.js"></script>

<?php
$bugun = date("Y-m-d");
$time_elapsed = date_minus_day($bugun, $item->sitedel_date);
if (!empty($extimes)) {
    $total_day = $item->isin_suresi + sum_anything("extime", "uzatim_miktar", "contract_id", "$item->id");
    if ($time_elapsed > $total_day) {
        echo $sozlesme_yuzde = 100;
    } elseif ($time_elapsed < $total_day) {
        echo $sozlesme_yuzde = round($time_elapsed / $total_day * 100);
    }
} else {
    $total_day = $item->isin_suresi;
    if ($time_elapsed > $total_day) {
        echo $sozlesme_yuzde = 100;
    } elseif ($time_elapsed < $total_day) {
        echo $sozlesme_yuzde = round($time_elapsed / $total_day * 100);
    }
}
?>

<script>
    var options11 = {
        chart: {
            height: 350,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                dataLabels: {
                    name: {
                        fontSize: '22px',
                    },
                    value: {
                        fontSize: '23px',
                    },
                    total: {
                        show: true,
                        label: '%',
                        formatter: function (w) {
                            return <?php echo round($sozlesme_yuzde); ?>
                        }
                    }
                }
            }
        },
        series: ['<?php echo round($sozlesme_yuzde); ?>'],
        labels: ['<?php echo $item->dosya_no; ?>'],
        colors: ['<?php echo "#" . random_color(); ?>']


    }

    var chart11 = new ApexCharts(
        document.querySelector("#circlechart"),
        options11
    );

    chart11.render();
</script>


<?php if (!empty($costincs)) {
    $top_limit = $item->sozlesme_bedel + sum_anything("costinc", "artis_miktar", "contract_id", "$item->id");
} else {
    $top_limit = $item->sozlesme_bedel;
    ?>

    <?php $sub_limit = 0; ?>
    <?php $amount_payed = sum_anything("payment", "A", "contract_id", "$item->id"); ?>
    <?php if ($amount_payed >= $top_limit) {
        $finance_perc = $amount_payed / $top_limit * 100;
    } elseif ($amount_payed < $top_limit and $amount_payed > $sub_limit) {
        $finance_perc = $amount_payed / $top_limit * 100;
    } elseif ($amount_payed <= $sub_limit) {
        $finance_perc = 0;
    } ?>

    <?php echo "nerede"; ?>
    <script>
        var options11 = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '23px',
                        },
                        total: {
                            show: true,
                            label: '%',
                            formatter: function (w) {
                                return <?php echo round($finance_perc); ?>
                            }
                        }
                    }
                }
            },
            series: ['<?php echo round($finance_perc); ?>'],
            labels: ['<?php echo $item->dosya_no; ?>'],
            colors: ['<?php echo "#" . random_color(); ?>']
        }
        var chart11 = new ApexCharts(
            document.querySelector("#financechart"),
            options11
        );
        chart11.render();
    </script>
<?php } ?>


<?php $contract_price = $item->sozlesme_bedel;
$amount_payed = sum_anything("payment", "E", "contract_id", "$item->id");
$price_perc = round($amount_payed / $contract_price * 100);
if ($price_perc > 100) {
    $price_perc = 100;
}
?>

<?php $total_advance = sum_anything("advance", "avans_miktar", "contract_id", "$item->id"); ?>
<?php if ($total_advance > 0) { ?>
    <?php $advance_payback = sum_anything("payment", "I", "contract_id", "$item->id"); ?>

    <script>
        var options11 = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '23px',
                        },
                        total: {
                            show: true,
                            label: '%',
                            formatter: function (w) {
                                return <?php echo round($advance_payback / $total_advance * 100, 2); ?>
                            }
                        }
                    }
                }
            },
            series: ['<?php echo round($advance_payback / $total_advance * 100, 2); ?>'],
            labels: ['<?php echo round($advance_payback / $total_advance * 100, 2); ?>'],
            colors: ['<?php echo "#" . random_color(); ?>']


        }

        var chart11 = new ApexCharts(
            document.querySelector("#advancechart"),
            options11
        );

        chart11.render();
    </script>
<?php } ?>

<?php
$total_bond = sum_anything("bond", "teminat_miktar", "contract_id", "$item->id"); ?>
<?php if ($total_bond > 0) { ?>
    <?php $total_payback = sum_anything_and("bond", "teminat_miktar", "contract_id", "$item->id", "teminat_durumu", "1");
    ?>

    <script>
        var options11 = {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '23px',
                        },
                        total: {
                            show: true,
                            label: '%',
                            formatter: function (w) {
                                return <?php echo round($total_payback / $total_bond * 100, 2); ?>
                            }
                        }
                    }
                }
            },
            series: ['<?php echo round($total_payback / $total_bond * 100, 2); ?>'],
            labels: ['<?php echo round($total_payback / $total_bond * 100, 2); ?>'],
            colors: ['<?php echo "#" . random_color(); ?>']


        }

        var chart11 = new ApexCharts(
            document.querySelector("#bondchart"),
            options11
        );

        chart11.render();
    </script>

<?php } ?>
<?php
$payments_array = json_encode((array_column($payments, 'E')));
$payments_name_array = json_encode((array_column($payments, 'hakedis_no')));

if (!empty($item->workplan_payment)) {
    $number = json_encode(range(1, count(json_decode($item->workplan_payment))));
    $workplan_payment = $item->workplan_payment;
} else {
    $number = json_encode(range(1, count($payments)));
    $workplan_payment = json_encode(array_fill(0, count(array_column($payments, 'E')), 0));
}
?>

<script>
    var options1 = {
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        series: [{
            name: 'Hakedişler',
            data: <?php echo $payments_array; ?>
        }, {
            name: 'İş Programı',
            data: <?php echo $workplan_payment; ?>
        }],

        xaxis: {
            type: 'text',
            categories:  <?php echo $number; ?>
        },

        colors: ['#0b23c2', '#f73164']
    }

    var chart1 = new ApexCharts(
        document.querySelector("#area-spaline"),
        options1
    );

    chart1.render();
</script>

<?php if (!empty($item->workplan_payment)) {

    $workplan_payments = json_decode($item->workplan_payment);
    $total_workplan = array();
    $runningSum = 0;
    foreach ($workplan_payments as $workplan_payment) {
        $runningSum += $workplan_payment;
        $total_workplan[] = $runningSum;
    }
} else {
    $number = json_encode(range(1, count($payments)));
    $total_workplan = array_fill(0, count(array_column($payments, 'E')), 0);
}

$payments_array = array_column($payments, 'E');

$total_payments = array();
$runningSum_payments = 0;
foreach ($payments_array as $payment) {
    $runningSum_payments += $payment;
    $total_payments[] = $runningSum_payments;
}

$payments_array = json_encode((array_column($payments, 'E')));

?>

<script>
    var options1 = {
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        series: [{
            name: 'Hakedişler',
            data: <?php echo json_encode($total_payments); ?>
        }, {
            name: 'İş Programı',
            data: <?php echo json_encode($total_workplan); ?>
        }],

        xaxis: {
            type: 'text',
            categories:  <?php echo $number; ?>
        },

        colors: ['#0b23c2', '#f73164']
    }

    var chart1 = new ApexCharts(
        document.querySelector("#area-cumulative"),
        options1
    );

    chart1.render();
</script>


<script src="<?php echo base_url("assets"); ?>/js/jquery.repeater.js"></script><!--Form Inputs-->

<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.js"></script><!--Form Inputs-->
<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.en.js"></script><!--Form Inputs-->
<script src="<?php echo base_url("assets"); ?>/js/datepicker/date-picker/datepicker.custom.js"></script><!--Form Inputs-->
<!-- Plugins JS start-->
<script src="<?php echo base_url("assets"); ?>/js/photoswipe/photoswipe.min.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/photoswipe/photoswipe.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/tooltip-init.js"></script>
<!-- Plugins JS Ends-->
<!-- scrollbar js-->
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/simplebar.js"></script>
<script src="<?php echo base_url("assets"); ?>/js/scrollbar/custom.js"></script>

<script src="<?php echo base_url("assets"); ?>/js/xlsx.full.min.js"></script> <!--Excel Olaraa Tablo İndirtme-->

<script src="<?php echo base_url("assets"); ?>/js/editor/ckeditor/ckeditor.js"></script>


<script> function enable() {
        document.getElementById("change").disabled = false;
        var x = document.getElementById("save_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script> function enable_workplan() {
        document.getElementById("wpchange").disabled = false;
        var x = document.getElementById("save_wpbutton");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script> function enable_provision() {
        document.getElementById("prochange").disabled = false;
        var x = document.getElementById("save_probutton");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script> function enable_final() {
        document.getElementById("finalchange").disabled = false;
        var x = document.getElementById("save_finalbutton");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>


<script>
    $(document).ready(function () {
        $('.repeater').repeater({
            // (Required if there is a nested repeater)
            // Specify the configuration of the nested repeaters.
            // Nested configuration follows the same format as the base configuration,
            // supporting options "defaultValues", "show", "hide", etc.
            // Nested repeaters additionally require a "selector" field.
            repeaters: [{
                // (Required)
                // Specify the jQuery selector for this nested repeater
                selector: '.inner-repeater'
            }],
            hide: function (deleteElement) {
                if (confirm('Bu satırı Silmek İstediğinize Emin Misiniz?')) {
                    $(this).slideUp(deleteElement);
                }
            },
        });
    });
</script>

<script>
    function myFunction(btn) {
        // Get the checkbox
        var $data_id = btn.getAttribute('data-id');
        const element = document.getElementById($data_id);

        var $a = (getComputedStyle(element).display);

        if ($a == "block") {
            element.style.display = "none";
            element.style.pageBreakAfter = "";
            btn.innerHTML = "Sayfayı Ayır";
        } else if ($a == "none") {
            element.style.display = "block";
            element.style.pageBreakAfter = "always";
            btn.innerHTML = "Sayfayı Ayırma";
        }
    }

</script>

<script>
    function hideGroup(btn) {
        // Get the checkbox
        var $data_id = btn.getAttribute('data-id');
        const element = document.getElementById($data_id);

        var $a = (getComputedStyle(element).display);

        if ($a == "block") {
            element.style.display = "none";
            element.style.pageBreakAfter = "";
            btn.innerHTML = "Açıklama Ekle";
        } else if ($a == "none") {
            element.style.display = "block";
            element.style.pageBreakAfter = "always";
            btn.innerHTML = "Açıklama Gizle";
        }
    }

</script>

<script>
    function toggle() {
        var spolier = document.getElementById('spoiler');

        if (spolier.style.display == "none") {
            spolier.style.display = "";
            date.innerHTML = "Tarihi Gizle";
        } else {
            spolier.style.display = "none";
            date.innerHTML = "Tarihi Göster";
        }
    }
</script>

<script>
    function changeIcon(anchor) {
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
        })

        var icon = anchor.querySelector("i");
        icon.classList.toggle('fa-star');
        icon.classList.toggle('fa-star-o');
    }
</script>

<script>
    function ConfirmationBoq(btn) {
        var url = btn.getAttribute('url');

        swal({
            title: "Sözleşme Miktar ve Fiyatlarını Kontrol Ediniz",
            text: "Emin Misiniz!",
            icon: "warning",
            buttons: ["Kaydet", "Değişiklikleri Uygulamadan Çık"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Kayıt Yapılmadı", {
                        icon: "success",
                    });
                    window.location.href = url;
                }
            })
    }
</script>


<script>

    function update_group(anchor) {

        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".refresh_group").html(response);
        });
    }
</script>

<script>
    function delete_group(element) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_group/"); ?>' + itemId;

        $.post(formAction, function (response) {
            $(".refresh_group").html(response);

        });
    }
</script>

<script>
    // Checkbox öğesini seçiyoruz
    var checkbox = document.getElementById("toggleCheckbox");

    // Checkbox durumunu takip ediyoruz
    checkbox.addEventListener("change", function () {
        // Tüm input öğelerini seçiyoruz
        var inputElements = document.querySelectorAll("input[type='text']");

        // Checkbox işaretlendiğinde veya kaldırıldığında tüm input öğelerini etkinleştir veya devre dışı bırak
        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].disabled = !checkbox.checked;
        }
    });
</script>


<script>
    // Input alanlarının değişikliklerini dinlemek için event listener ekle
    var inputElements = document.querySelectorAll('input[id$="_qty"], input[id$="_price"]');
    inputElements.forEach(function (input) {
        input.addEventListener("input", function () {
            var id = input.id.split("_")[0]; // ID'den malzeme numarasını al
            calculateTotal(id);
        });

        // Virgülü otomatik olarak noktaya çevir
        input.addEventListener("input", function () {
            var inputValue = input.value;
            // Virgülü noktaya çevir
            input.value = inputValue.replace(/,/g, '.');
        });
    });

    function formatNumberWithSpaces(number) {
        // Sayıyı binlik ayracı olan boşlukla formatla
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    function calculateTotal(materialId) {
        var qtyInput = document.getElementById(materialId + "_qty");
        var priceInput = document.getElementById(materialId + "_price");
        var totalInput = document.getElementById(materialId + "_total");

        // Kullanıcının girdiği değeri alırken virgülü otomatik olarak noktaya çeviriyoruz
        var qtyValue = qtyInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir
        var priceValue = priceInput.value.replace(/ /g, '').replace(',', '.'); // Girilen boşluğu kaldır ve virgülü noktaya çevir

        var qty = parseFloat(qtyValue) || 0; // Miktarı al, eğer geçersizse veya boşsa 0 kabul et
        var price = parseFloat(priceValue) || 0; // Birim fiyatı al, eğer geçersizse veya boşsa 0 kabul et

        var total = qty * price; // Toplam maliyeti hesapla

        totalInput.value = formatNumberWithSpaces(total.toFixed(2)); // Toplam maliyeti binlik ayracı ile formatlı olarak input alanına yaz

        // Tüm "_total" input alanlarının toplamını hesapla
        var totalContract = 0;
        var totalInputs = document.querySelectorAll('input[id$="_total"]');
        totalInputs.forEach(function (input) {
            totalContract += parseFloat(input.value.replace(/ /g, '')) || 0; // Girilen boşluğu kaldır
        });

        // Toplam maliyeti "total_contract" input alanına yaz
        document.getElementById("total_contract").value = formatNumberWithSpaces(totalContract.toFixed(2));
    }
</script>

<script>
    function open_contract_group(anchor) {
        $(".contract_group").show();
        var $url = anchor.getAttribute('url');
        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
            $('#list').DataTable();
        })
    }
</script>

<script>
    function delete_item(anchor) {
        var $url = anchor.getAttribute('url');

        $.post($url, {}, function (response) {
            $(".contract_group").html(response);
        })
    }
</script>
<script>
    function hesaplaT(inputId) {
        // "q-X" ve "p-X" inputlarının id'sinden tüm inputları alın
        var qInput = document.querySelector('input[id="q-' + inputId + '"]');
        var pInput = document.querySelector('input[id="p-' + inputId + '"]');
        var tInput = document.querySelector('input[id="t-' + inputId + '"]');

        if (qInput && pInput && tInput) {
            // q ve p değerlerini alın
            var q = parseFloat(qInput.value) || 0;
            var p = parseFloat(pInput.value) || 0;

            // Çarpma işlemi
            var t = q * p;

            // Sonucu t-X inputuna yazın
            tInput.value = t.toFixed(2);
        }
    }

    function addInputListeners(inputType) {
        // Tüm "inputType-X" inputlarına bir "input" olay dinleyici ekleyin
        var inputs = document.querySelectorAll('input[id^="' + inputType + '-"]');
        inputs.forEach(function (input) {
            var inputId = input.id.split('-')[1];
            input.addEventListener('input', function () {
                hesaplaT(inputId);
            });
        });
    }

    // "q-X" inputlarına olay dinleyicilerini ekle
    addInputListeners("q");

    // "p-X" inputlarına olay dinleyicilerini ekle
    addInputListeners("p");

</script>
<script>
    function update_price(anchor) {
        var $form = anchor.getAttribute('form-id');

        var formAction = $("#" + $form).attr("action"); // Formun action özelliğini alır
        var formData = $("#" + $form).serialize(); // Form verilerini alır ve seri hale getirir

        $.post(formAction, formData, function (response) {
            $(".price_update").html(response);
            hesaplaT();
            activateDragAndDrop();
            addInputListeners("q");
            addInputListeners("p");
        });
    }
</script>
<script>
    function addLeader() {
        $("#add_leader_btn").click(function (e) {
            e.preventDefault();

            var leader_code = $("#leader_code").val();
            var leader_name = $("#leader_name").val();
            var leader_unit = $("#leader_unit").val();
            var leader_price = $("#leader_price").val();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url("contract/add_leader/$item->id"); ?>",
                data: {
                    leader_code: leader_code,
                    leader_name: leader_name,
                    leader_unit: leader_unit,
                    leader_price: leader_price
                },
                success: function (response) {
                    // Sunucudan gelen yanıtı alarak price_update div'ini güncelle
                    $(".price_update").html(response);
                    hesaplaT();
                    activateDragAndDrop();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        hesaplaT();
        activateDragAndDrop();
    }

    // Fonksiyonu çağırarak çalıştırabilirsiniz
    addLeader();
</script>
<script>
    function delete_price_item(element) {
        var itemId = element.id;
        var formAction = '<?php echo base_url("contract/delete_contract_price/"); ?>' + itemId;

        $.post(formAction, function (response) {
            $(".price_update").html(response);
            hesaplaT();
            activateDragAndDrop();
            addInputListeners("q");
            addInputListeners("p");
        })
            .fail(function (error) {
                // Hata durumunda bu fonksiyon çalışır
                console.error('Error:', error.responseText);
                hesaplaT();
                activateDragAndDrop();
                addInputListeners("q");
                addInputListeners("p");
            });
    }
</script>

<script>
    function activateDragAndDrop() {
        // Sürükleyici öğeleri seç
        var dragSources = document.querySelectorAll('#dragSource');
        // Hedef alanları seç
        var dropTargets = document.querySelectorAll('.dropTarget');

        // Her bir sürükleyici öğe için sürükleme başlatma olayını ekle
        dragSources.forEach(function (dragSource) {
            dragSource.addEventListener('dragstart', function (event) {
                // Veri aktarımı sırasında taşınacak veriyi belirt
                event.dataTransfer.setData('text/plain', event.target.dataset.info);
            });
        });

        // Her bir hedef alanı için bırakma olayını ekle
        dropTargets.forEach(function (dropTarget) {
            dropTarget.addEventListener('drop', function (event) {
                // Varsayılan davranışı engelle (örneğin, bağlantıyı açmayı engelle)
                event.preventDefault();
                // Sürüklenen öğenin veri bilgisini al
                var draggedItemData = event.dataTransfer.getData('text/plain');
                // Hedef alanın veri bilgisini al
                var dropTargetData = dropTarget.dataset.info;
                // Alert ile bilgileri ekrana bastır

                var formAction = '<?php echo base_url("contract/drag_drop_price/$item->id/"); ?>' + draggedItemData + "/" + dropTargetData;

                $.post(formAction, function (response) {
                    $(".price_update").html(response);
                    hesaplaT();
                    activateDragAndDrop();
                    addInputListeners("q");
                    addInputListeners("p");
                    activateDragAndDrop();
                });

            });

            // Bırakma olayının varsayılan davranışını engelle
            dropTarget.addEventListener('dragover', function (event) {
                event.preventDefault();
            });
        });
    }

    // Sürükleyici ve bırakma işlevselliğini etkinleştir
    activateDragAndDrop();
</script>

