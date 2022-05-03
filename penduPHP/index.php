<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Le Pendu</title>
</head>
<body>
    <?php 
        include 'menu.php';
    ?>
        
    <div class="container">
        <?php 
            include 'pendu.php';
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">
                    <img src='img/pendu<?=$_SESSION['vies']?>.png' alt='pendu'>
                </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <div class="card">
                <div class="card-body">

                    <h3>Session en cours :</h3>
                    <?php 
                    echo "<br>Nombre de vies restantes : ".$_SESSION['vies'];
                    echo "<br>Parties gagnées : ".$_SESSION['partiesGagnees'];
                    echo "<br>Parties perdues : ".$_SESSION['partiesPerdues']."<br>";
                    ?>
                    <br><p><a href="<?php unset($_SESSION) ?>">Nouveau mot</a></p>
                </div>
                </div>
            </div>
            </div>
        </div>

    <div class="footer">
        <?php
            include 'footer.php';
        ?>
    </div>
</body>
</html>