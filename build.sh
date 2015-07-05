#!/bin/bash

WHERE=`pwd`

TGZ_NAME="jphp-2.1-1.tgz"
DIR_NAME="jphp"

cd ..
tar -cvz --exclude=OLD --exclude=*.webprj --exclude=work --exclude=*~ --exclude=CVS --exclude=.?* --exclude=np --exclude=.cvsignore -f $TGZ_NAME $DIR_NAME
cd "$WHERE"
