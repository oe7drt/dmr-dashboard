<?php

/* 
 * index.php
 * Dashboard for YSFGateway
 * Dominic Reich, OE7DRT, oe7drt@oevsv.at
 *
 */

  $time_start = microtime(true);
  include("conf.php");
  include("func.php");

?><html>
<head>
  <meta name=viewport content="width=device-width,initial-scale=1">
  <meta name=generator content="Sublime Text 3 / Vim">
  <meta name="author" content="Dominic Reich">
  <title>OE7DRT DMR Hotspot Dashboard</title>
  <link rel="stylesheet" type="text/css" media="screen" href="dash.min.css" />
  <meta http-equiv="refresh" content="60">
</head>
<body>
  <div class="container">
    <div class="header">
      <div style="font-size: 0.9em; text-align: left; padding-left: 8px; float: left; max-width: 65%">
        Hostname: <?php echo trim(`hostname`); ?> (<?php echo trim(`hostname -I | cut -d' ' -f1`); ?>)<br />
        <?php
          $iniFile  = MMDVM_INI;
          $logline  = `egrep -h "^Options=\"" $iniFile | tail -n 1`;

          if( !empty( $logline )) {
            //$options  = substr($logline, strpos($logline, "Options="));
            $optionsLine = explode( "\"", $logline );
            $options = explode( ";", $optionsLine[1] );
            echo "DMR Options: ";
            foreach( $options as $option ) {
              echo "$option ";
            }
          } else {
            $logline = `grep "DMR Network" $iniFile -A 10 | egrep "^Address"`;
            $addressLine = explode( "=", $logline );

            $logline = `grep "DMR Network" $iniFile -A 10 | egrep "^Port"`;
            $portLine = explode( "=", $logline );

            if( defined( "DNS" )) {
              $address = strstr( `nslookup $addressLine[1]`, "=" );
              $dns = substr( $address, 2, strrpos( $address, "." ) - 2);

              echo "BM Master: $dns:" . trim( $portLine[1] );
            } else {
              echo "BM Master: " . trim( $addressLine[1] ) . ":" . trim( $portLine[1] );
            }
          }
        ?>
      </div>
      <div style="font-size: 0.9em; text-align: right; padding-right: 8px;"><?php
        echo date("d.m.Y H:i:s T") . "<br />\n";
        echo "Uptime: " . getUptime();
      ?></div>
      <a href="/" style="color: #ffffff;"><h1>Dashboard for DMR Hotspot OE7DRT</h1></a>
      <p style="padding-right: 5px; text-align: right; color: #ffffff;">
        <a href="/" style="color: #ffffff;">Dashboard</a>
        | <a href="http://srv05.oevsv.at/ipsc/" style="color: #ffffff;" target="_blank">
          IPSC2-OE-DMO</a>
        | <a href="http://srv07.oevsv.at/ipsc/" style="color: #ffffff;" target="_blank">
          IPSC2-OE-MASTER</a>
        | <a href="http://srv08.oevsv.at/ipsc/" style="color: #ffffff;" target="_blank">
          IPSC2-OE-MLINK</a>
      </p>
      <div style="font-size: 8px; text-align: left; padding-left: 8px; ">
      </div>
    </div>
    <div class="content">
      <table id="toptable" align="center">
        <tr>
          <th>Model</th>
          <th>CPU Freq.</th>
          <th>Load</th>
          <th>Temp.</th>
        </tr>
        <tr>
        <td><?php echo trim( `cat /sys/firmware/devicetree/base/model` ); ?> (<?php echo trim( `uname -sr` ); ?>)</td>
          <td><?php echo round((int)`cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq` / 1000) . " MHz"; ?></td>
          <td><?php echo str_replace(","," /",implode(", ", explode(" ", `cat /proc/loadavg`, -2))); ?></td>
          <td><?php echo round((int)`cat /sys/class/thermal/thermal_zone0/temp` / 1000) . "°C"; ?></td>
        </tr>
      </table>
  <table align="center">
    <tr>
      <th>Time (<?php echo date("T"); ?>)</th>
      <th>Station</th>
      <th>Slot</th>
      <th>Talkgroup</th>
      <!-- <th>Source/Repeater</th> -->
      <th>Duration</th>
      <th>Loss</th>
      <th>BER</th>
    </tr>
<?php
  getLastHeard();
?>
  </table>
<?php
  !defined("DEBUG") ?: printLogs();
  //printLogs();
?>
</div>
<div class="footer">
    <div style="font-size: 1.2em; text-align: right; padding-right: 8px;">
      <a href="https://oe7drt.com" style="color: #ffffff;"
        target="_blank">OE7DRT Website</a>
      &middot; <a href="https://github.com/oe7drt/dmr-dashboard" style="color: #ffffff;"
        target="_blank">This dashboard on github.com</a>
    </div>
    This dashboard has been put together by
    <a href="https://oe7drt.com/" style="color: #ffffff;">Dominic, OE7DRT</a>.
    It looks like Pi-Star. Just in case you did not notice ;-)
</div>
</body>
</html>

<!-- <?php $time_end = microtime(true); echo (round($time_end - $time_start, 3)*1000)." ms execution time"; ?> -->
