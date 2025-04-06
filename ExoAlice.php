
<?php

function calculerMoyenne($n1,$n2,$n3){
    return ($n1+$n2+$n3)/3;
}




function afficherResultat($nom, $moy) {
    if ($moy >= 10) {
        print("$nom a la moyenne");
    } else {
        print("$nom n'a pas la moyenne");
    }
}


echo afficherResultat("Alice",calculerMoyenne(12,15,16))
 
 
?>

