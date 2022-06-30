<?php 

    namespace test\carbon_test\autoloader;

    use carbon\kernel\loaders\Autoloader;
    use test\UnitTest;

    class AutoloaderTest extends UnitTest
    {

        private $rightClass = "test\carbon_test\autoloader\TestClass";
        private $wrongClass = "carbon_test\autoloader\wrongPath\TestClass"; 

        public function execTest() {

            // test if found file
            $this->expectSuccess (function () {
                Autoloader::loadFile($this->rightClass);
            });
            $this->expectException (function () {
                Autoloader::loadFile($this->wrongClass);
            });

            // test if found class
            $this->expectSuccess (function () {
                Autoloader::loadClass($this->rightClass);
            });
            $this->expectException (function () {
                Autoloader::loadClass($this->wrongClass);
            });

            // test if found file
            $this->expectSuccess (function () {
                Autoloader::loadClass($this->rightClass);
            });
            $this->expectException (function () {
                Autoloader::loadClass($this->wrongClass);
            });

        }
    
    }

?>




