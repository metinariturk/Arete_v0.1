<?php
$projects = all_projects();
$project_type_name_id = array();
foreach ($projects as $project) {
    $project_type_name_id[] = $project->id . " - " . $project->proje_ad . " - Proje";
}

$contracts = all_contracts();
$contract_type_name_id = array();
foreach ($contracts as $contract) {
    $contract_type_name_id[] = $contract->id . " - " . $contract->sozlesme_ad . " - Sözleşme";
}

$subcontracts = all_contracts();
$subcontract_type_name_id = array();
foreach ($subcontracts as $subcontract) {
    $subcontract_type_name_id[] = $subcontract->id . " - " . $subcontract->sozlesme_ad . " - Alt Sözleşme";
}

$sites = all_sites();
$site_type_name_id = array();
foreach ($sites as $site) {
    $site_type_name_id[] = $site->id . " - " . $site->santiye_ad . " - Şantiye";
}

$auctions = all_auctions();
$auction_type_name_id = array();
foreach ($auctions as $auction) {
    $auction_type_name_id[] = $auction->id . " - " . $auction->ihale_ad . " - Teklif";
}

$all_data = array_merge($project_type_name_id, $contract_type_name_id, $subcontract_type_name_id, $site_type_name_id, $auction_type_name_id);

?>


<script>
    $(document).ready(function(){
    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });

            cb(matches);
        };
    };

    var states = <?php echo json_encode($all_data); ?>;

    $('#the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: substringMatcher(states)
        });
    });
</script>