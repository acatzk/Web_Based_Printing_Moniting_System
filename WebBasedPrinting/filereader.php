<?php

  $browser_ver = get_browser(null, true);

  if ($browser_ver['browser'] == 'IE') {

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
      html{
        height: 100%;
      }
    </style>
    <script>
        function printIt(id){
          var pdf = document.getElementById("samplePDF");
          pdf.click();
          pdf.setActive();
          pdf.focus();
          pdf.print();
        }
    </script>
  </head>
  <body style="margin: 0; height: 100%;">
      <embed id="samplePDF" type="application/pdf" src="documents/rich.pdf" width="100%" height="100%" onLoad="printIt('samplePDF')">
      <button onClick="printIt('')">Print</button>
  </body>
</html>

<?php } else { ?>
  <HTML>
      <script language="javascript">
            function printfile(){
              window.frames['objAdobePrint'].focus();
              window.frames['objAdobePrint'].print();
            }
      </script>

<body marginheight="0" marginwidth="0">
    <iframe src="documents/rich.pdf" width="100%" height="95%" name="objAdobePrint" id="objAdobePrint" frameborder=0></iframe>
    <input type="button"  value="Print" onclick="javascript: printfile();">
</body>

  </HTML>
<?php } ?>
