Bolt extras
====================

#### Since these changes override files on the backend it will probably break on upgrade or if you have an unusual bolt install. It will be versionlocked to a specific bolt version.

This extension adds a couple of modifications to bolt that I have found useful.

### Frontend

It adds two twig functions to the frontend:
 
`filemodified`: Returns the last time a file was modified. Used for filename based cachebusting. See:

https://github.com/h5bp/server-configs-nginx/blob/master/h5bp/location/cache-busting.conf

https://github.com/h5bp/server-configs-apache/blob/master/src/web_performance/filename-based_cache_busting.conf

Example usage:
`<link rel="stylesheet" href="{{ paths.theme }}css/style.combined.{{ filemodified(paths.themepath~"/css/style.combined.css") }}.css" />`
 
`d`: To dump variables without turning on debug. Usage: `{{d(records)}}`

### Backend

It moves custom backend listings to app/config/backend/listing, and adds a menuitem under Configuration to access/edit them.

It changes default indentation and tab behaviour in CodeMirror to better allow for those who prefer 4 spaces instead of tabs. Works with both indent and outdent.

It adds a ctrl-s save command to all CodeMirror editors on the backend.

It adds buttons to autoprefix and to beautify css when working on them in the backend.

It moves extension menu items to the main level.

It adds customizable theme shortcuts to the menu in the backend, configuration is done in the themes config.yml to allow for different theme's to have different shortcuts.

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