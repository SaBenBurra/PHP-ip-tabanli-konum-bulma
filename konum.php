<?php
require_once('db.php');

$ip = $_SERVER["REMOTE_ADDR"];//Kullanıcının ip adresini aldık.
$ch = curl_init('http://ip-api.com/json/'.$ip.'?lang=en');                                                                     
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json'                                                                                
));
//Curl ayarlarımızı yaptık.


$sonuc = curl_exec($ch);
//Curl ile ip-api.com/json adresine kullanıcının ip adresini gönderdik.
//Dönen sonucu $sonuc değişkenine aktardık.


$veri = json_decode($sonuc); //json veriyi aldık.
//print_r($veri) ile gelen verileri görebilirsiniz.

$postaKodu = $veri->zip;
$il = $veri->regionName;
$ilce = $veri->city;
// İl ve ilçe bilgilerini dönen veriden alıyoruz.Dilerseniz siz veritabanından da alabilirsiniz.


//Şimdi de mahalle tespitini gerçekleştirelim.

$mahalleler = []; //Posta koduyla eşleşen mahalleleri tutacağımız dizi.

$adressorgusu = $db->query("SELECT * FROM pk WHERE pk=$postaKodu")->fetchAll();
foreach($adressorgusu as $satir)
{
	array_push($mahalleler,$satir['mahalle']);//Eşleşen mahalleleri diziye ekliyoruz.
}

//Elde ettiğimiz verileri ekrana yazdırıyoruz.
echo "ADRES BİLGİLERİ <br>";
echo "Posta Kodu: $postaKodu <br>";
echo "İl: $il <br>";
echo "İlçe: $ilce <br>";
echo "Muhtemel mahalleler: ";
foreach($mahalleler as $mahalle)
{
	echo $mahalle."---";
}
