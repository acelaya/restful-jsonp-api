<?php
namespace Acelaya\Controller;

abstract class AbstractRestfulController extends AbstractController
{
    const IDENTIFIER_KEY = 'id';

    /**
     * @var array
     */
    protected $queryParams = [];

    final public function dispatch()
    {
        $resp = [];
        $this->queryParams = $this->app->request()->get();
        $id = $this->getRouteParam(self::IDENTIFIER_KEY);

        // Dispatch based on HTTP verb
        switch (strtolower($this->app->request()->getMethod())) {
            case 'get':
                if ($this->isJsonpRequest()) {
                    $resp = $this->processJsonpRequest($this->queryParams['action'], $id);
                } else {
                    $resp = isset($id) ? $this->get($id) : $this->getList();
                }
                break;
            case 'post':
                $resp = $this->create($this->parseRequestBody());
                break;
            case 'put':
                $resp = $this->update($id, $this->parseRequestBody());
                break;
            case 'delete':
                $resp = $this->delete($id);
                break;
            case 'options':
                $resp = $this->app->response();
                $resp->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $resp->header('Access-Control-Max-Age', 1000);
                $resp->header('Access-Control-Allow-Headers', 'origin, x-csrftoken, content-type, accept');
                break;
            default:
                $this->app->response()->setStatus(405);
        }

        // Write response and content-type
        $responseContent = json_encode($resp);
        if ($this->isJsonpRequest()) {
            $responseContent = sprintf('%s(%s)', $this->queryParams['callback'], $responseContent);
            $this->app->response()->header('Content-type', 'application/javascript');
        } else {
            $this->app->response()->header('Content-type', 'application/json');
            $this->app->response()->header('Access-Control-Allow-Origin', '*');
        }
        $this->app->response()->write($responseContent);

    }

    protected function isJsonpRequest()
    {
        return
            strtolower($this->app->request()->getMethod()) === 'get'
            && isset($this->queryParams['callback'])
            && isset($this->queryParams['action']);
    }

    public function get($id)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function getList()
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function create(array $data)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function update($id, array $data)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function delete($id)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    // So on...

    public function deleteList(array $data)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function head($id = null)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    public function patch($id, $data)
    {
        $this->app->response()->setStatus(405);
        return [
            'error' => 'Method Not Allowed'
        ];
    }

    /**
     * @return array
     */
    protected function parseRequestBody()
    {
        // Try to decode from JSON
        $content = $this->app->request()->getBody();
        $parsedArgs = json_decode($content, true);
        if (is_array($parsedArgs)) {
            return $parsedArgs;
        }

        // Try to parse from standard params string
        $parsedArgs = [];
        parse_str($content, $parsedArgs);
        return $parsedArgs;
    }

    /**
     * @param $action
     * @param null $id
     * @return array
     */
    protected function processJsonpRequest($action, $id = null)
    {
        $resp = [];

        // Dispatch based on action param
        switch ($action) {
            case 'read':
                $resp = isset($id) ? $this->get($id) : $this->getList();
                break;
            case 'create':
                $resp = $this->create($this->parseDataArgument());
                break;
            case 'update':
                $resp = $this->update($id, $this->parseDataArgument());
                break;
            case 'delete':
                $resp = $this->delete($id);
                break;
            default:
                $this->app->response()->setStatus(405);
        }

        return $resp;
    }

    protected function parseDataArgument()
    {
        if (! isset($this->queryParams['data'])) {
            return [];
        }

        // Try to decode from JSON
        $content = $this->queryParams['data'];
        $parsedArgs = json_decode($content, true);
        if (is_array($parsedArgs)) {
            return $parsedArgs;
        }

        // Try to parse from standard params string
        $parsedArgs = [];
        parse_str($content, $parsedArgs);
        return $parsedArgs;
    }
}
