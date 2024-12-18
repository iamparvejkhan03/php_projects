<?php
    require 'vendor/autoload.php';
    use Carbon\Carbon;

    function date_difference($date){
        $old_date = Carbon::create($date, "Asia/Kolkata");
        return $old_date->diffForHumans(); // Output: "1 week ago", "1 year ago", etc.
    }


?>