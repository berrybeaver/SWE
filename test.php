<?php
$newDate = "11.11.2011";
$newDate = date('d/m/Y', strtotime($newDate));
$startDate = date('d/m/Y', strtotime("11.12.2011"));
$endDate = date('d/m/Y', strtotime($newDate));
$zeit_s = 11.00;
$dbzeit = 11.00;
if(($newDate >= $startDate) && ($newDate <= $endDate)){
    echo "fehler";
}else{
    if ($newDate == $endDate){
        //check time
        //while($row_termin_check2 = mysqli_fetch_assoc($result_termin_check)) {
            if ($zeit_s <= $dbzeit ){
                echo "fehler";
            } else{
                echo "gtg";
            }
    }else{
        echo "gtg";
    }
}

