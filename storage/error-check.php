<?php
$c = file_get_contents('storage/logs/laravel.log');
preg_match_all('/\[20\d\d-\d\d-\d\d \d\d:\d\d:\d\d\] local\.ERROR: (.*?)Stack trace:/s', $c, $m);
if(count($m[1])>0){
    echo trim(end($m[1]));
}
