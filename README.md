Bolt extras
====================

**Since these changes override files on the backend it will probably break on
upgrade or if you have an unusual bolt install. It will be versionlocked to a
specific bolt version.**

This extension adds a couple of modifications to bolt that I have found useful.

### Frontend

It adds three twig functions to the frontend:
 
`filemodified`: Returns the last time a file was modified. Used for filename 
based cachebusting. See [h5bp nginx configs](https://github.com/h5bp/server-
configs-nginx/blob/master/h5bp/location/cache-busting.conf) or [h5bp apache 
configs](https://github.com/h5bp/server-configs-apache/blob/master/src/web_
performance/filename-based_cache_busting.conf) for more info.



Example usage:
`<link rel="stylesheet" href="{{ paths.theme }}css/style.combined.{{ filemodified(paths.theme~"/css/style.combined.css") }}.css" />`
 
`d`: To dump variables without turning on debug. Usage: `{{d(records)}}`

`numToString`: takes a number and returns the english language word for that 
number. Used when you want to build grid columns based on an equation.

It also checks if you use a favicon, and if you don't it will output an empty 
base64 favicon in the header. The check this is based on is either if the 
favicon setting is not set in the config.yml and you don't have a file called
favicon.ico in your webroot or if the favicon setting is set to false.

### Backend

It moves custom backend listings to app/config/backend/listing, and adds a 
menuitem under Configuration to access/edit them.

It changes default indentation and tab behaviour in CodeMirror to better allow 
for those who prefer 4 spaces instead of tabs. Works with both indent and outdent.

It adds a ctrl-s save command to all CodeMirror editors on the backend.

It adds buttons to autoprefix and to beautify css when working on them in the 
backend.

It moves extension menu items to the main level.

It adds customizable theme shortcuts to the menu in the backend, configuration
is done in the themes config.yml to allow for different theme's to have different
shortcuts.

Example config in a theme's config.yml:

    shortcuts:
        - folder: /
          icon: folder-o
          name: intendit
        - file: /index.twig
          icon: html5
          name: index.twig
        - file: /config.yml
          icon: file-code-o
          name: config.yml
        - file: /css/custom.css
          icon: css3
          name: custom.css
        - file: /js/custom.js
          icon: jsfiddle
          name: custom.js