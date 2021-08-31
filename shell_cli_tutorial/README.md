

foo=$(grep "London" "cities" | ( read foo; echo $foo))
echo $foo
London 1630433087
arrIN=(${foo// / })
 $ echo ${arrIN[1]}
1630433087
D1=$(echo ${arrIN[1]})
D2=$(date +%s)
echo "$(((D2-D1)/86400)):$(date -u -d@$((D2-D1)) +%H:%M)"
0:02:24
