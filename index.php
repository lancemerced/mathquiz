<?php
session_start();

if (!isset($_SESSION['difficulty_level'], $_SESSION['math_operator'], $_SESSION['total_questions'])) {
    header("Location: settings.php");
    exit;
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
    $_SESSION['wrong_answers'] = 0;
    $_SESSION['question_count'] = 0;
}

function generateQuestion($difficulty_level, $math_operator, $custom_min_value = null, $custom_max_value = null) {
    if ($difficulty_level === 'custom') {
        $min = $custom_min_value;
        $max = $custom_max_value;
    } else {
        $min = $difficulty_level == 1 ? 1 : 11;
        $max = $difficulty_level == 1 ? 10 : 100;
    }
    $num1 = rand($min, $max);
    $num2 = rand($min, $max);

    switch ($math_operator) {
        case 'addition':
            return ["$num1 + $num2", $num1 + $num2];
        case 'subtraction':
            return ["$num1 - $num2", $num1 - $num2];
        case 'multiplication':
            return ["$num1 * $num2", $num1 * $num2];
    }
}

function generateChoices($correct_answer, $min, $max) {
    $choices = [$correct_answer];
    while (count($choices) < 4) {
        $fake = rand($min, $max);
        if (!in_array($fake, $choices)) {
            $choices[] = $fake;
        }
    }
    shuffle($choices);
    return $choices;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['answer'] == $_SESSION['current_question'][1]) {
        $_SESSION['score']++;
    } else {
        $_SESSION['wrong_answers']++;
    }
    $_SESSION['question_count']++;
    if ($_SESSION['question_count'] >= $_SESSION['total_questions']) {
        header("Location: result.php");
        exit;
    }
}

list($question, $answer) = generateQuestion(
    $_SESSION['difficulty_level'],
    $_SESSION['math_operator'],
    $_SESSION['custom_min_value'] ?? null,
    $_SESSION['custom_max_value'] ?? null
);

$choices = generateChoices($answer, 1, 100);
$_SESSION['current_question'] = [$question, $answer];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="quiz-container">
        <h1>Math Quiz</h1>
        <p>Question <?= $_SESSION['question_count'] + 1; ?>/<?= $_SESSION['total_questions']; ?></p>
        <p><?= $_SESSION['current_question'][0]; ?> = ?</p>
        <form method="post">
            <?php foreach ($choices as $choice): ?>
                <label>
                    <input type="radio" name="answer" value="<?= $choice; ?>" required>
                    <?= $choice; ?>
                </label>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
</body>
</html>
