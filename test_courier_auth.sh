#!/bin/bash

RAW_PASS_ONE=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 10 | head -n 1)
RAW_PASS_TWO=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 10 | head -n 1)

PASS_CRYPT=$(echo $RAW_PASS_ONE | userdbpw)
PASS_MD5=$(echo $RAW_PASS_TWO | userdbpw -md5)

userdb spam@janbrodda.de set systempw=$PASS_CRYPT
makeuserdb
echo "checking raw"
authtest spam@janbrodda.de $RAW_PASS_ONE

userdb spam@janbrodda.de set systempw=$PASS_MD5
makeuserdb
echo "checking md5"
authtest spam@janbrodda.de $RAW_PASS_TWO
