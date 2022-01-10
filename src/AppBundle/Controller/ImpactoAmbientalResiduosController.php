<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\StorageService;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\CaracterizacionEntorno;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\EmpresaHasActividad;
use AppBundle\Entity\MarcoLegal;
use AppBundle\Entity\FactorAfectacion;
use AppBundle\Entity\MedidaEficiencia;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Riesgo;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Formulario;
use AppBundle\Entity\Representante;
use AppBundle\Entity\Agua;
use AppBundle\Entity\EmpresaHasRepresentante;
use AppBundle\Entity\Planta;
use AppBundle\Entity\PartidaInmobiliaria;
use AppBundle\Entity\Producto;
use AppBundle\Entity\SubProducto;
use AppBundle\Entity\MateriaPrima;
use AppBundle\Entity\Insumo;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\SustanciaAuxiliar;
use AppBundle\Entity\SustanciaRiesgosa;
use AppBundle\Entity\CategoriaResiduoPeligroso;
use AppBundle\Entity\InmuebleAnexo;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\Storage;
use AppBundle\Entity\DimencionamientoPlanta;
use AppBundle\Entity\ResumenEjecutivo;
use AppBundle\Entity\FormacionPersonal;
use AppBundle\Entity\EmisionGaseosa;
use AppBundle\Entity\TipoEmision;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\TipoEfluente;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\TipoResiduo;
use AppBundle\Entity\SubTipoResiduo;
use AppBundle\Entity\RiesgoPresunto;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Tanque;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\EtapaConstructiva;
use AppBundle\Entity\EtapaOperativa;
use AppBundle\Entity\UsoRecurso;
use AppBundle\Entity\Impacto;
use AppBundle\Entity\TipoImpacto;
use \DateTime;
use Doctrine\ORM\EntityManagerInterface;

class  ImpactoAmbientalResiduosController extends BaseController
{
    /**
     * @Route("/formularioFeedLotsPresentacion", name="formularioFeedLotsPresentacion", methods={"POST","GET"})
     */
    public function formularioImpactoAmbientalResiduos(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->get("idTramite")!=0){
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $empresa = $tramite->getEmpresa();
            $filtro['Empresa'] = $empresa;
            $filtro['Persona'] = $entityManager->getRepository(Persona::class)->find($tramite->getEmpresa()->getPersona()); 
            $filtro['ResumenEjecutivo'] = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
            $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
            $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilio!=null){
                $filtro['Domicilio'] = $domicilio;
            }
        }else{
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(15);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $estado = $entityManager->getRepository(Estado::class)->find(1);
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
            $entityManager->flush();
        }          
        $filtro['idTramite'] = $tramite->getId();
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['EmpresaActividad'] = $entityManager->getRepository(EmpresaHasActividad::class)->findBy(["empresa"=> $tramite->getEmpresa()]);
        $filtro['titulo'] = $tramite->getNombre();
        
        
        return $this->render('impactoAmbientalResiduos/formularioEIARA1.html.twig',$filtro);        
    }

    /**
     * @Route("/tramiteEIARA1", name="tramiteEIARA1", methods={"POST"})
     */
    public function tramiteEIARA1(Request $request)
    {
        $filtro = $this->getFiltro($request);     
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $datos['Persona'] = $request->get('Persona');
        $datos['Empresa'] = $request->get('Empresa');
        $datos['ActividadEmpresa'] = $request->get('ActividadEmpresa');
        
        if ($datos['Persona'] != null && $datos['Empresa'] != null){
            $cuit = $datos['Persona']["cuit"];
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
            if($persona== null){
                $persona = new Persona();
            }
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
            $persona->setCuit($cuit);
            $entityManager->persist($persona);
            $empresa= $entityManager->getRepository(Empresa::class)->findOneBy(['persona'=>$persona]);
            if($empresa == null){
                $empresa = new Empresa();
            }
            $empresa->setFechaInicioActividad(new \DateTime($datos['Empresa']["fechaInicio"]));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);
            $entityManager->persist($empresa);
            $tramite->setEmpresa($empresa);

            $entityManager->persist($tramite);

            if($datos['ActividadEmpresa']!=null){
                              
                for($i=0;$i<count($datos['ActividadEmpresa']);$i++){
                    $actividad = $entityManager->getRepository(Actividad::class)->findOneBy(["id" => $datos['ActividadEmpresa'][$i]]);
                    $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=> $tramite->getEmpresa(), "actividad" => $request->get('ActividadEmpresa')[$i]]);
                    if ($empresaHasActividad == null){
                        $empresaHasActividad = new EmpresaHasActividad();
                    }
                    $empresaHasActividad->setActividad($actividad);
                    $empresaHasActividad->setTipo($request->get('prse')[$i]);
                    $empresaHasActividad->setEmpresa($tramite->getEmpresa());

                    $entityManager->persist($empresaHasActividad);
                    
                }                                       
            }               
            $entityManager->flush();
        }
        $filtro['Domicilio'] = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>1]);
        $filtro['paginaInicio'] = "formularioFeedLotsPresentacion";
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();

        return $this->render('impactoAmbientalResiduos/formularioEIARA2.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA2", name="tramiteEIARA2", methods={"POST"})
     */
    public function tramiteEIARA2(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Domicilio'] = $request->get('Domicilio');
        $provinciaLegal = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidadLegal = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamentoLegal = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        
        
        if($datos['Domicilio'] != null){
            $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>1]);
            if($domicilioLegal == null){
                $domicilioLegal = new Domicilio();            
            }  
            $domicilioLegal->setCalle($datos['Domicilio']["calle"]);
            $domicilioLegal->setNumero($datos['Domicilio']["numero"]);
            $domicilioLegal->setPiso($datos['Domicilio']["piso"]);
            $domicilioLegal->setDepto($datos['Domicilio']["depto"]);
            $domicilioLegal->setTelefono($datos['Domicilio']["telefono"]);
            $domicilioLegal->setEmail($datos['Domicilio']["email"]);
            $domicilioLegal->setEmpresa($tramite->getEmpresa());
            
            $domicilioLegal->setProvincia($provinciaLegal);
            $domicilioLegal->setDepartamento($departamentoLegal);
            $domicilioLegal->setLocalidad($localidadLegal);
            $domicilioLegal->setTipo(1);

            $entityManager->persist($domicilioLegal);
            $entityManager->flush();
        }
        
        $filtro['Domicilio'] = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>3]);
        
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        return $this->render('impactoAmbientalResiduos/formularioEIARA3.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA3", name="tramiteEIARA3", methods={"POST"})
     */
    public function tramiteEIARA3(Request $request)
    {
        $filtro = $this->getFiltro($request);          
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        
        
        if($datos['Domicilio'] != null){
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>3]);
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
            
            $domicilio->setProvincia($provincia);
            $domicilio->setDepartamento($departamento);
            $domicilio->setLocalidad($localidad);
            $domicilio->setTipo(3);

            $entityManager->persist($domicilio);
            $entityManager->flush();
        }
        
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"1"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        $filtro["Representantes"] = $empresaHasRepresentante;
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        return $this->render('impactoAmbientalResiduos/formularioEIARA4.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA4", name="tramiteEIARA4", methods={"POST"})
     */
    public function tramiteEIARA4(Request $request)
    {
        $filtro = $this->getFiltro($request);     
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $datos['Persona'] = $request->get('Persona');
        $datos['Representante'] = $request->get('Representante');
        if($datos['Persona']!=null){
            for( $i = 0; $i <count($datos['Persona']['razonSocial']); $i++){
                $cuit = $datos['Persona']["cuit"][$i];
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
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"2"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        $filtro["Representantes"] = $empresaHasRepresentante;
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        return $this->render('impactoAmbientalResiduos/formularioEIARA5.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA5", name="tramiteEIARA5", methods={"POST"})
     */
    public function tramiteEIARA5(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $datos['Persona'] = $request->get('Persona');
        $datos['Representante'] = $request->get('Representante');
        if($datos['Persona']!=null){
            for( $i = 0; $i <count($datos['Persona']['razonSocial']); $i++){
                $cuit = $datos['Persona']["cuit"][$i];
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
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"3"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);  
        $filtro["Representante"] = $empresaHasRepresentante;
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        return $this->render('impactoAmbientalResiduos/formularioEIARA6.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA6", name="tramiteEIARA6", methods={"POST"})
     */
    public function tramiteEIARA6(Request $request)
    {
        $filtro = $this->getFiltro($request);         
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Persona'] = $request->get('Persona');

        if($datos['Persona']!=null){
            $cuit = $datos['Persona']["cuit"];
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
            if($persona == null){
                $persona = new Persona();                
            }
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
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

            $entityManager->flush(); 
        }
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['Domicilio'] = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        return $this->render('impactoAmbientalResiduos/formularioEIARA7.html.twig',$filtro); 
    }
    
    /**
     * @Route("/tramiteEIARA7", name="tramiteEIARA7", methods={"POST"})
     */
    public function tramiteEIARA7(Request $request)
    {
        $filtro = $this->getFiltro($request);       
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        
        
        if($datos['Domicilio'] != null){
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
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
            
            $domicilio->setProvincia($provincia);
            $domicilio->setDepartamento($departamento);
            $domicilio->setLocalidad($localidad);
            $domicilio->setTipo(2);

            $entityManager->persist($domicilio);
            $entityManager->flush();
        }
        for($i = 1; $i <= 7; $i++) {
            $filtro['Storage' . $i] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "8." . $i]);
        }
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        
        return $this->render('impactoAmbientalResiduos/formularioEIARA8.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARA8", name="tramiteEIARA8", methods={"POST"})
     */
    public function tramiteEIARA8(Request $request)
    {
        $filtro = $this->getFiltro($request);     
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        // $entityManager->flush();
        $filtro['Planta'] = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
        $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["planta"=> $filtro['Planta']]);
        $filtro['InmueblesAnexos'] = $entityManager->getRepository(InmuebleAnexo::class)->findBy(["partidaInmobiliaria"=> $partidaInmobiliaria]);;
        $filtro['Servicio'] = $entityManager->getRepository(Servicio::class)->findOneBy(["planta"=>$filtro['Planta']]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        return $this->render('impactoAmbientalResiduos/formularioEIARB1.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB1", name="tramiteEIARB1", methods={"POST"})
     */
    public function tramiteEIARB1(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Planta'] = $request->get('Planta');
        $datos['InmuebleAnexo'] = $request->get('InmuebleAnexo');
        $datos["Servicio"] = $request->get('Servicio');

        if ($datos['Planta'] != null){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
            if ($planta == null){
                $planta = new Planta();
            }
            $planta -> setNombre($datos['Planta']['nombre']);
            $planta -> setEmpresa($tramite->getEmpresa());
            $entityManager -> persist($planta);

            if ($datos['InmuebleAnexo'] != null){

                $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["planta"=> $planta]);
                if ($partidaInmobiliaria == null){
                    $partidaInmobiliaria = new PartidaInmobiliaria();
                }
                $partidaInmobiliaria -> setPlanta($planta);
                $entityManager -> persist($partidaInmobiliaria);

                for($i = 0; $i< count($datos['InmuebleAnexo']['domicilio']); $i++){
                    $inmuebleAnexo = $entityManager->getRepository(InmuebleAnexo::class)->findOneBy(["partidaInmobiliaria"=> $partidaInmobiliaria, "domicilio" => $datos['InmuebleAnexo']['domicilio'][$i]]);
                    if ($inmuebleAnexo == null){
                        $inmuebleAnexo = new InmuebleAnexo();
                    }
                    $inmuebleAnexo -> setDomicilio($datos['InmuebleAnexo']['domicilio'][$i]);
                    $inmuebleAnexo -> setActividadDesarrollada($datos['InmuebleAnexo']['actividad'][$i]);
                    $inmuebleAnexo -> setPartidaInmobiliaria($partidaInmobiliaria);
                    $entityManager -> persist($inmuebleAnexo);
                }                
                if ($datos['Servicio'] != null){
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
                }
            }
            $entityManager->flush();   
        }
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        $filtro['Productos'] = $entityManager->getRepository(Producto::class)->findBy(["planta"=>$planta]);
        $filtro['SubProductos'] = $entityManager->getRepository(Subproducto::class)->findBy(["planta"=>$planta]);
        return $this->render('impactoAmbientalResiduos/formularioEIARB2.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB2", name="tramiteEIARB2", methods={"POST"})
     */
    public function tramiteEIARB2(Request $request)
    {
        $filtro = $this->getFiltro($request);         
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Producto'] = $request->get('Producto');
        $datos["SubProducto"] = $request->get('SubProducto');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos["Producto"] !=null){

            for($i=0;$i<count($datos["Producto"]["nombre"]);$i++){
                $producto = $entityManager->getRepository(Producto::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["Producto"]["nombre"][$i]]);
                if($producto==null){
                    $producto = new Producto();
                }
                $producto->setNombre($datos["Producto"]["nombre"][$i]);
                $producto->setEstadoFisico($datos["Producto"]["estado"][$i]);
                $producto->setProduccion($datos["Producto"]["produccion"][$i]);
                $producto->setUnidad($datos["Producto"]["unidad"][$i]);
                $producto->setAlmacenamiento($datos["Producto"]["almacenamiento"][$i]);
                
                $producto->setPlanta($planta);
                $entityManager->persist($producto);
            }

        }
        
        if ($datos["SubProducto"] !=null){

            for($i=0; $i<count($datos["SubProducto"]["nombre"]); $i++){

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
        $entityManager->flush();
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        $filtro['Proyecto'] = $entityManager->getRepository(Proyecto::class)->findOneBy(["empresa" => $tramite->getEmpresa()]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.1"]);
        return $this->render('impactoAmbientalResiduos/formularioEIARB3.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB3", name="tramiteEIARB3", methods={"POST"})
     */
    public function tramiteEIARB3(Request $request)
    {
        $filtro = $this->getFiltro($request);          
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 
        $datos['Proyecto'] = $request->get('Proyecto');   

        if ($datos['Proyecto'] != null){

            $proyecto = $entityManager->getRepository(Proyecto::class)->findOneBy(["empresa" => $tramite->getEmpresa()]);

            if ($proyecto == null){
                $proyecto = new Proyecto();
            }
            $proyecto->setDefinicion($datos['Proyecto']['capacidad']);
            $proyecto->setEmpresa($tramite->getEmpresa());
            $proyecto->setProduccionAnual($datos['Proyecto']['anual']);
            $entityManager->persist($proyecto);
        }

        $entityManager->flush();
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
        $filtro["MateriasPrimas"] = $entityManager->getRepository(MateriaPrima::class)->findBy(["planta"=>$planta]);
        $filtro['Insumos'] = $entityManager->getRepository(Insumo::class)->findBy(["planta"=>$planta]);
        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]);
        $filtro['SustanciasAuxiliares'] = $entityManager->getRepository(SustanciaAuxiliar::class)->findBy(["planta"=>$planta]);
        $filtro['AguasPublicas'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso]);
        $filtro['Tanques'] = $entityManager->getRepository(Tanque::class)->findBy(['planta'=>$planta]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        return $this->render('impactoAmbientalResiduos/formularioEIARB4.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB4", name="tramiteEIARB4", methods={"POST"})
     */
    public function tramiteEIARB4(Request $request)
    {
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['MateriaPrima'] = $request->get("MateriaPrima");
        $datos['Insumo'] = $request->get("Insumo");
        $datos['SustanciaAuxiliar'] = $request->get("SustanciaAuxiliar");
        $datos['AguaPublica'] = $request->get("AguaPublica");
        $datos['Cisterna'] = $request->get("Cisterna");

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if($datos["MateriaPrima"] != null){
            for($i=0;$i<count($datos["MateriaPrima"]["nombre"]);$i++){
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

            if($datos["Insumo"] != null){
                for($i=0;$i<count($datos["Insumo"]["nombre"]);$i++){
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

                if ($datos["SustanciaAuxiliar"] != null){            
                    for($i=0;$i<count($datos["SustanciaAuxiliar"]["nombre"]);$i++){
                        $sustanciaAuxiliar = $entityManager->getRepository(SustanciaAuxiliar::class)->findOneBy(["planta"=>$planta,"nombre"=>$datos["SustanciaAuxiliar"]["nombre"][$i]]);
                        if($sustanciaAuxiliar==null){
                            $sustanciaAuxiliar = new SustanciaAuxiliar();
                        }
                        $datos["SustanciaAuxiliar"]["unidad"][$i] = "kg";
                        $sustanciaAuxiliar->setNombre($datos["SustanciaAuxiliar"]["nombre"][$i]);
                        $sustanciaAuxiliar->setEstadoFisico($datos["SustanciaAuxiliar"]["estado"][$i]);
                        $sustanciaAuxiliar->setProduccion($datos["SustanciaAuxiliar"]["produccion"][$i]);
                        $sustanciaAuxiliar->setUnidad($datos["SustanciaAuxiliar"]["unidad"][$i]);
                        $sustanciaAuxiliar->setAlmacenamiento($datos["SustanciaAuxiliar"]["almacenamiento"][$i]);
                        $sustanciaAuxiliar->setPlanta($planta);
                        $entityManager->persist($sustanciaAuxiliar);
                    }
                    
                    if($datos['AguaPublica'] != null){
                        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]);
                        if($recurso == null){
                            $recurso = new Recurso();
                            $recurso->setPlanta($planta);
                            $recurso->setTipo(1);
                            $entityManager->persist($recurso);
                        }
                        for($i = 0;$i<count($datos['AguaPublica']['nombre']); $i++){
                            $agua = $entityManager->getRepository(Agua::class)->findOneBy(["recurso"=>$recurso,"nombre"=>$datos['AguaPublica']['nombre'][$i]]);
                            if($agua == null){
                                $agua = new Agua();
                            }
                            $agua->setRecurso($recurso);
                            $agua->setTipo(1);
                            $agua->setNombre($datos['AguaPublica']['nombre'][$i]);
                            $agua->setCantidad($datos['AguaPublica']['consumo'][$i]);
                            $agua->setUnidad($datos['AguaPublica']['unidad'][$i]);
                            $agua->setTiempo($datos['AguaPublica']['tiempo'][$i]);
                            $entityManager->persist($agua);
                        }
                        
                        if($datos['Cisterna'] != null){
                            for ($i=0; $i<count($datos["Cisterna"]['cantidad']); $i++){
                                $tanque = $entityManager->getRepository(Tanque::class)->findOneBy(['planta'=>$planta, 'cantidad'=>$datos["Cisterna"]['cantidad'][$i], 'capacidadTotal' => $datos["Cisterna"]['capacidad']]);
                                if($tanque == null){
                                    $tanque = new Tanque();
                                }
                                $tanque->setCantidad($datos['Cisterna']['cantidad'][$i]);
                                $tanque->setCapacidadTotal($datos['Cisterna']['capacidad'][$i]);
                                $tanque->setUnidad($datos['Cisterna']['unidad'][$i]);
                                $tanque->setPlanta($planta);
                                $entityManager->persist($tanque);
                            }
                        }
                    }
                }
            }
        }
        $entityManager->flush();
        $filtro['Residuos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        return $this->render('impactoAmbientalResiduos/formularioEIARB5.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB5", name="tramiteEIARB5", methods={"POST"})
     */
    public function tramiteEIARB5(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $datos['Residuo'] = $request->get("Residuo");
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos['Residuo'] != null){
            
            for ($i = 0; $i < count($datos["Residuo"]["proceso"]); $i++){ 

                $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"procesoGenerador" => $datos["Residuo"]["proceso"][$i],"tipo" => 1]);
                
                if($residuo==null){
                    $residuo = new Residuo();
                }
                $residuo->SetTipo(1);
                $residuo->setComponenteRelevante($datos["Residuo"]["componente"][$i]);
                $residuo->setEstadoFisico($datos["Residuo"]["estado"][$i]);
                $residuo->setProcesoGenerador($datos["Residuo"]["proceso"][$i]);

                $categoriaResiduoPeligroso = $entityManager->getRepository(CategoriaResiduoPeligroso::class)->findOneBy(["categoria" => $datos['Residuo']['peligrosidad'][$i]]);
                if ($categoriaResiduoPeligroso == null){
                    $categoriaResiduoPeligroso = new CategoriaResiduoPeligroso();
                }
                $categoriaResiduoPeligroso -> setCategoria($datos['Residuo']['peligrosidad'][$i]);
                $entityManager->persist($categoriaResiduoPeligroso);

                $residuo->setCategoriaResiduoPeligroso($categoriaResiduoPeligroso);
                $residuo->setPlanta($planta);
                $entityManager->persist($residuo);
                
            }

        }
        
        $entityManager->flush();
        $filtro['Efluentes'] = $entityManager->getRepository(Efluente::class)->findBy(["planta"=>$planta]);
        $filtro['Emisiones'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        
        return $this->render('impactoAmbientalResiduos/formularioEIARB6.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB6", name="tramiteEIARB6", methods={"POST"})
     */
    public function tramiteEIARB6(Request $request)
    {
        $filtro = $this->getFiltro($request);           
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos["Efluentes"] = $request->get('Efluentes');
        $datos["Emisiones"] = $request->get('Emisiones');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos['Efluentes'] != null){
            for ($i = 0; $i < count($datos["Efluentes"]["proceso"]); $i++){        

                $efluente = $entityManager->getRepository(Efluente::class)->findOneBy(["planta"=>$planta, "tipo"=>"Efluentes","procesoGenerador" => $datos["Efluentes"]["proceso"][$i]]);
                if($efluente==null){
                    $efluente = new Efluente();
                }
                
                $efluente->setComponenteRelevante($datos["Efluentes"]["componente"][$i]);
                $efluente->setProcesoGenerador($datos["Efluentes"]["proceso"][$i]);
                $efluente->setTipo("Efluentes");
                $efluente->setUnidad($datos["Efluentes"]["cantidad"][$i]);
                
                $efluente->setPlanta($planta);
                $entityManager->persist($efluente);   
            }
            if ($datos['Emisiones'] != null){

                for ($i = 0; $i < count($datos["Emisiones"]["proceso"]); $i++){  

                    $emision = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["planta" => $planta]);
                    if ($emision == null){
                        $emision = new EmisionGaseosa();
                    }
                    $emision->setComponenteRelevante($datos["Emisiones"]["componente"][$i]);
                    $emision->setProcesoGenerador($datos["Emisiones"]["proceso"][$i]);
                    $emision->setEmision($datos["Emisiones"]["cantidad"][$i]);
                    $emision->setPlanta($planta);

                    $entityManager->persist($emision);     
                }
                
            }


            $entityManager->flush();
        }
        $filtro["RiesgoPresunto"] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(["planta"=>$planta]);
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(15)->getDescripcion();
        return $this->render('impactoAmbientalResiduos/formularioEIARB7.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIARB7", name="tramiteEIARB7", methods={"POST"})
     */
    public function tramiteEIARB7(Request $request)
    {
        $filtro = $this->getFiltro($request);      
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos["RiesgoPresunto"] = $request->get('RiesgoPresunto');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos["RiesgoPresunto"] != null){

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
        
        return $this->redirectToRoute('misTramites');
    }
}