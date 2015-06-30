# mtg-pricer

## Create bundle.min.js

    cd web
    node_modules/browserify/bin/cmd.js . | node_modules/uglify-js/bin/uglifyjs -cm > js/bundle.min.js
