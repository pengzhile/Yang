<?php
namespace Yang\Foundation\Interfaces;

interface ISubject
{
    /**
     * 默认事件，接受所有广播
     */
    const OBEVENT_ALL = 0;

    /**
     * 注册一个观察者，可以指定此观察者所接收的事件，默认接受所有广播
     * @param IObserver $observer
     * @param int       $obEvent    使用一个OBEVENT_开头的常量
     * @return bool
     */
    public function addObserver(IObserver $observer, $obEvent = self::OBEVENT_ALL);

    /**
     * 解除一个观察者，需要制定其注册时制定的事件
     * @param IObserver $observer
     * @param int       $obEvent    使用一个OBEVENT_开头的常量
     * @return bool
     */
    public function removeObserver(IObserver $observer, $obEvent = self::OBEVENT_ALL);

    /**
     * 通知订阅定应事件的观察者
     * 无论什么事件，总是会另外通知订阅了OBEVENT_ALL事件的观察者
     * @param int $obEvent  使用一个OBEVENT_开头的常量
     * @param array $data
     * @return true
     */
    public function notifyObserver($obEvent = self::OBEVENT_ALL, array $data = null);
}