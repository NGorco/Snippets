<?php
$zip = new ZipArchive;
$res = $zip->open('yanni_14_09_15.zip');
if ($res === TRUE) {
  $zip->extractTo(__DIR__ . '/');
  $zip->close();
  echo 'woot!';
} else {
  echo 'doh!';
}