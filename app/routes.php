<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Domain\Controladores\Controlador_Paquetes as CP;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('index.twig'));
        return $response;
    });

    // $app->group('/paquetes', function (Group $group) {
    //   $group->get('', CP::class)->listarPaquetes();
    // });

    $app->POST('/paquetes', function (Request $request, Response $response, array $args) {
        // CP::listarPaquetes();
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('listado.twig'));
        return $response;
    });

    $app->get('/registro', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('registro.twig'));
        return $response;
    });

    $app->get('/login', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('login.twig'));
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});
};
