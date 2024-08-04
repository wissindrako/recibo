<?php
    if(!function_exists('f_formato')){
        function f_formato($fecha){
            return date("d/m/Y", strtotime($fecha));
        }
    }
?>