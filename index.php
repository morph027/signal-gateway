<?php

if(isset($_POST['from'])) { $from = escapeshellarg($_POST['from']);}
if(isset($_POST['to'])) {$to = escapeshellarg($_POST['to']);}
if(isset($_POST['message'])) {$message = escapeshellarg($_POST['message']);}

$options = "--to $to --message $message";

if(isset($from)) {$options = $options." --from $from";}

$cmd = "bin/textsecure-wrapper $options";

exec($cmd);

?>
