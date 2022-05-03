<?php

session_start(); 
// On démarre une nouvelle session ou une session déjà existante

if(!isset($_SESSION['mot']))
// S'il n'y a pas de mot en session
{ 
    // Déclaration des variables

    $mots = file("mots.txt"); // la liste de mots sont dans le fichier txt
    $mot = rtrim(strtoupper($mots[array_rand($mots)])); // array_rand prend un mot au hasard du fichier txt, strtoupper le met en majuscule et rtrim supprime les espaces/caractères en fin de chaîne
    $_SESSION['mot'] = $mot; // on déclare la variable mot en session
    $_SESSION['essais'] = []; // le tableau des lettres qu'on a essayé de deviner en session
    $_SESSION['vies'] = 6; // le nombre d'essais autorisé
    if(!isset($_SESSION['partiesGagnees'])){ // si il n'y a pas de partie gagnée en session
        $_SESSION['partiesGagnees'] = 0; // il y a 0 partie gagnée dans la session
    }
    if(!isset($_SESSION['partiesPerdues'])){ // si il n'y a pas de partie perdue en session
        $_SESSION['partiesPerdues'] = 0; // il y a 0 partie perdue dans la session
    }
}

if(isset($_POST['essai']))
// si il y a un essai/une lettre dans la méthode POST
{ 
    if(!in_array($_POST['essai'], $_SESSION['essais']))
    // si la lettre n'est pas dans la méthode POST ni dans le tableau d'essais
    { 
        if(strpos($_SESSION['mot'], $_POST['essai']) === FALSE)
        // si la lettre essayée se retrouve dans une position du mot en session
        { 
           $_SESSION['vies']--; // on décrémente/soustrait une vie en session
        }
        $_SESSION['essais'][] = $_POST['essai']; 
        // le tableau d'essais en session est égale aux essais effectués dans la méthode POST
    } else // sinon
    { 
        echo "<p>Lettre déjà devinée </p>"; // on affiche que la lettre a déjà été devinée
    }
}

$lettresRestantes = array_diff(range('A', 'Z'), $_SESSION['essais']); 
// array_diff compare 2 tableaux, ici l'alphabet et les lettres essayées en session

if($_SESSION['vies'] <= 0)
// s'il y a 0 vie en session
{ 
    echo "<p>Tu as perdu!</p>"; 
    echo "<p>Le mot était " . $_SESSION['mot']."</p>";
    $_SESSION['partiesPerdues']++; // on incrémente/ajoute 1 au tableau de parties perdues en session
    unset($_SESSION['mot']); // on vide le mot en session
} else // sinon
{ 
    $lettresRestantesADeviner = 0;
    $etat = '';
    $longueurDuMot = strlen($_SESSION['mot']); // nombre de lettres dans le mot en session
    echo "<p>";
    for($i = 0; $i < $longueurDuMot; $i++)
    // pour i allant de 0 à la longeur du mot
    { 
        if(in_array($_SESSION['mot'][$i], $_SESSION['essais']))
        // in_array permet de voir si une valeur appartient à un tableau, ici on cherche à savoir si la lettre qu'on devine a déjà devinée ou pas dans le mot
        { 
            $etat .= $_SESSION['mot'][$i]; 
            // .= est un opérateur d'affectation de concaténation, là on affiche la lettre et on la met dans le tableau de lettres devinées
        } else // sinon
        { 
            $etat .= "_"; // on affiche un _ à la place de la lettre
            $lettresRestantesADeviner++;
        }
        $etat .= " ";
    }
    echo $etat."</p>";

    if($lettresRestantesADeviner == 0)
    { 
        echo "<p>Tu as gagné petit padawan!</p>";
        $_SESSION['partiesGagnees']++; // on incrémente/ajoute 1 au tableau de parties gagnées en session
        unset($_SESSION['mot']); // on vide le mot en session
    }
}

if($_SESSION['vies'] !=0 && $lettresRestantesADeviner !=0)
// si le nb de vies et de lettres restantes est différent de 0
{ ?>
<form method = "post" action = "">
    <select name = "essai">
    <?php
        foreach($lettresRestantes AS $lettre)
        // on affiche une liste des lettres restantes à trouver
        { 
            echo '<option value = "'.strtoupper($lettre).'">'.strtoupper($lettre).'</option>';
        }   
    ?>
    </select>
    <input type = "submit" name = "submit" value = "ESSAI">
</form>
<?php
}