<?php
namespace Yang\MVC;

use Yang\Foundation\Interfaces\IObserver;
use Yang\Foundation\Interfaces\ISubject;
use Yang\MVC\Interfaces\IController;
use Yang\MVC\Interfaces\IRequest;

abstract class Controller implements IController, IObserver
{
    static public function isSubClass($who)
    {
        $selfClass = get_called_class();
        return is_string($who) ? is_subclass_of($who, $selfClass) : $who instanceof $selfClass;
    }

    public function observerUpdate(ISubject $subject, $obEvent, array $data = null) {

    }

    public function access(IRequest $request)
    {
        return false;
    }
}