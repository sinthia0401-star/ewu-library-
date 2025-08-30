<?php require __DIR__ . '/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>EWU Library</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Library of East West University</h1>

  <form action="search.php" method="get" class="card">
    <label>Search by title or author</label>
    <input type="text" name="q" placeholder="e.g., Algorithms" required>
    <button type="submit">Search</button>
  </form>

  <div class="card">
    <h3>Member tools</h3>
    <form action="history.php" method="get" class="inline">
      <input type="number" name="member_id" placeholder="Member ID" required>
      <button type="submit">View Borrow History</button>
    </form>
  </div>
</body>
</html>
