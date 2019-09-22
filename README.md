Make directory `temp/` and in the temp `log/`,`cache/`,`sessions/`. Set `chmod 0777 temp, chmod 0777 log, chmod 0777 cache, chmod 0777 sessions`.  

run
- npm install
- composer install

duplicate
- app/config/config.local.neon.sample -> app/config/config.local.neon
	- change <DB_HOST>
	- change <DB_NAME>
	- change <DB_USER>
	- change <DB_PASSWORD>
	
Create employees table in your database -> sql in table.sql

Start the server by 

	php -S localhost:8000 -t www


Or setup virtual host to point to the `www/` directory of the project.


Should be ready to go.

You can start by importing `dummy/dummy_data.xml` in UI `http://{host}/employees/import`.