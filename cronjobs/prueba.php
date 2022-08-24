<?php
    date_default_timezone_set('America/La_Paz');
    $aux = strtotime("now");
    echo $aux."\n";
    echo date('Y-m-d h:i:s',$aux);