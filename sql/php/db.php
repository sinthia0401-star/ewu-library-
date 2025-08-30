<?php
// Copy this file, fill your real password locally.
// Do NOT commit real passwords to GitHub.
$user = 'EWULIB';
$pass = 'CHANGE_ME_PASSWORD';
$dsn  = 'localhost/XEPDB1'; // service name form

$conn = oci_connect($user, $pass, $dsn, 'AL32UTF8');
if (!$conn) {
  $e = oci_error();
  die('DB connect failed: ' . htmlentities($e['message']));
}
