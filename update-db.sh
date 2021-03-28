#!/bin/bash
# Get an actual dmrid.dat file from radioid.net

# This file got some more logic to also handle backups,
# the code for that was taken from YSFHostsupdate.sh from
# YSFClients:
# https://github.com/g4klx/YSFClients/blob/master/DGIdGateway/YSFHostsupdate.sh
#
###############################################################################

###############################################################################
#
# YSFHostsupdate.sh
#
# Copyright (C) 2016 by Tony Corbett G0WFV
# Adapted to YSFHosts by Paul Nannery KC2VRJ on 6/28/2016 with all crdeit 
# to G0WFV for the orignal script.
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#
###############################################################################

DMRIDFILE=dmrid.dat
BACKUPS=1

if [ ${BACKUPS} -ne 0 ]
then
  cp ${DMRIDFILE} ${DMRIDFILE}.$(date +%Y%m%d)
fi

COUNT=$(ls ${DMRIDFILE}.* | wc -l)
TODELETE=$(expr ${COUNT} - ${BACKUPS})

if [ ${COUNT} -gt ${BACKUPS} ]
then
  for f in $(ls -tr ${DMRIDFILE}.* | head -${TODELETE})
  do
    rm -f $f
  done
fi

curl https://www.radioid.net/static/dmrid.dat > ${DMRIDFILE}

exit 0

