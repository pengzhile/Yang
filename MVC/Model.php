<?php
namespace Yang\MVC;

use Yang\Foundation\Subject;
use Yang\Foundation\Interfaces\IObserver;

class Model extends Subject
{
    /**
     * 通知观察者需要更新session
     */
    const OBEVENT_UPDATE_SESSION = 1;
    /**
     * 通知观察者需要更新cookie
     */
    const OBEVENT_UPDATE_COOKIE = 2;

    protected $_properties = array();

    final public function __set($property, $value)
    {
        $this->_properties[$property] = $value;
    }

    final public function __get($property)
    {
        return isset($this->_properties[$property]) ? $this->_properties[$property] : null;
    }

    /**
     * 该方法能快速设置为session, cookie观察者
     * @param IObserver $observer
     * @return void
     */
    final public function respondResponse(IObserver $observer)
    {
        $this->addObserver($observer, self::OBEVENT_UPDATE_SESSION);
        $this->addObserver($observer, self::OBEVENT_UPDATE_COOKIE);
    }

    public function __destruct()
    {
        unset($this->properties);
    }

    /**
     * 当前model需要更新session，通常发送给controller
     * 虽然你调用了这个方法，但未必能更新出去，因为controller未必订阅或未必理会你
     * 需要传递一个map型数组  array('item' => 'data')
     * @param array $data
     * @return void
     */
    final protected function setSession(array $data)
    {
        $this->notifyObserver(self::OBEVENT_UPDATE_SESSION, $data);
    }

    /**
     * 当前model需要更新cookie，通常发送给controller
     * 虽然你调用了这个方法，但未必能更新出去，因为controller未必订阅或未必理会你
     * 需要传递一个map型数组  array('item' => 'data')
     * @param array $data
     * @return void
     */
    final protected function setCookie(array $data)
    {
        $this->notifyObserver(self::OBEVENT_UPDATE_COOKIE, $data);
    }
}