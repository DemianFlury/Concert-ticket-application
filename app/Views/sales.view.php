<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht</title>
</head>
<body>
    <?php foreach($allsales as $sale) : ?>
        <?= $sale ?><br>
    <?php endforeach; ?>
</body>
</html>