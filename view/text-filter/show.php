<h2>Source in txt</h2>
<pre><?= wordwrap(htmlentities($text)) ?></pre>

<h2>Source formatted as HTML</h2>
<?= $text ?>

<h2>Filter applied, source</h2>
<pre><?= wordwrap(htmlentities($html)) ?></pre>

<h2>Filter applied, HTML</h2>
<?= $html ?>
