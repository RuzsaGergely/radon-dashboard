# Radon dashboard

## Install

### API install

The API is based on the Codeigniter framework with an MySQL database. For the API, you need to install:

- Apache2 (webserver)
- MySQL (database)

For Apache, you need to enable [AllowOverride](http://httpd.apache.org/docs/2.4/mod/core.html#allowoverride) directive in the config file, because of the .htaccess file.

For MySQL you don't need any special configuration, just a database and a user with rights on it.

The database will have these tables:

- jobs
  - tasknum [smallint] [KEY, AI]
  - servernum [tinyint]
  - task [text]
- old_jobs
  - tasknum [smallint]
  - servernum [tinyint]
  - task [text]
- server_points
  - servernum [tinyint] [UNIQUE KEY]
  - t_point [tinyint]
  - ct_point [tinyint]
- server_teams
  - servernum [tinyint] [UNIQUE KEY]
  - t_name [text]
  - ct_name [text]

Or, you can import the premade template SQL file.

If the database and the webserver is up and running, then, you need to configure the database access in the CI config file. The config file is at "application/config/database.php". You need to change credentials respectively to your situation. Example:

```php
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'EXAMPLEUSER',
	'password' => 'EXAMPLEPASS',
	'database' => 'RadonDB',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
```

### Plugin install

You need to install Sourcemod and Metamod on your Source server. You can find information about that on this website: https://wiki.alliedmods.net/Installing_SourceMod

If everything went good and the SM-MM installation was successful, you just need to copy the compiled plugin to the "csgo/addons/sourcemod/plugins" folder. The file with the .smx extension is the compiled one!

After that, you need to create a "settings.txt" file with 2 lines in it. The first line must be a number, the number of the server. The second line must be a full URL to the API. This file must be stored in the "addons/sourcemod" folder. Example content:

```
2
http://myapi.org/radon/api
```



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