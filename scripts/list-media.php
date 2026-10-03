<?php

$dir = 'C:/xampp/htdocs/Home/Images and Viedio of homestay';
$files = array_values(array_filter(scandir($dir), fn ($f) => ! in_array($f, ['.', '..'], true)));
sort($files);
foreach ($files as $f) {
    $path = $dir.'/'.$f;
    $size = is_file($path) ? filesize($path) : 0;
    echo sprintf("%s\t%.1fMB\n", $f, $size / 1048576);
}
echo 'COUNT='.count($files)."\n";
