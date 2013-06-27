IERU Organic Edunet Wen App
---------------------------

For installing the Analytics Service, a server with the following tools installed is required:

* PHP 5.4
* MySQL 5.5
* Apache
* Modules: mod_rewrite
* Git
* Composer (http://getcomposer.org)

The file of the virtual hosts of the Apache server should be something like this: 

```
<virtualhost *:80>
     serveradmin  david@teluria.es
     documentroot "/users/david/sites/github/api-server"
     servername   edunet.dev
     serveralias  www.edunet.dev

     <directory /users/david/sites/github/api-server>
         options indexes followsymlinks multiviews
         allowoverride all
         order allow,deny
         allow from all
     </directory>
</virtualhost>
```

Installation
------------

**Install the REST engine**

Clone the Github project of the api server to a folder.
```
~/Sites/github $> git clone https://github.com/ieru/ieru-api-server
```

**Install the APIs**

Check the github project for installation instructions of the API server (https://github.com/ieru/ieru-oe-webapp).

**Database installation**

Import to the local server the ieru_organic_oauth.sql and ieru_organic_analytics.sql files.

**Success!**

Check that everything is working accessing the following URLs:

```
http://www.api.dev/api/analytics/translate?text=potato&from=en&to=es
http://edunet.dev
```