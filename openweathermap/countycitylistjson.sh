#!/bin/bash
i=0
input="city.list.json"
while IFS= read -r line
do

if [[ $line == *"\"id\""* ]]; then
i=$((i+1))
fi

done < "$input"

echo count $i
