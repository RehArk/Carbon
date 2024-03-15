<?php

namespace Rehark\Carbon\Test\datasets;

use Rehark\Carbon\Test\utils\Dir;

class RouterDataset {

    public static function create(string $dir) {

        Dir::mk($dir . '/' . 'routes');
        
        Dir::addFile($dir . '/' . 'routes', 'base_routes.php','
            <?php

            use Rehark\Carbon\http\method\HTTPMethods;
            use Rehark\Carbon\http\router\route\DefinitionRoute;
            use Rehark\Carbon\http\router\uri\DefinitionUri;
            
            $this->addRoute(new DefinitionRoute(
                new DefinitionUri(\'/\'),
                HTTPMethods::GET
            ));
        ');

        Dir::mk($dir . '/' . 'routes/others');

        Dir::addFile($dir . '/' . 'routes/others', 'extended_routes.php','
            <?php

            use Rehark\Carbon\http\method\HTTPMethods;
            use Rehark\Carbon\http\router\route\DefinitionRoute;
            use Rehark\Carbon\http\router\uri\DefinitionUri;
            
            $this->addRoute(new DefinitionRoute(
                new DefinitionUri(\'/other\'),
                HTTPMethods::GET
            ));
        ');

        Dir::addFile($dir . '/' . 'routes/others', 'extended_routes.ignore','
            <?php

            use Rehark\Carbon\http\method\HTTPMethods;
            use Rehark\Carbon\http\router\route\DefinitionRoute;
            use Rehark\Carbon\http\router\uri\DefinitionUri;
            
            $this->addRoute(new DefinitionRoute(
                new DefinitionUri(\'/ignore\'),
                HTTPMethods::GET
            ));
        ');
    }

    public static function clear(string $dir) {
        Dir::rm($dir . '/' . 'routes/others');
        Dir::rm($dir . '/' . 'routes');
    }

}