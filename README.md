## Coolurl
A library created for static websites to generate pretty SEO friendly urls.

index.php

```php
require '../app.php'; // require app.php (the one and only core file)

$app = new App(); //instantiate

$app->basePath('public/'); // change it to path where you index.php is (everything after localhost/)
$app->viewsPath('views/'); // your views folder path


// create routes as many as you want
$app->map('/', function ($params) use ($app) {
    $app->render('home');
});

$app->dispatch(); // dispatch you are done :)
```

.htaccess
```apacheconf
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]
```
