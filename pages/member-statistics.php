<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistics</title>
  <?php $assetVersion = "20260420s1"; ?>
  <link rel="stylesheet" href="../css/style.css?v=<?php echo $assetVersion; ?>">
</head>
<body class="member-statistics-vintage-page">
  <div class="books-page-shell">
    <div class="books-page-container member-books-vintage-layout">
      <a class="member-books-top-back" href="member-dashboard.php" aria-label="Back to Dashboard">&#8592; Back to Dashboard</a>

      <div class="books-page-header member-books-vintage-header">
        <h1>Statistics</h1>
        <p class="member-books-vintage-quote" id="memberStatisticsQuoteText">There is no friend as loyal as a book.</p>
        <p class="member-books-vintage-author" id="memberStatisticsQuoteAuthor">Ernest Hemingway</p>
      </div>

      <div class="books-page-card">
        <div class="books-page-list-header member-statistics-center-head">
          <h2>Overview</h2>
        </div>

        <div id="statisticsOverview" class="stats-grid member-statistics-overview-grid"></div>
      </div>

      <div class="books-page-card">
        <div class="books-page-list-header member-statistics-center-head">
          <h2>Active Members</h2>
        </div>

        <div id="activeMembersList" class="members-list"></div>
      </div>

      <div class="books-page-card">
        <div class="books-page-list-header member-statistics-center-head">
          <h2>Passive Members</h2>
        </div>

        <div id="passiveMembersList" class="members-list"></div>
      </div>
    </div>
  </div>

  <script src="../js/quotes.js?v=<?php echo $assetVersion; ?>"></script>
  <script src="../js/member-statistic.js?v=<?php echo $assetVersion; ?>"></script>
</body>
</html>
