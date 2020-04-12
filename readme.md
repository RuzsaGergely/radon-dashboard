# Radon dashboard

## Install

## Requests

### changeMap

POST */api/changeMap/[server_id]*

Request body:

```json
{
	"map": "de_dust2"
}
```

Available maps:

- de_dust2
- de_inferno
- de_train
- de_mirage
- de_nuke
- de_overpass
- de_verigo



### changeFlag

POST */api/changeMap/[server_id]*

Request body:

```json
{
	"team": 1,
	"country": "hu"
}
```

Team 1 is Counter-terrorists and team 2 is Terrorists.

For the "country" parameter, you must supply an 2 character long country ISO code. For all ISO codes, there are a [website](https://www.iban.com/country-codes). Don't forget, you need 2 character long ISO codes!



### changeTeamname

POST */api/changeTeamname/[server_id]*

Request body:

```json
{
	"team": 1,
	"name": "ITdept"
}
```

Team 1 is Counter-terrorists and team 2 is Terrorists.



### getTasks

GET */api/getTasks/[server_id]*

This will return the jobs on the list, for the specified server.



### doneTask

POST */api/doneTask/[server_id]*

Request body:

```json
{
	"tasknum": 1
}
```

This will remove the task from the active jobs ('jobs' table) and move to the 'old_jobs' table in case, when supervision needed.



### setPoints

POST */api/setPoints/[server_id]*

Request body:

```json
{
	"ctpoint": 1,
	"tpoint": 2
}
```

Both argument should be provided.



### getPoints

GET */api/getPoints/*

No request body.



### changeStats

POST */api/changeStats/[server_id]*

Request body:

```json
{
	"txt": "\"Hello\"",
	"team1": "\"Szia\"",
    "team2": "\"Ciao\""
}
```

Team 1 is Counter-terrorists and team 2 is Terrorists. All argument should be provided, else it will be rejected.