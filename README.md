# mtg-pricer

## Starting development server

To start Symfony web server:

    app/console server:run

To start automatic compilation of JS sources:

    cd web
    node_modules/watchify/bin/cmd.js js/app.js -o js/bundle.js

## Create bundle.min.js

    cd web
    node_modules/browserify/bin/cmd.js . | node_modules/uglify-js/bin/uglifyjs -cm > js/bundle.min.js
