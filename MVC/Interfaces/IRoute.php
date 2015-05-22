<?php
namespace Yang\MVC\Interfaces;

interface IRoute
{
    /**
     * 返回该路由规则的名字，最好使用对应的类名
     * @return string
     */
    public function name();

    /**
     * 解析请求字符串，并设置request
     * 如果你确定能完全解析成功，则返回true，系统则不继续使用其他规则
     * @param IRequest $request
     * @return bool
     */
    public function parse(IRequest $request);
}