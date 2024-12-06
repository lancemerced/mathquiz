<?php
session_start();

if (!isset($_SESSION['score'], $_SESSION['wrong_answers'])) {
    header("Location: settings.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    header("Location: settings.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="result-container">
        <h1>Quiz Results</h1>
        <p>Total Questions: <?= $_SESSION['total_questions']; ?></p>
        <p>Correct Answers: <?= $_SESSION['score']; ?></p>
        <p>Wrong Answers: <?= $_SESSION['wrong_answers']; ?></p>
        <table>
            <tr>
                <th>Correct</th>
                <th>Wrong</th>
                <th>Accuracy</th>
            </tr>
            <tr>
                <td><?= $_SESSION['score']; ?></td>
                <td><?= $_SESSION['wrong_answers']; ?></td>
                <td><?= round(($_SESSION['score'] / $_SESSION['total_questions']) * 100, 2); ?>%</td>
            </tr>
        </table>
        <form method="post">
            <button type="submit" class="restart-btn">Restart Quiz</button>
        </form>
    </div>
</body>
</html>
