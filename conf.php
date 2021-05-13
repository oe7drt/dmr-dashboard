<?php

/* 
 * conf.php
 * Dashboard for YSFGateway
 * Configuration file
 * Dominic Reich, OE7DRT, oe7drt@oevsv.at
 *
 */

  if (isset($_GET['debug'])) {
  	define("DEBUG", true);
  }

  if (isset($_GET['nonames'])) {
    define("NONAMES", true);
  }

  if (isset($_GET['notglink'])) {
    define("NOTGLINK", true);
  }

  if (isset($_GET['dns'])) {
    define("DNS", true);
  }

  if (isset($_GET['full'])) {
  	define("MAXENTRIES", 500);
    define("MAXLOGENTRIES", MAXENTRIES * 5);
  } else {
    define("MAXENTRIES", 20);
    define("MAXLOGENTRIES", MAXENTRIES * 5);
    //define("MAXLOGENTRIES", 500);
  }
  
  // default values for files etc...
  define("MMDVM_INI", "/etc/MMDVM-IPSC.ini");
  define("YSFGW_INI", "/etc/YSFGateway.ini");
  define("APRS_INI", "/etc/APRSGateway.ini");

  define("LOGPATH", "/var/log/mmdvm");
  define("MMDVM_PREFIX", "DMRHost-IPSC");
  define("YSFGW_PREFIX", "YSFGateway");
  define("APRSGW_PREFIX","APRSGateway");

  define("DMRID_DAT", "/home/pi/dmrid.dat");

  // if we use IPSC2, if we use brandmeister just comment this line out
  define("IPSC", true);
?>
