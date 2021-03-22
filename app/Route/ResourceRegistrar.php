<?php

namespace App\Route;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class ResourceRegistrar extends BaseResourceRegistrar
{
    protected $resourceDefaults = [
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'delete',
    ];

    /**
     * Add the list method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    public function addResourceDelete($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/{'.$base.'}/delete';

        $action = $this->getResourceAction($name, $controller, 'delete', $options);

        return $this->router->get($uri, $action);
    }
}