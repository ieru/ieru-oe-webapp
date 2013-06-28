IERU Organic Edunet Web App
===========================

About
-----

Organic.Edunet is, at its core, a multilingual search engine. With this in mind, the architecture has been developed to be platform-independent, and also it has not been developed with any specific programming language in mind. If designed correctly, the entire Organic.Edunet search service can be implemented on any language, and be exploited by any means: website, mobile app, desktop app, etc. All the services involved in the project are standalone, so they can be used by other projects around the world.


Technical requirements
----------------------

For installing the Organic Edunet web app, a server with the following tools installed is required:

* PHP 5.3
* MySQL 5.5
* Apache
* Modules: mod_rewrite
* Git
* Composer (http://getcomposer.org)

The file of the virtual hosts of the Apache server should be something like this: 

```
<virtualhost *:80>
     serveradmin  david@teluria.es
     documentroot "/users/david/sites/github/ieru-oe-webapp/public"
     servername   edunet.dev
     serveralias  www.edunet.dev

     <directory /users/david/sites/github/ieru-oe-webapp/public>
         options indexes followsymlinks multiviews
         allowoverride all
         order allow,deny
         allow from all
     </directory>
</virtualhost>
```

Laravel uses the file /public/index.php as the starting point of the website, so Apache must point to the /public directory.

Installation
------------

**Install the web app**

Clone the Github project of the api server to a folder.
```
~/Sites/github $> git clone https://github.com/ieru/ieru-oe-webapp
~/Sites/github $> cd ieru-oe-webapp
~/Sites/github/ieru-oe-webapp $> composer install
```

Configure the server where the API server is going to be located in the file /public/js/app.js. Change the variable "api_server" with the proper value:

```
var api_server = 'http://api.dev';
```

**Install the APIs**

Check the github project for installation instructions of the API server (https://github.com/ieru/ieru-api-server).

**Databases installation**

Import to the local server the ieru_organic_resources.sql, ieru_organic_oauth.sql and ieru_organic_analytics.sql files (if not already installed through the API server installation).

**Success!**

Check that everything is working accessing the following URLs:

```
http://www.api.dev/api/analytics/translate?text=potato&from=en&to=es
http://edunet.dev
```

Standalone installation
=======================

You can find a full version of the Organic.Edunet project (updated from time to time with the latest version) in the folder /_standalone of the project. 

Requisites
----------

* PHP 5.3 (http://php.net/download)
* MySQL 5.5 (http://dev.mysql.com/downloads/mysql/)
* Apache server (must have the mod_rewrite module activated)

Use your Linux or OS X package manager of choice or download and install from the given links. In Windows, use a package like WampServer (http://www.wampserver.com/en/) that includes the php, mysql and apache server applications.

Installation
------------

For installing the project, follow these steps:

* Download and unzip to your local server directory the file /_standalone/organic-edunet_0.1.zip.
* Import the three SQL files you will find in there to your local MySQL database. You will have to create three distinct databases with the names of the .sql files, but removing the .sql extension.
* Access the URL of your localhost (usually http://localhost) and you should see the website working.





