
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

     // $connector = new WindowsPrintConnector("prantrian");
     $connector = new WindowsPrintConnector("smb://192.168.0.106/LABEL2");
     //     //$connector = new WindowsPrintConnector("Receipt Printer");
     //
     //     /* Print a "Hello world" receipt" */
     $printer = new Printer($connector);
     $printer -> text("Hello World!\n");
     $printer -> cut();

     /* Close printer */
     $printer -> close();




} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
