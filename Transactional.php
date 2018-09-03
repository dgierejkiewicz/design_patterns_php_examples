<?php

interface Processiable
{
    public function process($subject);
}


interface Transactionable
{
    public function tryOperation();

    public function operation();

    public function saveToMemento();

    public function restoreFromMemento();
}

interface TransactionChainable
{
    public function commit();

    public function rollback();
}

class AbstractSubject extends stdClass
{

}

class Processor implements Processiable
{
    private function incrementId($id, $howMuch)
    {
        if (is_int($id)) {
            return $id + $howMuch;
        }
        return false;
    }

    public function process($subject)
    {
        if (!isset($subject->id)) return false;
        return $this->incrementId($subject->id, 100);
    }
}


class Memento
{
    private $subject;

    public function __construct($subjectToSave)
    {
        $this->subject = $subjectToSave;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}

abstract class AbstractTransaction implements Transactionable
{

    /** @var $subject mixed */
    private $subject;

    /** @var $processor Processiable */
    private $processor;

    /** @var $memento Memento */
    private $memento;

    /** @var $state boolean */
    private $state;

    /**
     * TestFn constructor.
     * @param $subjectObject mixed
     */
    public function __construct($subjectObject, Processiable $processor)
    {
        $this->subject = $subjectObject;
        $this->processor = $processor;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     * @return AbstractTransaction
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param mixed $processor
     */
    public function setProcessor(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * @return bool
     */
    public function isState(): bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     */
    public function setState(bool $state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getMemento()
    {
        return $this->memento;
    }

    /**
     * @param mixed $memento
     */
    public function setMemento($memento)
    {
        $this->memento = $memento;
    }

    /**
     * @return Memento
     */
    public function saveToMemento()
    {
        $memento = new Memento(clone ((object)$this->subject));
        $this->memento = &$memento;
    }


    public function operation()
    {
        $value = $this->processor->process($this->subject);

        if (is_bool($value) && false == $value) {
            $this->setState($value);
            return $this;
        }

        $this->subject = $value;
        $this->setState(true);
        return $this;

    }

    public function restoreFromMemento()
    {
        $memento = $this->getMemento();
        $this->subject = $memento->getSubject();
    }

    public function tryOperation()
    {
        $this->operation();
        return $this->isState();
    }
}


class Transaction extends AbstractTransaction
{

}


class TransactionChain implements TransactionChainable
{
    private $chain;
    private $autoRollback = true;


    /**
     * TransactionCall constructor.
     *
     * @param bool $autoRollback
     */
    public function __construct($autoRollback = true)
    {
        $this->registerShutdown();
        $this->chain = new SplDoublyLinkedList();
        $this->autoRollback = $autoRollback;
    }

    public function addTransactionable(Transactionable $transactionable)
    {
        $transactionable->saveToMemento();
        $this->chain->push($transactionable);
        return $this;
    }

    public function commit()
    {
        $this->chain->rewind();
        while ($this->chain->valid()) {

            /** @var Transactionable $t */
            $t = $this->chain->current();

            if (!$t->tryOperation()) {
                $this->rollback();
                return false;
            }

            $this->chain->next();
        }
        return true;
    }

    public function rollback()
    {
        $this->chain->rewind();
        while ($this->chain->valid()) {

            /** @var Transactionable $t */
            $t = $this->chain->current();
            $t->restoreFromMemento();
            $this->chain->next();

        }
    }

    public function registerShutdown(): void
    {
        register_shutdown_function(array($this, 'rollback'));
    }

}

class Test extends AbstractSubject
{
    public $id;
}

$sub1 = new AbstractSubject();
$sub1->id = 1;

$sub2 = new AbstractSubject();
$sub2->id = 2;

$sub3 = new Test();
$sub3->id = 3;

$processor = new Processor();


$transactionCall = new TransactionChain(true);
$transactionCall
    ->addTransactionable(new Transaction($sub1, $processor))
    ->addTransactionable(new Transaction($sub2, $processor))
    ->addTransactionable(new Transaction($sub3, $processor));

print_r($transactionCall);

$transaction_status = $transactionCall->commit();

print_r($transactionCall);

var_dump($transaction_status);

exit;