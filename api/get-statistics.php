<?php
header('Content-Type: application/json');

function readJsonFile($path) {
    if (!file_exists($path)) {
        return [];
    }

    $content = file_get_contents($path);
    $data = json_decode($content, true);

    return is_array($data) ? $data : [];
}

$users = readJsonFile("../data/users.json");
$loans = readJsonFile("../data/loans.json");
$books = readJsonFile("../data/books.json");
$ratings = readJsonFile("../data/ratings.json");

$members = [];
foreach ($users as $user) {
    if (($user['role'] ?? '') === 'member') {
        $members[] = $user;
    }
}

$totalMembers = count($members);
$totalBooks = count($books);

$bookMap = [];
foreach ($books as $book) {
    $bookMap[$book['id']] = $book;
}

$activeMembers = [];
$passiveMembers = [];
$borrowedBooks = 0;
$availableBooks = 0;
$bookBorrowCount = [];
$bookRatingCount = [];
$genreBorrowCount = [];

foreach ($books as $book) {
    if (!empty($book['available'])) {
        $availableBooks++;
    }
}

foreach ($members as $user) {
    $activeBorrowedCount = 0;

    foreach ($loans as $loan) {
        if ((int) ($loan['userId'] ?? 0) !== (int) ($user['id'] ?? 0)) {
            continue;
        }

        $bookId = (int) ($loan['bookId'] ?? 0);

        if (!isset($bookBorrowCount[$bookId])) {
            $bookBorrowCount[$bookId] = 0;
        }
        $bookBorrowCount[$bookId]++;

        $genre = $bookMap[$bookId]['genre'] ?? 'Unknown';
        if (!isset($genreBorrowCount[$genre])) {
            $genreBorrowCount[$genre] = 0;
        }
        $genreBorrowCount[$genre]++;

        if (empty($loan['returned'])) {
            $activeBorrowedCount++;
        }
    }

    $memberData = [
        "id" => $user['id'] ?? 0,
        "libraryId" => $user['libraryId'] ?? '',
        "name" => $user['name'] ?? '',
        "surname" => $user['surname'] ?? '',
        "email" => $user['email'] ?? '',
        "username" => $user['username'] ?? '',
        "activeBorrowedCount" => $activeBorrowedCount
    ];

    if ($activeBorrowedCount > 0) {
        $activeMembers[] = $memberData;
    } else {
        $passiveMembers[] = $memberData;
    }
}

foreach ($loans as $loan) {
    if (empty($loan['returned'])) {
        $borrowedBooks++;
    }
}

$mostRatedBook = "None";
$mostRatedBookCount = 0;

foreach ($ratings as $rating) {
    $bookId = (int) ($rating['bookId'] ?? 0);
    if ($bookId <= 0) {
        continue;
    }

    if (!isset($bookRatingCount[$bookId])) {
        $bookRatingCount[$bookId] = 0;
    }
    $bookRatingCount[$bookId]++;
}

foreach ($bookRatingCount as $bookId => $count) {
    if ($count > $mostRatedBookCount) {
        $mostRatedBookCount = $count;
        $mostRatedBook = $bookMap[$bookId]['name'] ?? 'Unknown Book';
    }
}

$mostBorrowedBook = "None";
$mostBorrowedBookCount = 0;

foreach ($bookBorrowCount as $bookId => $count) {
    if ($count > $mostBorrowedBookCount) {
        $mostBorrowedBookCount = $count;
        $mostBorrowedBook = $bookMap[$bookId]['name'] ?? 'Unknown Book';
    }
}

$mostBorrowedGenre = "None";
$mostBorrowedGenreCount = 0;

foreach ($genreBorrowCount as $genre => $count) {
    if ($count > $mostBorrowedGenreCount) {
        $mostBorrowedGenreCount = $count;
        $mostBorrowedGenre = $genre;
    }
}

echo json_encode([
    "totalMembers" => $totalMembers,
    "totalBooks" => $totalBooks,
    "borrowedBooks" => $borrowedBooks,
    "availableBooks" => $availableBooks,
    "mostBorrowedBook" => $mostBorrowedBook,
    "mostRatedBook" => $mostRatedBook,
    "mostBorrowedGenre" => $mostBorrowedGenre,
    "activeMembers" => $activeMembers,
    "passiveMembers" => $passiveMembers
]);
?>
