#!/usr/bin/bash

BASEDIR=$(readlink -f $0 | xargs dirname)
CFGFILE="$BASEDIR""/config/ALFA_settings.sh"
source "$CFGFILE"

IFS="
"

echo $BASEDIR
echo $CFGFILE
echo $LIBRARY_DIR


REPO="$1"
VERSION="$2"
cd "$LIBRARY_DIR"

#git clone "$REPO"
RDIR=$(basename "$REPO" ".git")
cd "$RDIR"

tags=$(git tag | grep "^""$VERSION")
if [ "$tags" == "" ]
then
	tags=$(git tag | grep -i "^v""$VERSION")
fi

if [ "$tags" != "" ]
then
	git checkout "tags/""$tags"
fi