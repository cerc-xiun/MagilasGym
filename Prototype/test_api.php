<?php
$url = "https://cercxiun.site/API_folder/api.php"; // VPS API endpoint

$response = file_get_contents($url);

if ($response === FALSE) {
    die("Error calling API");
}

$data = json_decode($response, true);

// Pretty-print results
foreach ($data as $row) {
    echo "ID: {$row['id']} | Message: {$row['message']} | Created: {$row['created_at']}\n";
}
?>