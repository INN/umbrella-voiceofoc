# Largo child theme for Voice of OC #

This repository is for the Largo child theme, used by Voice of OC on INN's shared hosting.

## Compiling LESS to CSS:

You'll need `npm` and `grunt` in order to compile the stylesheets.

1. Install the dependencies:

    `$ npm install`
    
2. While developing new changes, use:

    `$ grunt watch`
    
    
3. When you're ready to commit and deploy changes, use:


    `$ grunt cssmin`
    
NOTE: We're including some of Largo's `.less` files in Voice of OC's `less/foundation.less` file as a way of overriding some of the standard Largo colors and sizes, specifically related to site navigation.

This is made possible in the `Gruntfile.js`, which points to `../largo-dev/less/inc` as one of the import paths used by LESS when compiling CSS.
