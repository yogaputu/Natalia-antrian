<script src="js/JSPrintManager.js"></script>


<script src="js/bluebird.min.js"></script>
<script src="js/jquery-3.2.1.slim.min.js"></script>

<script>
    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();
 JSPM.JSPrintManager.WS.onStatusChanged = function () {
   if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open) {
            var cpj = new JSPM.ClientPrintJob();
            var myPrinter = new JSPM.InstalledPrinter('HP Laser 103 107 108 (COPY 1)');
            cpj.clientPrinter = myPrinter;
            var my_file = new JSPM.PrintFilePDF('sep/sep.pdf', JSPM.FileSourceType.URL, 'MyFile.pdf', 1);
            cpj.files.push(my_file);
            cpj.sendToClient();
        }
    };

</script>

<?php header( "refresh:5;url=index.php" ); ?>
