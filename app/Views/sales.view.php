<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Übersicht</title>
    <style>
        div{
            font-size: 20px;
        }
        td {
            border: grey solid 2px;
            font-size: 20px;
            padding: 5px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <h1>Übersicht</h1>
    <div>
        <a href="new">neuer eintrag</a>
        <a href="notpayed">offene Rechnungen</a>
    </div>
    <table>
        <tr>
            <td>Name des Kunden</td>
            <td>E-Mail Adresse</td>
            <td>Telefonnummer</td>
            <td>Treuebonus</td>
            <td>Konzert / Künstler</td>
            <td>Ablauf der Zahlung (yyyy-mm-dd) </td>
            <td>Bezahlt</td>
            <td>Ticket-ID</td>

        </tr>
        <?php foreach ($allsales as $sale) : ?>
            <tr>
                <?php if($sale['Paid'] === null) $sale['Paid'] = 0; ?>
                <td> <?= $sale['CustomerName']; ?> </td>
                <td> <?= $sale['Email']; ?> </td>
                <td> <?= $sale['Phone']; ?> </td>
                <td> <?= $sale['loyaltybonus']; ?> </td>
                <td> <?= $sale['Artist']; ?> </td>
                <td> <?= $sale['Paydate']; ?> </td>
                <td> <?= $sale['Paid'] ?> </td>
                <td> <?= $sale['TicketID'] ?> </td>
                <td><a href="edit?id=<?= $sale['TicketID']; ?>">Bearbeiten</a></td>
                <td><a href="delete?id=<?= $sale['TicketID']; ?>">Löschen</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>