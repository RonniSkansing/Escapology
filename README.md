Escapology [![Build Status](https://travis-ci.org/RonnieSkansing/Escapology.svg?branch=master)](https://travis-ci.org/RonnieSkansing/Escapology)
========================
A front controller to put in front of your impossible-to-ever-refactor-into-clean-code codebase/framework.

The primary intention is to slowly and safely migrate away from a legacy codebase and into a new modern approach.
	
CAUTION		
-------------------------
- Unstable. The API may change at any time for any reason


Requirements
-------------------------
Tested against PHP 5.4, 5.5, 5.6, 7, hhvm.   
 
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
- Make route file parser for popular frameworks to avoid having to maintain replicate routes in this frontal router and the new application. 
- Tests
- Escape plans for frameworks like CodeIgniter, Yii and etc.

Credits 
---------------------------
This package regex routing is highly inspired by Nikita Popov's [FastRoute](https://github.com/nikic/FastRoute/) library
