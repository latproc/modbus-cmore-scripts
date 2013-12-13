#!/bin/bash
#. ./bsfl

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

${DIR}/lib/iod2Events.php -o /tmp/EvtMgr.XLS

