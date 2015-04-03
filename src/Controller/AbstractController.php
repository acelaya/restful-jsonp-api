<?php
namespace Acelaya\Controller;

use Slim\Slim;

abstract class AbstractController
{
    /**
     * @var Slim
     */
    protected $app;

    public function __construct(Slim $app)
    {
        $this->app = $app;
    }

    protected function getRouteParam($name, $default = null)
    {
        $routeParams = $this->app->router()->getCurrentRoute()->getParams();
        return array_key_exists($name, $routeParams) && ! empty($routeParams[$name]) ? $routeParams[$name] : $default;
    }
}
