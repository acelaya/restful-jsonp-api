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
}
