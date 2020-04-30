<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<h1>Tärningar</h1>

<p>
    <?= $histogram ?><br>
</p>

<p>
    <?php foreach ($players as $key => $player) : ?>
        <?= $key ?>: <?= $player ?><br>
    <?php endforeach ?>
</p>

<p>Points: <?= $tempP ?></p>

<p>
    <?php foreach ($values as $key => $val) : ?>
        <?= $val ?>
    <?php endforeach ?>
</p>

<?php if ($winner) : ?>
    <?= $winner ?> is the winner!
<?php endif; ?>

<form method="post">
    <?php if (!$winner) : ?>
        <?php if (!$one) : ?>
            <input type="submit" name="rollDice" value="Kasta tärningarna"><br>
            <input type="submit" name="save" value="Spara"><br>
        <?php endif; ?>
        <?php if ($one) : ?>
            <input type="submit" name="computer" value="Computers turn"><br>
        <?php endif; ?>
    <?php endif; ?>
    <input type="submit" name="reset" value="Reset">
</form>

<!-- <pre>
<?= var_dump($_POST) ?> -->
