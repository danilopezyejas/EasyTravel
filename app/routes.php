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


return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $listaDestinos = CP::getDestinosGuardados();
        $destinos = "";
        foreach ($listaDestinos as $key => $value) {
          $destinos.=$value['ciudad'].',';
        }
        $datos = array('listaDestinos' => $destinos);
        $twig = new Environment($loader);
        $response->getBody()->write($twig->render('index.twig',$datos));
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
        $destinos = $cp->listarPaquetes($_POST['destino'],$_POST['precio'],$_POST['fecha'],$_POST['tematica']);
//        if($destinos["paquetes"]){
            $response->getBody()->write($twig->render('listadoPaquetes.twig',$destinos));
//        }else{
//            $response->getBody()->write($twig->render('listadoDestinos.twig',$destinos));
//        }
        return $response;
    });

    $app->post('/guardarPaquete', function (Request $request, Response $response, array $args) {
      $idAlojamiento = $_POST['idAlojamiento'];
      $idVuelo = $_POST['idVuelo'];
      $idDestino = $_POST['idDestino'];
      CU::guardarPaquete($idAlojamiento,$idVuelo,$idDestino);
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
        $response->getBody()->write($twig->render('index.twig'));
        return $response;
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
    $nick =CU::existeNick($usr);
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

    CU::guardarUsuario($usr);

    $response->getBody()->write($twig->render('index.twig'));
    return $response;
    });

//Luego que ingresa el usuario y la pass lo redirecciona al index.twig
    $app->post('/entrar', function (Request $request, Response $response) {
    $loader = new FilesystemLoader(__DIR__ . '/../vistas');
    $twig = new Environment($loader);

    $usr = new DTUsuario();
    $usr->setNickname($request->getParsedBody()['nickname']);
    $usr->setContrasenia($request->getParsedBody()['password']);
    $nickname =CU::login($usr);
    if (sizeof($nickname) !== 0  ){
        $response->getBody()->write($twig->render('index.twig',$nickname));
    }else{
        $response->getBody()->write($twig->render('login.twig'));
    }
//    $response->getBody()->write($nickname);

     return $response;
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

    $nick =CU::modificar($usr);

    if (sizeof($nick) !== 0  ){

//    $response->getBody()->write($nick['nickname']);
    return $response->withHeader('Location','/');
   // $response->getBody()->write($twig->render('index.twig',$nick));
    }
     return $response;
    });
//muestra los datos del usuario que se va a modificar
    $app->get('/modificarusr/{nick}', function (Request $request, Response $response,array $args) {       
        $loader = new FilesystemLoader(__DIR__ . '/../vistas');
        $twig = new Environment($loader);
        
        $nick = $args['nick'];
        $usr = new DTUsuario();
        //$usr->setNickname($request->getParsedBody()['logueado']);
        $usr->setNickname($nick);
        $usuario = CU::getUsuarioLogueado($usr);

//        $nombre = array('nombre'=> $usr->getNombre());
        $response->getBody()->write($twig->render('modificar.twig',$usuario));
        return $response;
    });
};
