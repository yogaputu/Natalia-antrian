<?php
date_default_timezone_set("Asia/Jakarta");
require('fpdf/fpdf.php');

include 'koneksi.php';
include_once 'decompress.php';

$kode = $_GET['kode'];
$kontrol = $_GET['kontrol'];

$sql = ibase_query($dbh, "SELECT A.NORUJUKAN, B.NO_JAMINAN, B.NO_TELEPON, B.NORM, C.NAMA AS DOKTER, C.KD_DOKTERBPJS AS KD_DOKTER, D.KDPOLI_BPJS, A.SURAT_KONTROL  FROM TH_KUNJUNGAN A
JOIN MH_PASIEN B ON A.NORM = B.NORM
JOIN MH_PROVIDER C ON A.DPJP = C.ID
JOIN MH_TEMPATLAYANAN D ON D.ID = A.TMP_LAYANAN2
WHERE A.KODE = '$kode'");
$a = ibase_fetch_object($sql);

$tgl_sep = date('Y-m-d');
$bulan = date('m');
$tahun = date('Y');
$kartu = $a->NO_JAMINAN;
use LZCompressor\LZString as LZString;

require('LZCompressor/LZString.php');
require('LZCompressor/LZContext.php');
require('LZCompressor/LZData.php');
require('LZCompressor/LZReverseDictionary.php');
require('LZCompressor/LZUtil.php');
require('LZCompressor/LZUtil16.php');

class PDF extends FPDF
{
// Page header
// function Header()
// {
//     // Logo
//     $this->Image('images/logo.svg.png' ,5,7,55);
//     // Arial bold 15
//     $this->SetFont('Arial','B',12);
//     // Move to the right
//     $this->Cell(55);
//     // Title
//     $this->Cell(0,0,'SURAT ELEGIBILITAS PESERTA',0,0,'L');
//     // Line break
//     $this->Ln(5);
//     $this->SetFont('Arial','B',12);
//     $this->Cell(55);
//     $this->Cell(0,0,'RSU NATALIA KAB.BOYOLALI',0,0,'L');
// }
}


$data = "9667";
$secretKey = "5aR549A8D1";
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
  "Content-type: Application/x-www-form-urlencoded"
);

$base_URL = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";


$ch=curl_init();
curl_setopt($ch,CURLOPT_URL, $base_URL."Rujukan/".$a->NORUJUKAN);
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

        $nama_poli = $data['rujukan']['poliRujukan']['nama'];
        $asal_rujukan = $data['rujukan']['provPerujuk']['nama'];



        $ch1=curl_init();
        curl_setopt($ch1,CURLOPT_URL, $base_URL."/RencanaKontrol/noSuratKontrol/".$a->SURAT_KONTROL);
        curl_setopt($ch1,CURLOPT_HTTPHEADER,$headers);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch1,CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $NoPeserta);
        curl_setopt($ch1,CURLOPT_TIMEOUT,3);
        curl_setopt($ch1,CURLOPT_HTTPGET,1);
        curl_setopt($ch1,CURLOPT_SSL_VERIFYPEER,false);

        $content1=curl_exec($ch1);
        curl_close($ch1);
        $data1=json_decode($content1, true);

                $b1 = stringDecrypt($key, $data1['response']);
                // echo decompress($a);
                $data1=json_decode(decompress($b1), true);
                $dr_kontrol = $data1['kodeDokter'];
                // echo $dr_kontrol;

if ($kontrol != "") {
  $arr = array(
            "request"=>array(
               "t_sep"=>array(
                  "noKartu"=>$a->NO_JAMINAN,
                  "tglSep"=>$tgl_sep,
                  "ppkPelayanan"=>"0149R894",
                  "jnsPelayanan"=>"2",
                  "klsRawat"=>array(
                     "klsRawatHak"=>"",
                     "klsRawatNaik"=>"",
                     "pembiayaan"=>"",
                     "penanggungJawab"=>""
                  ),
                  "noMR"=>$a->NORM,
                  "rujukan"=>array(
                     "asalRujukan"=>$data['asalFaskes'],
                     "tglRujukan"=>$data['rujukan']['tglKunjungan'],
                     "noRujukan"=>$data['rujukan']['noKunjungan'],
                     "ppkRujukan"=>$data['rujukan']['provPerujuk']['kode']
                  ),
                  "catatan"=>"RJ",
                  "diagAwal"=>$data['rujukan']['diagnosa']['kode'],
                  "poli"=>array(
                     "tujuan"=>$a->KDPOLI_BPJS,
                     "eksekutif"=>"0"
                  ),
                  "cob"=>array(
                     "cob"=>"0"
                  ),
                  "katarak"=>array(
                     "katarak"=>"0"
                  ),
                  "jaminan"=>array(
                     "lakaLantas"=>"0",
                     "noLP"=>"",
                     "penjamin"=>array(
                        "tglKejadian"=>"",
                        "keterangan"=>"",
                        "suplesi"=>array(
                           "suplesi"=>"0",
                           "noSepSuplesi"=>"",
                           "lokasiLaka"=>array(
                              "kdPropinsi"=>"",
                              "kdKabupaten"=>"",
                              "kdKecamatan"=>""
                           )
                        )
                     )
                  ),
                  "tujuanKunj"=>"2",
                  "flagProcedure"=>"",
                  "kdPenunjang"=>"",
                  "assesmentPel"=>"5",
                  "skdp"=>array(
                     "noSurat"=>$a->SURAT_KONTROL,
                     "kodeDPJP"=>$dr_kontrol
                  ),
                  "dpjpLayan"=>$a->KD_DOKTER,
                  "noTelp"=>$a->NO_TELEPON,
                  "user"=>"TINA"
               )
            )
         );
         echo "DENGAN SURAT KONTROL";
}else {
  $arr = array(
            "request"=>array(
               "t_sep"=>array(
                  "noKartu"=>$a->NO_JAMINAN,
                  "tglSep"=>$tgl_sep,
                  "ppkPelayanan"=>"0149R894",
                  "jnsPelayanan"=>"2",
                  "klsRawat"=>array(
                     "klsRawatHak"=>"",
                     "klsRawatNaik"=>"",
                     "pembiayaan"=>"",
                     "penanggungJawab"=>""
                  ),
                  "noMR"=>$a->NORM,
                  "rujukan"=>array(
                     "asalRujukan"=>$data['asalFaskes'],
                     "tglRujukan"=>$data['rujukan']['tglKunjungan'],
                     "noRujukan"=>$data['rujukan']['noKunjungan'],
                     "ppkRujukan"=>$data['rujukan']['provPerujuk']['kode']
                  ),
                  "catatan"=>"RJ",
                  "diagAwal"=>$data['rujukan']['diagnosa']['kode'],
                  "poli"=>array(
                     "tujuan"=>$a->KDPOLI_BPJS,
                     "eksekutif"=>"0"
                  ),
                  "cob"=>array(
                     "cob"=>"0"
                  ),
                  "katarak"=>array(
                     "katarak"=>"0"
                  ),
                  "jaminan"=>array(
                     "lakaLantas"=>"0",
                     "noLP"=>"",
                     "penjamin"=>array(
                        "tglKejadian"=>"",
                        "keterangan"=>"",
                        "suplesi"=>array(
                           "suplesi"=>"0",
                           "noSepSuplesi"=>"",
                           "lokasiLaka"=>array(
                              "kdPropinsi"=>"",
                              "kdKabupaten"=>"",
                              "kdKecamatan"=>""
                           )
                        )
                     )
                  ),
                  "tujuanKunj"=>"0",
                  "flagProcedure"=>"",
                  "kdPenunjang"=>"",
                  "assesmentPel"=>"",
                  "skdp"=>array(
                     "noSurat"=>"",
                     "kodeDPJP"=>""
                  ),
                  "dpjpLayan"=>$a->KD_DOKTER,
                  "noTelp"=>$a->NO_TELEPON,
                  "user"=>"TINA"
               )
            )
         );
         echo "TANPA SURAT KONTROL";

}
echo $a->NO_JAMINAN;
echo "<br>";
echo $tgl_sep;
echo "<br>";
echo $a->NORM;
echo "<br>";
echo $data['asalFaskes'];
echo "<br>";
echo $data['rujukan']['tglKunjungan'];
echo "<br>";
echo $data['rujukan']['noKunjungan'];
echo "<br>";
echo $data['rujukan']['provPerujuk']['kode'];
echo "<br>";
echo $data['rujukan']['diagnosa']['kode'];
echo "<br>";
echo $a->KDPOLI_BPJS;
echo "<br>";
echo $kontrol;
echo "<br>";
echo $a->KD_DOKTER;
echo "<br>";
echo $a->KD_DOKTER;
echo "<br>";
echo $a->SURAT_KONTROL;

$json = json_encode($arr);
 print_r($json);

$method2 = "POST";

$ch2=curl_init();
curl_setopt($ch2,CURLOPT_URL, $base_URL."SEP/2.0/insert");
curl_setopt($ch2,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch2,CURLOPT_CUSTOMREQUEST, $method2);
curl_setopt($ch2,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch2,CURLOPT_POSTFIELDS, $json);
curl_setopt($ch2,CURLOPT_TIMEOUT,3);
// curl_setopt($ch,CURLOPT_HTTPGET,1);
curl_setopt($ch2,CURLOPT_SSL_VERIFYPEER,false);

$content2=curl_exec($ch2);
$err2 = curl_error($ch2);
curl_close($ch2);
print_r($content2);


$data2=json_decode($content2, true);

        $b2 = stringDecrypt($key, $data2['response']);
        // echo decompress($a);
        $data2=json_decode(decompress($b2), true);
        print_r($data2);

        echo $data2['sep']['noSep'];
        echo $data2['sep']['tglSep'];

date_default_timezone_set('Asia/Jakarta');
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage('P','legal');


$pdf->Image('images/logo.svg.png' ,5,7,55);
// Arial bold 15
$pdf->SetFont('Arial','B',12);
// Move to the right
$pdf->Cell(55);
// Title
$pdf->Cell(0,0,'SURAT ELEGIBILITAS PESERTA',0,0,'L');
// Line break
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(55);
$pdf->Cell(0,0,'RSU NATALIA KAB.BOYOLALI',0,0,'L');

$pdf->SetFont('Arial','',10);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x - 201, $y + 9);
$pdf->Cell(0,0,'No. SEP',0,0);
$pdf->SetXY($x - 165, $y + 9);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 9);
$pdf->Cell(0,0,$data2['sep']['noSep'],0,0);

$tgl_kunjungan = date('Y-m-d');
$pdf->SetXY($x - 201, $y + 15);
$pdf->Cell(0,0,'Tgl. SEP',0,0);
$pdf->SetXY($x - 165, $y + 15);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 15);
$pdf->Cell(0,0,$data2['sep']['tglSep'],0,0);

$pdf->SetXY($x - 201, $y + 21);
$pdf->Cell(0,0,'No. Kartu',0,0);
$pdf->SetXY($x - 165, $y + 21);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 21);
$pdf->Cell(0,0,$data2['sep']['peserta']['noKartu'].'(MR : '.$data2['sep']['peserta']['noMr'].')',0,0);

$pdf->SetXY($x - 65, $y + 21);
$pdf->Cell(0,0,'Peserta',0,0);
$pdf->SetXY($x - 45, $y + 21);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y + 21);
$pdf->Cell(0,0,$data2['sep']['peserta']['jnsPeserta'],0,0);

$pdf->SetXY($x - 201, $y + 27);
$pdf->Cell(0,0,'Nama Peserta',0,0);
$pdf->SetXY($x - 165, $y + 27);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 27);
if ($data2['sep']['peserta']['kelamin'] == "Laki-Laki") {
  $kelamin = "L";
}else {
  $kelamin = "P";
}
$pdf->Cell(0,0,$data2['sep']['peserta']['nama'].'('.$kelamin.')',0,0);

$pdf->SetXY($x - 65, $y + 27);
$pdf->Cell(0,0,'COB',0,0);
$pdf->SetXY($x - 45, $y + 27);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y + 27);
$pdf->Cell(0,0,'-',0,0);

$pdf->SetXY($x - 201, $y + 33);
$pdf->Cell(0,0,'Tgl. Lahir',0,0);
$pdf->SetXY($x - 165, $y + 33);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 33);
$pdf->Cell(0,0,$data2['sep']['peserta']['tglLahir'],0,0);

$pdf->SetXY($x - 65, $y + 33);
$pdf->Cell(0,0,'Jns. Rawat',0,0);
$pdf->SetXY($x - 45, $y + 33);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y + 33);
$pdf->Cell(0,0,'Rawat Jalan',0,0);

$pdf->SetXY($x - 201, $y + 39);
$pdf->Cell(0,0,'No. Telepon',0,0);
$pdf->SetXY($x - 165, $y + 39);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 39);
$pdf->Cell(0,0,$a->NO_TELEPON,0,0);

$pdf->SetXY($x - 65, $y + 39);
$pdf->Cell(0,0,'Kls. Rawat',0,0);
$pdf->SetXY($x - 45, $y + 39);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y + 39);
$pdf->Cell(0,0,'-',0,0);

$pdf->SetXY($x - 201, $y + 45);
$pdf->Cell(0,0,'Sub/Spesialis',0,0);
$pdf->SetXY($x - 165, $y + 45);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 45);
$pdf->Cell(0,0,$data2['sep']['poli'],0,0);

$pdf->SetXY($x - 65, $y + 45);
$pdf->Cell(0,0,'Penjamin',0,0);
$pdf->SetXY($x - 45, $y + 45);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y + 45);
$pdf->Cell(0,0,$data2['sep']['kelasRawat'],0,0);

$pdf->SetXY($x - 201, $y + 51);
$pdf->Cell(0,0,'DPJP',0,0);
$pdf->SetXY($x - 165, $y + 51);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 51);
$pdf->Cell(0,0,$a->DOKTER,0,0);

$pdf->SetXY($x - 201, $y + 57);
$pdf->Cell(0,0,'Faskes Perujuk',0,0);
$pdf->SetXY($x - 165, $y + 57);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 57);
$pdf->Cell(0,0,$asal_rujukan,0,0);

$pdf->SetXY($x - 201, $y + 63);
$pdf->Cell(0,0,'Diagnosa Awal',0,0);
$pdf->SetXY($x - 165, $y + 63);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 61);
$pdf->MultiCell(90,4,$data2['sep']['diagnosa'],0,'L');

$tgl1 = date('d-m-Y');
$tgl2 = date('d-m-Y');
$pdf->SetXY($x - 201, $y + 72);
$pdf->Cell(0,0,'Catatan',0,0);
$pdf->SetXY($x - 165, $y + 72);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y + 72);
$pdf->Cell(0,0,'',0,0);

$pdf->SetXY($x - 45, $y + 63);
$pdf->Cell(0,0,'Pasien/Keluarga Pasien',0,0);
$pdf->SetXY($x - 45, $y + 82);
$pdf->Cell(0,0,'......................................',0,0);

$pdf->Image('images/potong.png' ,55,100,13);
$pdf->Line(5,106.5,210,106.5);

$pdf->SetFont('Arial','',6);
$pdf->SetXY($x - 201, $y + 78);
$pdf->Cell(0,0,'*Saya Menyetujui BPJS Kesehatan Menggunakan Informasi Medis Pasien Jika Diperlukan.',0,0);

$pdf->SetXY($x - 201, $y + 82);
$pdf->Cell(0,0,'*SEP Bukan Sebagai Bukti Penjaminan Peserta.',0,0);

$tgl = date('d-m-Y h:i:s A');

$pdf->SetXY($x - 201, $y + 86);
$pdf->Cell(0,0,'Cetakan Ke 1 - '.$tgl_sep,0,0);



$pdf->SetFont('Arial','B',12);
$pdf->SetY($y + 97);
$pdf->Cell(0,0,'RESUME RAWAT JALAN',0,0,'C');
$pdf->SetY($y + 101);
$pdf->Cell(0,0,'RSU NATALIA',0,0,'C');

$pdf->Line(5,118.5,210,118.5);
$pdf->SetXY($x - 201, $y + 107);
$pdf->Cell(0,0,'PEMERIKSAAN FISIK',0,0);

$pdf->Line(5,140,210,140);
$pdf->SetXY($x - 201, $y + 128);
$pdf->Cell(0,0,'PEMERIKSAAN PENUNJANG',0,0);

$pdf->Line(5,162,210,162);
$pdf->SetXY($x - 201, $y + 150);
$pdf->Cell(0,0,'DIAGNOSA UTAMA',0,0);
$pdf->SetXY($x - 98, $y + 150);
$pdf->Cell(0,0,'DIAGNOSA SEKUNDER',0,0);
$pdf->Line(108,162,108,184);

$pdf->Line(5,184,210,184);
$pdf->SetXY($x - 201, $y + 172);
$pdf->Cell(0,0,'TINDAKAN',0,0);

$pdf->Line(5,206,210,206);
$pdf->SetXY($x - 201, $y + 194);
$pdf->Cell(0,0,'Tanggal Pemeriksaan :',0,0);
$pdf->SetXY($x - 201, $y + 199);
$pdf->Cell(0,0,$tgl_sep,0,0);
$pdf->Line(60,206,60,236);

$pdf->Line(5,236,210,236);
$pdf->SetXY($x - 105, $y + 194);
$pdf->Cell(0,0,'Dokter Penanggung Jawab Pasien',0,0);
$pdf->SetXY($x - 110, $y + 212);
$pdf->Cell(0,0,'('.$a->DOKTER.')',0,0);
$pdf->SetFont('Arial','',10);
$pdf->SetXY($x - 101.5, $y + 216);
$pdf->Cell(0,0,'Tanda Tangan dan Nama Terang Dokter',0,0);

$pdf->Image('images/logo.svg.png' ,5,240,55);
// Arial bold 15

$pdf->SetFont('Arial','B',12);
$pdf->SetXY($x - 140, $y + 227);
$pdf->Cell(0,0,'SURAT ELEGIBILITAS PESERTA',0,0,'L');
// Line break
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(56);
$pdf->Cell(0,0,'RSU NATALIA KAB.BOYOLALI',0,0,'L');

$pdf->SetFont('Arial','',10);

$y1 = $y + 233;

$pdf->SetXY($x - 201, $y1 + 9);
$pdf->Cell(0,0,'No. SEP',0,0);
$pdf->SetXY($x - 165, $y1 + 9);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 9);
$pdf->Cell(0,0,$data2['sep']['noSep'],0,0);

$tgl_kunjungan = date('Y-m-d');
$pdf->SetXY($x - 201, $y1 + 15);
$pdf->Cell(0,0,'Tgl. SEP',0,0);
$pdf->SetXY($x - 165, $y1 + 15);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 15);
$pdf->Cell(0,0,$data2['sep']['tglSep'],0,0);

$pdf->SetXY($x - 201, $y1 + 21);
$pdf->Cell(0,0,'No. Kartu',0,0);
$pdf->SetXY($x - 165, $y1 + 21);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 21);
$pdf->Cell(0,0,$data2['sep']['peserta']['noKartu'].'(MR : '.$data2['sep']['peserta']['noMr'].')',0,0);

$pdf->SetXY($x - 65, $y1 + 21);
$pdf->Cell(0,0,'Peserta',0,0);
$pdf->SetXY($x - 45, $y1 + 21);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y1 + 21);
$pdf->Cell(0,0,$data2['sep']['peserta']['jnsPeserta'],0,0);

$pdf->SetXY($x - 201, $y1 + 27);
$pdf->Cell(0,0,'Nama Peserta',0,0);
$pdf->SetXY($x - 165, $y1 + 27);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 27);
if ($data2['sep']['peserta']['kelamin'] == "Laki-Laki") {
  $kelamin = "L";
}else {
  $kelamin = "P";
}

$pdf->Cell(0,0,$data2['sep']['peserta']['nama'].'('.$kelamin.')',0,0);

$pdf->SetXY($x - 65, $y1 + 27);
$pdf->Cell(0,0,'COB',0,0);
$pdf->SetXY($x - 45, $y1 + 27);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y1 + 27);
$pdf->Cell(0,0,'-',0,0);

$pdf->SetXY($x - 201, $y1 + 33);
$pdf->Cell(0,0,'Tgl. Lahir',0,0);
$pdf->SetXY($x - 165, $y1 + 33);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 33);
$pdf->Cell(0,0,$data2['sep']['peserta']['tglLahir'],0,0);

$pdf->SetXY($x - 65, $y1 + 33);
$pdf->Cell(0,0,'Jns. Rawat',0,0);
$pdf->SetXY($x - 45, $y1 + 33);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y1 + 33);
$pdf->Cell(0,0,'Rawat Jalan',0,0);

$pdf->SetXY($x - 201, $y1 + 39);
$pdf->Cell(0,0,'No. Telepon',0,0);
$pdf->SetXY($x - 165, $y1 + 39);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 39);
$pdf->Cell(0,0,$a->NO_TELEPON,0,0);

$pdf->SetXY($x - 65, $y1 + 39);
$pdf->Cell(0,0,'Kls. Rawat',0,0);
$pdf->SetXY($x - 45, $y1 + 39);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y1 + 39);
$pdf->Cell(0,0,'-',0,0);

$pdf->SetXY($x - 201, $y1 + 45);
$pdf->Cell(0,0,'Sub/Spesialis',0,0);
$pdf->SetXY($x - 165, $y1 + 45);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 45);
$pdf->Cell(0,0,$data2['sep']['poli'],0,0);

$pdf->SetXY($x - 65, $y1 + 45);
$pdf->Cell(0,0,'Penjamin',0,0);
$pdf->SetXY($x - 45, $y1 + 45);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 40, $y1 + 45);
$pdf->Cell(0,0,$data2['sep']['kelasRawat'],0,0);

$pdf->SetXY($x - 201, $y1 + 51);
$pdf->Cell(0,0,'DPJP',0,0);
$pdf->SetXY($x - 165, $y1 + 51);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 51);
$pdf->Cell(0,0,$a->DOKTER,0,0);

$pdf->SetXY($x - 201, $y1 + 57);
$pdf->Cell(0,0,'Faskes Perujuk',0,0);
$pdf->SetXY($x - 165, $y1 + 57);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 57);
$pdf->Cell(0,0,$asal_rujukan,0,0);

$pdf->SetXY($x - 201, $y1 + 63);
$pdf->Cell(0,0,'Diagnosa Awal',0,0);
$pdf->SetXY($x - 165, $y1 + 63);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 61);
$pdf->MultiCell(90,4,$data2['sep']['diagnosa'],0,'L');

$tgl1 = date('d-m-Y');
$tgl2 = date('d-m-Y');
$pdf->SetXY($x - 201, $y1 + 72);
$pdf->Cell(0,0,'Catatan',0,0);
$pdf->SetXY($x - 165, $y1 + 72);
$pdf->Cell(0,0,':',0,0);
$pdf->SetXY($x - 160, $y1 + 72);
$pdf->Cell(0,0,$tgl1 . 's/d' . $tgl2,0,0);

$pdf->SetXY($x - 45, $y1 + 63);
$pdf->Cell(0,0,'Pasien/Keluarga Pasien',0,0);
$pdf->SetXY($x - 45, $y1 + 82);
$pdf->Cell(0,0,'......................................',0,0);


$pdf->SetFont('Arial','',6);
$pdf->SetXY($x - 201, $y1 + 78);
$pdf->Cell(0,0,'*Saya Menyetujui BPJS Kesehatan Menggunakan Informasi Medis Pasien Jika Diperlukan.',0,0);

$pdf->SetXY($x - 201, $y1 + 82);
$pdf->Cell(0,0,'*SEP Bukan Sebagai Bukti Penjaminan Peserta.',0,0);

$tgl = date('d-m-Y h:i:s A');

$pdf->SetXY($x - 201, $y1 + 86);
$pdf->Cell(0,0,'Cetakan Ke 1 - '.$tgl,0,0);

$pdf->Output('F', "sep/sep.pdf");
// $pdf->Output();
$sep = $data2['sep']['noSep'];
$sql_update = ibase_query($dbh, "UPDATE TH_KUNJUNGAN A SET A.NOSEP = '$sep', A.TGL_SEP = '$tgl_sep'
  WHERE A.KODE = '$kode'");
header('location:printpdfsep.php');
?>
