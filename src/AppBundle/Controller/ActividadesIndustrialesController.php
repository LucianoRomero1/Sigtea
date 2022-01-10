<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\StorageService;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\EmpresaHasActividad;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Representante;
use AppBundle\Entity\EmpresaHasRepresentante;
use AppBundle\Entity\Planta;
use AppBundle\Entity\PartidaInmobiliaria;
use AppBundle\Entity\Producto;
use AppBundle\Entity\SubProducto;
use AppBundle\Entity\MateriaPrima;
use AppBundle\Entity\Insumo;
use AppBundle\Entity\SustanciaAuxiliar;
use AppBundle\Entity\InmuebleAnexo;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\DimencionamientoPlanta;
use AppBundle\Entity\FormacionPersonal;
use AppBundle\Entity\Storage;
use AppBundle\Entity\EmisionGaseosa;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\RiesgoPresunto;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Tanque;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\Estado;
use \DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ActividadesIndustrialesController extends BaseController
{
    /**
     * @Route("/formularioIndustriasEstudioImpactoAmbiental", name="formularioIndustriasEstudioImpactoAmbiental", methods={"GET"})
     */
    public function formulario(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
            if($tramite != null){
                $empresa = $tramite->getEmpresa() ?? null;
                if($empresa != null){
                    $filtro['Empresa'] = $empresa;
                    $filtro['Persona'] = $empresa->getPersona();
                    $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
                    if($empresaHasActividad != null){
                        $filtro['Actividad'] = $empresaHasActividad;
                        $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
                    }           
                }
            }
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(3);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $tramite->setEstado($estado);
            $tramite->setFechaCreacion(new DateTime());
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$this->getUser()->getCuit()]);
            if($persona == null){
                $persona = new Persona();
                $persona->setCuit($this->getUser()->getCuit());
                $persona->setRazonSocial($this->getUser()->getRazonSocial());
                $entityManager->persist($persona);
            } 
            $perito = $entityManager->getRepository(Perito::class)->findOneBy(["persona"=>$persona]);
            if($perito ==null){
                $perito = new Perito();
                $perito->setPersona($persona);
                $perito->setProfesion("Perito");
                $perito->setFirma($persona->getRazonSocial());
                $entityManager->persist($perito);
            }
            $tramite->setPerito($perito);
            $entityManager->persist($tramite);
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$persona]);
            if($empresa==[]){
                $empresa = new Empresa();            
            }
            $empresa->setFechaInicioActividad(new \DateTime(date('y-m-d') ));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);        
            $entityManager->persist($empresa);
            $entityManager->flush();
        }          
        $filtro['idTramite'] = $tramite->getId();        
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['titulo']= $tramite->getNombre();
        return $this->render('actividadIndustrial/formularioA1.html.twig',$filtro);        
    }
    /**
     * @Route("/formularioExpendioCombustibleEsIA", name="formularioExpendioCombustibleEsIA", methods={"GET"})
     */
    public function formularioExpendioCombustible(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
            if($tramite != null){
                $empresa = $tramite->getEmpresa() ?? null;
                if($empresa != null){
                    $filtro['Empresa'] = $empresa;
                    $filtro['Persona'] = $empresa->getPersona();
                    $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
                    if($empresaHasActividad != null){
                        $filtro['Actividad'] = $empresaHasActividad;
                        $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
                    }           
                }
            }
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(12);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $tramite->setEstado($estado);
            $tramite->setFechaCreacion(new DateTime());
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$this->getUser()->getCuit()]);
            if($persona == null){
                $persona = new Persona();
                $persona->setCuit($this->getUser()->getCuit());
                $persona->setRazonSocial($this->getUser()->getRazonSocial());
                $entityManager->persist($persona);
            } 
            $perito = $entityManager->getRepository(Perito::class)->findOneBy(["persona"=>$persona]);
            if($perito ==null){
                $perito = new Perito();
                $perito->setPersona($persona);
                $perito->setProfesion("Perito");
                $perito->setFirma($persona->getRazonSocial());
                $entityManager->persist($perito);
            }
            $tramite->setPerito($perito);
            $entityManager->persist($tramite);
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$persona]);
            if($empresa==[]){
                $empresa = new Empresa();            
            }
            $empresa->setFechaInicioActividad(new \DateTime(date('y-m-d') ));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);        
            $entityManager->persist($empresa);
            $entityManager->flush();
        }          
        $filtro['idTramite'] = $tramite->getId();        
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['titulo']= $tramite->getNombre();
        return $this->render('actividadIndustrial/formularioA1.html.twig',$filtro);        
    }
    /**
     * @Route("/formularioAcopioGranosEsIA", name="formularioAcopioGranosEsIA", methods={"GET"})
     */
    public function formularioAcopioGranosEsIA(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
            if($tramite != null){
                $empresa = $tramite->getEmpresa() ?? null;
                if($empresa != null){
                    $filtro['Empresa'] = $empresa;
                    $filtro['Persona'] = $empresa->getPersona();
                    $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
                    if($empresaHasActividad != null){
                        $filtro['Actividad'] = $empresaHasActividad;
                        $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
                    }           
                }
            }
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(12);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $tramite->setEstado($estado);
            $tramite->setFechaCreacion(new DateTime());
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$this->getUser()->getCuit()]);
            if($persona == null){
                $persona = new Persona();
                $persona->setCuit($this->getUser()->getCuit());
                $persona->setRazonSocial($this->getUser()->getRazonSocial());
                $entityManager->persist($persona);
            } 
            $perito = $entityManager->getRepository(Perito::class)->findOneBy(["persona"=>$persona]);
            if($perito ==null){
                $perito = new Perito();
                $perito->setPersona($persona);
                $perito->setProfesion("Perito");
                $perito->setFirma($persona->getRazonSocial());
                $entityManager->persist($perito);
            }
            $tramite->setPerito($perito);
            $entityManager->persist($tramite);
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$persona]);
            if($empresa==[]){
                $empresa = new Empresa();            
            }
            $empresa->setFechaInicioActividad(new \DateTime(date('y-m-d') ));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);        
            $entityManager->persist($empresa);
            $entityManager->flush();
        }          
        $filtro['idTramite'] = $tramite->getId();        
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['titulo']= $tramite->getNombre();
        return $this->render('actividadIndustrial/formularioA1.html.twig',$filtro);        
    }
    
    /**
     * @Route("/tramiteA1", name="/tramiteA1", methods={"POST"})
     */
    public function tramite1A(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);        
        $datos['Persona'] = $request->get('Persona');
        $datos['Empresa'] = $request->get('Empresa');
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            if($datos['Persona']!=null){
                $cuit = trim($datos['Persona']["cuit"]);
                $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
                if($persona==[]){
                    $persona = new Persona();            
                }        
                $persona->setRazonSocial($datos['Persona']["razonSocial"]);
                $persona->setCuit($cuit);
                $entityManager->persist($persona);
            }
            $domicilio = null;
            if($datos['Empresa']!=null){
                $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$persona]);
                if($empresa==[]){
                    $empresa = new Empresa();            
                }
                $empresa->setFechaInicioActividad(new \DateTime($datos['Empresa']["fechaInicio"] ?? date('y-m-d') ));
                $empresa->setTipoPersona($datos['Empresa']["tipoEntidad"] ?? 1);
                $empresa->setDeposito($datos['Empresa']["deposito"] ? 1 : 0);
                $empresa->setPersona($persona);        
                $entityManager->persist($empresa);
                $tramite->setEmpresa($empresa);
                $entityManager->persist($tramite);
                $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
                if($domicilio!=null){
                    $filtro['Domicilio'] = $domicilio;
                }
            }        
            if($request->get('actividadEmpresa')!=null){            
                for($i=0;$i<count($request->get('actividadEmpresa'));$i++){
                    $actividad = $entityManager->getRepository(Actividad::class)->find($request->get('actividadEmpresa')[$i]);
                    $empresaHasActividad = new EmpresaHasActividad();
                    $empresaHasActividad->setActividad($actividad);
                    $empresaHasActividad->setTipo($request->get('prse')[$i]);
                    $empresaHasActividad->setEmpresa($empresa);
                }            
                $entityManager->persist($empresaHasActividad);
            }
            $entityManager->flush();
        }
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();

        $filtro['deptos'] = $entityManager->getRepository(Departamento::class)->findAll();

        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>1]);
        if($domicilio!=null){
            $filtro['Domicilio'] = $domicilio;
        }
        return $this->render('actividadIndustrial/formularioA2.html.twig',$filtro);        
    }
    
    /**
     * @Route("/tramiteA2", name="tramiteA2" , methods={"POST"})
     */
    public function tramiteA2(Request $request)
    {
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Domicilio'] = $request->get('Domicilio');
            if($datos['Domicilio']!=null){
                $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa()]);
                if($domicilio == null){
                    $domicilio = new Domicilio();            
                }        
                $domicilio->setCalle($datos['Domicilio']["calle"]);
                $domicilio->setNumero($datos['Domicilio']["numero"]);
                $domicilio->setPiso($datos['Domicilio']["piso"]);
                $domicilio->setDepto($datos['Domicilio']["depto"]);
                $domicilio->setTelefono($datos['Domicilio']["telefono"]);
                $domicilio->setEmail($datos['Domicilio']["email"]);
                $domicilio->setEmpresa($tramite->getEmpresa());
                $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
                $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
                $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
                $domicilio->setProvincia($provincia);
                $domicilio->setLocalidad($localidad);
                $domicilio->setDepartamento($departamento);
                $domicilio->setTipo(1);
                $entityManager->persist($domicilio);
                $entityManager->flush();
            }
        }
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        if($domicilio != null){
            $filtro['Domicilio'] = $domicilio;
        }
        return $this->render('actividadIndustrial/formularioA3.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA3", name="tramiteA3" , methods={"POST"})
     */
    public function tramiteA3(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Domicilio'] = $request->get('Domicilio');
            if($datos['Domicilio']!=null){
                $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa()]);
                if($domicilio == null){
                    $domicilio = new Domicilio();
                }
                $domicilio->setCalle($datos['Domicilio']["calle"]);
                $domicilio->setNumero($datos['Domicilio']["numero"]);
                $domicilio->setPiso($datos['Domicilio']["piso"]);
                $domicilio->setDepto($datos['Domicilio']["depto"]);
                $domicilio->setTelefono($datos['Domicilio']["telefono"]);
                $domicilio->setEmail($datos['Domicilio']["email"]);
                $domicilio->setEmpresa($tramite->getEmpresa());
                $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
                $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
                $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
                $domicilio->setProvincia($provincia);
                $domicilio->setLocalidad($localidad);
                $domicilio->setDepartamento($departamento);
                $domicilio->setTipo(2);
                $entityManager->persist($domicilio);
                $entityManager->flush();
            }
        }
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"1"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        }
        return $this->render('actividadIndustrial/formularioA4.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA4", name="tramiteA4" , methods={"POST"})
     */
    public function tramiteA4(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Persona'] = $request->get('Persona');
            $datos['Representante'] = $request->get('Representante');
            if($datos['Persona']!=null){
                for( $i = 0; $i <count($datos['Persona']['razonSocial']); $i++){
                    $cuit = trim($datos['Persona']["cuit"][$i]);
                    $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
                    if($persona == null){
                        $persona = new Persona();            
                    }
                    $persona->setRazonSocial($datos['Persona']["razonSocial"][$i]);
                    $persona->setCuit($cuit);                
                    $entityManager->persist($persona);
                    $representante = $entityManager->getRepository(Representante::class)->findOneBy(['persona' => $persona]);
                    if($representante == null){
                        $representante = new Representante();                
                    }
                    $representante->setTipo(1);
                    $representante->setCargo($datos['Representante']['cargo'][$i]);
                    $representante->setPersona($persona);
                    $entityManager->persist($representante);
                    $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findOneBy(['empresa'=>$tramite->getEmpresa(),'representante'=>$representante]);
                    if($empresaHasRepresentante==null){
                        $empresaHasRepresentante = new EmpresaHasRepresentante();             
                    }            
                    $empresaHasRepresentante->setEmpresa($tramite->getEmpresa());
                    $empresaHasRepresentante->setRepresentante($representante);
                    $entityManager->persist($empresaHasRepresentante);
                }    
                $entityManager->flush();     
            }     
        }   
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"2"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        }
        return $this->render('actividadIndustrial/formularioA5.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA5", name="tramiteA5" , methods={"POST"})
     */
    public function tramiteA5(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Persona'] = $request->get('Persona');
            $datos['Representante'] = $request->get('Representante');
            if($datos['Persona']!= null){
                for( $i = 0; $i <count($datos['Persona']['razonSocial']); $i++){
                    $cuit = trim($datos['Persona']["cuit"][$i]);
                    $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
                    if($persona == null){
                        $persona = new Persona();                
                    }
                    $persona->setRazonSocial($datos['Persona']["razonSocial"][$i]);
                    $persona->setCuit($cuit);                
                    $entityManager->persist($persona);
                    $representante = $entityManager->getRepository(Representante::class)->findOneBy(['persona' => $persona]);
                    if($representante == null){
                        $representante = new Representante();                
                    }
                    $representante->setTipo(2);
                    $representante->setCargo($datos['Representante']['cargo'][$i]);
                    $representante->setPersona($persona);
                    $entityManager->persist($representante);
                    $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findOneBy(['empresa'=>$tramite->getEmpresa(),'representante'=>$representante]);
                    if($empresaHasRepresentante==null){
                        $empresaHasRepresentante = new EmpresaHasRepresentante();             
                    }            
                    $empresaHasRepresentante->setEmpresa($tramite->getEmpresa());
                    $empresaHasRepresentante->setRepresentante($representante);
                    $entityManager->persist($empresaHasRepresentante);
                }    
                $entityManager->flush();
            }
        }
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"3"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);        
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        }
        return $this->render('actividadIndustrial/formularioA6.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA6", name="tramiteA6" , methods={"POST"})
     */
    public function tramiteA6(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Persona'] = $request->get('Persona');
            if($datos['Persona']!=null){
                for( $i = 0; $i <count($datos['Persona']['razonSocial']); $i++){
                    $cuit = trim($datos['Persona']["cuit"][$i]);
                    $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
                    if($persona == null){
                        $persona = new Persona();                
                    }
                    $persona->setRazonSocial($datos['Persona']["razonSocial"][$i]);
                    $persona->setCuit($cuit);                
                    $entityManager->persist($persona);
                    $representante = $entityManager->getRepository(Representante::class)->findOneBy(['persona' => $persona]);
                    if($representante == null){
                        $representante = new Representante();                
                    }
                    $representante->setTipo(3);
                    $representante->setCargo('Representante Legal');
                    $representante->setPersona($persona);
                    $entityManager->persist($representante);
                    $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findOneBy(['empresa'=>$tramite->getEmpresa(),'representante'=>$representante]);
                    if($empresaHasRepresentante==null){
                        $empresaHasRepresentante = new EmpresaHasRepresentante();                 
                    }         
                    $empresaHasRepresentante->setEmpresa($tramite->getEmpresa());
                    $empresaHasRepresentante->setRepresentante($representante);
                    $entityManager->persist($empresaHasRepresentante);
                }    
                $entityManager->flush();     
            }        
        }
        $filtro['peritos'] = $entityManager->getRepository(Perito::class)->findAll();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $empresa = $tramite->getEmpresa();
        $domicilioRepository = $entityManager->getRepository(Domicilio::class);        
        $domicilio = $domicilioRepository->findDomicilio($empresa,3);
        if($domicilio != null){
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilio]);
            $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findBy(["planta"=>$planta]);
            $filtro['PartidaInmobiliaria'] = $partidaInmobiliaria;
            $filtro['Domicilio'] = $domicilio[0];
        }
        return $this->render('actividadIndustrial/formularioA8.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA8", name="tramiteA8", methods={"POST"})
     */
    public function tramiteA8(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);           
        $domicilioRepository = $entityManager->getRepository(Domicilio::class);
        $domicilio = $domicilioRepository->findDomicilio($tramite->getEmpresa(),3);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilio]);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Domicilio'] = $request->get('Domicilio');
            $datos['Coordenadas'] = $request->get('Coordenadas');
            if($datos['Domicilio'] != null){
                if($domicilio == null && !isset($domicilio[0])){
                    $domicilio = new Domicilio();            
                }else{
                    $domicilio = $domicilio[0];    
                }
                $domicilio->setCalle($datos['Domicilio']["calle"]);
                $domicilio->setNumero($datos['Domicilio']["numero"]);
                $domicilio->setPiso($datos['Domicilio']["piso"]);
                $domicilio->setDepto($datos['Domicilio']["depto"]);
                $domicilio->setTelefono($datos['Domicilio']["telefono"]);
                $domicilio->setEmail($datos['Domicilio']["email"]);
                $domicilio->setEmpresa($tramite->getEmpresa());
                $domicilio->setZonificacion($datos['Domicilio']["zona"]);
                $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
                $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
                $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
                $domicilio->setProvincia($provincia);
                $domicilio->setLocalidad($localidad);
                $domicilio->setDepartamento($departamento);
                $domicilio->setTipo(3);
                $entityManager->persist($domicilio);
                if($planta == null){
                    $planta = new Planta();            
                }        
                $planta->setEmpresa($tramite->getEmpresa());
                $planta->setDomicilio($domicilio);
                $entityManager->persist($planta);
                
                if($datos['Coordenadas']!= null){
                    for($i=0;$i<count($datos['Coordenadas']['partida']);$i++){
                        $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['numero'=>$datos['Coordenadas']['partida'][$i]]);
                        if($partidaInmobiliaria == null){
                            $partidaInmobiliaria = new PartidaInmobiliaria();                
                        }
                        $partidaInmobiliaria->setNumero($datos['Coordenadas']['partida'][$i]);
                        $partidaInmobiliaria->setLatitud($datos['Coordenadas']['lat'][$i]);
                        $partidaInmobiliaria->setLongitud($datos['Coordenadas']['long'][$i]);
                        $partidaInmobiliaria->setPlanta($planta);
                        $entityManager->persist($partidaInmobiliaria);
                    }
                }

                $entityManager->flush();
            }
        }
        $filtro['idPlanta']=$planta->getId();        
        $filtro['Storage'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9"]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.4"]);
        $filtro['Storage5'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.5"]);
        $filtro['Storage6'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.6"]);
        $filtro['Storage7'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.7"]);
        return $this->render('actividadIndustrial/formularioA9.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteA9", name="tramiteA9")
     */
    public function tramiteA9(Request $request)
    {
        $filtro = $this->getFiltro($request); 
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){     
            $datos['Observaciones'] = $request->get('Observaciones');
            if($datos['Observaciones'] != null){

                $storage = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9"]);
                if ($storage == null){
                    $storage = new Storage();
                }
                $storage -> setObservaciones($datos['Observaciones']);
                $storage -> setInciso("9");
                $storage -> setTramite( $tramite );
                $entityManager -> persist( $storage );

            }
            $entityManager->flush();
        }
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $domicilioRepository = $entityManager->getRepository(Domicilio::class);
        $domicilio = $domicilioRepository->findDomicilio($tramite->getEmpresa(),3);
        if($domicilio != null){
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilio]);
            $filtro['Planta'] = $planta;
            $filtro['Domicilios'] = $domicilioRepository->findDomicilio($tramite->getEmpresa(),4);
        }
        return $this->render('actividadIndustrial/formularioB1.html.twig',$filtro);
    }

    /**
     * @Route("/archivo",methods={"POST"}, name="archivo")
     */
    public function archivo(Request $request)
    {
        $storage = new StorageService($this->getDoctrine()->getManager());
        foreach($request->files->get("files") as $file){
            if ($storage->generarUID($file)){
                $storage->crearDirectorio();
                $storage->subirArchivo();
            }else{
                return new JsonResponse([
                    'success' => false,
                    'res' => "ERROR: Uno de sus archivos no es PDF"
                ]);
            }
        }
        return new JsonResponse([
            'success' => true,
            'res' => "Se cargaron correctamente todos los archivos!"
        ]);
    }
    
    /**
     * @Route("/tramiteB1", name="tramiteB1", methods={"POST"})
     */
    public function tramiteB1(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);  
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
        $datos['Domicilio'] = $request->get('Domicilio');
        $datos['Planta'] = $request->get('Planta');
            if($datos['Planta']['otrasFueraProvincia'] == "SI" && isset($datos['Domicilio']['calle'])){

                for($i=0;$i<count($datos['Domicilio']['calle']);$i++){
                    $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["tipo"=>4,"empresa"=>$tramite->getEmpresa()]);
                    if($domicilio == null){
                        $domicilio = new Domicilio();                    
                    }
                    $domicilio->setCalle($datos['Domicilio']["calle"][$i]);
                    $domicilio->setEmpresa($tramite->getEmpresa());
                    $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"][$i]);
                    $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"][$i]);
                    $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"][$i]);
                    $domicilio->setProvincia($provincia);
                    $domicilio->setLocalidad($localidad);
                    $domicilio->setDepartamento($departamento);                
                    $domicilio->setTipo(4);
                    $entityManager->persist($domicilio);
                }
                $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
                if($planta==null){
                    $planta = new Planta();            
                }
                $planta->setNombre($datos['Planta']['nombre']);
                $planta->setFueraProvincia($datos['Planta']['otrasFueraProvincia']);
                $planta->setEmpresa($tramite->getEmpresa());
                if($datos['Planta']['InicioFecha'] == "SI"){
                    $planta->setFechaInicioActividades(new \DateTime($datos['Planta']['inicioActividades']));
                }
                $entityManager->persist($planta);        
                $entityManager->flush();
            }
        }
        $filtro['Empresa'] = $tramite->getEmpresa();
        $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]);
        $filtro['Actividad'] = $empresaHasActividad->getActividad()->getNombreActividad();
        $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]);
        $filtro["Productos"] = $entityManager->getRepository(Producto::class)->findBy(["planta"=>$planta]);
        $filtro["SubProductos"] = $entityManager->getRepository(SubProducto::class)->findBy(["planta"=>$planta]);
        $filtro["MateriaPrima"] = $entityManager->getRepository(MateriaPrima::class)->findBy(["planta"=>$planta]);
        $filtro["Insumo"] = $entityManager->getRepository(Insumo::class)->findBy(["planta"=>$planta]);
        $filtro["SustanciaAuxiliares"] = $entityManager->getRepository(SustanciaAuxiliar::class)->findBy(["planta"=>$planta]);        
        $combustible = 0;
        $aceite = 0;
        $gasNatural = 0;
        $aire = 0;
        foreach($filtro["SustanciaAuxiliares"] as $sustancias){
            switch ($sustancias->getTipo()){
                case 1:
                    $combustible = 1;
                    break;
                case 2:
                    $aceite = 2;
                    break;
                case 3:
                    $gasNatural = 3;
                    break;
                case 4:
                    $aire = 4;
                    break;
            }            
        }
        $filtro["TipoSustanciaCombustible"] = $combustible;
        $filtro["TipoSustanciaAceite"] = $aceite;
        $filtro["TipoSustanciaGasNatural"] = $gasNatural;
        $filtro["TipoSustanciaAire"] = $aire;
        $filtro["Tanques"] = $entityManager->getRepository(Tanque::class)->findOneBy(["planta"=>$planta]);
        return $this->render('actividadIndustrial/formularioB2.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB2", name="tramiteB2", methods={"POST"})
     */
    public function tramiteB2(Request $request)
    {
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();        
        $tramite = $this->getTramite($filtro['idTramite']);
        $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
        
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Producto'] = $request->get("Producto");
            $datos['SubProducto'] = $request->get("SubProducto");
            $datos['MateriaPrima'] = $request->get("MateriaPrima");
            $datos['Insumo'] = $request->get("Insumo");
            $datos['Cisterna'] = $request->get("Cisterna");
            $datos['SustanciaAuxiliar'] = $request->get("SustanciaAuxiliar");
            $datos['Sustancia'] = $request->get('Sustancia');
            $tipo = [];
            foreach($request->get('Sustancia')['tipo'] as $sustanciaTipo){
                $tipo[] = $sustanciaTipo;
            }
            
            $comercioExterior = $datos["Producto"]["exterior"][0];
            if ($datos["Producto"] !=null && isset($datos["Producto"]["numero"])){
                for($i=0;$i<count($datos["Producto"]["numero"]);$i++){
                    $producto = $entityManager->getRepository(Producto::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["Producto"]["nombre"][$i]]);
                    if($producto==null){
                        $producto = new Producto();
                    }
                    $producto->setNombre($datos["Producto"]["nombre"][$i]);
                    $producto->setEstadoFisico($datos["Producto"]["estado"][$i]);
                    $producto->setProduccion($datos["Producto"]["produccion"][$i]);
                    $producto->setUnidad($datos["Producto"]["unidad"][$i]);
                    $producto->setAlmacenamiento($datos["Producto"]["almacenamiento"][$i]);
                    
                    $producto->setClasificacion($datos["Producto"]["clasificacion"][$i] ?? null);
                    $producto->setEspecificacion($datos["Producto"]["especificacion"][$i] ?? null);
                    $producto->setComercioExterior($comercioExterior);
                    $producto->setPlanta($planta);
                    $entityManager->persist($producto);
                }
            }
            
            if ($datos["SubProducto"] !=null && isset($datos["SubProducto"]["numero"])){
                for($i=0; $i<count($datos["SubProducto"]["numero"]); $i++){
                    $subProducto = $entityManager->getRepository(SubProducto::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["SubProducto"]["nombre"][$i]]);
                    if($subProducto==null){
                        $subProducto = new SubProducto();
                    }
                    $subProducto->setNombre($datos["SubProducto"]["nombre"][$i]);
                    $subProducto->setEstadoFisico($datos["SubProducto"]["estado"][$i]);
                    $subProducto->setProduccion($datos["SubProducto"]["produccion"][$i]);
                    $subProducto->setUnidad($datos["SubProducto"]["unidad"][$i]);
                    $subProducto->setAlmacenamiento($datos["SubProducto"]["almacenamiento"][$i]);
                    $subProducto->setPlanta($planta);
                    $entityManager->persist($subProducto);
                    
                }   
            }
            if($datos["MateriaPrima"] != null && isset($datos["MateriaPrima"]['numero'])){
                for($i=0;$i<count($datos["MateriaPrima"]["numero"]);$i++){
                    $materiaPrima = $entityManager->getRepository(MateriaPrima::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["MateriaPrima"]["nombre"][$i]]);
                    if($materiaPrima==null){
                        $materiaPrima = new MateriaPrima();
                    }
                    $materiaPrima->setNombre($datos["MateriaPrima"]["nombre"][$i]);
                    $materiaPrima->setEstadoFisico($datos["MateriaPrima"]["estado"][$i]);
                    $materiaPrima->setProduccion($datos["MateriaPrima"]["produccion"][$i]);
                    $materiaPrima->setUnidad($datos["MateriaPrima"]["unidad"][$i]);
                    $materiaPrima->setAlmacenamiento($datos["MateriaPrima"]["almacenamiento"][$i]);
                    $materiaPrima->setPlanta($planta);
                    $entityManager->persist($materiaPrima);
                } 
            }
            if($datos["Insumo"] != null && isset($datos["Insumo"]['numero'])){
                for($i=0;$i<count($datos["Insumo"]["numero"]);$i++){
                    $insumo = $entityManager->getRepository(Insumo::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["Insumo"]["nombre"][$i]]);
                    if($insumo==null){
                        $insumo = new Insumo();
                    }
                    $insumo->setNombre($datos["Insumo"]["nombre"][$i]);
                    $insumo->setEstadoFisico($datos["Insumo"]["estado"][$i]);
                    $insumo->setProduccion($datos["Insumo"]["produccion"][$i]);
                    $insumo->setUnidad($datos["Insumo"]["unidad"][$i]);
                    $insumo->setAlmacenamiento($datos["Insumo"]["almacenamiento"][$i]);
                    $insumo->setPlanta($planta);
                    $entityManager->persist($insumo);
                }
            }
           
            
            if ($datos["Cisterna"]["posee"] == "SI"){
                $cisterna = $entityManager->getRepository(Tanque::class)->findOneBy(["planta"=>$planta]);
                if($cisterna == null){
                $cisterna = new Tanque();
                }
                $cisterna->setCantidad($datos["Cisterna"]["cantidad"]);
                $cisterna->setCapacidadTotal($datos["Cisterna"]["capacidad"]);
                $cisterna->setUnidad($datos["Cisterna"]["unidad"]);
                $cisterna->setPlanta($planta);
                $entityManager->persist($cisterna);
            }
            if ($datos["SustanciaAuxiliar"] != null && isset($datos["SustanciaAuxiliar"]["nombre"] )){            
                for($i=0;$i<count($datos["SustanciaAuxiliar"]["nombre"]);$i++){
                    $sustanciaAuxiliar = $entityManager->getRepository(SustanciaAuxiliar::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["SustanciaAuxiliar"]["nombre"][$i]]);
                    if($sustanciaAuxiliar==null){
                        $sustanciaAuxiliar = new SustanciaAuxiliar();
                    }
                    $datos["SustanciaAuxiliar"]["unidad"][$i] = "kg";
                    $sustanciaAuxiliar->setNombre($datos["SustanciaAuxiliar"]["nombre"][$i]);
                    $sustanciaAuxiliar->setProduccion($datos["SustanciaAuxiliar"]["produccion"][$i]);
                    $sustanciaAuxiliar->setUnidad($datos["SustanciaAuxiliar"]["unidad"][$i]);
                    $sustanciaAuxiliar->setAlmacenamiento($datos["SustanciaAuxiliar"]["almacenamiento"][$i]);
                    $sustanciaAuxiliar->setPlanta($planta);
                    switch($tipo[$i]){
                        case 1:
                            $tipo = 1;
                            break;
                        case 2:
                            $tipo = 2;
                            break;
                        case 3:
                            $tipo = 3;
                            break;
                        case 4:
                            $tipo = 4;
                            break;
                    }
                    $sustanciaAuxiliar->setTipo($tipo);
                    $entityManager->persist($sustanciaAuxiliar);
                }
            }
            $entityManager->flush();
        }    
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"tipo"=>3]);
        $filtro['Domicilio'] = $domicilio;
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();        
        $filtro['PartidaInmobiliaria'] = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["planta"=>$planta]);
        $filtro['InmuebleAnexo'] = $entityManager->getRepository(InmuebleAnexo::class)->findBy(["partidaInmobiliaria"=>$filtro['PartidaInmobiliaria']]);
        $filtro['Servicio'] = $entityManager->getRepository(Servicio::class)->findOneBy(["planta"=>$planta]);
        return $this->render('actividadIndustrial/formularioB3.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB3", name="tramiteB3", methods={"POST"})
     */
    public function tramiteB3(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
        $tramite = $this->getTramite($filtro['idTramite']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos['Domicilio'] = $request->get('Domicilio');
            $datos['PartidaInmobiliaria'] = $request->get('PartidaInmobiliaria');
            $datos['InmuebleAnexo'] = $request->get('InmuebleAnexo');
            $datos["Servicio"] = $request->get('Servicio');
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa(),'tipo'=>3]);
            if($domicilio == null){
                $domicilio = new Domicilio();            
            }
            $domicilio->setCalle($datos['Domicilio']["calle"]);
            $domicilio->setNumero($datos['Domicilio']["numero"]);
            $domicilio->setPiso($datos['Domicilio']["piso"]);
            $domicilio->setDepto($datos['Domicilio']["depto"]);
            $domicilio->setZonificacion($datos['Domicilio']["zona"]);
            $domicilio->setEmpresa($tramite->getEmpresa());
            $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
            $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
            $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
            
            $domicilio->setProvincia($provincia);
            $domicilio->setLocalidad($localidad);
            $domicilio->setDepartamento($departamento);
            $domicilio->setTipo(3);
            $entityManager->persist($domicilio);

            $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["numero"=>$datos["PartidaInmobiliaria"]["partida"]]);
            if($partidaInmobiliaria == null){
                $partidaInmobiliaria = new PartidaInmobiliaria();
            }
            $partidaInmobiliaria->setNumero($datos["PartidaInmobiliaria"]["partida"]);
            $partidaInmobiliaria->setLatitud($datos["PartidaInmobiliaria"]["lat"]);
            $partidaInmobiliaria->setLongitud($datos["PartidaInmobiliaria"]["long"]);
            $partidaInmobiliaria->setPlanta($planta);
            $entityManager->persist($partidaInmobiliaria);
            if($datos["InmuebleAnexo"]["opt"] == "SI" && isset($datos['InmuebleAnexo']['domicilio'])){
                for ($i = 0; $i < count($datos["InmuebleAnexo"]["domicilio"]); $i++ ){
                    
                    $inmueble = $entityManager->getRepository(InmuebleAnexo::class)->findOneBy(["domicilio"=>$datos["InmuebleAnexo"]["domicilio"][$i]]);
                    if($inmueble == null){
                        $inmueble = new InmuebleAnexo();
                    }
                    $inmueble->setDomicilio($datos["InmuebleAnexo"]["domicilio"][$i]);
                    $inmueble->setActividadDesarrollada($datos["InmuebleAnexo"]["actividad"][$i]);
                    $inmueble->setPartidaInmobiliaria($partidaInmobiliaria);
                    $entityManager->persist($inmueble);
                }
            }       
            $entityManager->flush(); 
            $servicio = $entityManager->getRepository(Servicio::class)->findOneBy(["planta"=>$planta]);
            if($servicio == null){
                $servicio = new Servicio();
            }
            
            $servicio->setEnergiaElectrica($datos["Servicio"]["energiaElectrica"] ? 1 : 0);
            $servicio->setAguaRed($datos["Servicio"]["aguaRed"] ? 1: 0);
            $servicio->setCloacas($datos["Servicio"]["cloacas"] ? 1 : 0);
            $servicio->setGasNatural($datos["Servicio"]["gasNatural"] ? 1: 0);
            $servicio->setPlanta($planta);
            $entityManager->persist($servicio);

            $entityManager->flush();
        }

        $filtro["DimensionPlanta"] = $entityManager->getRepository(DimencionamientoPlanta::class)->findOneBy(["planta"=>$planta]);
        $filtro["FormacionPersonal"] = $entityManager->getRepository(FormacionPersonal::class)->findOneBy(["planta"=>$planta]);
        return $this->render('actividadIndustrial/formularioB4.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB4", name="tramiteB4", methods={"POST"})
     */
    public function tramiteB4(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            $datos["DimencionamientoPlanta"] = $request->get('DimensionPlanta');
            $datos["FormacionPersonalObrero"] = $request->get('FormacionPersonalObrero');
            $datos["FormacionPersonalTecnico"] = $request->get('FormacionPersonalTecnico');
            $datos["FormacionPersonalProfesional"] = $request->get('FormacionPersonalProfesional');
            $datos["FormacionPersonal"] = $request->get('FormacionPersonal');
            $dimencionamientoPlanta = $entityManager->getRepository(DimencionamientoPlanta::class)->findOneBy(["planta"=>$planta]);
            if($dimencionamientoPlanta==null){
                $dimencionamientoPlanta = new DimencionamientoPlanta();
            }
            $dimencionamientoPlanta->setSuperficieTotal($datos["DimencionamientoPlanta"]['superficieTotal']);
            $dimencionamientoPlanta->setSuperficieCubierta($datos["DimencionamientoPlanta"]['superficieCubierta']);
            $dimencionamientoPlanta->setSuperficieInstalada($datos["DimencionamientoPlanta"]['superficieInstalada']);
            $dimencionamientoPlanta->setDotacionPersonal($datos["DimencionamientoPlanta"]['dotacionPersonal']);
            $dimencionamientoPlanta->setPlanta($planta);
            $entityManager->persist($dimencionamientoPlanta);

            $formacionPersonal = $entityManager->getRepository(FormacionPersonal::class)->findOneBy(["planta"=>$planta]);
            if($formacionPersonal==null){
                $formacionPersonal = new FormacionPersonal();
            }
            $formacionPersonal->setCantidadObrero($datos["FormacionPersonalObrero"]["cantidad"]);
            $formacionPersonal->setCapacitacionObrero($datos["FormacionPersonalObrero"]["capacitacion"]);
            $formacionPersonal->setCantidadTecnico($datos["FormacionPersonalTecnico"]["cantidad"]);
            $formacionPersonal->setCapacitacionTecnico($datos["FormacionPersonalTecnico"]["capacitacion"]);
            $formacionPersonal->setCantidadProfecional($datos["FormacionPersonalProfesional"]["cantidad"]);
            $formacionPersonal->setCapacitacionProfecional($datos["FormacionPersonalProfesional"]["capacitacion"]);
            $formacionPersonal->setHorarioTrabajo($datos["FormacionPersonal"]["horas"]);
            $formacionPersonal->setPlanta($planta);
            $entityManager->persist($formacionPersonal);

            $entityManager->flush();
        }
        $filtro["EmisionGaseosa"] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta,"tipo"=>"ContempladosNaturales"]);
        $filtro["EmisionGaseosaCombustion"] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta,"tipo"=>"ContempladosCombustibles"]);
        $filtro["EmisionGaseosaGases"] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta,"tipo"=>"NoContemplados"]);
        $filtro["Efluentes"] = $entityManager->getRepository(Efluente::class)->findBy(["planta"=>$planta,"tipo"=>"Efluentes"]);
        $filtro["Residuos"] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta,"tipo" => 1]);
        $filtro["EfluentesLiquidos"] = $entityManager->getRepository(Efluente::class)->findBy(["planta"=>$planta,"tipo"=>"EfluentesLiquidos"]);
        $filtro["ResiduosSolidos"] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta,"tipo" => 2]);
        $filtro["ResiduosPeligrosos"] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta,"tipo"=>3]);
        return $this->render('actividadIndustrial/formularioB5.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB5", name="tramiteB5", methods={"POST"})
     */
    public function tramiteB5(Request $request)
    {
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){
            
            $datos["EmisionGaseosa"] = $request->get('EmisionGaseosa');
            $datos["EmisionGaseosaCombustion"] = $request->get('EmisionGaseosaCombustion');
            $datos["EmisionGaseosaGases"] = $request->get('EmisionGaseosaGases');
            $datos["Efluentes"] = $request->get('Efluentes');
            $datos["Residuo"] = $request->get('Residuo');
            $datos["EfluentesLiquidos"] = $request->get('EfluentesLiquidos');
            $datos["ResiduosSolidos"] = $request->get('ResiduosSolidos');
            $datos["ResiduosPeligrosos"] = $request->get('ResiduosPeligrosos'); 
            if ($datos["EmisionGaseosa"]["poseeComponenetesNaturales"] == "SI" && isset($datos["EmisionGaseosa"]["emision"])){

                for ($i = 0; $i < count($datos["EmisionGaseosa"]["emision"]); $i++ ){
                    $emisionGaseosa = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["planta"=>$planta,"tipo"=>"ContempladosNaturales","emision" => $datos["EmisionGaseosa"]["emision"][$i],"procesoGenerador" => $datos["EmisionGaseosa"]["proceso"][$i]]);
                    if($emisionGaseosa==null){
                        $emisionGaseosa = new EmisionGaseosa();
                    }
                    $emisionGaseosa->setTipo("ContempladosNaturales");
                    $emisionGaseosa->setEmision($datos["EmisionGaseosa"]["emision"][$i]);
                    $emisionGaseosa->setProcesoGenerador($datos["EmisionGaseosa"]["proceso"][$i]);
                    $emisionGaseosa->setTratamiento($datos["EmisionGaseosa"]["tratamiento"][$i]);
                    $emisionGaseosa->setPlanta($planta);
                    $entityManager->persist($emisionGaseosa);
                }
            }        
            if ($datos["EmisionGaseosaCombustion"]["poseeCombustibles"] == "SI" && isset($datos["EmisionGaseosaCombustion"]["emision"])){

                for ($i = 0; $i < count($datos["EmisionGaseosaCombustion"]["emision"]); $i++ ){
                    $emisionGaseosa = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["planta"=>$planta,"tipo"=>"ContempladosCombustibles","emision" => $datos["EmisionGaseosaCombustion"]["emision"][$i],"procesoGenerador" => $datos["EmisionGaseosaCombustion"]["proceso"][$i]]);
                    if($emisionGaseosa==null){
                        $emisionGaseosa = new EmisionGaseosa();
                    }
                    $emisionGaseosa->setTipo("ContempladosCombustibles");
                    $emisionGaseosa->setEmision($datos["EmisionGaseosaCombustion"]["emision"][$i]);
                    $emisionGaseosa->setProcesoGenerador($datos["EmisionGaseosaCombustion"]["proceso"][$i]);
                    $emisionGaseosa->setTratamiento($datos["EmisionGaseosaCombustion"]["tratamiento"][$i]);
                    $emisionGaseosa->setPlanta($planta);
                    $entityManager->persist($emisionGaseosa);
                }
            }

            if ($datos["EmisionGaseosaGases"]["poseeNoContemplados"] == "SI" && isset($datos["EmisionGaseosaGases"]["proceso"])){

                for ($i = 0; $i < count($datos["EmisionGaseosaGases"]["proceso"]); $i++){
                    $emisionGaseosa = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["planta"=>$planta,"tipo"=>"NoContemplados","componenteRelevante" => $datos["EmisionGaseosaGases"]["componentes"][$i],"procesoGenerador" => $datos["EmisionGaseosaGases"]["proceso"][$i]]);
                    
                    if($emisionGaseosa==null){
                        $emisionGaseosa = new EmisionGaseosa();
                    }
                    $emisionGaseosa->setTipo("NoContemplados");
                    $emisionGaseosa->setEmision("");
                    $emisionGaseosa->setProcesoGenerador($datos["EmisionGaseosaGases"]["proceso"][$i]);
                    $emisionGaseosa->setComponenteRelevante($datos["EmisionGaseosaGases"]["componentes"][$i]);
                    $emisionGaseosa->setTratamiento($datos["EmisionGaseosaGases"]["tratamiento"][$i]);
                    
                    $emisionGaseosa->setPlanta($planta);
                    $entityManager->persist($emisionGaseosa);
                }
            }
            if ($datos["Efluentes"]["poseeEfluentes"] == "SI"){
                
                if ($datos["Efluentes"]["noResiduosPeligrosos"] == "SI" && isset($datos["Efluentes"]["procesoGenerado"])){
                    for ($i = 0; $i < count($datos["Efluentes"]["procesoGenerado"]); $i++){        

                        $efluente = $entityManager->getRepository(Efluente::class)->findOneBy(["planta"=>$planta,"tipo"=>"Efluentes","procesoGenerador" => $datos["Efluentes"]["procesoGenerado"][$i]]);
                        if($efluente==null){
                            $efluente = new Efluente();
                        }
                        // $efluente->setCategoria($datos["Efluentes"]["agua"]);
                        
                        $efluente->setTipo("Efluentes");
                        $efluente->setVolumen($datos["Efluentes"]["cantidad"][$i]);
                        $efluente->setProcesoGenerador($datos["Efluentes"]["procesoGenerado"][$i]);
                        $efluente->setComponenteRelevante($datos["Efluentes"]["componenteRelevante"][$i]);
                        $efluente->setUnidad($datos["Efluentes"]["volumen"][$i]);
                        $efluente->setPeriodoTiempo($datos["Efluentes"]["periodoTiempo"][$i]);
                        $efluente->setReceptor($datos["Efluentes"]["receptor"][$i]);
                        $efluente->setGestion($datos["Efluentes"]["gestion"][$i][0] ?? null);
                        $efluente->setPlanta($planta);
                        $entityManager->persist($efluente);   
                    }
                }
                if ($datos["Residuo"]["posee"] == "SI" && isset($datos["Residuo"]["proceso"])){
                    
                    for ($i = 0; $i < count($datos["Residuo"]["proceso"]); $i++){    
                        $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"procesoGenerador" => $datos["Residuo"]["proceso"][$i],"tipo" => 1]);
                        
                        if($residuo==null){
                            $residuo = new Residuo();
                        }
                        $residuo->SetTipo(1);
                        $residuo->setVolumen($datos["Residuo"]["cantidad"][$i]);
                        // $residuo->setReceptor($datos["Residuo"]["receptor"][$i]);
                        $residuo->setProcesoGenerador($datos["Residuo"]["proceso"][$i]);
                        $residuo->setComponenteRelevante($datos["Residuo"]["componente"][$i]);
                        $residuo->setUnidad($datos["Residuo"]["volumen"][$i]);
                        $residuo->setPeriodoTiempo($datos["Residuo"]["periodoTiempo"][$i]);
                        $residuo->setGestion($datos["Residuo"]["gestion"][$i][0] ?? null);
                        $residuo->setPlanta($planta);
                        $entityManager->persist($residuo);
                        
                    }
                }

                if ($datos["EfluentesLiquidos"]["vertidos"] == "SI" && isset($datos["EfluentesLiquidos"]["proceso"])){
                    
                    for ($i = 0; $i < count($datos["EfluentesLiquidos"]["proceso"]); $i++){    
                        
                        $efluenteLiquidos = $entityManager->getRepository(Efluente::class)->findOneBy(["planta"=>$planta,"tipo"=>"EfluenteLiquidos","procesoGenerador" => $datos["EfluentesLiquidos"]["proceso"][$i]]);

                        if($efluenteLiquidos==null){
                            $efluenteLiquidos = new Efluente();
                        }
                        $efluenteLiquidos->setTipo("EfluentesLiquidos");
                        $efluenteLiquidos->setCategoria(1);
                        $efluenteLiquidos->setDescarga("aaa");
                        $efluenteLiquidos->setReceptor($datos["EfluentesLiquidos"]["receptor"][$i]);
                        $efluenteLiquidos->setVolumen($datos["EfluentesLiquidos"]["cantidad"][$i]);
                        $efluenteLiquidos->setProcesoGenerador($datos["EfluentesLiquidos"]["proceso"][$i]);
                        $efluenteLiquidos->setComponenteRelevante($datos["EfluentesLiquidos"]["componente"][$i]);
                        $efluenteLiquidos->setUnidad($datos["EfluentesLiquidos"]["volumen"][$i]);
                        $efluenteLiquidos->setPeriodoTiempo($datos["EfluentesLiquidos"]["periodoTiempo"][$i]);
                        $efluenteLiquidos->setGestion($datos["EfluentesLiquidos"]["gestion"][$i][0]);
                        $efluenteLiquidos->setPlanta($planta);
                        $entityManager->persist($efluenteLiquidos);
                    }

                }
                
            }   
            if ($datos["ResiduosSolidos"]["nopeligrosos"] == "SI" && isset($datos["ResiduosSolidos"]["proceso"]) ){
                for ($i = 0; $i < count($datos["ResiduosSolidos"]["proceso"]); $i++){    
                    $residuoSolidos = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"procesoGenerador" => $datos["ResiduosSolidos"]["proceso"][$i],"tipo" => 2]);
                    if($residuoSolidos==null){
                        $residuoSolidos = new Residuo();
                    }
                    $residuoSolidos->SetTipo(2);
                    // VER
                    $residuoSolidos->setComponenteRelevante($datos["ResiduosSolidos"]["unidad"][$i]);
                    //
                    $residuoSolidos->setVolumen($datos["ResiduosSolidos"]["cantidad"][$i]);
                    $residuoSolidos->setProcesoGenerador($datos["ResiduosSolidos"]["proceso"][$i]);
                    $residuoSolidos->setUnidad($datos["ResiduosSolidos"]["unidad"][$i]);
                    $residuoSolidos->setPeriodoTiempo($datos["ResiduosSolidos"]["periodoTiempo"][$i]);
                    $residuoSolidos->setGestion($datos["ResiduosSolidos"]["gestion"][$i]);
                    $residuoSolidos->setPlanta($planta);
                    $entityManager->persist($residuoSolidos);
                }
            }

            if ($datos["ResiduosPeligrosos"]["posee"] == "SI" && isset($datos["ResiduosPeligrosos"]["cantidad"])){
                for ($i = 0; $i < count($datos["ResiduosPeligrosos"]["cantidad"]); $i++){   
                    $residuoLiquidos = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"tipo"=>3]);
                    if($residuoLiquidos==null){
                        $residuoLiquidos = new Residuo();
                    }
                    $residuoLiquidos->setTipo(3);
                    $residuoLiquidos->setVolumen($datos["ResiduosPeligrosos"]["cantidad"][$i]);
                    $residuoLiquidos->setProcesoGenerador($datos["ResiduosPeligrosos"]["proceso"][$i]);
                    $residuoLiquidos->setUnidad($datos["ResiduosPeligrosos"]["unidad"][$i]);
                    $residuoLiquidos->setPeriodoTiempo($datos["ResiduosPeligrosos"]["periodoTiempo"][$i]);
                    $residuoLiquidos->setGestion($datos["ResiduosPeligrosos"]["gestion"][$i]);
                    $residuoLiquidos->setPlanta($planta);
                    $entityManager->persist($residuoLiquidos);
                }
            }  
            $entityManager->flush();
        }
        $filtro["RiesgoPresunto"] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(["planta"=>$planta]);
        return $this->render('actividadIndustrial/formularioB6.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB6", name="tramiteB6")
     */
    public function tramiteB6(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']);
        $tramite = $this->getTramite($filtro['idTramite']); 
        if($filtro['userSession']->getRoles()[0] != 'ROLE_ADMIN'){         
            $datos["RiesgoPresunto"] = $request->get('RiesgoPresunto');
            $riesgoPresunto = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(["planta"=>$planta]);
            if($riesgoPresunto == null){
                $riesgoPresunto = new RiesgoPresunto();
            }
            $riesgoPresunto->setFuentesMoviles($datos["RiesgoPresunto"]["fuentesMoviles"] == "on" ? 1 : 0);
            $riesgoPresunto->setAparatoSometido($datos["RiesgoPresunto"]["aparatosSometidos"] == "on" ? 1 : 0);
            $riesgoPresunto->setSustanciaQuimica($datos["RiesgoPresunto"]["sustanciasQuimicas"] == "on" ? 1 : 0);
            $riesgoPresunto->setExplosion($datos["RiesgoPresunto"]["explosion"] == "on" ? 1 : 0);
            $riesgoPresunto->setIncendio($datos["RiesgoPresunto"]["incendio"] == "on" ? 1 : 0);
            $riesgoPresunto->setOtro($datos["RiesgoPresunto"]["otros"] == "on" ? 1 : 0);
            $riesgoPresunto->setObservaciones($datos["RiesgoPresunto"]["observaciones"] ?? null);
            $riesgoPresunto->setPlanta($planta);
            $entityManager->persist($riesgoPresunto);
            $entityManager->flush();
        }
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.4"]);
        return $this->render('actividadIndustrial/formularioB7.html.twig',$filtro);
    }
    
    /**
     * @Route("/tramiteB7", name="tramiteB7", methods={"POST"})
     */
    public function tramiteB7(Request $request)
    {
        return $this->redirectToRoute('misTramites');
    }    
}
