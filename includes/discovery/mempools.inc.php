<?php

echo 'Memory : ';

// Include all discovery modules
$include_dir = 'includes/discovery/mempools';
require 'includes/include-dir.inc.php';

// Remove memory pools which weren't redetected here
$sql = "SELECT * FROM `mempools` WHERE `device_id`  = '".$device['device_id']."'";

if ($debug) {
    print_r($valid_mempool);
}

foreach (dbFetchRows($sql) as $test_mempool) {
    $mempool_index = $test_mempool['mempool_index'];
    $mempool_type  = $test_mempool['mempool_type'];
    if ($debug) {
        echo $mempool_index.' -> '.$mempool_type."\n";
    }

    if (!$valid_mempool[$mempool_type][$mempool_index]) {
        echo '-';
        dbDelete('mempools', '`mempool_id` = ?', array($test_mempool['mempool_id']));
    }

    unset($mempool_oid);
    unset($mempool_type);
}

unset($valid_mempool);
echo "\n";
