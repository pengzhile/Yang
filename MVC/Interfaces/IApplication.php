<?php
namespace Yang\MVC\Interfaces;

interface IApplication
{
    /**
     * 返回app基路径，末尾不带/
     * @return string
     */
    public function path();

    /**
     * 返回app的基namespace，末尾不带\
     * @return string
     */
    public function ns();

    /**
     * App在实例化的时候触发此动作
     */
    public function init();

    /**
     * 在该App被丢进System的时候触发此动作
     */
    public function attached();

    /**
     * 调度顺序1
     * 在调度之前触发此动作，此动作之后会立刻调度
     * @return bool 如果返回true才会接下来调度
     */
    public function preDispatch();

    /**
     * 顺序调度2
     * 在路由解析之前触发此动作
     * @param IRequest $request
     * @return bool 如果返回true才会接下来路由解析
     */
    public function preRoute(IRequest $request);

    /**
     * 顺序调度3
     * 路由结束后出发此动作
     * 如果preRoute中断了操作，则不会触发
     * @param IRequest $request
     * @param IRoute $route 如果解析成功该参数会被设置为生效的规则，否则为null
     */
    public function routed(IRequest $request, IRoute $route = null);

    /**
     * 顺序调度4
     * 开始调度controller链时触发此动作
     * @param IRequest    $request
     * @return bool 如果返回true才会接下来调度controller链
     */
    public function preInvokeControllers(IRequest $request);

    /**
     * 顺序调度5
     * 开始调度某个controller的service触发此动作
     * @param IController $controller
     * @param IRequest    $request
     * @return bool 如果返回true才会接下来调度service，否则跳过该controller
     */
    public function preInvokeService(IController $controller, IRequest $request);

    /**
     * 顺序调度6
     * 特定controller的service调度完成触发
     * @param IController $controller
     * @param IRequest    $request
     */
    public function invokedService(IController $controller, IRequest $request);

    /**
     * 顺序调度7
     * controller链调度完成时触发
     * @param array $controllers 所有被调度成功的controller
     * @param IRequest    $request
     */
    public function invokedControllers(array $controllers, IRequest $request);

    /**
     * 顺序调度8
     * 调度结束之后触发此动作
     * 但preDispatch如果返回非true终止调度，则不会触发
     */
    public function dispatched();

    /**
     * 顺序调度9
     * 系统即将结束运行，可以做最后的收尾工作，接下来就会退出
     */
    public function atExit();

    /**
     * 实现这个方法可以返回一个自定义路由规则数组，系统会优先以此每条规则
     * 如果所有规则都不能解析，则使用系统默认规则再尝试一次
     * 规则必须实现IRoute接口，如果返回null，则忽略该方法
     * @return array|null
     */
    public function customRoutes();

    /**
     * 实现这个方法可以返回一个自定义Request
     * 系统会使用该Request替代默认
     * Request必须实现IRequest接口，如果返回null，则忽略该方法
     * @return null|IRequest
     */
    public function customRequest();

    /**
     * 当系统检查到一个controller没有继承自Controller基类时触发
     * @param string $controllerName
     */
    public function invalidController($controllerName);

    /**
     * 当请求的controller找不到对应类的时候处触发，404
     * @param $controllerName
     */
    public function controllerNotFound($controllerName);
}