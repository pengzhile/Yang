<?php
namespace Yang\MVC;

use Yang\MVC\Interfaces\IApplication;

class System
{
    const EXIT_SUCCESS = 0;
    const EXIT_FAILURE = 1;

    /**
     * @var static
     */
    static protected $_instance;

    /**
     * @var string
     */
    protected $_path;

    /**
     * @var IApplication
     */
    protected $_app;

    /**
     * @var \Yang\Foundation\Interfaces\IRuntime
     */
    protected $_runtime;

    /**
     * @return static
     */
    static public function instance()
    {
        if (null === static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    /**
     * 获取框架更目录的绝对地址
     * @return string
     */
    public function path()
    {
        if (null === $this->_path) {
            $this->_path = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
        }

        return $this->_path;
    }

    /**
     * 让System加载一个app
     * 参数为一个匿名函数，该参数必须返回一个IApplication实例
     * 如果你要包含你的Application类文件
     * 结果发现其继承的Yang\MVC\Application类找不到，那么你可以改在该匿名函数内包含
     * @param callable $appMaker
     * @return $this
     * @throws \RuntimeException
     */
    public function loadApp(\Closure $appMaker)
    {
        /**
         * @var IApplication $app
         */
        $app = $appMaker();

        if (! $app instanceof IApplication) {
            throw new \RuntimeException('Argument 1 must return a IApplication instance!');
        }

        $this->_app = $app;
        $app->attached();
        return $this;
    }

    /**
     * 运行已通过loadApp加载过的App
     * @return mixed
     */
    public function runApp()
    {
        $app = $this->_app;
        $ret = $this::EXIT_SUCCESS;

        if (true === $app->preDispatch()) {
            /**
             * @var Dispatcher $dispatcher
             */
            $dispatcher = $this->_runtime()->make('dispatcher', array($this->_runtime()));
            $ret = $dispatcher->dispatch($app);
            $app->dispatched();
        }

        $app->atExit();
        return $ret;
    }

    public function __destruct()
    {
        unset($this->_app);
        unset($this->_runtime);
    }

    protected function _loader($class)
    {
        if (0 === strncmp($class, 'Yang\\', 5)) {
            require $this->path() . strtr(substr($class, 4), '\\', DIRECTORY_SEPARATOR) . '.php';
        }
    }

    /**
     * @return \Yang\Foundation\Interfaces\IRuntime
     */
    protected function _runtime()
    {
        if (null === $this->_runtime) {
            $this->_runtime = DataSource::makeRuntime();
        }

        return $this->_runtime;
    }

    protected function __construct()
    {
        set_error_handler(function ($no, $str, $file, $line) {
            throw new \ErrorException($str, 0, $no, $file, $line);
        }, error_reporting());

        spl_autoload_register(array($this, '_loader'));

        $this->_runtime()->register(DataSource::systemObjectContexts());
    }

    protected function __clone()
    {
    }

    protected function __sleep()
    {
    }

    protected function __wakeup()
    {
    }
}