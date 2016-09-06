SahAssar extras
====================

**Since these changes override files on the backend it will probably break on
upgrade or if you have an unusual bolt install.**

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

It also checks if you use a favicon, and if you don't it will output an empty 
base64 favicon in the header. The check this is based on is either if the 
favicon setting is not set in the config.yml and you don't have a file called
favicon.ico in your webroot or if the favicon setting is set to false.

### Backend

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
          
*The extension icon (lightbulb) is by Michael Jonny Marzi from the Noun Project*
