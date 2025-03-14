<?php
/* Call this file 'hello-world.php' */
// use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\CapabilityProfile;
// include "Mike42/Escpos/CapabilityProfile.php";
include "vendor/Mike42/Escpos/PrintConnectors/WindowsPrintConnector.php";
// $profile = CapabilityProfile::load("simple");
$connector = new WindowsPrintConnector("smb://192.168.0.100/POS");
$printer = new Printer($connector);
$printer -> text("Hello World!\n");
$printer -> cut();
$printer -> close();
