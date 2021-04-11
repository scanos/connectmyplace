This is a bash script which publishes a 5 day weather forecast page to your intranet and internet simultaneously



This shows how to extract data from the Openweathermap cities files which are stored in json format

In particular, we will look at city.list.json which has over 200k entries about towns and cities all over the world
It has the following format
    "id": 707860,
    "name": "Hurzuf",
    "country": "UA",
    "coord": {
      "lon": 34.283333,
      "lat": 44.549999
    }
The id is important because you may need it if you want to search weather forecast for 5 days with data every 3 hours by city ID. 
All weather data can be obtained in JSON and XML formats.
List of city ID "city.list.json.gz" can be downloaded from https://bulk.openweathermap.org/sample/
Calling API by city ID gives an unambiguous result for your city.

API call
api.openweathermap.org/data/2.5/forecast?id={city ID}&appid={API key}

The problem is that given there are 200k entries, how do you know if your town exists
One way is to use grep
 grep "Portaferry"  city.list.json
    "name": "Portaferry",

This doesn't return the city id so you can open an editor such as nano and search for the entry. Another way is to 
use a script such as searchcitylistjson.sh searchcitylistjson.sh
you can use it to search for an individual city e.g. ./searchcitylistjson.sh Portaferry
or all cities from a certain country e.g. ./searchcitylistjson.sh "UA"
./searchcitylistjson.sh Portaferry
"id": 2640084, "name": "Portaferry",

./searchcitylistjson.sh "UA"
"id": 707860, "name": "Hurzuf", "country": "UA",
"id": 708546, "name": "Holubynka", "country": "UA",
"id": 703363, "name": "Laspi", "country": "UA",
"id": 713514, "name": "Alupka", "country": "UA",
"id": 690856, "name": "Tyuzler", "country": "UA",
"id": 707716, "name": "Il’ichëvka", "country": "UA",
"id": 697959, "name": "Partyzans’ke", "country": "UA",

ETC ETC

You can also use countycitylistjson.sh to count the number of entries in city.list.json, over 200k
