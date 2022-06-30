<?php

    include "../carbon/kernel/overlays/constant.php";
    include "../carbon/kernel/loaders/Autoloader.php";

    use carbon\kernel\loaders\Autoloader;
    Autoloader::register();

    /**
     * use the testing class extended of UnitTest
     * and construct them in html main
    */
    use test\carbon_test\autoloader\AutoloaderTest;

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Test</title>

        <link rel="stylesheet" href="/test/assets/css/test.css">

    </head>

    <body class="carbon_test">

        <main>

            <?php
            
                new AutoloaderTest();

            ?>

        </main>
        
    </body>

</html>