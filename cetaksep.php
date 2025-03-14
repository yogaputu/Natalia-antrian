<?php
/* Example print-outs using the older bit image print command */
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\CapabilityProfile;


// $profile = CapabilityProfile::load("SP2000");
$connector = new WindowsPrintConnector("smb://192.168.0.106/LAB");
// $printer = new Printer($connector, $profile);
$printer = new Printer($connector);
$printer -> text("Hello World!\n");
$printer -> cut();
$printer -> close();
