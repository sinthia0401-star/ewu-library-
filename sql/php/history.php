<?php
require __DIR__ . '/db.php';
$member_id = (int)($_GET['member_id'] ?? 0);
if (!$member_id) { die('Member not specified'); }

$m = oci_parse($conn, 'SELECT full_name FROM member WHERE member_id = :mid');
oci_bind_by_name($m, ':mid', $member_id);
oci_execute($m);
$member = oci_fetch_array($m, OCI_ASSOC);
if (!$member) { die('Member not found'); }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Borrow History</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Borrow history for <?php echo htmlspecialchars($member['FULL_NAME']); ?> (ID <?php echo $member_id; ?>)</h2>

<table>
  <tr>
    <th>Title</th>
    <th>Borrowed</th>
    <th>Due</th>
    <th>Returned</th>
    <th>Action</th>
  </tr>
<?php
$sql = "SELECT t.txn_id, b.title, t.borrowed_on, t.due_on, t.returned_on
        FROM borrow_txn t
        JOIN book b ON b.book_id = t.book_id
        WHERE t.member_id = :mid
        ORDER BY t.borrowed_on DESC";
$st = oci_parse($conn, $sql);
oci_bind_by_name($st, ':mid', $member_id);
oci_execute($st);

while ($row = oci_fetch_array($st, OCI_ASSOC)) {
  echo '<tr>';
  echo '<td>'.htmlspecialchars($row['TITLE']).'</td>';
  echo '<td>'.htmlspecialchars(date('Y-m-d', strtotime($row['BORROWED_ON']))).'</td>';
  echo '<td>'.htmlspecialchars(date('Y-m-d', strtotime($row['DUE_ON']))).'</td>';
  echo '<td>'.($row['RETURNED_ON'] ? htmlspecialchars(date('Y-m-d', strtotime($row['RETURNED_ON']))) : '').'</td>';
  echo '<td>';
  if (!$row['RETURNED_ON']) {
    echo '<form action="return.php" method="post" class="inline">
            <input type="hidden" name="txn_id" value="'.(int)$row['TXN_ID'].'">
            <button type="submit">Return</button>
          </form>';
  }
  echo '</td>';
  echo '</tr>';
}
?>
</table>

<p><a href="index.php">Home</a></p>
</body>
</html>
