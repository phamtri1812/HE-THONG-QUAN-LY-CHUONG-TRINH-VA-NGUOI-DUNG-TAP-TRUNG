<?php
    function to_date($date){
        if($date!=''){
            $a=date_create($date);
            date_format($a,'d-M-y');
            $date=$a->format("d-m-Y");
        }
        else {
            $date='';
        }
        return $date;
    }
?>