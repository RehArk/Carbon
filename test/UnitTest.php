<?php

    namespace test;

    use \Throwable;
    use \Exception;
    use \Closure;

    interface UnitTestInterface {
        public function execTest();
    }

    /**
     * Abstract class to test if function work properly
     * Extends them to another class to start testing your code
     */
    abstract class UnitTest implements UnitTestInterface{

        public static $status = [
            'Fail' => '❌ Fail',
            'Success' => '✔️ Success'
        ];

        /**
         * load create test class and load test
         */
        public function __construct() {
            $this->displayTestedClass();
            $this->execTest();
        }

        /**
         * display class name
         * @return void
         */
        public function displayTestedClass() : void {
            $title = '
                <div class="test-class">
                    <h2 class="test-title">
                        '.get_class($this).'
                    </h2>
                </div>
            ';
            echo $title;
        }

        /**
         * return stack who is calling test to string
         * @return string $caller 
         */
        private function retrieveWhoIsCallingMe() : string {
            $stack = debug_backtrace()[1];
            $caller = $stack['class'].'.php:'.$stack['line'];
            return $caller;
        }

        /**
         * return formatted result of test
         * @return string $result 
         */
        public function sendStatus($status, $caller) : string {
            $result = '<p class="plop">'.$status.' : '.$caller.'</p>';
            return $result;
        }

        /**
         * test if callback is success
         * @param Closure $callback
         * @return void
         */
        function expectSuccess(Closure $callback) : void {
            $caller = $this->retrieveWhoIsCallingMe();
            $status = self::$status['Success'];

            try {
                $callback();
            } catch (Throwable $th) {    
                $status = self::$status['Fail'];
            }
        
            echo $this->sendStatus($status, $caller);
        }
        
        /**
         * test if callback throw exception
         * @param Closure $callback
         * @return void
         */
        function expectException(Closure $callback) : void {

            $caller = $this->retrieveWhoIsCallingMe();
            $status = self::$status['Fail'];
            
            try {
                $callback();
            } catch (Throwable $th) {    
                $status = self::$status['Success'];
            }
        
            echo $this->sendStatus($status, $caller);       
        }

        /**
         * test if 2 var are same
         * @param mixed $var1
         * @param mixed $var2
         * @return void
         */
        function expectSame(mixed $var1, mixed $var2) : void {

            $caller = $this->retrieveWhoIsCallingMe();
            $status = self::$status['Fail'];

            if($var1 === $var2) {
                $status = self::$status['Success'];
            }

            echo $this->sendStatus($status, $caller); 
        }

        /**
         * test if var is empty
         * @param mixed $var
         * @return void
         */
        function expectEmpty(mixed $var) : void {

            $caller = $this->retrieveWhoIsCallingMe();
            $status = self::$status['Fail'];

            if(empty($var1)) {
                $status = self::$status['Success'];
            }

            echo $this->sendStatus($status, $caller); 
        }

        /**
         * test if var is null
         * @param mixed $var
         * @return void
         */
        function expectNull(mixed $var) : void {

            $caller = $this->retrieveWhoIsCallingMe();
            $status = self::$status['Fail'];

            if(is_null($var1)) {
                $status = self::$status['Success'];
            }

            echo $this->sendStatus($status, $caller); 
        }

    }

?>