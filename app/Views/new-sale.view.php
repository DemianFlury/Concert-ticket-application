<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Neues Ticket</title>
    <base href="<?= ROOT_URL ?>/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        main {
            margin-top: 2em;
            width: 80%;
            max-width: 550px;
            margin: 2em auto 0;
        }

        .form-title {
            margin-bottom: .7em;
        }

        .form-label {
            margin-top: .7em;
            margin-bottom: .3em;
        }

        fieldset {
            margin-top: 2em;
        }

        .form-legend {
            margin-bottom: .75em;
        }

        .form-legend+.form-group>.form-label:first-child {
            margin-top: 0;
        }

        .option-group {
            margin-top: 2em;
        }

        .form-actions {
            padding-top: 1em;
            border-top: 1px solid #eee;
            margin-top: 1em;
            margin-bottom: 2em;
        }
    </style>
</head>

<body>
    <main>
        <script>
            window.addEventListener("DOMContentLoaded", function() {
                var form = document.querySelector('#form');
                form.addEventListener("submit", function(e) {
                    var errors = [];
                    var name = document.querySelector("#name").value;
                    var email = document.querySelector("#email").value;
                    var phone = document.querySelector("#phone").value;
                    var concert = document.querySelector("#concert").value;
                    if (name === '') {
                        errors.push('Bitte geben Sie einen Namen ein.');
                    }
                    if (email === '') {
                        errors.push('Bitte geben Sie eine Email ein.');
                    } else if (!email.includes('@')) {
                        errors.push('Ihre E-Mail ist ungültig');
                    }
                    if (phone.match('/a-z/')) {
                        errors.push('Bitte geben Sie nur Nummern ein.');
                    }
                    if (errors.length > 0) {
                        alert(errors);
                        e.preventDefault();
                    }
                })
            });
        </script>

        <h1 class="form-title">Neues Ticket erfassen</h1>
        <form action="validatenew" method="post" id="form">
            <fieldset>
                <legend class="form-legend">Kundendaten</legend>
                <div class="form-group">
                    <label class="form-label" for="name">Vor- und Nachname</label>
                    <input class="form-control" type="text" id="name" name="name">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">E-Mail-Adresse</label>
                    <input class="form-control" type="email" id="email" name="email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">Telefonnummer</label>
                    <input class="form-control" type="text" id="phone" name="phone" placeholder="nicht erforderlich">
                </div>
                <div class="form-group">
                    <label class="form-label" for="concert">Treuerabatt</label>
                    <select class="form-control" id="concert" name="concert">
                        <option value="0">0%</option>
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                        <option value="15">15%</option>
                    </select>
                </div>
            </fieldset>
            <fieldset>
                <legend class="form-legend">Konzert</legend>
                <div class="form-group">
                    <label class="form-label" for="concert">Konzert auswählen</label>
                    <select class="form-control" id="concert" name="concert">
                        <option value="">bitte auwählen...</option>
                        <?php foreach ($concertlist as $concert) : ?>
                            <option value='<?= $concert['Artist'] ?>'><?= $concert['Artist'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </fieldset>
            <div class="form-actions">
                <input class="btn btn-primary" type="submit" value="Erfassen">
            </div>
        </form>
    </main>
</body>

</html>