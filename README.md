## dmr-dashboard

by Dominic Reich OE7DRT

**This is under development and may not work properly.** Please don't create issues
but create patches and send pull requests.

### About

This is a very simple dashboard for **DMR only**. It loops through the logfile of
MMDVMHost and displays the information that you already know from Pi-Star.

This dashboard is for people that don't know how to code one for theirself. As I'm
not a good programmer there might be still a lot of bugs, but the board works for me
and I do not have high standards to meet - I just want a simple dashboard that I can
also look at from my phone. Otherwise I would rather look into the logs on the command
line.

### Installation

Copy all files into your webroot and modify `config.php` to your needs.

If you want to see Callsigns instead of DMR-IDs then place a file `dmrids.dat` in your
webroot. Run `update-db.sh` in this folder to get an actual `dmrid.dat` file.

You may also want to create an automated job for this (cron).

### Licenses

Some code (Stylesheet) was taken from Pi-Star by Andy Taylor.

The rest (php) is published using the MIT License.

