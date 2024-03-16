# carbon
Carbon is a small PHP framework, light as fiber, strong as carbon.

## Create Route

Create a `routes` file at the root of the project.
Add a file with the name you want and with the .php extension, for example `routes.php`.
Then you can create routes like this :

```php
<?php

use Rehark\Carbon\http\method\HTTPMethods;
use Rehark\Carbon\http\router\route\DefinitionRoute;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\http\router\uri\DefinitionUri;
use Rehark\Carbon\component\controller\DefaultController;

$this->addRoute(new DefinitionRoute(
    new DefinitionUri('/'),
    HTTPMethods::GET,
    DefaultController::class,
    'serverStatus'
));

```

## Create Controller

You can create a crontroller by adding a `controller.php` file, then create class inheriting the `AbstractController` class

```php
<?php

namespace App\controller;

use Rehark\Carbon\component\controller\AbstractController;

class Controller extends AbstractController {
    
    public function test() {
        # code ...
    }

}
```

## Send Response

You can send responses to the client with `Response` class. All you have to do is return a response in a controller like this:

```php
<?php

namespace App\controller;

use Rehark\Carbon\component\controller\AbstractController;
use Rehark\Carbon\http\response\Response;

class Controller extends AbstractController {
    
    public function test() {
        return new Response(200, 'All ok !');
    }

}
```

### Test
To test the framework, you could use this following command :

```bash
php -d xdebug.mode=coverage ./vendor/bin/phpunit  --colors=auto --coverage-html .phpunit.result.cache/html-code-coverage
```