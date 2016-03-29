#!/usr/bin/env bash

case $1 in
	"getConfig")
		cat "$2"
		;;
	"setConfig")
		echo $2 | tee $3 > /dev/null
		;;
	"reloadConfig")
		ajenti-ipc vmail apply
		;;
	*)
		echo "Unknown Command $1. getConfig, setConfig, reloadConfig."
		;;
esac