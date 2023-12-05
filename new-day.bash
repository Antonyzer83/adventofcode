#!/bin/bash

year=$1
day=$2

if [ -z "$year" ] || [ -z "$day" ]; then
    echo "Please provide year and day"
    exit 1
fi

mkdir -p $year/$day
cp -a ./starter/. $year/$day
