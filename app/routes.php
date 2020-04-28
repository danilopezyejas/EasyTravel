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
use App\Infrastructure\Persistence\db as DB;
//require __DIR__ . '/../src/config/db.php';
require __DIR__ . '/../src/Infrastructure/Persistence/db.php';


return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('index.twig'));
        return $response;
    });

    // $app->group('/prueba', function(Group $group){
    //     $group->get('', function ( Request $request, Response $response ){
    //       $response->getBody()->write("Funciono");
    //       return $response;
    //     });
    //     $group->get('/', function ( Request $request, Response $response ){
    //       $loader = new FilesystemLoader(__DIR__ . '/../vistas');
    //       $twig = new Environment($loader);
    //       $response->getBody()->write($twig->render('listado.twig'));
    //       return $response;
    //     });
    // });

    $app->POST('/paquetes', function (Request $request, Response $response, array $args) {
         CP::listarPaquetes();
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

    $app->post('/guardar', function (Request $request, Response $response) {
    $loader = new FilesystemLoader(__DIR__ . '/../vistas');
    $twig = new Environment($loader);
    $nombre = $request->getParsedBody()['nombre'];
    $apellidos = $request->getParsedBody()['apellido'];
      $nickname = $request->getParsedBody()['nickname'];
      $correo = $request->getParsedBody()['email'];
      //la funcion sha1 codifica la contrasña
      $pass = password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT);

     $sql = "INSERT INTO usuario (nombre, apellido, nikname, correo, password) VALUES
             (:nombre, :apellidos, :nickname, :correo, :pass)";

    try{
      $db = new DB();
      $db = $db->conexionDB();
      $resultado = $db->prepare($sql);

      $resultado->bindParam(':nombre', $nombre);
      $resultado->bindParam(':apellidos', $apellidos);
      $resultado->bindParam(':correo', $correo);
      $resultado->bindParam(':nickname', $nickname);
      $resultado->bindParam(':pass', $pass);

      $resultado->execute();

     $resultado = null;
     $db = null;
     $response->getBody()->write($twig->render('index.twig'));
   }catch(PDOException $e){
     $response->getBody()->write( '{"error" : {"text":'.$e->getMessage().'}}' );
   }
    //$response->getBody()->write("Guarde,$nombre");
    return $response;
    });
};
