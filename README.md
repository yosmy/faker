# Dev

docker network create backend

docker-compose \
-f docker/all.yml \
-p yosmy_faker \
up -d

# Generate country data

docker exec -it yosmy_faker_php sh

php vendor/mledoze/countries/countries.php convert \
-i cca2 \
-i callingCode \
--format=json_unescaped \
--output-dir=./data

mv data/countries-unescaped.json data/countries.json

exit

docker-compose \
-f docker/all.yml \
-p yosmy_faker \
stop