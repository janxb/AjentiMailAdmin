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
	"unblockFail2ban")
    	fail2ban-client set $2 unbanip $3
    	;;
	*)
		echo "Unknown Command $1. getConfig, setConfig, reloadConfig."
		;;
esac