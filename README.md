Footy Lineups
=============

A simple PHP + JavaScript application that allows users to create football formations and share them with friends.

Demo at http://play.abcruz.com/footy-lineups

Dedicated to the Public Domain on 11 May 2014.

Testing
-------

* Install PHP5-CLI.
* In a terminal, navigate to this directory.
* Run: php -S 0.0.0.0:5000 (must be the same address[:port] as in settings.php)

Production
----------

* Must have a PHP5-capable webserver.
* Open settings.php and modify SITE_DOMAIN constant accordingly.  
  It should point to where footy-lineups is installed. For example,  
  http://play.abcruz.com/footy-lineups is the value in the demo site.  
  DO NOT put a trailing slash.
* Ensure that the lineups directory is writable by the system user that runs the webserver.  
  DO NOT set it to 0777! Bad things can happen.

TODO
----

Maybe create preset formations? Dunno.

