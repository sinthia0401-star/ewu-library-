<?php
require __DIR__ . '/db.php';

$book_id   = (int)($_POST['book_id'] ?? 0);
$member_id = (int)($_POST['member_id'] ?? 0);
if (!$book_id || !$member_id) { die('Missing data'); }

$pl = oci_parse($conn, 'BEGIN borrow_book(:m, :b); END;');
oci_bind_by_name($pl, ':m', $member_id);
oci_bind_by_name($pl, ':b', $book_id);

$ok = @oci_execute($pl);
if (!$ok) {
  $e = oci_error($pl);
  die('Borrow failed: ' . htmlentities($e['message']));
}
header('Location: history.php?member_id=' . $member_id);
exit;
