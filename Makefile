.PHONY: up
up: 
	docker compose -f "./compose.$(app).yml" up -d 

.PHONY: down
down:
	docker compose -f "./compose.$(app).yml" down --rmi local --remove-orphans