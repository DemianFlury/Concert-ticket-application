<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht</title>
    <style>
        td {
            border: black solid 1px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>Name des Kunden</td>
            <td>E-Mail Adresse</td>
            <td>Telefonnummer</td>
            <td>Treuebonus</td>
            <td>Konzert / Künstler</td>
            <td>Ablauf der Zahlung</td>
            <td>Bezahlt</td>
        </tr>
        <?php foreach ($allsales as $sale) : ?>
            <tr>
                <td> <?= $sale['customerName']; ?> </td>
                <td> <?= $sale['email']; ?> </td>
                <td> <?= $sale['phone']; ?> </td>
                <td> <?= $sale['loyaltybonus']; ?> </td>
                <td> <?= $sale['Artist']; ?> </td>
                <td> <?= $sale['paydate']; ?> </td>
                <td> <?= $sale['paid'] ?> </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>