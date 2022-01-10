<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Formulario;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Planta;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\EmpresaHasPerito;
use AppBundle\Entity\Mensaje;
use \DateTime;


class BaseController extends Controller
{
    /**
     * @Route("/secure/logout")
    */
    public function logout()
    {
    }

    /**
     * @Route("/", name="login")
     */
    public function loginAction()
    {
        // replace this example code with whatever you need        
        $url = $this->generateUrl('fos_user_security_login');
        $response = new RedirectResponse($url);
        return $response;
    }

    /**
     * @Route("/inicio", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/test", name="homepage-test")
     */
    public function indexTestAction(Request $request)
    {
        return $this->render('@STGTheme/Default/base.html.twig');

    }

    /**
     * @Route("/misTramites", name="misTramites")
     */
    public function misTramites(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $filtro["idTramite"] = 1;
        $entityManager = $this->getDoctrine()->getManager();
        $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$this->getUser()->getCuit()]);
        $perito = $entityManager->getRepository(Perito::class)->findOneBy(["persona"=>$persona]);
        $filtro["listaTramites"] = $entityManager->getRepository(ListaTramites::class)->findAll();
        $filtro["tramites"] = $entityManager->getRepository(Tramite::class)->findBy(["perito"=>$perito]);   
        $urlList = [];
        foreach($filtro["tramites"] as $tramite){
            foreach($filtro["listaTramites"] as $listaTramites){
                if($listaTramites->getDescripcion() == $tramite->getNombre()){
                    $urlList[$tramite->getId()] = $listaTramites->getUrl();
                    break;
                }
            }
        }
        $filtro["urlList"] = $urlList;
        return $this->render('default/misTramites.html.twig',$filtro);

    }
    
    /**
     * @Route("/tramites", name="tramites")
     */
    public function tramites(Request $request)
    {

        //Redirect login from admin 
        $user = $this->getUser();
        if($user != null){
            if($user->getRoles()[0] == 'ROLE_ADMIN'){
                return $this->redirectToRoute('admin/listadoTramite');
            }
        }
      

        $filtro = $this->getFiltro($request);
        $manager = $this->getDoctrine()->getManager();
        $repository = $manager->getRepository(ListaTramites::class);

        $listaTramites = $repository->findAll();
        $filtro["listaTramites"] = $listaTramites;
        
        return $this->render('default/tramites.html.twig',$filtro);

    }
    
    /**
     * @Route("/actividad", name="actividad")
     */
    public function actividad(Request $request)
    {
        $grupoId = $request->get('grupoId');
        $manager = $this->getDoctrine()->getManager();
        $datos = [];
        $actividades = $manager->getRepository(Actividad::class)->findBy(['grupo'=>$grupoId]);
        foreach($actividades as $actividad){
            $datos[] = [
                "id"=>$actividad->getId(),
                "nombreActividad"=>$actividad->getNombreActividad(),
                "estandar"=>$actividad->getEstandar(),
                "grupo"=>$actividad->getGrupo(),
                "cuacm"=>$actividad->getCuacm(),
                "estandarAmbiental"=>$actividad->getEstandar(),
            ];
        }
        $response = new Response( json_encode($datos) );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * @Route("/departamento", name="departamento")
     */
    public function departamento(Request $request)
    {
        $provincia = $request->get('provinciaId');
        $manager = $this->getDoctrine()->getManager();
        $datos = [];
        $departamentos = $manager->getRepository(Departamento::class)->findBy(['provincia'=>$provincia]);
        foreach($departamentos as $departamento){
            $datos[] = [
                "id"=>$departamento->getId(),
                "nombre"=>$departamento->getNombre(),
            ];
        }
        $response = new Response( json_encode($datos) );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * @Route("/localidad", name="localidad")
     */
    public function localidad(Request $request)
    {
        $departamento = $request->get('departamentoId');
        $manager = $this->getDoctrine()->getManager();
        $datos = [];
        $localidades = $manager->getRepository(Localidad::class)->findBy(['departamento'=>$departamento]);
        foreach($localidades as $localidad){
            $datos[] = [
                "id"=>$localidad->getId(),
                "nombre"=>$localidad->getNombre(),
                "codigoPostal"=>$localidad->getCodigoPostal(),
            ];
        }
        $response = new Response( json_encode($datos) );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function getFiltro(Request $request){
        $valores = $request->query->all();
        $filtro = [];
        $user = $this->getUser();
        $filtro["userSession"] = $user;
        if($user->getRoles()[0] == 'ROLE_ADMIN'){
            $filtro["rol"] = $valores;
        }else{
            $filtro["rol"] = [];
        }
        if($request->get("idTramite")!= null ){
            $filtro['idTramite'] = $request->get('idTramite');
        }
        if($request->get("idPlanta")!= null ){
            $filtro['idPlanta'] = $request->get('idPlanta');
        }
        return $filtro;
    }

    public function getTramite($idTramite){
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $entityManager->getRepository(Tramite::class)->find($idTramite);
        return $tramite ?? null;
    }
    
    public function getFormulario($idTramite){
        $entityManager = $this->getDoctrine()->getManager();
        $formulario = $entityManager->getRepository(Formulario::class)->findOneBy(['tramite'=>$idTramite]);
        return $formulario ?? null;
    }
    
    public function getPlanta($empresa){
        $entityManager = $this->getDoctrine()->getManager();
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(['empresa'=>$empresa]);
        return $planta ?? null;
    }

    /**
     * @Route("/mensajes/lista", name="/mensajes/lista", methods={"GET"})
     */
    public function listaMensaje(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $mensajes = $entityManager->getRepository(Mensaje::class)->findBy(['tramite'=>$request->get('idTramite')]);
        if($mensajes!=null){
            foreach($mensajes as $mensaje){
                $datos[] = [
                    "id"=>$mensaje->getId(),
                    "mensaje"=>$mensaje->getMensaje(),
                    "usuario"=>$mensaje->getPersona()->getRazonSocial(). " ". $mensaje->getPersona()->getCuit(),
                    "fechaCreacion"=>$mensaje->getFechaCreacion()->format('Y-m-d H:i:s')
                ];
            }    
            $response = new Response( json_encode($datos) );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            $response = new Response( 'No hay mensajes' );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }        
        
    }

    /**
     * @Route("/mensajes/nuevo", name="/mensajes/nuevo" , methods={"POST"})
     */
    public function nuevoMensaje(Request $request){
        try{
            $entityManager = $this->getDoctrine()->getManager();      
            $usuario = $this->getUser();  
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit'=>$this->getUser()->getCuit()]);
            if($persona == null){
                $persona = new Persona();
                $persona->setCuit($usuario->getCuit()); 
                $persona->setRazonSocial($usuario->getRazonSocial());
                $entityManager->persist($persona);
            }
            $mensaje = new Mensaje();
            $mensaje->setMensaje($request->get("mensaje"));
            $mensaje->setTramite($request->get("idTramite"));
            $mensaje->setPersona($persona);
            $mensaje->setFechaCreacion(new DateTime());
            $entityManager->persist($mensaje);
            $entityManager->flush();
            if($usuario->getRoles()[0] == 'ROLE_ADMIN'){
                $this->enviarMensaje($request->get("mensaje"), $request->get("idTramite"));
                              
            }
            $datos[]= ["ok"=>"ok"];
            $response = new Response( json_encode($datos) );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            
        }catch(\Exception $e){
            $response = new Response( json_encode($e->getMessage()) );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }    

    /**
     * @Route("/cambioestado", name="/cambioestado" , methods={"POST"})
     */
    public function cambioEstado(Request $request){
        try{
            $tramiteId = $this->getTramite($request->get("idTramite"));
            $estadoId = $request->get("idEstado");
            $entityManager = $this->getDoctrine()->getManager();
            $estado = $entityManager->getRepository(Estado::class)->find($estadoId);
            $tramite = $entityManager->getRepository(Tramite::class)->find($tramiteId);
            $tramite->setEstado($estado);
            $tramite->setFechaModificacion(new DateTime());
            $entityManager->persist($tramite);
            $entityManager->flush();
            $response = new Response(json_encode(["ok"=>"ok"]));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }catch(\Exception $e){
            $response = new Response( json_encode($e->getMessage()) );
            $response->headers->set('Content-Type', 'application/json');
            return $response;    
        }        
    }

    public function asociarEmpresaPerito($empresa,$perito){
        $entityManager = $this->getDoctrine()->getManager();
        $empresaHasPerito = $entityManager->getRepository(EmpresaHasPerito::class)->findBy(['empresa'=>$empresa,'perito'=>$perito]);
        if($empresaHasPerito == null){
            $empresaHasPerito = new EmpresaHasPerito();
        }
        $empresaHasPerito->setEmpresa($empresa);
        $empresaHasPerito->setPerito($perito);
        $entityManager->persist($empresaHasPerito);
        $entityManager->flush();
        return $empresaHasPerito;
    }


    public function buscarPerito(){
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$user->getCuit()]);//Sesion
        if($persona == null){
            $persona = new Persona();
            $persona->setCuit($user->getCuit()); //Sesion
            $persona->setRazonSocial($user->getRazonSocial()); //Sesion
            $entityManager->persist($persona);
        } 
        $perito = $entityManager->getRepository(Perito::class)->findOneBy(["persona"=>$persona]);
        if($perito == null){
            $perito = new Perito();
            $perito->setPersona($persona);
            $perito->setProfesion("Perito");
            $perito->setFirma($persona->getRazonSocial());
            $entityManager->persist($perito);
        }

        return $perito;
    }


    public function enviarMensaje($mensaje, $idTramite)
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $entityManager->getRepository(Tramite::class)->findOneBy(["id"=>$idTramite]);
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), 'tipo'=> 1]);
       
        $emailUser = $domicilio->getEmail();
        $empresa = $tramite->getEmpresa()->getPersona();

        $message = \Swift_Message::newInstance()
            ->setSubject('SIGTEA - (no responder a este email)')
            ->setFrom('evaluacionambiental@santafe.gov.ar')
            ->setTo($emailUser)
            ->setBody(
                $this->renderView(
                    'default/mensaje.html.twig',
                    array('mensaje' => $mensaje,'empresa'=>$empresa)
                ),
                'text/html'
            );
        
        return $this->get('mailer')->send($message);
    }

    /**
     * @Route("/eliminarRegistroEntidad", name="eliminarRegistroEntidad", methods={"POST"})
     */
    public function eliminarRegistroEntidad(Request $request){
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entidad = $entityManager->getRepository('AppBundle:'.$request->get('entidad'))->find($request->get('id'));
            if($entidad!=null){
                $entityManager->remove($entidad);
                $entityManager->flush();
            }

            $datos[]= ["ok"=>"ok"];
            $response = new Response( json_encode($datos) );
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (\Exception $e){
            return $e->getMessage();
        }        
    }


}