<?php
namespace Yang\Foundation;

use Yang\Foundation\Interfaces\IObserver;
use Yang\Foundation\Interfaces\ISubject;

abstract class Subject implements ISubject
{
    private $__observers = array(
        self::OBEVENT_ALL => array()
    );

    private function initObservers($obEvent)
    {
        if (isset($this->__observers[$obEvent])) {
            return;
        }

        $this->__observers[$obEvent] = array();
    }
    
    final public function addObserver(IObserver $observer, $obEvent = self::OBEVENT_ALL)
    {
        $this->initObservers($obEvent);

        $this->__observers[$obEvent][] = $observer;
        return true;
    }

    final public function removeObserver(IObserver $observer, $obEvent = self::OBEVENT_ALL)
    {
        $this->initObservers($obEvent);

        $key = array_search($observer, $this->__observers[$obEvent], true);
        if (false !== $key) {
            unset($this->__observers[$obEvent][$key]);
            return true;
        }

        return false;
    }

    final public function notifyObserver($obEvent = self::OBEVENT_ALL, array $data = null)
    {
        $this->initObservers($obEvent);

        /**
         * @var IObserver $observer
         */
        foreach ($this->__observers[$obEvent] as $observer) {
            $observer->observerUpdate($this, $obEvent, $data);
        }

        /**
         * 这里会判断事件类型，如果不是OBEVENT_ALL，则另外通知OBEVENT_ALL事件订阅者
         */
        if (self::OBEVENT_ALL !== $obEvent) {
            foreach ($this->__observers[self::OBEVENT_ALL] as $observer) {
                $observer->observerUpdate($this, $obEvent, $data);
            }
        }

        return true;
    }

    public function __destruct()
    {
        unset($this->__observers);
    }
}