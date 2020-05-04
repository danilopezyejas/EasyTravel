<?php
declare(strict_types=1);


use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Domain\Controladores\Controlador_usuario as CU;
use App\Domain\Controladores\Controlador_paquetes as CP;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
//use App\Infrastructure\Persistence\db as DB;
use App\Domain\Clases\DtUsuario as DTUsuario;

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

    $app->post('/paquetes', function (Request $request, Response $response, array $args) {
        // CP::listarPaquetes();
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $cp = new CP;
        $destinos = $cp->listarPaquetes($_POST['destino']);
        //var_dump($destinos);
        $response->getBody()->write($twig->render('listado.twig',$destinos));
        // $response->getBody()->write($twig->render('usuarios_listados.twig', $datos));
        //$response->getBody($destinos);
        return $response;
    });

    $app->get('/registro', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('registro.twig'));
        return $response;
    });

    $app->get('/modificar', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('modificar.twig'));
        return $response;
    });
    
    $app->get('/login', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('login.twig'));
        return $response;
    });
    $app->get('/logout', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('index.twig'));
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

    $usr = new DTUsuario();
    $usr->setNombre($request->getParsedBody()['nombre']);
    $usr->setApellido($request->getParsedBody()['apellido']);
    $usr->setNickname($request->getParsedBody()['nickname']);
    $usr->setCorreo($request->getParsedBody()['email']);  
    $usr->setContrasenia(password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT));

    CU::guardarUsuario($usr);
         
    $response->getBody()->write($twig->render('index.twig'));
    //$response->getBody()->write("Guarde,$nombre");
    return $response;
    });
    
    
    $app->post('/entrar', function (Request $request, Response $response) {
    $loader = new FilesystemLoader(__DIR__ . '/../vistas');
    $twig = new Environment($loader);
    
    $usr = new DTUsuario();
    $usr->setNickname($request->getParsedBody()['nickname']);    
    $usr->setContrasenia(password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT));
    $nickname =CU::login($usr);
    if (sizeof($nickname) !== 0  ){
        $response->getBody()->write($twig->render('index.twig',$nickname));
    }else{
        $response->getBody()->write($twig->render('login.twig'));
    }
     return $response;
    });
    
    $app->post('/modificar', function (Request $request, Response $response) {
    $loader = new FilesystemLoader(__DIR__ . '/../vistas');
    $twig = new Environment($loader);
    
    $usr = new DTUsuario();
    $usr->setNickname($request->getParsedBody()['nickname']);
    $usr->setNombre($request->getParsedBody()['nombre']);
    $usr->setApellido($request->getParsedBody()['apellido']);
    $usr->setCorreo($request->getParsedBody()['email']);  
    $usr->setContrasenia(password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT));
    
    $nick =CU::modificar($usr);
    
    if (sizeof($nick) !== 0  ){
    $response->getBody()->write($twig->render('index.twig',$nick));
    }
     return $response;
    });
};
