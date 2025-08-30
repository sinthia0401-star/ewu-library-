<?php
require __DIR__ . '/db.php';
$q = trim($_GET['q'] ?? '');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search Results</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h2>Results for "<?php echo htmlspecialchars($q); ?>"</h2>

<table>
  <tr>
    <th>Title</th>
    <th>Authors</th>
    <th>ISBN</th>
    <th>Available</th>
    <th>Borrow</th>
  </tr>
<?php
$sql = "SELECT book_id, title, authors, isbn, available_copies
        FROM vw_book_with_authors
        WHERE :q IS NULL
           OR title   LIKE '%' || :q || '%'
           OR authors LIKE '%' || :q || '%'
        ORDER BY title";
$stid = oci_parse($conn, $sql);
$qbind = ($q === '') ? null : $q;
oci_bind_by_name($stid, ':q', $qbind);
oci_execute($stid);

while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
  echo '<tr>';
  echo '<td>'.htmlspecialchars($row['TITLE']).'</td>';
  echo '<td>'.htmlspecialchars($row['AUTHORS']).'</td>';
  echo '<td>'.htmlspecialchars($row['ISBN']).'</td>';
  echo '<td>'.(int)$row['AVAILABLE_COPIES'].'</td>';
  echo '<td>';
  if ((int)$row['AVAILABLE_COPIES'] > 0) {
    echo '<form action="borrow.php" method="post" class="inline">
            <input type="hidden" name="book_id" value="'.(int)$row['BOOK_ID'].'">
            <input type="number" name="member_id" placeholder="Member ID" required>
            <button type="submit">Borrow</button>
          </form>';
  } else {
    echo 'Not available';
  }
  echo '</td>';
  echo '</tr>';
}
?>
</table>

<p><a href="index.php">Back</a></p>
</body>
</html>
