<?php
use LZCompressor\LZString as LZString;

require('LZCompressor/LZString.php');
require('LZCompressor/LZContext.php');
require('LZCompressor/LZData.php');
require('LZCompressor/LZReverseDictionary.php');
require('LZCompressor/LZUtil.php');
require('LZCompressor/LZUtil16.php');
// include 'koneksi.php';
// include 'query.php';
// $data = "9667";
// $secretKey = "5aR549A8D1";
$data = "19733";
$secretKey = "9Wc#Eo4sDq";
$userkey = "64341530008e74c5275eab800f8b87b4";

// Computes the timestamp
date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
// Computes the signature by hashing the salt with the secret key as the key
$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
$key = $data.$secretKey.$tStamp;
// base64 encode…
$encodedSignature = base64_encode($signature);

// urlencode…
// $encodedSignature = urlencode($encodedSignature);

// echo "X-cons-id: " .$data ." ";
// echo "X-timestamp:" .$tStamp ." ";
// echo "X-signature: " .$encodedSignature;
// echo "<br>";
$headers=array(
  "X-cons-id: ".$data,
  "X-timestamp: ".$tStamp,
  "X-signature: ".$encodedSignature,
  "user_key: ".$userkey,
  "Content-type: application/json"
);



$method = "GET";
$base_URL = "https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/";
// $base_URL = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/";
$NoPeserta = "112103021221Y000980";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL, $base_URL."Rujukan/Peserta/0002080254418");
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
// print_r($data);




// $tgl_tujukan = $data['response']['rujukan']['tglKunjungan'];
// $date_rujukan = date('Y-m-d', strtotime($tgl_tujukan));
// $akhir_rujukan = date('Y-m-d', strtotime($date_rujukan."+86 days"));


function stringDecrypt($key, $string){


            $encrypt_method = 'AES-256-CBC';

            // hash
            $key_hash = hex2bin(hash('sha256', $key));

            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

            return $output;
        }

        // function lzstring decompress
        // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
        function decompress($string){

            return LZCompressor\LZString::decompressFromEncodedURIComponent($string);

        }

        $a = stringDecrypt($key, $data['response']);
        // echo decompress($a);
        $data1=json_decode(decompress($a), true);
        print_r($data1);
        // echo $data['poli']['0']['nama'];
?>
