<?php

/* 
 * func.php
 * Dashboard for YSFGateway
 * Manually compiled and configured MMDVMHost without DMRGateway
 * connecting to IPSC2-OE-DMO Server 89.185.97.34 (srv05.oevsv.at)
 *
 */

function getUptime() {
  $uptime = intval( `cat /proc/uptime | awk '{ print $1 }'` );
  if( $uptime >= 60 ) {
    // in minutes
    $minutes = intval( $uptime / 60 );
    $seconds = $uptime % 60;
    if( $minutes >= 60 ) {
      $hours = intval( $minutes / 60 );
      $minutes = $minutes % 60;
      if( $hours >= 24 ) {
        $days = intval( $hours / 24 );
        $hours = $hours % 24;
        $out = "$days days $hours hours $minutes minutes and $seconds seconds";
      } else {
        // no days, only hours minutes and seconds
        $out = "$hours hours $minutes minutes and $seconds seconds";
      }
    } else {
      // mintes < 60 only minuts, hours
      $out = "$minutes minutes and $seconds seconds";
    }
  } else {
    // only seconds
    $out = "$uptime seconds";
  }

  return $out;
}

function ImportDB() {

  $contents = array();
  
  if( $file = fopen( DMRID_DAT, 'r' )) {
    if( !defined("NONAMES")) {
      while( !feof( $file )) {
        $line = fgetss( $file, 64 );
        $elem = explode( ";", $line );
        array_push( $contents, $elem );
      }
    }
    fclose( $file );
  }
  
  return $contents;
}

function CallsignLookupDB( $id ) {
  // $call = "<a href=\"https://www.radioid.net/database/view?id=$call\"" . " target=\"_blank\">$call</a>";

  global $mem;

  if( !empty( $mem )) {

    foreach( $mem as $key => $val ) {
      if( $val[0] === $id ) {
        $call = $mem[$key];
        $callsign = $call[1];
        
        $call_code = "<a href=\"https://qrz.com/db/$callsign\"" . " target=\"_blank\">$callsign</a>";
        
        return $call_code;
      }
    }
  }

  $call_code = "<a href=\"https://www.radioid.net/database/view?id=$id\"" . " target=\"_blank\">$id</a>";

  return $call_code;
}

function linkCallsign( $callsign ) {
  $tmp = explode( "-", $callsign );
  $call = trim( $tmp[0] );
  $suffix = ( !empty( $tmp[1] ))
    ? "-$tmp[1]"
    : "";

  if( !empty( $suffix )) {
    $suffix="-$suffix";
  }

  if( !is_numeric( $call )) {
    $call = "<a href=\"https://qrz.com/db/$call\" target=\"_blank\">$call" . "</a>$suffix";
  } elseif( strlen( $call ) == 7 ) {
    // old version linked to ham-digital which now is fusioned into radioid.net
    //$call = "<a href=\"https://ham-digital.org/dmr-userreg.php?usrid=$call\"" . " target=\"_blank\">$call</a>";
    $call = CallsignLookupDB( $call );
  } elseif( strlen( $call ) == 6 ) {
    $call = "<a href=\"https://www.radioid.net/map?locator=$call\"" . " target=\"_blank\">$call</a>";
  } elseif( strlen( $call ) == 4 ) {
    //$call = "Reflector $call";
  }

  return $call;
}

function linkTG( $tg ) {
  if( !is_numeric( $tg ) && !defined("NOTGLINK")) {
    $tmp = explode( " ", $tg );
    $tg_id = trim( $tmp[1] );
    $tg_new = "<a href=\"https://brandmeister.network/?page=lh&DestinationID=$tg_id\" target=\"_blank\">$tg</a>";

    return $tg_new;
  }

  return $tg;
}

function rssiCalcImg( $val ) {
  if( $val > -53 ) $rssi       = "<img title=\"S9 +40dB\" alt=\"S9 +40dB\" src=\"img/4.png\">";
  else if( $val > -63 ) $rssi  = "<img title=\"S9 +30dB\" alt=\"S9 +30dB\" src=\"img/4.png\">";
  else if( $val > -73 ) $rssi  = "<img title=\"S9 +20dB\" alt=\"S9 +20dB\" src=\"img/4.png\">";
  else if( $val > -83 ) $rssi  = "<img title=\"S9 +10dB\" alt=\"S9 +10dB\" src=\"img/4.png\">";
  else if( $val > -93 ) $rssi  = "<img title=\"S9\" alt=\"S9\" src=\"img/4.png\">";
  else if( $val > -99 ) $rssi  = "<img title=\"S8\" alt=\"S8\" src=\"img/3.png\">";
  else if( $val > -105 ) $rssi = "<img title=\"S7\" alt=\"S7\" src=\"img/3.png\">";
  else if( $val > -111 ) $rssi = "<img title=\"S6\" alt=\"S6\" src=\"img/2.png\">";
  else if( $val > -117 ) $rssi = "<img title=\"S5\" alt=\"S5\" src=\"img/2.png\">";
  else if( $val > -123 ) $rssi = "<img title=\"S4\" alt=\"S4\" src=\"img/1.png\">";
  else if( $val > -129 ) $rssi = "<img title=\"S3\" alt=\"S3\" src=\"img/1.png\">";
  else if( $val > -135 ) $rssi = "<img title=\"S2\" alt=\"S2\" src=\"img/0.png\">";
  else if( $val > -141 ) $rssi = "<img title=\"S1\" alt=\"S1\" src=\"img/0.png\">";

  return "$rssi";
}

function rssiCalc( $val ) {
  if( $val > -53 ) $rssi = "S9+40dB";
  else if( $val > -63 ) $rssi = "S9+30dB";
  else if( $val > -73 ) $rssi = "S9+20dB";
  else if( $val > -83 ) $rssi = "S9+10dB";
  else if( $val > -93 ) $rssi = "S9";
  else if( $val > -99 ) $rssi = "S8";
  else if( $val > -105 ) $rssi = "S7";
  else if( $val > -111 ) $rssi = "S6";
  else if( $val > -117 ) $rssi = "S5";
  else if( $val > -123 ) $rssi = "S4";
  else if( $val > -129 ) $rssi = "S3";
  else if( $val > -135 ) $rssi = "S2";
  else if( $val > -141 ) $rssi = "S1";

  return "$rssi ($val dBm)";
}

function printTable( $id=0, $time, $callsign, $slot, $tg, $duration, $loss = "---", $ber = "---" ) {
  if( $duration >= 60 ) {
    $min = str_pad( intval( $duration / 60 ), 2, "0", STR_PAD_LEFT );
    $sec = str_pad( $duration % 60, 2, "0", STR_PAD_LEFT );
    $duration = "$min:$sec";
  } else {
    $duration = "00:" . str_pad( $duration, 2, "0", STR_PAD_LEFT );
  }
  echo "  <tr>\n" .
    "<td>$id</td>\n" .
    "<td>$time</td>\n" .
    "<td>" . linkCallsign( $callsign ) ."</td>\n" .
    "<td>$slot</td>\n" .
    "<td>" . linkTG( $tg ) . "</td>\n" .
    "<td>$duration</td>\n" .
    "<td>$loss</td>\n" .
    "<td>$ber</td>\n" .
  "</tr>\n";
}

function getLastHeard($limit = MAXENTRIES) {
  $logPath = LOGPATH."/".MMDVM_PREFIX."-*.log";
  $logLines =  explode( "\n", `egrep -h "DMR Slot" $logPath` );

  $oldline = "";

  $time     = "";
  $loss     = "";
  $ber      = "";
  $rssi     = "";
  $call     = "";
  $duration = "";
  $repeater = "";

  $printLines = [];

  foreach( $logLines as $line ) {
  	if( empty( $oldline ) && strpos( $line, "network watchdog has expired" )) {
      // $oldine=$line;
      continue;
    }

  	if( strpos( $line, "RF end of voice transmission" )) {
        $time = date( "Y-m-d H:i:s", strtotime( substr( $line, 3, 24 )." UTC" ));
        $callsign = substr( $line, 82, strpos( $line, "to" ) - 82 );
        $slot = substr( $line, 36, strpos( $line, ",") -36);
        $tg = substr( $line, 93, strpos( $line, ",", 93 ) - 93 );
        $duration = round( trim( substr( $line, 103, strpos( $line, "seconds,", 103 ) - 103 ), " ," ));
        $rssi_values = explode( "/", substr( $line, 133, strpos( $line, "dBm", 133 ) - 133 ));
        $loss = rssiCalcImg( round( array_sum( $rssi_values ) / count( $rssi_values )));
        $ber = substr( $line, 120, strpos( $line, ",", 120 ) - 120 );
        if( empty( $ber )) $ber = "---";
  	} elseif( strpos( $line, "received network voice header" )) {
  		if( strpos( $oldline, "received network voice header" )) {
        $oldline = $line;
  			continue;
  		} else {
        $time = date( "Y-m-d H:i:s", strtotime( substr( $line, 3, 24 )." UTC" ));
  			$old_time = strtotime( $time );
        $oldline=$line;
        continue;
  		}
  	} elseif( strpos( $line, "received network end of voice" )) {
      $time = date( "Y-m-d H:i:s", strtotime( substr( $line, 3, 24 )." UTC" ));
		  $callsign = substr( $line, 87, strpos( $line, "to ") - 87 );
      $slot = substr( $line, 36, strpos( $line, ",") - 36);
		  $tg = substr(
        $line,
        strpos( $line, "to " ) + 3,
        strpos( $line, ",", strpos( $line, "to " ) + 3 ) - strpos( $line, "to " ) - 3
      );
      
      $duration = substr(
        $line,
        strpos( $line, "to " ) + strlen( $tg ) + 5,
        strpos( $line, " seconds," ) - strpos( $line, "to " ) - strlen( $tg ) - 5
      );
		  $loss = substr(
        $line,
        strpos( $line, "seconds, " ) + 9,
        strpos( $line, " packet loss" ) - strpos( $line, "seconds, " ) - 9
      );
      /*if( $loss == "0%" ) {
        $loss = "-x-";
      }*/
		  $ber = substr(
        $line,
        strpos( $line, "BER: " ) + 5,
        strpos( $line, "%", strpos( $line, "BER: ")) - strpos( $line, "BER: " )
      );
      //if( $ber == "0.0%" ) $ber = "-x-";
      $rssi = "";
  	} else {
  		continue;
  	}
      // echo "<pre><code>\$callsign: $callsign at \$dgid: $dgid\n\$old_time: ".date("Y-m-d H:i:s", $old_time ).
      //   "\n\$new_time: ".date("Y-m-d H:i:s", $new_time )."</code></pre>\n";

  	// echo "<pre><code>OLD LINE: $oldline\nLINE: $line\n</code></pre>\n";

	$tmp = [];
	$tmp['time'] = $time;
	$tmp['callsign'] = $callsign;
  $tmp['slot'] = $slot;
	$tmp['tg'] = $tg;
	$tmp['duration'] = round( $duration, 0, PHP_ROUND_HALF_UP );
	$tmp['loss'] = $loss;
	$tmp['ber'] = $ber;
	array_unshift( $printLines, $tmp );
	unset( $tmp );

  	// Lastly we set $oldline as the actual line
  	$oldline = $line;
  }

  $c = 0;
  
  foreach( $printLines as $key=>$line ) {
    printTable(
      $c + 1,
      $line['time'],
      $line['callsign'],
      $line['slot'],
      $line['tg'],
      $line['duration'],
      $line['loss'],
      $line['ber']
    );
    if( ++$c >= MAXENTRIES ) break;
  } // end foreach $printLines
} // end function

function printLogs($limit = MAXLOGENTRIES) {
  $logPath  = LOGPATH."/*-".gmdate("Y-m-d").".log";
  $logLines = explode("\n", `tail -n $limit $logPath`);

  echo "\n<!-- start logfile output -->\n<h2>DEBUG LOGFILES OUTPUT</h2>\n";
  echo "<div style=\"text-align:left;font-size:0.8em;\"><code><pre>\n";

  foreach( $logLines as $line ) {
    if ( substr( $line, 0, 4) == "==> " ) {
      echo "<strong style=\"font-size:1.3em;\">$line</strong>\n";
    } else {
      echo "$line\n";
    }
  }

  echo "\n</pre></code></div>\n<!-- end logfile output -->\n\n";
  return 0;
}

