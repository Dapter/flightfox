<?php

class App
{
    
    public static function run():void
    {
        self::autoloader();
        $dbHandler = self::getDBHandler();  
        
        $model = new Model($dbHandler);
        $controller = new Controller($model);
        
        $dispacher = new Dispacher($controller);
        $dispacher->dispatch();
    }

    private static function autoloader():void
    {
        require_once('code/Controller.php');
        require_once('code/Model.php');
        require_once('code/Dispacher.php');
    }
    
    /**
     * @return \mysqli
     * @throws Exception
     */
    private static function getDBHandler():mysqli
    {
        $handler = mysqli_connect("127.0.0.1", "root", "", "flightfox");
        
        if (!$handler || $handler->connect_errno) {
            throw new Exception('Connect failed');
        }
        
        return $handler;
    }
}