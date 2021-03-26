#!/bin/bash
input="city.list.json"
while IFS= read -r line
do

#if [[ $line == *"\"LB\""* ]]; then
if [[ $line == *"\"id\""* ]]; then
unset my_cities
declare -a my_cities
fi

my_cities+=($line)

#if [[ $line == *"\"LB\""* ]]; then
if [[ $line == *"\"$1"* ]]; then

#  echo "$line"
echo "${my_cities[*]}"

fi

done < "$input"

