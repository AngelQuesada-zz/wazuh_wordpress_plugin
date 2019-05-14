# Wazuh Wordpress Plugin

### Wordpress plugin for selection program in the company "Wazuh"

### The instructions was

Task 2: Find the incorrect hash

  > You will create a simple WordPress plugin. You’ll need to install WordPress
  > in your localhost, free hosting or another hosting that you already have.
  > Once you’ve done this, create a WordPress plugin that shows a textarea and
  > a submit button “check MD5”.

  > The text area must receive a text like this one:
  ```
  001 srvmail bddac79424b4fad646d7fe56a8b5af77
  002 srvdatabase 75ba2cdf8f0d1527afb0b843b0036ba8
  003 websrv d6899f6189fab1976f4f40bd246b192d
  004 security bc1fe94600e5195725db983fa1dae23e
  005 remote 73e379d2344b6c6f94e6895cf160a186
  ```
  >The text format is ID NAME MD5. The MD5 is calculated by concatenating
  >the ID + NAME:
  
  >MD5(001srvmail) = bddac79424b4fad646d7fe56a8b5af77
  >This way, the plugin will search in the WordPress database for an entry like
  >this one ( bddac79424b4fad646d7fe56a8b5af77 ):
  
  >  - If there’s an entry with the same value it will return whether this MD5
  >  is right or not.
  >  - If this MD5 doesn’t exist in the database, it will save it in the database
  >  and return whether this MD5 is correct or not.
  >After clicking on “check MD5” the plugin will show which lines had a correct
  >MD5 and which didn’t.

I followed all the rules and added some features and details.
Take a look if you want :wink:
