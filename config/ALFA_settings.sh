#!/bin/bash

#If you installed arduino-cli with brew this should be fine
#Otherwise please set to the correct directories

export ARDUINO_CLI_BIN=$(which arduino-cli)
export ARDUINO_HOME_DIR=~/Arduino/
export LIBRARY_DIR="$ARDUINO_HOME_DIR""libraries/"


