<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('assets/dist/css/style.css') }}
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Teste">
        <meta name="author" content="Jonnes">
    </head>
    <body>
        {{ content() }}
        {{ javascript_include('assets/dist/js/app.js') }}
        {{ javascript_include('js/utils.js') }}
    </body>
</html>