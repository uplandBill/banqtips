<?php

$aFruits = array (    'Juicy'  , 'Grapes',
                      'Colourful', 'Dragon Fruit');  
                      
$szJsonEncoded = json_encode($aFruits);  

echo $szJsonEncoded;

?>