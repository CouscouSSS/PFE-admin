<?php
// Array with names
$a[] = "Grammar";
$a[] = "Skills";
$a[] = "Culture Générale";
$a[] = "Calendar";
$a[] = "Contact";
$a[] = "Home";
$a[] = "Tests";
$a[] = "Quizzs";
$a[] = "Corona Virus";
$a[] = "About us";
$a[] = "General English";


// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>