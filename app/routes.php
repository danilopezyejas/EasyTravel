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
use App\Domain\Clases\DtUsuario as DTUsuario;

require __DIR__ . '/../src/Infrastructure/Persistence/db.php';

session_start();

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $listaDestinos = CP::getDestinosGuardados();
        $destinos = "";
        foreach ($listaDestinos as $key => $value) {
            $destinos .= $value['ciudad'] . ',';
        }
        $datos = array('listaDestinos' => $destinos);
        $twig = new Environment($loader);
        $twig->addGlobal('session', $_SESSION);

        $response->getBody()->write($twig->render('index.twig', $datos));
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
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $cp = new CP;
        $destinos = $cp->listarPaquetes($_POST['destino'], $_POST['precio'], $_POST['fecha'], $_POST['tematica']);
        $twig->addGlobal('session', $_SESSION);
        if (isset($destinos["paquetes"])) {
            //Busqueda por precio
            $response->getBody()->write($twig->render('listadoPaquetes.twig', $destinos));
        } else {
            //Busqueda comun
            $response->getBody()->write($twig->render('listadoDestinos.twig', $destinos));
        }
        return $response;
    });

    $app->post('/guardarPaquete', function (Request $request, Response $response, array $args) {
        $idAlojamiento = $_POST['idAlojamiento'];
        $idVuelo = $_POST['idVuelo'];
        $idDestino = $_POST['idDestino'];
        CU::guardarPaquete($idAlojamiento, $idVuelo, $idDestino);
        return $response;
    });
//Para registrar un nuevo usuario
    $app->get('/registro', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('registro.twig'));
        return $response;
    });
//Para que un usuario se loguee
    $app->get('/login', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('login.twig'));
        return $response;
    });
//Para que un usuario se desloguee
    $app->get('/logout', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        session_destroy();
        session_start();
        // $_SESSION['salida']= 'SI';
        return $response->withHeader('Location', '/EasyTravel/public');
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

// para chequear que el nickname no existe
    $app->get('/nickname/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];

        $usr = new DTUsuario();
        $usr->setNickname($name);
        $nick = CU::existeNick($usr);
        $response->getBody()->write($nick);
        return $response;
    });
//Guardar los datos de un usuario que se Registra.
    $app->post('/guardar', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);

        $usr = new DTUsuario();
        $usr->setNombre($request->getParsedBody()['nombre']);
        $usr->setApellido($request->getParsedBody()['apellido']);
        $usr->setNickname($request->getParsedBody()['nickname']);
        $usr->setCorreo($request->getParsedBody()['email']);
        $usr->setContrasenia(password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT));
        //$usr->setContrasenia($request->getParsedBody()['password']);

        $nickname = CU::guardarUsuario($usr);
        if ($nickname['nickname'] !== '') {
            $nickname = CU::login($usr);
            $_SESSION['nuevo'] = 'SI';
            $_SESSION['nick'] = $nickname['nickname'];
            return $response->withHeader('Location', '/EasyTravel/public');
        } else {
            $_SESSION['nuevo'] = 'NO';
            $_SESSION['nick'] = '';
            return $response->withHeader('Location', '/EasyTravel/public');
        }
    });

//Luego que ingresa el usuario y la pass lo redirecciona al index.twig
    $app->post('/entrar', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);

        $usr = new DTUsuario();
        $usr->setNickname($request->getParsedBody()['nickname']);
        $usr->setContrasenia($request->getParsedBody()['password']);

        $nickname = CU::login($usr);

        if ($nickname['nickname'] !== '') {
            // Set session variables
            $_SESSION['nuevo'] = 'SI';
            $_SESSION["nick"] = $nickname['nickname'];
        } else {
            return $response->withHeader('Location', '/EasyTravel/public/login');
        }
        return $response->withHeader('Location', '/EasyTravel/public');
    });
//Modifica los datos del usuario que está logueado
    $app->post('/modificar', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);

        $usr = new DTUsuario();
        $usr->setNickname($request->getParsedBody()['nickname']);
        $usr->setNombre($request->getParsedBody()['nombre']);
        $usr->setApellido($request->getParsedBody()['apellido']);
        $usr->setCorreo($request->getParsedBody()['email']);
        $usr->setContrasenia(password_hash($request->getParsedBody()['password'], PASSWORD_DEFAULT));

        $_SESSION['nick'] = CU::modificar($usr)['nickname'];

        if ($_SESSION['nick'] !== '') {
            $_SESSION['modificado'] = 'SI';

        }
        return $response->withHeader('Location', '/EasyTravel/public');
    });
//muestra los datos del usuario que se va a modificar
    $app->post('/modificarusr', function (Request $request, Response $response, array $args) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        //$nick = $_SESSION["nick"];
        //$nick = $args['nick'];
        $usr = new DTUsuario();
        $usr->setNickname($request->getParsedBody()['logueado']);
        //$usr->setNickname($nick);
        $usuario = CU::getUsuarioLogueado($usr);


//        $nombre = array('nombre'=> $usr->getNombre());
        $response->getBody()->write($twig->render('modificar.twig', $usuario));
        return $response;
    });
};
