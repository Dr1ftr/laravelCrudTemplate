const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// only show notifications if something goes wrong
mix.disableSuccessNotifications();

// generate sourcemaps, but not in production
mix.sourceMaps(false, 'source-map');

// copy images into public
mix.copyDirectory('resources/img', 'public/img');

// default js and css for the entire site
mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/boxicons.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ]);

// js and stylesheet for choices.js npm package
mix.js('node_modules/choices.js/public/assets/scripts/choices.min.js', 'public/modules/choicesjs')
    // use css instead of postcss so that the stylesheet isn't edited
    .css('node_modules/choices.js/public/assets/styles/choices.min.css', 'public/modules/choicesjs');

// js for the message component
mix.js('resources/js/components/message.js', 'public/js/components');
// Css for request article page
mix.postCss('resources/css/rArticle.css', 'public/css');

// navbar
mix.postCss('resources/css/navbar.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ]);

// sidemenu
mix.postCss('resources/css/sidemenu.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ])
    .ts('resources/ts/sidemenu.ts', 'public/ts');

// dashboard specific background/navbar styling
mix.postCss('resources/css/dashboard.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ]);

// create user
mix.js('resources/js/create-user_choices-setup.js', 'public/js')
    .postCss('resources/css/create-user.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss')
    ]);
//order overview
mix.postCss('resources/css/order_overview.css', 'public/css');

// loan overview and loan requests overview
mix.postCss('resources/css/overview-loan.css', 'public/css')
    .postCss('resources/css/overview-request.css', 'public/css');

// ts for buttons on the loan and loan request overviews
mix.ts('resources/ts/loan/take-in.ts', 'public/ts/loan')
    .ts('resources/ts/loan/accept-request.ts', 'public/ts/loan')
    .ts('resources/ts/loan/reject-request.ts', 'public/ts/loan');

if (mix.inProduction()) {
    mix.version();
}
