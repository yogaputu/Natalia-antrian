<?php
require __DIR__ . '\vendor\autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Devices\AuresCustomerDisplay;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile*/
try {
  $norm = $_GET['norm'];
  $pj = $_GET['pj'];
  $antrian = $_GET['antrian'];
  $poli = $_GET['poli'];
  $dr = $_GET['dr'];
  // $estimasi = $_GET['est'];
  $kode = $_GET['kode'];
  $kontrol = $_GET['kontrol'];
  // $est = date('d-m-Y H:i:s', strtotime($estimasi));
     // $connector = new WindowsPrintConnector("prantrian");
     $connector = new WindowsPrintConnector("smb://192.168.0.106/LABEL2");
     //     //$connector = new WindowsPrintConnector("Receipt Printer");
     //
     //     /* Print a "Hello world" receipt" */
         $printer = new Printer($connector);
         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer -> setTextSize(2, 2);
         $printer -> text("RSU NATALIA \n");
         $printer -> text("KABUPATEN BOYOLALI \n");
         $printer -> setTextSize(2, 2);
         $printer -> text("TIKET ANTRIAN ANDA NOMOR \n");
         $printer -> text($norm . "\n");
         $printer -> setTextSize(6, 6);
         $printer -> text($antrian . "\n");
         $printer -> setTextSize(1, 1);
         $printer -> text("PENJAMIN : ");
         $printer -> text($pj . "\n");
         $printer -> text("POLI : ");
         $printer -> text($poli . "\n");
         $printer -> text("DOKTER : ");
         $printer -> text($dr . "\n");
         $printer -> text("ESTIMASI DILAYANI\n");
         $printer -> text("\n");
         $printer -> text("Tiket Hanya Berlaku Pada Hari Dicetak\n");
         $printer -> text("Terimakasih Atas Kunjungan Anda\n");
         $printer -> text("\n");
         $printer -> text("\n");

         $printer -> cut();

         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer -> setTextSize(2, 2);
         $printer -> text("RSU NATALIA \n");
         $printer -> text("KABUPATEN BOYOLALI \n");
         $printer -> setTextSize(2, 2);
         $printer -> text("TIKET ANTRIAN ANDA NOMOR \n");
         $printer -> text($norm . "\n");
         $printer -> setTextSize(6, 6);
         $printer -> text($antrian . "\n");
         $printer -> setTextSize(1, 1);
         $printer -> text("PENJAMIN : ");
         $printer -> text($pj . "\n");
         $printer -> text("POLI : ");
         $printer -> text($poli . "\n");
         $printer -> text("DOKTER : ");
         $printer -> text($dr . "\n");
         $printer -> text("ESTIMASI DILAYANI\n");
         $printer -> text("\n");
         $printer -> text("Tiket Hanya Berlaku Pada Hari Dicetak\n");
         $printer -> text("Terimakasih Atas Kunjungan Anda\n");
         $printer -> text("\n");
         $printer -> text("\n");

         $printer -> cut();

         /* Close printer */
         $printer -> close();

     } catch (Exception $e) {
         echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
     }
     if ($pj == 'BPJ') {
       echo "<script>window.location = 'tuto1.php?kode=".$kode."&kontrol=".$kontrol."';</script>";
     }else {
       // code...
      //  header("location:index.php");
     }
?>
