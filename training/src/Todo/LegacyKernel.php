<?php
// src/Todo/LegacyKernel.php
namespace Todo;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

class LegacyKernel implements HttpKernelInterface
{
  private $sourceDir;

  public function __construct($sourceDir)
  {
    $this->sourceDir = realpath($sourceDir);
  }

  private function runFile($file, Request $request)
  {
    ob_start();
    require $this->sourceDir . DIRECTORY_SEPARATOR . $file;

    return new Response(ob_get_clean());
  }

  public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
  {
    try {
      $router = $this->createUrlMatcher($request);
      $params = $router->match($request->getPathinfo());

      if (isset($params['_file'])) {
        $response = $this->runFile($params['_file'], $request);
      } else {
        $request->attributes->add($params);
        $response = $this->runController($request);
      }

    } catch (ResourceNotFoundException $e) {
      return new Response('Page Not Found', 404);
    } catch (MethodNotAllowedException $e) {
      return new Response('Method Not Allowed', 405);
    } catch (\Exception $e) {
      return new Response('Internal Server Error', 500);
    }

    return $response;
  }

  private function createUrlMatcher(Request $request)
  {
    $context = new RequestContext();
    $context->fromRequest($request);

    $locator = new FileLocator([$this->sourceDir . '/config']);
    $loader = new YamlFileLoader($locator);
    $routes = $loader->load('routing.yml');

    return new UrlMatcher($routes, $context);
  }

  private function runController($request)
  {
    $params = explode('::', $request->attributes->get('_controller'));
    list($class, $method) = $params;
    $instance = new $class;

    $callable = array($instance, $method);
    $response = call_user_func_array($callable, array($request));

    if (!$response instanceOf Response) {
      throw new \RuntimeException('A controller must returnResponse.');
    }

    return $response;
  }

}