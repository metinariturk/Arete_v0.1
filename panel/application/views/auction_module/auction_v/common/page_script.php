<script>
    $(document).ready(function() {

        // enable fileuploader plugin
        $('input[name="files"]').fileuploader({
            changeInput: '<div class="fileuploader-input">' +
                '<div class="fileuploader-input-inner">' +
                '<div class="fileuploader-icon-main"></div>' +
                '<h3 class="fileuploader-input-caption"><span>${captions.feedback}</span></h3>' +
                '<p>${captions.or}</p>' +
                '<button type="button" class="fileuploader-input-button"><span>${captions.button}</span></button>' +
                '</div>' +
                '</div>',
            theme: 'dragdrop',
            upload: {
                url: "<?php echo base_url("$this->Module_Name/file_upload/$item->id/Main"); ?>",
                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                beforeSend: null,
                onSuccess: function(result, item) {
                    var data = {};

                    // get data
                    if (result && result.files)
                        data = result;
                    else
                        data.hasWarnings = true;

                    // if success
                    if (data.isSuccess && data.files[0]) {
                        item.name = data.files[0].name;
                        item.html.find('.column-title > div:first-child').text(data.files[0].name).attr('title', data.files[0].name);
                    }

                    // if warnings
                    if (data.hasWarnings) {
                        for (var warning in data.warnings) {
                            alert(data.warnings[warning]);
                        }

                        item.html.removeClass('upload-successful').addClass('upload-failed');
                        // go out from success function by calling onError function
                        // in this case we have a animation there
                        // you can also response in PHP with 404
                        return this.onError ? this.onError(item) : null;
                    }

                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                    setTimeout(function() {
                        item.html.find('.progress-bar2').fadeOut(400);
                    }, 400);
                },
                onError: function(item) {
                    var progressBar = item.html.find('.progress-bar2');

                    if(progressBar.length) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<button type="button" class="fileuploader-action fileuploader-action-retry" title="Retry"><i class="fileuploader-icon-retry"></i></button>'
                    ) : null;
                },
                onProgress: function(data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    if(progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: null,
            },
            onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
                // AJAX isteği ile dosyanın sunucudan silinmesi
                $.ajax({
                    url: "<?php echo base_url("auction/filedelete_java/$item->id/"); ?>", // Silme işlemini gerçekleştirecek endpoint
                    type: 'POST',
                    data: {
                        fileName: item.name // Dosyanın adı
                    },
                    success: function(response) {
                        if (response.success) {
                            // Sunucu silme işlemini başarıyla tamamladı
                            console.log('Dosya başarıyla silindi:', item.name);
                        } else {
                            // Sunucu bir hata mesajı döndürdü
                            console.error(item.id, response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // AJAX isteği başarısız oldu
                        console.error('Bir hata oluştu:', error);
                    }
                });

                // Dosyanın listeden hemen kaldırılmasını önlemek için false döndürün
                return true;
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['en'], {
                feedback: 'Drag and drop files here',
                feedback2: 'Drag and drop files here',
                drop: 'Drag and drop files here',
                or: 'or',
                button: 'Browse files',
            }),
        });

    });
</script>
<script>
    $(document).ready(function() {
        // FileUploader eklentisini etkinleştir
        $('input[name="files"]').fileuploader({
            addMore: true,
            onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
                // AJAX isteği ile dosyanın sunucudan silinmesi
                $.ajax({
                    url: "<?php echo base_url("auction/filedelete_java/$item->id/"); ?>", // Silme işlemini gerçekleştirecek endpoint
                    type: 'POST',
                    data: {
                        fileName: item.name // Dosyanın adı
                    },
                    success: function(response) {
                        if (response.success) {
                            // Sunucu silme işlemini başarıyla tamamladı
                            console.log('Dosya başarıyla silindi:', item.name);
                        } else {
                            // Sunucu bir hata mesajı döndürdü
                            console.error(item.id, response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // AJAX isteği başarısız oldu
                        console.error('Bir hata oluştu:', error);
                    }
                });

                // Dosyanın listeden hemen kaldırılmasını önlemek için false döndürün
                return true;
            },
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#cost').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: 'Kopyala',
                    className: "btn-primary",
                    title: '<?php echo "Yaklaşık Maliyet" . "-" . $item->ihale_ad; ?>'
                },
                {
                    extend: 'excelHtml5',
                    title: '<?php echo "Yaklaşık Maliyet" . "-" . $item->ihale_ad; ?>'
                },
                {
                    extend: 'pdfHtml5',
                    title: '<?php echo "Yaklaşık Maliyet" . "-" . $item->ihale_ad; ?>'
                }
            ]
        });
    });
</script>

<script src="<?php echo base_url("assets"); ?>/js/chart/apex-chart/apex-chart.js"></script>

<?php if (!empty($teklifler->offer)) { ?>
    <?php $teklifler = json_decode($teklifler->offer, true); ?>
    <?php if (isset($teklifler)) { ?>
        <?php $turn_count = count($teklifler);
        $label = array();
        $i = 1;
        foreach ($teklifler as $teklif) {
            $label[] = $i++ . " .Tur";
        }
        $labels = json_encode($label);
        ?>
    <?php } ?>

        <?php $min_values = json_encode(array_fill(0,$i-1,$item->min_cost)); ?>
        <?php $max_values = json_encode(array_fill(0,$i-1,$item->max_cost)); ?>

    <script>
        // annotation chart
        var options6 = {
            annotations: {
                yaxis: [{
                    y: <?php echo sum_anything("cost", "cost", "auction_id", $item->id); ?>,
                    borderColor: '#e01515',
                    label: {
                        borderColor: '#e01515',
                        style: {
                            color: '#fff',
                            background: '#e01515',
                        },
                        text: 'Yaklaşık Maliyet <?php echo money_format(sum_anything("cost", "cost", "auction_id", $item->id)) . get_currency_auc($item->id); ?>',
                    }
                }, {
                    y: <?php echo $item->min_cost; ?>,
                    y2: <?php echo $item->max_cost; ?>,
                    borderColor: '#000',
                    fillColor: 'rgba(29,69,238,0.21)',
                    opacity: 0.2,
                    label: {
                        borderColor: '#333',
                        style: {
                            fontSize: '10px',
                            color: '#333',
                            background: '#FEB019',
                        },
                        text: 'Aşırı Yüksek',
                    }
                }],


            },
            chart: {
                height: 350,
                type: 'line',
                id: 'areachart-2',
                toolbar: {
                    show: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                padding: {
                    right: 30,
                    left: 20
                }
            },

            series:
                [
                    <?php if (!empty($item->max_cost)){
                    echo "{name: 'Aşırı Yüksek', data : $max_values},";
                } ?>
                    <?php foreach ($teklifler as $teklif) {
                    $istekliler = array_keys($teklif);
                } ?>
                    <?php foreach ($istekliler as $istekli) { ?>
                    <?php $data = array(); ?><?php $offers = array(); ?>
                    <?php foreach ($teklifler as $teklif) { ?>
                    <?php $offers[] = $teklif[$istekli]; ?>
                    <?php } ?>
                    <?php $json_datas = array($istekli => $offers); ?>
                    <?php foreach ($json_datas as $json_data => $bids) { ?>
                    <?php echo '{name: "'; ?><?php echo company_name($json_data) ?><?php echo '", data : '; ?><?php echo json_encode($bids); ?><?php echo '},'; ?>
                    <?php } ?>
                    <?php } ?>
                    <?php if (!empty($item->min_cost)){
                       echo "{name: 'Aşırı Düşük', data : $min_values},";
                    } ?>
                ],


            title: {
                text: '',
                align: 'left'
            },
            labels: <?php echo $labels; ?>,
            xaxis: {
                type: 'string',
            },
            colors: [
                <?php if (!empty($item->max_cost)){ ?>
                'rgba(243,2,2,0.36)',
                <?php } ?>
                <?php foreach ($istekliler as $color) { ?>
                '<?php echo "#" . random_color(); ?>',
                <?php } ?>
                <?php if (!empty($item->min_cost)){ ?>
                'rgba(33,255,0,0.3)',
                <?php } ?>
            ]
        }

        var chart6 = new ApexCharts(
            document.querySelector("#annotationchart"),
            options6
        );

        chart6.render();


    </script>
<?php } ?>
<script>


    <?php if (!empty($ymler)) {
        $groups = array_unique(array_column($ymler, 'ym_grup'));
        $title = array();
        $value = array();
        foreach ($groups as $group) {
            $title[] = $group;
            $value[] = ceil(sum_anything_and("cost", "cost", "ym_grup", "$group", "auction_id", "$item->id"));
        }
    } ?>

    // pie chart
    var options8 = {
        chart: {
            width: 500,
            type: 'pie',
            fontSize: 50,
        },
        labels: <?php echo json_encode($title); ?>,
        series: <?php echo json_encode($value); ?>,
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '14px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
                colors: ['#000000']
            }
        },
        dataSeries: {
            enabled: true,
            style: {
                fontSize: '30px',
                fontFamily: "Helvetica, Arial, sans-serif",
                fontWeight: "bold"
            }
        },
        legend: {

            fontSize: '16px',
            fontFamily: 'Helvetica, Arial, sans-serif',
            fontWeight: 400,

        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    fontSize: '50px',
                    position: 'bottom'
                }
            }
        }],
        colors: [CubaAdminConfig.primary, CubaAdminConfig.secondary, '#51bb25', '#a927f9', '#f8d62b']
    }

    var chart8 = new ApexCharts(
        document.querySelector("#yaklasik"),
        options8
    );

    chart8.render();

</script>

<script>
    var e = document.getElementById("bidder");

    function onChange() {
        var value = e.value;

        $.post(value, {}, function (response) {
            $(".bidder_list_container").html(response);
        })
    }

    e.onchange = onChange;

    $(document).ready(function () {
        $("form").submit(function (event) {
            $.ajax({
                type: 'post',
                dataType: "json",
                success: function (response) {
                    $("#bidder_list_container").html(response.message);
                }
            });
            alert(message);
            event.preventDefault();
        });
    });

    function deleteConfirmationCompany(btn) {
        var $url = btn.getAttribute('url');

        swal({
            title: "İstekliyi Silmek İstediğine Emin Misin?",
            text: "Bu işlem geri alınamaz!",
            icon: "warning",
            buttons: ["İptal", "Sil"],
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    $.post($url, {}, function (response) {
                        $(".bidder_list_container").html(response);
                    })

                    swal("İstekli Başarılı Bir Şekilde Silindi", {
                        icon: "success",
                    });

                } else {
                    swal("İşlem Geri Alındı");
                }
            })
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
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
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
    function save_min(btn) {
        var x = document.getElementById("min_cost").value;

        var url = btn.getAttribute('url');
        var $post = url+"/"+x

        $.post($post, {}, function (response) {
        })

        var a = document.getElementById("min_cost");
        if (a.disabled === false) {
            a.disabled = true;
        } else {
            a.disabled = true;
        }

        var x = document.getElementById("save_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }
</script>

<script>
    function save_max(btn) {
        var x = document.getElementById("max_cost").value;

        var url = btn.getAttribute('url');
        var $post = url+"/"+x

        $.post($post, {}, function (response) {
        })

        var a = document.getElementById("max_cost");
        if (a.disabled === false) {
            a.disabled = true;
        } else {
            a.disabled = true;
        }

        var x = document.getElementById("save_max_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }
</script>

<script> function enable_min() {
        document.getElementById("min_cost").disabled = false;

        var x = document.getElementById("save_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script> function enable_max() {
        document.getElementById("max_cost").disabled = false;

        var x = document.getElementById("save_max_button");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script>
    function OfferToExcel(type, fn, dl) {
        var elt = document.getElementById('offer_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "sheet1"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->ihale_ad; ?> Teklifler.' + (type || 'xlsx')));
    }
</script>

<script>
    function QualifyToExcel(type, fn, dl) {
        var elt = document.getElementById('qualify_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Ön Yeterlilik"});
        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->ihale_ad; ?> Yeterlilik.' + (type || 'xlsx')));
    }
</script>

<script>

    function CostToExcel(type, fn, dl) {
        var elt = document.getElementById('cost_table');
        var wb = XLSX.utils.table_to_book(elt, {sheet: "Sayfa1"});

        return dl ?
            XLSX.write(wb, {bookType: type, bookSST: true, type: 'base64'}) :
            XLSX.writeFile(wb, fn || ('<?php echo $item->ihale_ad; ?> Maliyet.' + (type || 'xlsx')));
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


