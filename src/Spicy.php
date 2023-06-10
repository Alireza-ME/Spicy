<?php

namespace spicy;

use Exception;
use spicy\constants\Config;
use spicy\cv_methods\Methods;
use spicy\extensions\Execute;
use spicy\extensions\HandlerManage;
use spicy\extensions\Transpiler;

class Spicy
{

    //method name
    private string $method;

    //method arguments
    private array $args;

    //methods object
    private object $Methods;

    //run ext object
    private object $Execute;

    //convert codes from spicy to py
    private object $Transpiler;

    public function __construct()
    {
        $execute = new Execute();
        if ($execute->python_exists()) {
            $this->Methods = new Methods();
            $this->Execute = $execute;
            $this->Transpiler = new Transpiler();
        } else {
            throw new Exception('python no exists or python version not ' . Config::PYTHON_VERSION);
        }
    }

    public function __call($method_name, $args)
    {
        if (Methods::cv_method_exists(strtolower($method_name))) {
            $this->method = strtolower($method_name);
            $this->args = $args;
            return $this->Transpiler->convert_method($this->method, $this->args);
        } else {
            throw new Exception('method not found');
        }
    }

    public function run(array $proc = [])
    {
        $code = null;
        if ($proc == []) {
            $code .= $this->Transpiler->convert_method($this->method, $this->args);
        } else {
            foreach ($proc as $prc) $code .= $prc;
        }
        $handler = new HandlerManage();
        $handler->add_to_handler($code);
        $result = $this->Execute->execute_file();
        $handler->del_from_handler();
        return $result;
    }

}
