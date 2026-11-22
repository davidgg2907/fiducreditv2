<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use Tests\TestCase;

class DomainApiRefactorTest extends TestCase
{
    public function test_domain_controllers_declare_their_own_crud_actions(): void
    {
        $controllers = [];

        foreach (Route::getRoutes() as $route) {
            if (!str_starts_with($route->uri(), 'api/v1/')) {
                continue;
            }

            $action = $route->getActionName();
            $controller = explode('@', $action)[0];

            if (!str_starts_with($controller, 'App\\Http\\Controllers\\')) {
                continue;
            }

            if (!str_starts_with(class_basename($controller), 'Credit')
                && !str_starts_with(class_basename($controller), 'Pld')) {
                continue;
            }

            $controllers[$controller] = true;

            foreach ($route->parameterNames() as $parameter) {
                $this->assertLessThanOrEqual(
                    32,
                    strlen($parameter),
                    'Symfony limita los parámetros de ruta a 32 caracteres.'
                );
            }
        }

        $this->assertCount(83, $controllers);

        foreach (array_keys($controllers) as $controller) {
            foreach (['index', 'show', 'store', 'update', 'destroy'] as $method) {
                $reflection = new ReflectionMethod($controller, $method);

                $this->assertSame($controller, $reflection->getDeclaringClass()->getName());
            }

            $name = str_replace('Controller', '', class_basename($controller));

            $this->assertTrue(class_exists('App\\Models\\'.$name));
            $this->assertTrue(class_exists('App\\Services\\'.$name.'Service'));
            $this->assertTrue(class_exists('App\\Repositories\\'.$name.'Repository'));
            $this->assertTrue(class_exists('App\\Http\\Requests\\Store'.$name.'Request'));
            $this->assertTrue(class_exists('App\\Http\\Requests\\Update'.$name.'Request'));
        }
    }

    public function test_legacy_generic_crud_dependencies_are_absent(): void
    {
        $this->assertFalse(class_exists('App\\Http\\Controllers\\DomainResourceController'));
        $this->assertFalse(class_exists('App\\Services\\DomainCrudService'));
        $this->assertFalse(class_exists('App\\Http\\Requests\\DomainWriteRequest'));
    }

    public function test_domain_endpoint_requires_authentication(): void
    {
        config(['auth_tokens.cookie_secure' => false]);

        $this->getJson('/api/v1/credit-clients')
            ->assertStatus(401)
            ->assertJsonPath('isSuccess', false);
    }
}
