CMD=docker exec -u root -it twitter-copy_twitter_copy_1

bash_php:
	$(CMD) /bin/bash

install:
	$(CMD) composer install

setup:
	$(CMD) bin/console d:d:d -f;true
	$(CMD) bin/console d:d:c;true
	$(CMD) bin/console d:m:m --no-interaction
	$(CMD) bin/console assets:install
	$(CMD) bin/console cache:warmup
	$(CMD) bin/console cache:clear

# Variables
stack_name=keycloak

keycloak_container_id = twitter-copy_keycloak_1

.PHONY: im
im:
	docker cp ./import/$(realm)-realm.json $(keycloak_container_id):/tmp/realm.json
	docker exec -it $(keycloak_container_id) /opt/jboss/keycloak/bin/standalone.sh -Dkeycloak.migration.action=import \
		-Dkeycloak.migration.provider=singleFile \
		-Dkeycloak.migration.file=/tmp/realm.json \
		-Dkeycloak.import=/tmp/realm.json \
		-Dkeycloak.migration.strategy=OVERWRITE_EXISTING \
		-Djboss.http.port=8888 -Djboss.https.port=9999 -Djboss.management.http.port=7777

.PHONY: ex
ex:
	docker exec -it $(keycloak_container_id) /opt/jboss/keycloak/bin/standalone.sh -Dkeycloak.migration.action=export \
		-Dkeycloak.migration.provider=singleFile \
		-Dkeycloak.migration.realmName=$(realm) \
		-Dkeycloak.migration.usersExportStrategy=REALM_FILE \
		-Dkeycloak.migration.file=/tmp/realm.json \
		-Djboss.http.port=8888 -Djboss.https.port=9999 -Djboss.management.http.port=7777
	docker cp $(keycloak_container_id):/tmp/realm.json ./import/$(realm)-realm.json

.PHONY: deploy
deploy:
	docker stack deploy -c docker-compose.yml $(stack_name)

.PHONY: undeploy
undeploy:
	docker stack rm $(stack_name)
