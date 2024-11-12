<?php
// Start a session to keep track of the game state
session_start();

// Start a new game or reset
if (!isset($_SESSION['turn']) || isset($_POST['new_game'])) {
    $_SESSION['turn'] = 1;
    $_SESSION['score'] = 0;
    $_SESSION['message'] = "The Sigma Game begins! Dodge the Skibidi Toilets!";
}

// Game logic after player moves
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['move'])) {
    // Player's move: 'left' or 'right'
    $playerMove = $_POST['move'];
    
    // Randomly decide the Skibidi's move
    $skibidiMove = (rand(0, 1) == 0) ? 'left' : 'right';

    // Check if the player dodged the Skibidi toilet
    if ($playerMove != $skibidiMove) {
        $_SESSION['score']++;
        $_SESSION['message'] = "Turn {$_SESSION['turn']}: You dodged the Skibidi toilet! Score: {$_SESSION['score']}";
    } else {
        $_SESSION['message'] = "Turn {$_SESSION['turn']}: Skibidi got you! Game Over. Final Score: {$_SESSION['score']}";
        $_SESSION['turn'] = null; // End game
    }
    
    $_SESSION['turn']++;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Skibidi Sigma Dodge Game</title>
</head>
<body>
    <h1>Skibidi Sigma Dodge Game</h1>
    <p><?php echo $_SESSION['message']; ?></p>

    <!-- Display move options if the game is still running -->
    <?php if (isset($_SESSION['turn'])): ?>
        <form method="POST" action="">
            <button type="submit" name="move" value="left">Dodge Left</button>
            <button type="submit" name="move" value="right">Dodge Right</button>
        </form>
    <?php endif; ?>

    <!-- Button to start a new game -->
    <form method="POST" action="">
        <button type="submit" name="new_game">Start New Game</button>
    </form>
</body>
</html>
