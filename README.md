# Carbon
Carbon is a small PHP framework, light as fiber, strong as diamond.

## Routing

### Create Controller

You can create a controller by adding a `controller.php` file, then create class inheriting the `AbstractController` class

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

### Create Route

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

### Send Response

You can send responses to the client with `Response` class. All you have to do is return a response in a controller like this:

```php
<?php

namespace App\controller;

use Rehark\Carbon\component\controller\AbstractController;

use Rehark\Carbon\http\response\Response;
use Rehark\Carbon\http\response\FileResponse;
use Rehark\Carbon\http\response\Response;

class Controller extends AbstractController {
    
    public function test() {
        // Classic response
        return new Response(200, 'All ok !');
        // -- File response
        // return new FileResponse(__DIR__ . '/FileResponse.doc');
        // -- File response
        // return new JsonResponse('{"json": "content"}');
    }

}
```

## Dependency Injection

You can call dependency injection anywhere like this :

```php
<?php

$container = Container::get();

```

It could be very usefull if you need to register or to resolve dependencies.

### Register

You can register 3 differents type of dependencies : 
- Class
- Interface
- Instance

When you register a new dependency, container check if `class_exist`. If yes, the dependency is register as `class`. Else it check if `interface_exist`. If yes, the dependency is register as `interface`. Else it will be register as `instance`. So warning if you register a dependency with a standart class name like Datetime. It could create some issues. And you can not register dependency with the same name as `interface` and `instance` for exemple.

```php
<?php

// custom
$container->register('my_custom_instance', $myCustomInstance);

// interface
$container->register(DateTimeInterface::class, $myInterfaceResolution);

// class /!\ class are auto-resolved 
$container->register(DateTime::class, DateTime::class);

// register a resolver, it should be usefull for an interface with multiple possible resolutions
$container->register(DateTimeInterface::class, function (array $data) {
            
    if ($data['type'] == 'immutable') {
        return new DateTimeImmutable($data['date']);
    }

    return new DateTime($data['date']);

});

```

### Resolve

Controller will resolve dependency by default. But you may need to use your register dependencies. To resolve a class, you can use ObjectResolver. And to resolve a method, you can use MethodResolver. You also could use the `resolve` method of the container. You could use it like this :

```php
<?php

use Rehark\Carbon\dependency_injection\MethodResolver;
use Rehark\Carbon\dependency_injection\ObjectResolver;

$objectResolver = new ObjectResolver();
$controllerInstance = $objectResolver->resolve($className, []);

$methodeResolver = new MethodResolver();
$response = $methodeResolver->resolve($controllerInstance, $methodName);

$container = Container::get();
$date = $container->resolve(Datetimeinterface::class)

```

# Test
To test the framework, you could use this following command :

```bash
php -d xdebug.mode=coverage ./vendor/bin/phpunit  --colors=auto --coverage-html .phpunit.result.cache/html-code-coverage
```
