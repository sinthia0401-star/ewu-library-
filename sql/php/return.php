<?php
require __DIR__ . '/db.php';
$txn_id = (int)($_POST['txn_id'] ?? 0);
if (!$txn_id) { die('Missing transaction'); }

$pl = oci_parse($conn, 'BEGIN return_book(:t); END;');
oci_bind_by_name($pl, ':t', $txn_id);

$ok = @oci_execute($pl);
if (!$ok) {
  $e = oci_error($pl);
  die('Return failed: ' . htmlentities($e['message']));
}

echo 'Return recorded. <a href="index.php">Home</a>';
