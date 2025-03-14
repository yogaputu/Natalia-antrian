<?php
use LZCompressor\LZString as LZString;

require('LZCompressor/LZString.php');
require('LZCompressor/LZContext.php');
require('LZCompressor/LZData.php');
require('LZCompressor/LZReverseDictionary.php');
require('LZCompressor/LZUtil.php');
require('LZCompressor/LZUtil16.php');

$tgl_sep = date('Y-m-d');
$bulan = date('m');
$tahun = date('Y');

function stringDecrypt($key, $string){
            $encrypt_method = 'AES-256-CBC';
            // hash
            $key_hash = hex2bin(hash('sha256', $key));
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
            return $output;
        }

        function decompress($string){
            return LZCompressor\LZString::decompressFromEncodedURIComponent($string);

        }


$data = "9667";
$secretKey = "9Wc#Eo4sDq";
$userkey = "16e789b4f9457c13b759d856f941d66d";

// Computes the timestamp
date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
// Computes the signature by hashing the salt with the secret key as the key
$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
$key = $data.$secretKey.$tStamp;
// base64 encode…
$encodedSignature = base64_encode($signature);

$headers=array(
  "X-cons-id: ".$data,
  "X-timestamp: ".$tStamp,
  "X-signature: ".$encodedSignature,
  "user_key: ".$userkey,
  "Content-type: application/json"
);



$method = "GET";
$base_URL = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";
// $base_URL = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/";
$kartu = $_GET['no_kartu'];

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL, $base_URL."RencanaKontrol/ListRencanaKontrol/Bulan/".$bulan."/Tahun/".$tahun."/Nokartu/".$kartu."/filter/2");
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $NoPeserta);
curl_setopt($ch,CURLOPT_TIMEOUT,3);
curl_setopt($ch,CURLOPT_HTTPGET,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

$content=curl_exec($ch);
curl_close($ch);
$data=json_decode($content, true);

        $b = stringDecrypt($key, $data['response']);
        // echo decompress($a);
        $data=json_decode(decompress($b), true);
        // print_r($data);
        $surat = $data['list']['0']['noSuratKontrol'];
        $data = array(
          'no_surat'      =>  $surat,);
          echo json_encode($data);

?>
