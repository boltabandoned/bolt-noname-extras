boltabandoned extras
====================

**Since these changes override files on the backend it will probably break on
upgrade or if you have an unusual bolt install.**

This extension adds a couple of modifications to bolt that I have found useful.

### Frontend

It adds twig functions/filters to the frontend:

`p`: To add preload headers so that assets can be pushed with HTTP2. Usage: `<link rel="stylesheet" href="{{ asset('css/styles.pkgd.css', 'theme')|p }}">`

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
