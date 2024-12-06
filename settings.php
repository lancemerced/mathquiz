<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['difficulty_level'] = $_POST['difficulty_level'];
    $_SESSION['math_operator'] = $_POST['math_operator'];
    $_SESSION['total_questions'] = $_POST['total_questions'];
    if ($_SESSION['difficulty_level'] === 'custom') {
        $_SESSION['custom_min_value'] = $_POST['custom_min_value'];
        $_SESSION['custom_max_value'] = $_POST['custom_max_value'];
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="settings-container">
        <h1>Quiz Settings</h1>
        <form method="post">
            <label>Select Difficulty:</label>
            <input type="radio" name="difficulty_level" value="1" required> Level 1 (1-10)<br>
            <input type="radio" name="difficulty_level" value="2"> Level 2 (11-100)<br>
            <input type="radio" name="difficulty_level" value="custom"> Custom Level (Enter Range)<br>
            <div id="custom-range">
                <label>Min:</label>
                <input type="number" name="custom_min_value" min="1">
                <label>Max:</label>
                <input type="number" name="custom_max_value" min="1">
            </div>
            <br>
            <label>Select Operator:</label>
            <input type="radio" name="math_operator" value="addition" required> Addition<br>
            <input type="radio" name="math_operator" value="subtraction"> Subtraction<br>
            <input type="radio" name="math_operator" value="multiplication"> Multiplication<br>
            <br>
            <label>Number of Questions:</label>
            <input type="number" name="total_questions" min="1" max="50" value="10" required>
            <br>
            <button type="submit" class="start-btn">Start Quiz</button>
        </form>
    </div>
    <script>
        document.querySelectorAll('input[name="difficulty_level"]').forEach((input) => {
            input.addEventListener('change', function () {
                document.getElementById('custom-range').style.display =
                    this.value === 'custom' ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
