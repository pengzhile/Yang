<?php
namespace Yang\MVC\Interfaces;

interface IController
{
    /**
     * 在controller调度之前会使用该方法，如果需要权限认证，请在此处理
     * 如果返回一个true，则继续调度该controller，否则不继续
     * @param IRequest $request
     * @param bool
     */
    public function access(IRequest $request);

    /**
     * 请求在controller的入口方法
     * @param IRequest $request
     * @return mixed 如果返回一个controller对象，则其会被继续调度
     */
    public function service(IRequest $request);
}