<?php
//-- konfigurasi database
$dbhost = 'localhost:3307';
$dbuser = 'root';
$dbpass = '';
$dbname = 'saw_db';
//-- koneksi ke database server dengan extension mysqli
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
//-- hentikan program dan tampilkan pesan kesalahan jika koneksi gagal
if ($db->connect_error) {
    die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
}
