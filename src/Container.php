<?php


namespace WorkWechat;


use IteratorAggregate;
use think\helper\Str;

/**
 * @property  \WorkWechat\Work\Gettoken $gettoken 获取token
 * @property  \WorkWechat\Work\Department $department 部门
 * @property  \WorkWechat\Work\Agent $agent
 * @property  \WorkWechat\Work\Batch $batch  批量操作
 * @property  \WorkWechat\Work\ExternalContact $externalcontact 外部联系人
 * @property  \WorkWechat\Work\User $user  用户
 * @property   \WorkWechat\Work\Tag $tag 标签
 * @see  \WorkWechat\Work\Tag
 * Class Container
 * @package WorkWechat
 */
class Container implements \ArrayAccess, IteratorAggregate
{
    /**
     * 容器对象实例
     * @var Container|\Closure
     */
    protected static $instance;

    /**
     * 容器中的对象实例
     * @var array
     */
    protected $instances = [];

    private $config = [];

    private $alias = array(
        'agent' => \WorkWechat\Work\Agent::class,
        'batch' => \WorkWechat\Work\Batch::class,
        'department' => \WorkWechat\Work\Department::class,
        'externalcontact' => \WorkWechat\Work\ExternalContact::class,
        'tag' => \WorkWechat\Work\Tag::class,
        'user' => \WorkWechat\Work\User::class,
        'gettoken' => \WorkWechat\Work\Gettoken::class,
    );

    /**
     * 获取当前容器的实例（单例）
     * @access public
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        if (static::$instance instanceof \Closure) {
            return (static::$instance)();
        }
        return static::$instance;
    }

    /**
     * 创建类的实例
     * @param string $abstract 类或者函数
     * @param array $vars 变量
     * @param bool $newInstance 是否每次创建新的实例
     * @return mixed
     * @throws \Exception
     */
    public function make($abstract, $vars = [], $newInstance = false)
    {
        $abstract = isset($this->alias[$abstract]) ? $this->alias[$abstract] : $abstract;
        if (isset($this->instances[$abstract]) && !$newInstance) {
            return $this->instances[$abstract];
        }
        if (isset($this->alias[$abstract])) {
            $concrete = $this->alias[$abstract];
            if ($concrete instanceof \Closure) {
                $object = $this->invokeFunction($concrete, $vars);
            } else {
                $this->alias[$abstract] = $concrete;
                return $this->make($concrete, $vars, $newInstance);
            }
        } else {
            $object = $this->invokeClass($abstract, $vars);
        }
        if (!$newInstance) {
            $this->instances[$abstract] = $object;
        }
        return $object;
    }

    /**
     * 获取标识符
     * @param string $abstract
     * @return string
     */
    public function getAli($abstract = '')
    {
        if (isset($this->alias[$abstract])) {
            $bind = $this->alias[$abstract];
            if (is_string($bind)) return $this->getAli($bind);
        }
        return $abstract;
    }

    /**
     * 实例化闭包函数
     * @param string|\Closure $function
     * @param array $vars
     * @return mixed
     * @throws \Exception
     */
    public function invokeFunction($function, $vars = [])
    {
        try {
            $refs = new  \ReflectionFunction($function);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
        $args = $this->bindParams($refs, $vars);
        return $function($args);
    }

    /**
     * @param $abstract
     * @param null $concrete
     * @return Container
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_array($abstract)) {
            foreach ($abstract as $key => $val) {
                $this->bind($key, $val);
            }
        } else if ($concrete instanceof \Closure) {
            $this->alias[$abstract] = $concrete;
        } else if (is_object($concrete)) {
            $this->instance($abstract, $concrete);
        } else {
            $abstract = $this->getAli($abstract);
            $this->alias[$abstract] = $concrete;
        }
        return $this;
    }

    /**
     * 绑定一个类实例到容器
     * @param string $abstract
     * @param $instance
     * @return $this
     */
    public function instance(string $abstract, $instance)
    {
        $abstract = $this->getAli($abstract);
        $this->instances[$abstract] = $instance;
        return $this;
    }

    /**
     * 实例化类
     * @param string $class
     * @param array $vars
     * @return mixed|object
     * @throws \ReflectionException
     */
    protected function invokeClass(string $class, $vars = [])
    {
        try {
            $reflect = new \ReflectionClass($class);
        } catch (\Exception $exception) {

        }
        if ($reflect->hasMethod('__make')) {
            $method = $reflect->getMethod('__make');
            if ($method->isPublic() && $method->isStatic()) {
                $args = $this->bindParams($method, $vars);
                return $method->invokeArgs(null, $args);
            }
        }
        $constructor = $reflect->getConstructor();
        $args = $constructor ? $this->bindParams($constructor, $vars) : [];
        return $reflect->newInstanceArgs($args);
    }

    /**
     * 绑定参数
     * @param \ReflectionFunctionAbstract $abstract
     * @param array $vars
     * @return array
     * @throws \ReflectionException
     */
    protected function bindParams(\ReflectionFunctionAbstract $abstract, array $vars = [])
    {
        if ($abstract->getNumberOfParameters() == 0) {
            return [];
        }
        reset($vars);
        $type = key($vars) === 0 ? 1 : 0;
        $params = $abstract->getParameters();
        $args = [];
        foreach ($params as $item) {
            $name = $item->getName();
            $lowerName = Str::snake($name);
            $class = $item->getClass();
            if ($class) {
                $args[] = $this->getObjectParam($class->getName(), $vars);
            } else if (1 === $type && empty($vars)) {
                $args[] = array_shift($vars);
            } else if (0 === $type && isset($vars[$lowerName])) {
                $args[] = $vars[$lowerName];
            } else if ($item->isDefaultValueAvailable()) {
                $args[] = $item->getDefaultValue();
            } else {
                throw new \Exception('method param miss:' . $name);
            }
        }
        return $args;
    }

    /**
     * 获取对象类型的参数值
     * @param string $className
     * @param array $vars
     * @return mixed
     * @throws \Exception
     */
    public function getObjectParam(string $className, array &$vars)
    {
        $array = $vars;
        $value = array_shift($array);
        if ($value instanceof $className) {
            $result = $value;
            array_shift($vars);
        } else {
            $result = $this->make($className);
        }
        return $result;
    }

    /**
     * 删除容器中的对象实例
     * @access public
     * @param string $name 类名或者标识
     * @return void
     */
    public function delete($name)
    {
        $name = $this->getAli($name);
        if (isset($this->instances[$name])) {
            unset($this->instances[$name]);
        }
    }

    /**
     * 绑定一个类、闭包、实例、接口实现到容器
     * @param $abstract
     * @param string $concrete
     * @return Container
     */
    public function bindTo($abstract, $concrete = '')
    {
        if (is_array($abstract)) {
            $this->alias = array_merge($this->alias, $abstract);
        } elseif ($concrete instanceof \Closure) {
            $this->alias[$abstract] = $concrete;
        } elseif (is_object($concrete)) {
            if (isset($this->alias[$abstract])) {
                $abstract = $this->alias[$abstract];
            }
            $this->instances[$abstract] = $concrete;
        } else {
            $this->alias[$abstract] = $concrete;
        }
        return $this;
    }

    /**
     *
     * @param $abstract
     * @return Container
     * @throws \Exception
     */
    public function get($abstract)
    {
        if ($this->bind($abstract)) {
            return $this->bind($abstract);
        }
        throw new \Exception('为找faaaa');
    }

    public function bound($abstract): bool
    {
        return isset($this->bind[$abstract]) || isset($this->instances[$abstract]);
    }

    public function __isset($abstract)
    {
        return $this->bound($abstract);
    }

    public function __get($abstract)
    {
        return $this->make($abstract);
    }

    public function __unset($key)
    {
        $this->delete($key);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }


    public function __set($name, $value)
    {
        $this->bindTo($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->instances);
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}