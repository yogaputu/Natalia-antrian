<?php
require __DIR__ . '\vendor\autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\CapabilityProfile;
// use Mike42\Escpos\Devices\AuresCustomerDisplay;
// use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

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
  // $norm = $_GET['norm'];
  // $pj = $_GET['pj'];
  // $antrian = $_GET['antrian'];
  // $poli = $_GET['poli'];
  // $dr = $_GET['dr'];
  // $estimasi = $_GET['est'];
  // $est = date('d-m-Y H:i:s', strtotime($estimasi));
     // $connector = new WindowsPrintConnector("prantrian");
     $connector = new WindowsPrintConnector("smb://192.168.0.100/POS");
         //$connector = new WindowsPrintConnector("Receipt Printer");

         /* Print a "Hello world" receipt" */
         $printer = new Printer($connector);
         $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer -> setTextSize(2, 2);
         $printer -> text("RSU NATALIA \n");
         $printer -> text("KABUPATEN BOYOLALI \n");

         $printer -> cut();

         /* Close printer */
         $printer -> close();
     } catch (Exception $e) {
         echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
     }
     // header("location:index.php");
?>
