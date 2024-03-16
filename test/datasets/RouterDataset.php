<?php

namespace Rehark\Carbon\Test\datasets;

use Rehark\Carbon\Test\utils\Dir;

class RouterDataset {

    public static function create(string $dir) {

        Dir::mk($dir . '/' . 'routes');
        
        Dir::addFile($dir . '/' . 'routes', 'base_routes.php',
            '<?php '."\n\n".

            'use Rehark\Carbon\http\method\HTTPMethods;'."\n".
            'use Rehark\Carbon\http\router\route\DefinitionRoute;'."\n".
            'use Rehark\Carbon\http\router\uri\DefinitionUri;'."\n".
            'use Rehark\Carbon\component\controller\DefaultController;'."\n\n".
            
            '$this->addRoute(new DefinitionRoute('."\n".
            '    new DefinitionUri(\'/\'),'."\n".
            '    HTTPMethods::GET,'."\n".
            '    DefaultController::class,'."\n".
            '    \'serverStatus\''."\n".
            '));'
        );

        Dir::mk($dir . '/' . 'routes/others');

        Dir::addFile($dir . '/' . 'routes/others', 'extended_routes.php',
            '<?php '."\n\n".

            'use Rehark\Carbon\http\method\HTTPMethods;'."\n".
            'use Rehark\Carbon\http\router\route\DefinitionRoute;'."\n".
            'use Rehark\Carbon\http\router\uri\DefinitionUri;'."\n".
            'use Rehark\Carbon\component\controller\DefaultController;'."\n\n".
            
            '$this->addRoute(new DefinitionRoute('."\n".
            '    new DefinitionUri(\'/other\'),'."\n".
            '    HTTPMethods::GET,'."\n".
            '    DefaultController::class,'."\n".
            '    \'serverStatus\''."\n".
            '));'
        );

        Dir::addFile($dir . '/' . 'routes/others', 'extended_routes.ignore',
            '<?php '."\n\n".

            'use Rehark\Carbon\http\method\HTTPMethods;'."\n".
            'use Rehark\Carbon\http\router\route\DefinitionRoute;'."\n".
            'use Rehark\Carbon\http\router\uri\DefinitionUri;'."\n".
            'use Rehark\Carbon\component\controller\DefaultController;'."\n\n".
            
            '$this->addRoute(new DefinitionRoute('."\n".
            '    new DefinitionUri(\'/ignore\'),'."\n".
            '    HTTPMethods::GET,'."\n".
            '    DefaultController::class,'."\n".
            '    \'serverStatus\''."\n".
            '));'
        );
    }

    public static function clear(string $dir) {
        Dir::rm($dir . '/' . 'routes/others');
        Dir::rm($dir . '/' . 'routes');
    }

}