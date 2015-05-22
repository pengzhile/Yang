<?php
namespace Yang\Foundation\Interfaces;

interface IObserver
{
    /**
     * 收到广播，会传递一个广播发起者，和额外携带的数据
     * @param ISubject $subject
     * @param int      $obEvent
     * @param array    $data
     * @return void
     */
    public function observerUpdate(ISubject $subject, $obEvent, array $data = null);
}