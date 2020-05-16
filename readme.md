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
- servers
  - id [smallint] [key]
  - servername [tinytext]
- server_points
  - servernum [tinyint] [UNIQUE KEY]
  - t_point [tinyint]
  - ct_point [tinyint]
- server_teams
  - servernum [tinyint] [UNIQUE KEY]
  - t_name [text]
  - ct_name [text]
- users
  - id [tinyint] [KEY, AI]
  - username [text]
  - password [text]

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

After the database credentials are saved, you need to create an API key for the plugin. A simple string generator will do it, I used this [site](http://passwordsgenerator.net/) for example. You need to change the default API key to yours in "application/config/constants.php". Example:

```php
// Custom constants
defined('API_KEY')      OR define('API_KEY', "YOURAPIKEY!"); // API key
```

Next step is to configure your URL in the CI settings. This file is "application/config/config.php". You need to change this line:

```php
$config['base_url'] = 'http://mywebsite.com/radon/';
```

The last step is to configure the frontend settings. You will find a "config.js" file at "assets" folder. change the URL to your API's URL. Example:

```js
const settings = {
    url: "http://mywebsite.com/radon/api/"
}
```

### Plugin install

You need to install Sourcemod and Metamod on your Source server. You can find information about that on this website: https://wiki.alliedmods.net/Installing_SourceMod

If everything went good and the SM-MM installation was successful, you just need to copy the compiled plugin to the "csgo/addons/sourcemod/plugins" folder. The file with the .smx extension is the compiled one!

After that, you need to create a "settings.txt" file with 2 lines in it. The first line must be a number, the number of the server. The second line must be a full URL to the API. This file must be stored in the "addons/sourcemod" folder. Example content:

```
2
http://myapi.org/radon/api
```

Then <u>you need to create a "apikey.txt" file</u> with one line in it. That one line is <u>the static API key</u> you set up earlier in CI config.

### Default user

At this moment the best solution is to run a createUser request with CURL. This will do it:

```
curl -X POST -H "Content-Type: application/json" -d "{ \"username\": \"username\", \"password\": \"usernamepass\", \"key\": \"yourapikey\"  }" http://demopage.hu/radon/api/createUser
```

**Important!** For security measurements, your password needs to contain letters and numbers, and must be  minimum 8 character long.



## API Requests

### changeMap

POST */api/changeMap/[server_id]*

Request body:

```json
{
	"map": "mapname",
	"key": "youapikey"
}
```

### changeFlag

POST */api/changeMap/[server_id]*

Request body:

```json
{
	"team": 1,
	"country": "hu",
	"key": "youapikey"
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
	"name": "ITdept",
	"key": "yourapikey"
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
	"tasknum": 1,
	"key": "youapikey"
}
```

This will remove the task from the active jobs ('jobs' table) and move to the 'old_jobs' table in case, when supervision needed.

### setPoints

POST */api/setPoints/[server_id]*

Request body:

```json
{
	"ctpoint": 1,
    	"tpoint": 2,
	"key": "youapikey"
}
```

All argument should be provided

### getPoints

GET */api/getPoints/*

No request body. This one will show the points on the registered servers.

### changeStats

POST */api/changeStats/[server_id]*

Request body:

```json
{
	"txt": "\"Hello\"",
	"team1": "\"Szia\"",
	"team2": "\"Ciao\"",
	"key": "youapikey"
}
```

Team 1 is Counter-terrorists and team 2 is Terrorists. Team1 and Team2 are required to have text in it, but txt not. 

### createUser

POST */api/createUser/*

Request body:

```json
{
	"username": "yourusername",
	"password": "yourpass",
	"key": "youapikey"
}
```

This will create a user for the frontend.

### getServers

GET */api/getServers/*

No request body. This will list all of the server which registered in the database.

### addServer

POST */api/addServer/*

Request body:

```json
{
	"serverid": 1,
	"servername": "MyLittleServer",
	"key": "youapikey"
}
```

This one will register an server(id) in the database. This will appear on the frontend as a selectable server.
