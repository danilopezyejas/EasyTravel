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
use App\Domain\Clases\Resenia as Resenia;
use App\Domain\Clases\DtResenia as DtResenia;

require __DIR__ . '/../src/Infrastructure/Persistence/db.php';

session_start();

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        //para buscar y devolver las reseñas que se muestran en el inicio
        $resenias = CP::verResenias();
        $listaDestinos = CP::getDestinosGuardados();
        $destinos = "";
        foreach ($listaDestinos as $key => $value) {
            $destinos .= $value['ciudad'] . ',';
        }
        $datos = array('listaDestinos' => $destinos,
                        'resenias' => $resenias);
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
        $_SESSION['nuevo'] = 'NO';
        $_SESSION['modificado'] = 'NO';
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
        set_time_limit(60);
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
        $_SESSION['nuevo'] = 'NO';
        $_SESSION['modificado'] = 'NO';
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
        $args['name'] = null;
        return $response;
    });
// para ingresar una reseña del paquete
    $app->get('/resenia/{id_paquete}', function (Request $request, Response $response, array $args) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $id = $request->getAttribute('id_paquete');
        $id_usuario = $_SESSION['nick'];
        $fecha_viaje = $request->getAttribute('fecha_viaje');
        $datos = array('id_paquete'=>$id,
                        'id_usuario'=>$id_usuario,
                        'fecha_viaje'=>$fecha_viaje
        );
        $response->getBody()->write($twig->render('resenia.twig',$datos));
        return $response;


    });

//Guardar los datos de reseña
    $app->post('/resenia/guardar', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $usr = $_SESSION['nick'];
        $usuario = CU::getUsuarioLogueado($usr)['id_usuario'];
        $res = new DtResenia();
        $res->setDescripcion($_POST['comentarios']);
        $res->setIdPaquete($_POST['paquete']);
        $res->setValoracion($_POST['estrella']);
        $res->setIdUsuario($usuario);

        $respuesta = CU::guardarResenia($res);
        if ($respuesta['resenia'] !== '') {
            return $response->withHeader('Location', '/EasyTravel/public/');
        } else {
            return $response->withHeader('Location', '/EasyTravel/public/resenia/'.$_POST['paquete']);
        }
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

        $nickname = CU::guardarUsuario($usr);

        if ($nickname['nickname'] !== '') {
            $nickname = CU::login($usr);
            $_SESSION['nuevo'] = 'SI';
            $_SESSION['nick'] = $nickname['nickname'];
            $_SESSION['mail'] = $nickname['correo'];
        } else {
          $_SESSION['nuevo'] = 'NO';
          $_SESSION['modificado'] = 'NO';
          $_SESSION['nick'] = '';
        }
        return $response->withHeader('Location', '/EasyTravel/public');
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
            $_SESSION['mail'] = $nickname['correo'];
            $_SESSION['idUsuario'] = $nickname['idUsuario'];
            return $response->withHeader('Location', '/EasyTravel/public');
        } else {
            return false;
        }
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
        $_SESSION['mail'] = $usr->getCorreo();
        if ($_SESSION['nick'] !== '') {
            $_SESSION['modificado'] = 'SI';
        }
        return $response->withHeader('Location', '/EasyTravel/public');
    });

//muestra los datos del usuario que se va a modificar
    $app->get('/modificarusr/{usuario}', function (Request $request, Response $response, array $args) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        $_SESSION['nuevo'] = 'NO';
        $_SESSION['modificado'] = 'NO';
        $usr = $request->getAttribute('usuario');
        $usuario = CU::getUsuarioLogueado($usr);
        $paquetes= CP::getPaquetesComprados($usr);
        $resenias= CP::getResenias($usr);
        $paquetes['usuario']= $usuario ;
        $paquetes['resenias'] = $resenias;
        $response->getBody()->write($twig->render('modificar.twig',$paquetes));
        return $response;
    });
};
