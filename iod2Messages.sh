#!/bin/bash
#. ./bsfl

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

${DIR}/lib/iod2Messages.php -o /tmp/MsgDB.XLS

