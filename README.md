Escapology [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/badges/build.png?b=master)](https://scrutinizer-ci.com/g/RonnieSkansing/Escapology/build-status/master)
========================
A front controller to put in front of your impossible-to-ever-refactor-into-clean-code codebase/framework.

The primary intention is to slowly and safely migrate away from a legacy codebase and into a new modern approach.
	
CAUTION		
-------------------------
- Unstable. The API may change at any time for any reason


Requirements
-------------------------
Tested against PHP 5.4, 5.5, 5.6, 7, hhvm.   
 
When to use
-------------------------
Use when your application is a terrible mess and your new go-to codebase/framework is fully loaded when it hits the front controller (maybe you should consider another framework?). An example of this could be migrating from CodeIgniter/Yii to Laravel 5. 
At the time your clients hit Laravels front controller (router), Laravel already booted up a massive application. The performence hit of booting up the entire framework work only to route it the old application is too much. Instead put up this library to handle the routing between old and new application until you can remove both this libary and the old application.

Suggested alternatives
--------------------------
Your new clean code dispatches to the old application if the route is not found, because it is fully decoupled and super fast from day 1. 

How to use
--------------------------
See the examples folder for examples.

**Suggested Path of migration**

1. Stop building new functionality in your old codebase.
2. Setup a new codebase.
3. Setup the Escapology front controller, feed it the front controller of your old and new code base.
4. Feed the new front controller either a static route file or your new codebases.
5. Routes found in the new code base will be send to the new code base, any not found will be send to the old codebase. 
6. Migrate the old codebase bit by bit to the new one. 
7. When all of the old codebase is gone, remove Escapology and replace it with the real front controller.

TODO
--------------------------
- Add a "Yo Dawg, I heard you like front controllers .."
- Escape plans for frameworks like CodeIgniter, Yii and etc.

Credits 
---------------------------
This package regex routing is highly inspired by Nikita Popov's [FastRoute](https://github.com/nikic/FastRoute/) library
