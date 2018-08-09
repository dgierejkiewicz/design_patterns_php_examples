<?php

namespace DesignPatterns;

/**
 * Class Handler
 * @package DesignPatterns
 */
abstract class Handler
{
    /**
     * @var $nextHandler null
     */
    protected $nextHandler = null;

    /**
     * Abstract method for handling request or anything
     * @param $request
     * @return mixed
     */
    abstract public function handleRequest($request);

    /**
     * Method for setting new handler in chain
     * @param Handler $handler
     * @return $this
     */
    public function setNextHandler(Handler $handler)
    {
        $this->nextHandler = $handler;
        return $this;
    }
}

/**
 * Class BooleanHandler
 * @package DesignPatterns
 */
class BooleanHandler extends Handler
{
    public function handleRequest($request)
    {
        if (\is_bool($request)) {
            echo __METHOD__;
        } else if ($this->nextHandler instanceof Handler) {
            $this->nextHandler->handleRequest($request);
        }
    }
}

/**
 * Class NumericHandler
 * @package DesignPatterns
 */
class NumericHandler extends Handler
{
    public function handleRequest($request)
    {
//        \var_dump(\is_numeric($request));exit;
        if (\is_numeric($request)) {
            echo __METHOD__;
        } else if ($this->nextHandler instanceof Handler) {
            $this->nextHandler->handleRequest($request);
        }
    }
}

/**
 * Class StringHandler
 * @package DesignPatterns
 */
class StringHandler extends Handler
{
    public function handleRequest($request)
    {
        if (\is_string($request)) {
            echo __METHOD__;
        } else if ($this->nextHandler instanceof Handler) {
            $this->nextHandler->handleRequest($request);
        }
    }
}

/**
 * Class DefaultHandler
 * @package DesignPatterns
 */
class DefaultHandler extends Handler
{
    public function handleRequest($request)
    {
        echo __METHOD__;
    }
}

/**
 * Class Client
 * @package DesignPatterns
 */
class Client
{
    /**
     * Create chain
     * @param $request
     * @return string
     */
    public function request($request)
    {
        $defaultHandler     = new DefaultHandler();
        $stringHandler      = new StringHandler();
        $numericHandler     = new NumericHandler();
        $booleanHandler     = new BooleanHandler();

        $booleanHandler->setNextHandler($numericHandler);
        $numericHandler->setNextHandler($stringHandler);
        $stringHandler->setNextHandler($defaultHandler);

//        print_r($booleanHandler);exit;

        return $booleanHandler->handleRequest($request);
    }
}


$client = new Client();
$client->request(true);
echo "\n";
$client->request('aaa');
echo "\n";