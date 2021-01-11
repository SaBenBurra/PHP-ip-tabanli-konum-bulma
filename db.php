<?php
$host = "";
$databaseAdi = "";
$kullaniciAdi = "";
$sifre = "";
try
{
$db = new PDO("mysql:host=$host;dbname=$databaseAdi;charset=UTF8",$kullaniciAdi,$sifre);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
