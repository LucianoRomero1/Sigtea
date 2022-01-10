<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ActividadServicio;
use AppBundle\Entity\BocaExpendio;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Persona;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Formulario;
use AppBundle\Entity\MarcaBandera;
use AppBundle\Entity\Planta;
use AppBundle\Entity\PartidaInmobiliaria;
use AppBundle\Entity\AlmacenamientoTanque;
use AppBundle\Entity\TipoAlmacenamiento;
use AppBundle\Entity\Almacenamiento;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\Agua;
use AppBundle\Entity\ElectricaPropia;
use AppBundle\Entity\ElectricaAdquirida;
use AppBundle\Entity\OtroRecurso;
use AppBundle\Entity\TipoImpacto;
use AppBundle\Entity\Impacto;
use AppBundle\Entity\ListadoTipoResiduo;
use AppBundle\Entity\TipoResiduo;
use AppBundle\Entity\EntidadHasRepositorio;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\TramitePlantaExpendio;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\SitioContaminado;
use AppBundle\Entity\RiesgoPresunto;
use \DateTime;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Service\StorageService;
use AppBundle\Entity\ListaTramites;

class ExpendioCombustibleController extends BaseController{
    /**
     * @Route("/formularioExpendioCombustibleIAC", name="formularioExpendioCombustibleIAC", methods={"GET"})
     */
    public function formularioExpendio(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();        
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
            $filtro['Empresa'] = $tramite->getEmpresa() ?? null;
            if($filtro['Empresa'] != null){
                $filtro['Persona'] = $filtro['Empresa']->getPersona();
                $filtro['DomicilioLegal'] = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=> $filtro['Empresa'] ,"tipo"=> Domicilio::LEGAL]);
                $filtro['DomicilioReal'] = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=> $filtro['Empresa'] ,"tipo"=> Domicilio::REAL]);
                $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$filtro['Empresa'],"domicilio"=>$filtro['DomicilioReal']]);
                $filtro['PartidaInmobiliaria'] = $entityManager->getRepository(PartidaInmobiliaria::class)->findBy(['planta'=>$planta]);
                $filtro['MarcaBandera'] = $entityManager->getRepository(MarcaBandera::class)->findOneBy(['empresa'=>$filtro['Empresa']]);
            }
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(7);
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
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$perito->getPersona()]);
            if($empresa==null){
                $empresa = new Empresa();
            }
            $empresa->setPersona($persona);
            $empresa->setFechaInicioActividad(new \DateTime());
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $entityManager->persist($empresa);
            $entityManager->flush();
        }
        $filtro['idTramite'] = $tramite->getId();
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        return $this->render('expendioCombustible/formulario1.html.twig',$filtro);        
    }
    /**
     * @Route("/formularioExpendio2", name="formularioExpendio2", methods={"POST"})
     */
    public function formulario2(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();        
        $tramite = $this->getTramite($filtro['idTramite']);
        $datos['Persona'] = $request->get('Persona');        
        if($datos['Persona']!= null){
            $datos['Empresa'] = $request->get('Empresa');
            $datos['DomicilioLegal'] = $request->get('DomicilioLegal');
            $datos['DomicilioReal'] = $request->get('DomicilioReal');
            $datos['Coordenadas'] = $request->get('Coordenadas');
            $datos['MarcaBandera'] = $request->get('MarcaBandera');
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(["cuit"=>$datos['Persona']["cuit"]]);
            if($persona==null){
                $persona = new Persona();
            }
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
            $persona->setCuit(trim($datos['Persona']["cuit"]));
            $entityManager->persist($persona);
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(["persona"=>$persona]);
            if($empresa==[]){
                $empresa = new Empresa();            
            }
            $empresa->setFechaInicioActividad(new \DateTime($datos['Empresa']["fechaInicio"]));
            $empresa->setTipoPersona($datos['Empresa']["tipoEntidad"] ?? 1);
            $empresa->setDeposito($datos['Empresa']["deposito"] ?? 0);
            $empresa->setPersona($persona);        
            $entityManager->persist($empresa);
            $tramite->setEmpresa($empresa);
            $entityManager->persist($tramite);
            $marcaBandera = $entityManager->getRepository(MarcaBandera::class)->findOneBy(["empresa"=>$empresa]);
            if($marcaBandera== null){
                $marcaBandera = new MarcaBandera();
            }
            $marcaBandera->setNombre($datos['MarcaBandera']['nombre']);
            $marcaBandera->setEmpresa($empresa);
            $entityManager->persist($marcaBandera);
            $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilioLegal==null){
                $domicilioLegal = new Domicilio();
            }
            $domicilioLegal->setCalle($datos['DomicilioLegal']["calle"]);
            $domicilioLegal->setNumero($datos['DomicilioLegal']["numero"]);
            $domicilioLegal->setPiso($datos['DomicilioLegal']["piso"]);
            $domicilioLegal->setDepto($datos['DomicilioLegal']["depto"]);
            $domicilioLegal->setTelefono($datos['DomicilioLegal']["telefono"]);
            $domicilioLegal->setEmail($datos['DomicilioLegal']["email"]);
            $domicilioLegal->setEmpresa($empresa);
            $provincia = $entityManager->getRepository(Provincia::class)->find($datos['DomicilioLegal']["provincia"]);
            $localidad = $entityManager->getRepository(Localidad::class)->find($datos['DomicilioLegal']["localidad"]);
            $departamento = $entityManager->getRepository(Departamento::class)->find($datos['DomicilioLegal']["departamento"]);
            $domicilioLegal->setProvincia($provincia);
            $domicilioLegal->setLocalidad($localidad);
            $domicilioLegal->setDepartamento($departamento);
            $domicilioLegal->setTipo(1);
            $entityManager->persist($domicilioLegal);
            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>2]);
            if($domicilioReal==null){
                $domicilioReal = new Domicilio();
            }
            $domicilioReal->setCalle($datos['DomicilioReal']["calle"]);
            $domicilioReal->setNumero($datos['DomicilioReal']["numero"]);
            $domicilioReal->setPiso($datos['DomicilioReal']["piso"]);
            $domicilioReal->setDepto($datos['DomicilioReal']["depto"]);
            $domicilioReal->setTelefono($datos['DomicilioReal']["telefono"]);
            $domicilioReal->setEmail($datos['DomicilioReal']["email"]);
            $domicilioReal->setZonificacion($datos['DomicilioReal']["zona"]);
            $domicilioReal->setTitularInmueble($datos['DomicilioReal']["Titular"]);
            $domicilioReal->setEmpresa($empresa);
            $provincia = $entityManager->getRepository(Provincia::class)->find($datos['DomicilioReal']["provincia"]);
            $localidad = $entityManager->getRepository(Localidad::class)->find($datos['DomicilioReal']["localidad"]);
            $departamento = $entityManager->getRepository(Departamento::class)->find($datos['DomicilioReal']["departamento"]);
            $domicilioReal->setProvincia($provincia);
            $domicilioReal->setLocalidad($localidad);
            $domicilioReal->setDepartamento($departamento);
            $domicilioReal->setTipo(2);
            // agregar titularidad del inmueble -> lo que venga del combo String
            $entityManager->persist($domicilioReal);
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilioReal]);
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($empresa);
            $planta->setDomicilio($domicilioReal);
            $entityManager->persist($planta);
            if($datos['Coordenadas']!= null){
                for($i=0;$i<count($datos['Coordenadas']['partida']);$i++){
                    $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['numero'=>$datos['Coordenadas']['partida'][$i],'planta'=>$planta]);
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
        $filtro['MarcaBandera'] = $entityManager->getRepository(MarcaBandera::class)->findOneBy(["empresa"=>$empresa]);
        return $this->render('expendioCombustible/formulario2.html.twig',$filtro);        
    }

    /**
     * @Route("/formularioExpendio3", name="formularioExpendio3", methods={"POST"})
     */
    public function formulario3(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $marcaBandera = $entityManager->getRepository(MarcaBandera::class)->findOneBy(["empresa"=>$empresa]);
        $datos['MarcaBandera'] = $request->get('MarcaBandera');
        if($datos['MarcaBandera']!=null){
            $marcaBandera->setEntorno($datos['MarcaBandera']['entorno']);
            $entityManager->persist($marcaBandera);
            $entityManager->flush();
        }
        $actividadServicioLiquido = $entityManager->getRepository(ActividadServicio::class)->findBy(["marcaBandera"=>$marcaBandera,"combustibleLiquido"=>1]);
        if($actividadServicioLiquido != null){
            $filtro['ActividadServicio']['combustibleLiquido'] = 1;
            $bocaExpendios = $entityManager->getRepository(BocaExpendio::class)->findBy(["actividadServicio"=>$actividadServicioLiquido]);
            if($bocaExpendios != null){
                $filtro['BocaExpendios']['combustibleLiquido'] = $bocaExpendios;
            }
        }
        $actividadServicioGnc = $entityManager->getRepository(ActividadServicio::class)->findBy(["marcaBandera"=>$marcaBandera,"gnc"=>1]);
        if($actividadServicioGnc != null){
            $filtro['ActividadServicio']['gnc'] = 1;
            $bocaExpendios = $entityManager->getRepository(BocaExpendio::class)->findBy(["actividadServicio"=>$actividadServicioGnc]);
            if($bocaExpendios != null){
                $filtro['BocaExpendios']['gnc'] = $bocaExpendios;
            }
        }
        $actividadServicioOtro = $entityManager->getRepository(ActividadServicio::class)->findBy(["marcaBandera"=>$marcaBandera,"otro"=>1]);
        if($actividadServicioOtro != null){
            $filtro['ActividadServicio']['otro'] = 1;
            $bocaExpendios = $entityManager->getRepository(BocaExpendio::class)->findBy(["actividadServicio"=>$actividadServicioOtro]);
            if($bocaExpendios != null){
                $filtro['BocaExpendios']['otro'] = $bocaExpendios;
            }
        }
        return $this->render('expendioCombustible/formulario3.html.twig',$filtro);
    }
    
    /**
     * @Route("/formularioExpendio4", name="formularioExpendio4", methods={"POST"})
     */
    public function formulario4(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();        
        $datos['ActividadServicio'] = $request->get('ActividadServicio') ?? null;
        $datos['BocaExpendio'] = $request->get('BocaExpendio') ?? null;
        $marcaBandera = $entityManager->getRepository(MarcaBandera::class)->findOneBy(["empresa"=>$empresa]);        
        if($datos['ActividadServicio']['combustibleLiquido']=='on'){            
            $actividadServicio = $entityManager->getRepository(ActividadServicio::class)->findOneBy(["marcaBandera"=>$marcaBandera,'combustibleLiquido'=>1]);
            if($actividadServicio==null){
                $actividadServicio = new ActividadServicio();
            }
            $actividadServicio->setCombustibleLiquido(1);
            $actividadServicio->setMarcaBandera($marcaBandera);
            $entityManager->persist($actividadServicio);
            for($i=0;$i<count($datos['BocaExpendio']['combustibleLiquido']['bocaExpendio']);$i++){
                $bocaExpendio = $entityManager->getRepository(BocaExpendio::class)->findOneBy(["actividadServicio"=>$actividadServicio,"bocaExpendio"=>$datos['BocaExpendio']['combustibleLiquido']['bocaExpendio'][$i], "tipoServicio"=>'liquido']);
                if($bocaExpendio==null){
                    $bocaExpendio = new BocaExpendio();
                }
                $bocaExpendio->setTipoServicio('liquido');
                $bocaExpendio->setBocaExpendio($datos['BocaExpendio']['combustibleLiquido']['bocaExpendio'][$i]);
                $bocaExpendio->setCaudal($datos['BocaExpendio']['combustibleLiquido']['caudal'][$i]);
                $bocaExpendio->setNombreProducto($datos['BocaExpendio']['combustibleLiquido']['nombreProducto'][$i]);
                $bocaExpendio->setObservacion($datos['BocaExpendio']['combustibleLiquido']['observacion'][$i]);
                $bocaExpendio->setActividadServicio($actividadServicio);
                $entityManager->persist($bocaExpendio);
            }
        }
        if($datos['ActividadServicio']['gnc']=='on'){            
            $actividadServicio = $entityManager->getRepository(ActividadServicio::class)->findOneBy(["marcaBandera"=>$marcaBandera,'gnc'=>1]);
            if($actividadServicio==null){
                $actividadServicio = new ActividadServicio();
            }
            $actividadServicio->setGnc(1);
            $actividadServicio->setMarcaBandera($marcaBandera);
            $entityManager->persist($actividadServicio);
            for($i=0;$i<count($datos['BocaExpendio']['gnc']['bocaExpendio']);$i++){
                $bocaExpendio = $entityManager->getRepository(BocaExpendio::class)->findOneBy(["actividadServicio"=>$actividadServicio,"tipoServicio"=>"gnc","bocaExpendio"=>$datos['BocaExpendio']['gnc']['bocaExpendio'][$i]]);
                if($bocaExpendio==null){
                    $bocaExpendio = new BocaExpendio();
                }            
                $bocaExpendio->setTipoServicio('gnc');
                $bocaExpendio->setBocaExpendio($datos['BocaExpendio']['gnc']['bocaExpendio'][$i]);
                $bocaExpendio->setCaudal($datos['BocaExpendio']['gnc']['caudal'][$i]);
                $bocaExpendio->setNombreProducto($datos['BocaExpendio']['gnc']['nombreProducto'][$i]);
                $bocaExpendio->setObservacion($datos['BocaExpendio']['gnc']['observacion'][$i]);
                $bocaExpendio->setActividadServicio($actividadServicio);
                $entityManager->persist($bocaExpendio);
            }
        }
        if($datos['ActividadServicio']['otro']=='on'){            
            $actividadServicio = $entityManager->getRepository(ActividadServicio::class)->findOneBy(["marcaBandera"=>$marcaBandera,'otro'=>1]);
            if($actividadServicio==null){
                $actividadServicio = new ActividadServicio();
            }
            $actividadServicio->setOtro(1);
            $actividadServicio->setMarcaBandera($marcaBandera);
            $entityManager->persist($actividadServicio);
            for($i=0;$i<count($datos['BocaExpendio']['otro']['bocaExpendio']);$i++){
                $bocaExpendio = $entityManager->getRepository(BocaExpendio::class)->findOneBy(["actividadServicio"=>$actividadServicio,"tipoServicio"=>"otro","bocaExpendio"=>$datos['BocaExpendio']['otro']['bocaExpendio'][$i]]);
                if($bocaExpendio==null){
                    $bocaExpendio = new BocaExpendio();
                }
                $bocaExpendio->setTipoServicio("otro");
                $bocaExpendio->setBocaExpendio($datos['BocaExpendio']['otro']['bocaExpendio'][$i]);
                $bocaExpendio->setCaudal($datos['BocaExpendio']['otro']['caudal'][$i]);
                $bocaExpendio->setNombreProducto($datos['BocaExpendio']['otro']['nombreProducto'][$i]);
                $bocaExpendio->setObservacion($datos['BocaExpendio']['otro']['observacion'][$i]);
                $bocaExpendio->setActividadServicio($actividadServicio);
                $entityManager->persist($bocaExpendio);
            }
        }
        $entityManager->flush();
        $actividadServicio = $entityManager->getRepository(ActividadServicio::class)->findOtrosTipos($marcaBandera->getId());        
        if($actividadServicio != null){
            $filtro['ActividadServicio'] = $actividadServicio[0];
        }
        return $this->render('expendioCombustible/formulario4.html.twig',$filtro);
    }

    /**
     * @Route("/formularioExpendio5", name="formularioExpendio5", methods={"POST"})
     */
    public function formulario5(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $marcaBandera = $entityManager->getRepository(MarcaBandera::class)->findOneBy(["empresa"=>$empresa]);        
        $datos['ActividadServicio'] = $request->get('ActividadServicio');
        if($datos['ActividadServicio']['lavadero']==1 || $datos['ActividadServicio']['cambioAceite']==1 || $datos['ActividadServicio']['otroSecundario']!=null){
            $actividadServicio = $entityManager->getRepository(ActividadServicio::class)->findOneBy(["marcaBandera"=>$marcaBandera,'combustibleLiquido'=>0,'gnc'=>0,'otro'=>0]);
            if($actividadServicio==null){
                $actividadServicio = new ActividadServicio();
            }
            $actividadServicio->setLavadero($datos['ActividadServicio']['lavadero']);
            $actividadServicio->setCambioAceite($datos['ActividadServicio']['cambioAceite']);
            $actividadServicio->setOtroSecundario($datos['ActividadServicio']['otroSecundario']);
            $actividadServicio->setMarcaBandera($marcaBandera);
            $entityManager->persist($actividadServicio);
            $entityManager->flush();
        }        
        //// Aca los datos del formulario 5
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);        
        $almacenamientosTanque = $entityManager->getRepository(AlmacenamientoTanque::class)->findBy(['planta'=>$planta]);
        foreach($almacenamientosTanque as $almacenamientoTanque){
            switch ($almacenamientoTanque->getTipoTanque()){
                case 'liquido':
                    $filtro['Almacenamiento']['liquido'][] = $almacenamientoTanque;    
                    break;
                case 'gnc':
                    $filtro['Almacenamiento']['gnc'][] = $almacenamientoTanque;    
                    break;
                case 'otro':
                    $filtro['Almacenamiento']['otro'][] = $almacenamientoTanque;    
                    break;
            }
        }
        return $this->render('expendioCombustible/formulario5.html.twig',$filtro);
    }
    
    /**
     * @Route("/formularioExpendio6", name="formularioExpendio6", methods={"POST"})
     */
    public function formulario6(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();       
        $datos['Almacenamiento'] = $request->get('Almacenamiento');
        $datos['Tanque'] = $request->get('Tanque');      
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);    
        if($datos['Almacenamiento']["liquido"] == 1 ){
            for ($i=0; $i<count($datos["Tanque"]["almacenamientoLiquido"]['capacidad']); $i++){
                $almacenamientoTanque = $entityManager->getRepository(AlmacenamientoTanque::class)->findOneBy(['planta'=>$planta, 'tipoTanque'=>'liquido', 'numero'=>$i+1]);
                if($almacenamientoTanque == null){
                    $almacenamientoTanque = new AlmacenamientoTanque();
                }
                $almacenamientoTanque->setNumero($i+1);
                if($datos["Tanque"]["almacenamientoLiquido"]['Tipo'][$i]=="otro"){
                    $almacenamientoTanque->setNombre($datos["Tanque"]["almacenamientoLiquido"]['tipo']['otro'][$i]);
                }else{
                    $almacenamientoTanque->setNombre($datos["Tanque"]["almacenamientoLiquido"]['Tipo'][$i]);
                }
                $tipoAlmacenamiento = $entityManager->getRepository(TipoAlmacenamiento::class)->findOneBy(['nombre'=>$datos["Tanque"]["almacenamientoLiquido"]['Tipo'][$i]]);
                $almacenamientoTanque->setTipoAlmacenamiento($tipoAlmacenamiento);
                $almacenamientoTanque->setPlanta($planta);
                $almacenamientoTanque->setTipoTanque("liquido");
                $almacenamientoTanque->setDescripcion($datos['Tanque']["almacenamientoLiquido"]['descripcion'][$i]);
                $almacenamientoTanque->setSustancia($datos['Tanque']["almacenamientoLiquido"]['sustancia'][$i]);
                $almacenamientoTanque->setCapacidad($datos['Tanque']["almacenamientoLiquido"]['capacidad'][$i]);
                $entityManager->persist($almacenamientoTanque);
                $entityManager->flush();
            }
        }
        if($datos['Almacenamiento']["gnc"] == 1 ){
            for ($i=0; $i<count($datos["Tanque"]["almacenamientognc"]['capacidad']); $i++){
                $almacenamientoTanque = $entityManager->getRepository(AlmacenamientoTanque::class)->findOneBy(['planta'=>$planta, 'tipoTanque'=>'gnc', 'numero'=>$i+1]);
                if($almacenamientoTanque == null){
                    $almacenamientoTanque = new AlmacenamientoTanque();
                }
                $almacenamientoTanque->setNumero($i+1);
                $tipoAlmacenamiento = $entityManager->getRepository(TipoAlmacenamiento::class)->findOneBy(['nombre'=>'otro']);
                $almacenamientoTanque->setTipoAlmacenamiento($tipoAlmacenamiento);
                $almacenamientoTanque->setPlanta($planta);
                $almacenamientoTanque->setTipoTanque("gnc");
                $almacenamientoTanque->setNombre("gnc");
                $almacenamientoTanque->setDescripcion($datos['Tanque']["almacenamientognc"]['almacenamiento'][$i]);
                $almacenamientoTanque->setPresion($datos['Tanque']["almacenamientognc"]['unidad'][$i]);
                $almacenamientoTanque->setCapacidad($datos['Tanque']["almacenamientognc"]['capacidad'][$i]);
                $entityManager->persist($almacenamientoTanque);
                $entityManager->flush();
            }
        }
        if($datos['Almacenamiento']["otro"] == 1 ){
            for ($i=0; $i<count($datos["Tanque"]["almacenamientootro"]['capacidad']); $i++){
                $almacenamientoTanque = $entityManager->getRepository(AlmacenamientoTanque::class)->findOneBy(['planta'=>$planta, 'tipoTanque'=>'otro', 'numero'=>$i+1]);
                if($almacenamientoTanque == null){
                    $almacenamientoTanque = new AlmacenamientoTanque();
                }
                $almacenamientoTanque->setNumero($i+1);
                $tipoAlmacenamiento = $entityManager->getRepository(TipoAlmacenamiento::class)->findOneBy(['nombre'=>'otro']);
                $almacenamientoTanque->setTipoAlmacenamiento($tipoAlmacenamiento);
                $almacenamientoTanque->setPlanta($planta);
                $almacenamientoTanque->setTipoTanque("otro");
                $almacenamientoTanque->setNombre("otro");
                $almacenamientoTanque->setDescripcion($datos['Tanque']["almacenamientootro"]['almacenamiento'][$i]);
                $almacenamientoTanque->setPresion($datos['Tanque']["almacenamientootro"]['unidad'][$i]);
                $almacenamientoTanque->setCapacidad($datos['Tanque']["almacenamientootro"]['capacidad'][$i]);
                $entityManager->persist($almacenamientoTanque);
                $entityManager->flush();
            }
        }
        $entityManager->flush();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);
        $recurso = $entityManager->getRepository(Recurso::class)->findBy(["planta"=>$planta]);
        $filtro['AguaPublica'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso,"tipo"=>1]);
        $filtro['AguaSubterranea'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso,"tipo"=>2]);
        $filtro['EnergiaPropia'] = $entityManager->getRepository(ElectricaPropia::class)->findBy(["recurso"=>$recurso]);
        $filtro['EnergiaAdquirida'] = $entityManager->getRepository(ElectricaAdquirida::class)->findBy(["recurso"=>$recurso]);
        $filtro['OtroRecurso'] = $entityManager->getRepository(OtroRecurso::class)->findBy(["recurso"=>$recurso]);
        return $this->render('expendioCombustible/formulario6.html.twig',$filtro);
    }
    
    /**
     * @Route("/formularioExpendio7", name="formularioExpendio7", methods={"POST"})
     */
    public function formulario7(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $datos['Agua'] = $request->get('Agua');
        $datos['AguaPublica'] = $request->get('AguaPublica');
        $datos['AguaSubterranea'] = $request->get('AguaSubterranea');
        $datos['Electrica'] = $request->get('Electrica');
        $datos['EnergiaAdquirida'] = $request->get('EnergiaAdquirida');
        $datos['EnergiaPropia'] = $request->get('EnergiaPropia');
        $datos['OtroRecurso'] = $request->get('OtroRecurso');
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);
        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]);
        if($recurso == null){
            $recurso = new Recurso();
            $recurso->setPlanta($planta);
            $recurso->setTipo(1);
            $entityManager->persist($recurso);
        }
        if($datos['Agua']['tipo']['publica']==1){
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
        }
        if($datos['Agua']['tipo']['subterranea']==1){
            for($i = 0;$i<count($datos['AguaSubterranea']['nroPerforacion']); $i++){
                $agua = $entityManager->getRepository(Agua::class)->findOneBy(["recurso"=>$recurso,"nroPerforacion"=>$datos['AguaSubterranea']['nroPerforacion'][$i]]);
                if($agua == null){
                    $agua = new Agua();
                }
                $agua->setRecurso($recurso);
                $agua->setTipo(2);
                $agua->setNroPerforacion($datos['AguaSubterranea']['nroPerforacion'][$i]);
                $agua->setUbicacionPlano($datos['AguaSubterranea']['ubicacion'][$i]);
                $agua->setCantidad($datos['AguaSubterranea']['consumo'][$i]);
                $agua->setUnidad($datos['AguaSubterranea']['unidad'][$i]);
                $agua->setTiempo($datos['AguaSubterranea']['tiempo'][$i]);
                $entityManager->persist($agua);
            }
        }
        if($datos['Electrica']['tipo']['publica']==1){
            for($i = 0;$i<count($datos['EnergiaAdquirida']['nombre']); $i++){
                $electricaAdquirida = $entityManager->getRepository(ElectricaAdquirida::class)->findOneBy(["recurso"=>$recurso,"nombre"=>$datos['EnergiaAdquirida']['nombre'][$i]]);
                if($electricaAdquirida == null){
                    $electricaAdquirida = new ElectricaAdquirida();
                }
                $electricaAdquirida->setRecurso($recurso);
                $electricaAdquirida->setNombre($datos['EnergiaAdquirida']['nombre'][$i]);
                $electricaAdquirida->setCantidad($datos['EnergiaAdquirida']['consumo'][$i]);
                $entityManager->persist($electricaAdquirida);
            }
        }
        
        if($datos['Electrica']['tipo']['propia']==1){        
            $electricaPropia = $entityManager->getRepository(ElectricaPropia::class)->findOneBy(["recurso"=>$recurso,"metodo"=>$datos['EnergiaPropia']['metodo']]);
            if($electricaPropia == null){
                $electricaPropia = new ElectricaPropia();
            }
            $electricaPropia->setRecurso($recurso);
            $electricaPropia->setMetodo($datos['EnergiaPropia']['metodo']);
            $electricaPropia->setConsumo($datos['EnergiaPropia']['consumo']);
            $electricaPropia->setFuente($datos['EnergiaPropia']['fuente']);
            $entityManager->persist($electricaPropia);
        }
        if($datos['Electrica']['tipo']['otro']==1){
            for($i = 0;$i<count($datos['OtroRecurso']['tipo']); $i++){
                $otroRecurso = $entityManager->getRepository(OtroRecurso::class)->findOneBy(["recurso"=>$recurso,"tipo"=>$datos['OtroRecurso']['tipo'][$i]]);
                if($otroRecurso == null){
                    $otroRecurso = new OtroRecurso();
                }
                $otroRecurso->setRecurso($recurso);
                $otroRecurso->setTipo($datos['OtroRecurso']['tipo'][$i]);
                $entityManager->persist($otroRecurso);
            }
        }
        $entityManager->flush();
        $tiposImpacto = $entityManager->getRepository(TipoImpacto::class)->findAll();
        $archivos = $entityManager->getRepository(Storage::class)->findBy(['tramite'=>$tramite]);
        foreach($tiposImpacto as $tipoImpacto){
            switch ($tipoImpacto->getTipo()){                
                case 'suelo':
                    $filtro['ImpactoSuelo'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    foreach($archivos as $archivo){
                        if(substr($archivo->getInciso(),0,3) == "7.1" && substr($archivo->getInciso(),-1) == "1"){
                            $filtro['ImagenesImpactoSuelo']['PlanoUbbicacionPuntosMuestreo'][] = $archivo->getNombre();
                        }elseif (substr($archivo->getInciso(),0,3) == "7.1" && substr($archivo->getInciso(),-1) == "2"){
                            $filtro['ImagenesImpactoSuelo']['ProtocoloMuestreo'][] = $archivo->getNombre();
                        }
                    }                   
                    break;
                case 'agua':
                    $filtro['ImpactoAguaSubterranea'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    foreach($archivos as $archivo){
                        if(substr($archivo->getInciso(),0,3) == "7.2" && substr($archivo->getInciso(),-1) == "1"){
                            $filtro['ImagenesAgua']['PlanoUbicacionFreatimetrosEscurrimiento'][] = $archivo->getNombre();
                        }
                    }
                    break;
                case 'aire':
                    $filtro['ImpactoAire'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    foreach($archivos as $archivo){
                        if(substr($archivo->getInciso(),0,3) == "7.3" && substr($archivo->getInciso(),-1) == "1"){
                            $filtro['ImagenesAire']['PlanoUbbicacionPuntosMuestreo'][] = $archivo->getNombre();
                        }elseif (substr($archivo->getInciso(),0,3) == "7.3" && substr($archivo->getInciso(),-1) == "2"){
                            $filtro['ImagenesAire']['ProtocoloMuestreo'][] = $archivo->getNombre();
                        }                        
                    }
                    break;
                case 'cuerporeceptor':
                    $filtro['ImpactoCuerpoReceptor'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    foreach($archivos as $archivo){
                        if(substr($archivo->getInciso(),0,3) == "7.4" && substr($archivo->getInciso(),-1) == "1"){
                            $filtro['ImagenesCuerpoReceptor']['SistemaTratamiento'][] = $archivo->getNombre();
                        }elseif (substr($archivo->getInciso(),0,3) == "7.4" && substr($archivo->getInciso(),-1) == "2"){
                            $filtro['ImagenesCuerpoReceptor']['PlanoMuestreo'][] = $archivo->getNombre();
                        }elseif (substr($archivo->getInciso(),0,3) == "7.4" && substr($archivo->getInciso(),-1) == "3"){
                            $filtro['ImagenesCuerpoReceptor']['ProtocoloMuestreo'][] = $archivo->getNombre();
                        }                        
                    }
                    break;
                case 'otro_impacto':
                    $filtro['ImpactoOtro'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    foreach($archivos as $archivo){
                        if (substr($archivo->getInciso(),0,3) == "7.5" && substr($archivo->getInciso(),-1) == "1"){
                            $filtro['ImagenesoOtro']['PlanoMuestreo'][] = $archivo->getNombre();
                        }elseif (substr($archivo->getInciso(),0,3) == "7.5" && substr($archivo->getInciso(),-1) == "2"){
                            $filtro['ImagenesOtro']['ProtocoloMuestreo'][] = $archivo->getNombre();
                        }
                    }
                    break;
            }
        }       
        return $this->render('expendioCombustible/formulario7.html.twig',$filtro);
    }

    /**
     * @Route("/formularioExpendio8", name="formularioExpendio8", methods={"POST"})
     */
    public function formulario8(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);
        $data['ImpactoSuelo'] = $request->get('ImpactoSuelo');
        $data['ImpactoAguaSubterranea'] = $request->get('ImpactoAguaSubterranea');
        $data['ImpactoAire'] = $request->get('ImpactoAire');
        $data['ImpactoCuerpoReceptor'] = $request->get('ImpactoCuerpoReceptor');
        $data['ImpactoOtro'] = $request->get('ImpactoOtro');
        $data['Impacto'] = $request->get('Impacto');
        $data['imagenesSuelo'] = $request->files->get('ImpactoSuelo');
        $data['imagenesAgua'] = $request->files->get('ImpactoAguaSubterranea');
        $data['imagenesAire'] = $request->files->get('ImpactoAire');
        $data['imagenesCuerpoReceptor'] = $request->files->get('ImpactoCuerpoReceptor');
        $data['imagenesOtros'] = $request->files->get('ImpactoOtro');
        $storageService = new StorageService($entityManager);
        if($data['Impacto']['tipo']['suelo']==1){            
            $tipoImpacto = $entityManager->getRepository(TipoImpacto::class)->findOneBy(['tipo'=>'suelo']);
            for($i=0; $i<count($data['ImpactoSuelo']['descripcion']);$i++){                
                $impactoSuelo = $entityManager->getRepository(Impacto::class)->findOneBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto,"descripcion"=>$data['ImpactoSuelo']['descripcion'][$i]]);
                if($impactoSuelo == null){
                    $impactoSuelo = new Impacto();
                }
                $impactoSuelo->setTipoImpacto($tipoImpacto);
                $impactoSuelo->setDescripcion($data['ImpactoSuelo']['descripcion'][$i]);
                $impactoSuelo->setProceso($data['ImpactoSuelo']['proceso'][$i]);
                $impactoSuelo->setContaminanteRelevante($data['ImpactoSuelo']['contaminacionRelevantes'][$i]);
                $impactoSuelo->setPlanta($planta);
                $entityManager->persist($impactoSuelo);
                if(isset($data['imagenesSuelo']['PlanoUbbicacionPuntosMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesSuelo']['PlanoUbbicacionPuntosMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.1.'.$i.'.1',$tramite,'Impacto',$impactoSuelo->getid());
                }
                if(isset($data['imagenesSuelo']['ProtocoloMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesSuelo']['ProtocoloMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.1.'.$i.'.2',$tramite,'Impacto',$impactoSuelo->getid());
                }
                
            }
        }
        if($data['Impacto']['tipo']['aguasubterranea']==1){
            $tipoImpacto = $entityManager->getRepository(TipoImpacto::class)->findOneBy(['tipo'=>'agua']);
            for($i=0; $i<count($data['ImpactoAguaSubterranea']['descripcion']);$i++){
                $impactoAgua = $entityManager->getRepository(Impacto::class)->findOneBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto,"descripcion"=>$data['ImpactoAguaSubterranea']['descripcion'][$i]]);
                if($impactoAgua == null){
                    $impactoAgua = new Impacto();
                }
                $impactoAgua->setTipoImpacto($tipoImpacto);
                $impactoAgua->setDescripcion($data['ImpactoAguaSubterranea']['descripcion'][$i]);
                $impactoAgua->setProceso($data['ImpactoAguaSubterranea']['proceso'][$i]);
                $impactoAgua->setContaminanteRelevante($data['ImpactoAguaSubterranea']['contaminacionRelevantes'][$i]);
                $impactoAgua->setPlanta($planta);
                $entityManager->persist($impactoAgua);
                if(isset($data['imagenesAgua']['PlanoUbicacionFreatimetrosEscurrimiento'][$i])){
                    $storageService->generarUID($data['imagenesAgua']['PlanoUbicacionFreatimetrosEscurrimiento'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.2.'.$i.'.1',$tramite,'Impacto',$impactoAgua->getid());
                }
                
            }
        }
        if($data['Impacto']['tipo']['aire']==1){
            $tipoImpacto = $entityManager->getRepository(TipoImpacto::class)->findOneBy(['tipo'=>'aire']);
            for($i=0; $i<count($data['ImpactoAire']['descripcion']);$i++){
                $impactoAire = $entityManager->getRepository(Impacto::class)->findOneBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto,"descripcion"=>$data['ImpactoAire']['descripcion'][$i]]);
                if($impactoAire == null){
                    $impactoAire = new Impacto();
                }
                $impactoAire->setTipoImpacto($tipoImpacto);
                $impactoAire->setDescripcion($data['ImpactoAire']['descripcion'][$i]);
                $impactoAire->setProceso($data['ImpactoAire']['proceso'][$i]);
                $impactoAire->setContaminanteRelevante($data['ImpactoAire']['contaminacionRelevantes'][$i]);
                $impactoAire->setPlanta($planta);
                $entityManager->persist($impactoAire);
                if(isset($data['imagenesAire']['PlanoUbbicacionPuntosMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesAire']['PlanoUbbicacionPuntosMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.3.'.$i.'.1',$tramite,'Impacto',$impactoAire->getid());
                }
                if(isset($data['imagenesAire']['ProtocoloMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesAire']['ProtocoloMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.3.'.$i.'.2',$tramite,'Impacto',$impactoAire->getid());
                }
            }
        }
        if($data['Impacto']['tipo']['cuerpoReceptor']==1){
            $tipoImpacto = $entityManager->getRepository(TipoImpacto::class)->findOneBy(['tipo'=>'cuerporeceptor']);
            for($i=0; $i<count($data['ImpactoCuerpoReceptor']['origen']);$i++){
                $impactoCuerpoReceptor = $entityManager->getRepository(Impacto::class)->findOneBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto,"descripcion"=>$data['ImpactoCuerpoReceptor']['descripcion'][$i]]);
                if($impactoCuerpoReceptor == null){
                    $impactoCuerpoReceptor = new Impacto();
                }
                $impactoCuerpoReceptor->setTipoImpacto($tipoImpacto);
                $impactoCuerpoReceptor->setDescripcion($data['ImpactoCuerpoReceptor']['descripcion'][$i]);
                $impactoCuerpoReceptor->setProceso($data['ImpactoCuerpoReceptor']['origen'][$i]);
                $impactoCuerpoReceptor->setCaudal($data['ImpactoCuerpoReceptor']['caudal'][$i]); 
                $impactoCuerpoReceptor->setContaminanteRelevante($data['ImpactoCuerpoReceptor']['parametroReceptor'][$i]);
                $impactoCuerpoReceptor->setCuerpoReceptor($data['ImpactoCuerpoReceptor']['cuerpoReceptor'][$i]); 
                $impactoCuerpoReceptor->setPlanta($planta);
                $entityManager->persist($impactoCuerpoReceptor);
                if(isset($data['imagenesCuerpoReceptor']['SistemaTratamiento'][$i])){
                    $storageService->generarUID($data['imagenesCuerpoReceptor']['SistemaTratamiento'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.4.'.$i.'.1',$tramite,'Impacto',$impactoCuerpoReceptor->getid());
                }
                if(isset($data['imagenesCuerpoReceptor']['PlanoMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesCuerpoReceptor']['PlanoMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.4.'.$i.'.2',$tramite,'Impacto',$impactoCuerpoReceptor->getid());
                }
                if(isset($data['imagenesCuerpoReceptor']['ProtocoloMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesCuerpoReceptor']['ProtocoloMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.4.'.$i.'.3',$tramite,'Impacto',$impactoCuerpoReceptor->getid());
                }
            }
        }
        if($data['Impacto']['tipo']['otros']==1){
            $tipoImpacto = $entityManager->getRepository(TipoImpacto::class)->findOneBy(['tipo'=>'otro_impacto']);
            for($i=0; $i<count($data['ImpactoOtro']['descripcion']);$i++){
                $impactoCuerpoOtro = $entityManager->getRepository(Impacto::class)->findOneBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto,"descripcion"=>$data['ImpactoOtro']['descripcion'][$i]]);
                if($impactoCuerpoOtro == null){
                    $impactoCuerpoOtro = new Impacto();
                }
                $impactoCuerpoOtro->setTipoImpacto($tipoImpacto);
                $impactoCuerpoOtro->setDescripcion($data['ImpactoOtro']['descripcion'][$i]);
                $impactoCuerpoOtro->setProceso($data['ImpactoOtro']['proceso'][$i]);
                $impactoCuerpoOtro->setContaminanteRelevante($data['ImpactoOtro']['consecuencia'][$i]);
                $impactoCuerpoOtro->setPlanta($planta);
                $entityManager->persist($impactoCuerpoOtro);
                if(isset($data['imagenesOtros']['PlanoMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesOtros']['PlanoMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.4.'.$i.'.2',$tramite,'Impacto',$impactoCuerpoOtro->getid());
                }
                if(isset($data['imagenesOtros']['ProtocoloMuestreo'][$i])){
                    $storageService->generarUID($data['imagenesOtros']['ProtocoloMuestreo'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('7.4.'.$i.'.3',$tramite,'Impacto',$impactoCuerpoOtro->getid());
                }
            }
        }
        $entityManager->flush();
        $tiposImpacto = $entityManager->getRepository(TipoImpacto::class)->findAll();
        foreach($tiposImpacto as $tipoImpacto){
            switch ($tipoImpacto->getTipo()){                
                case 'suelo':
                    $filtro['ImpactoSuelo'] = $entityManager->getRepository(Impacto::class)->findImpactoCantidad($planta,$tipoImpacto);
                    $filtro['ImpactoSueloDAtos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'agua':
                    $filtro['ImpactoAguaSubterranea'] = $entityManager->getRepository(Impacto::class)->findImpactoCantidad($planta,$tipoImpacto);
                    $filtro['ImpactoAguaSubterraneaDAtos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'aire':
                    $filtro['ImpactoAire'] = $entityManager->getRepository(Impacto::class)->findImpactoCantidad($planta,$tipoImpacto);
                    $filtro['ImpactoAireDAtos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'cuerporeceptor':
                    $filtro['ImpactoCuerpoReceptor'] = $entityManager->getRepository(Impacto::class)->findImpactoCantidad($planta,$tipoImpacto);
                    $filtro['ImpactoCuerpoReceptorDAtos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'otro_impacto':
                    $filtro['ImpactoOtro'] = $entityManager->getRepository(Impacto::class)->findImpactoCantidad($planta,$tipoImpacto);
                    $filtro['ImpactoOtroDAtos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
            }
        }
        $filtro['TipoResiduosPeligroso'] = $entityManager->getRepository(ListadoTipoResiduo::class)->findBy(['tipo'=>'PELIGROSOS']);
        $filtro['TipoResiduosNoPeligroso'] = $entityManager->getRepository(ListadoTipoResiduo::class)->findBy(['tipo'=>'NO PELIGROSOS']);
        $filtro['TiposResiduos'] = $entityManager->getRepository(TipoResiduo::class)->findAll();
        $filtro['ResiduoSolido'] = $entityManager->getRepository(Residuo::class)->findOneby(['planta'=>$planta,'categoria'=>'ResiduoSolido']);
        $archivos = $entityManager->getRepository(Storage::class)->findBy(['tramite'=>$tramite]);
        if($filtro['ResiduoSolido']!=null){
            $filtro['TratamientoPlantaExpendioResiduoSolido'] = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneby(['residuo'=>$filtro['ResiduoSolido']]);
        }
        $filtro['Peligroso'] = $entityManager->getRepository(Residuo::class)->findby(['planta'=>$planta,'categoria'=>'Peligroso']);
        if($filtro['Peligroso']!=null){
            foreach($filtro['Peligroso'] as $residuo){
                $filtro['TratamientoPlantaExpendioPeligroso'][] = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneby(['residuo'=>$residuo]);
            }
        }
        $filtro['NoPeligroso'] = $entityManager->getRepository(Residuo::class)->findby(['planta'=>$planta,'categoria'=>'NoPeligroso']);
        if($filtro['NoPeligroso']!=null){
            foreach($filtro['NoPeligroso'] as $residuo){
                $filtro['TratamientoPlantaExpendioNoPeligroso'][] = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneby(['residuo'=>$residuo]);
            }
        }
        $filtro['LiquidosDesagote'] = $entityManager->getRepository(Residuo::class)->findby(['planta'=>$planta,'categoria'=>'LiquidosDesagote']);
        if($filtro['LiquidosDesagote']!=null){
            foreach($filtro['LiquidosDesagote'] as $residuo){
                $filtro['TratamientoPlantaExpendioLiquidosDesagote'][] = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneby(['residuo'=>$residuo]);
            }
        }        
        $filtro['LiquidosRedCloacal'] = $entityManager->getRepository(Residuo::class)->findOneby(['planta'=>$planta,'categoria'=>'LiquidosRedCloacal']);
        if($filtro['LiquidosRedCloacal']!=null){
            foreach($archivos as $archivo){
                if($archivo->getInciso() == "9.1.1"){
                    $filtro['ImagenesLiquidosRedCloacal'] = $archivo->getNombre();
                }
            }
            $filtro['TratamientoPlantaExpendioLiquidosRedCloacal'] = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneby(['residuo'=>$filtro['LiquidosRedCloacal']]);
        }
        $filtro['LiquidosResiduales'] = $entityManager->getRepository(Efluente::class)->findby(['categoria'=>'LiquidosResiduales','planta'=>$planta]);
        $filtro['EmisionGaseosa'] = $entityManager->getRepository(Efluente::class)->findby(['categoria'=>'EmisionGaseosa','planta'=>$planta]);
        $filtro['Ruido'] = $entityManager->getRepository(Efluente::class)->findby(['categoria'=>'Ruido','planta'=>$planta]);
        $filtro['RiesgoPresuntoLiquidos'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'liquidi']);
        $filtro['RiesgoPresuntoGnc'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'gnc']);
        $filtro['RiesgoPresuntoSustancia'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'sustancia']);
        $filtro['RiesgoPresuntoServec'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'servsec']);
        $filtro['RiesgoPresuntoLiquidas'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'liquidas']);
        $filtro['RiesgoPresuntoAlmGnc'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'almgnc']);
        $filtro['RiesgoPresuntoAlmSustancia'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'almsustancia']);
        $filtro['RiesgoPresuntoAgua'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'agua']);
        $filtro['RiesgoPresuntoElectricidad'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'electricidad']);
        $filtro['RiesgoPresuntoRecursos'] = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>'recursos']);
        return $this->render('expendioCombustible/formulario8.html.twig',$filtro);
    }

    /**
     * @Route("/formularioExpendio9", name="formularioExpendio9", methods={"POST"})
     */
    public function formulario9(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);
        $tiposImpacto = $entityManager->getRepository(TipoImpacto::class)->findAll();
        foreach($tiposImpacto as $tipoImpacto){
            switch ($tipoImpacto->getTipo()){                
                case 'suelo':
                    $filtro['ImpactoSuelo'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'agua':
                    $filtro['ImpactoAguaSubterranea'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'aire':
                    $filtro['ImpactoAire'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'cuerporeceptor':
                    $filtro['ImpactoCuerpoReceptor'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
                case 'otro_impacto':
                    $filtro['ImpactoOtro'] = $entityManager->getRepository(Impacto::class)->findBy(["planta"=>$planta,"tipoImpacto"=>$tipoImpacto]);
                    break;
            }
        }
        $datos['ImpactoSuelo'] = $request->get('ImpactoSuelo');
        $datos['MitigacionSuelo'] = $request->get('MitigacionSuelo');        
        for($i=0;$i<count($filtro['ImpactoSuelo']);$i++){
            $filtro['ImpactoSuelo'][$i]->setPrevencion($datos['ImpactoSuelo'][$i]);
            $filtro['ImpactoSuelo'][$i]->setMedidaMitigacion($datos['MitigacionSuelo'][$i]);
            if($request->get('CalidadSuelo')!=null){
                $filtro['ImpactoSuelo'][$i]->setFrecuencia($request->get('CalidadSuelo'));    
            }
            $entityManager->persist($filtro['ImpactoSuelo'][$i]);
        }

        $datos['ImpactoAguaSubterranea'] = $request->get('ImpactoAguaSubterranea');
        $datos['MitigacionAgua'] = $request->get('MitigacionAgua');
        for($i=0;$i<count($filtro['ImpactoAguaSubterranea']);$i++){
            $filtro['ImpactoAguaSubterranea'][$i]->setPrevencion($datos['ImpactoAguaSubterranea'][$i]);
            $filtro['ImpactoAguaSubterranea'][$i]->setMedidaMitigacion($datos['MitigacionAgua'][$i]);
            if($request->get('CalidadAguaSubterranea')!=null){
                $filtro['ImpactoAguaSubterranea'][$i]->setFrecuencia($request->get('CalidadAguaSubterranea'));    
            }
            $entityManager->persist($filtro['ImpactoAguaSubterranea'][$i]);
        }
        
        $datos['ImpactoAire'] = $request->get('ImpactoAire');
        $datos['MitigacionAire'] = $request->get('MitigacionAire');
        for($i=0;$i<count($filtro['ImpactoAire']);$i++){
            $filtro['ImpactoAire'][$i]->setPrevencion($datos['ImpactoAire'][$i]);
            $filtro['ImpactoAire'][$i]->setMedidaMitigacion($datos['MitigacionAire'][$i]);
            if($request->get('CalidadAire')!=null){
                $filtro['ImpactoAire'][$i]->setFrecuencia($request->get('CalidadAire'));    
            }
            $entityManager->persist($filtro['ImpactoAire'][$i]);
        }
        
        $datos['ImpactoCuerpoReceptor'] = $request->get('ImpactoCuerpoReceptor');
        $datos['MitigacionCuerpoReceptor'] = $request->get('MitigacionCuerpoReceptor');
        for($i=0;$i<count($filtro['ImpactoCuerpoReceptor']);$i++){
            $filtro['ImpactoCuerpoReceptor'][$i]->setPrevencion($datos['ImpactoCuerpoReceptor'][$i]);
            $filtro['ImpactoCuerpoReceptor'][$i]->setMedidaMitigacion($datos['MitigacionCuerpoReceptor'][$i]);
            if($request->get('CalidadCuerpoReceptor')!=null){
                $filtro['ImpactoCuerpoReceptor'][$i]->setFrecuencia($request->get('CalidadCuerpoReceptor'));    
            }
            $entityManager->persist($filtro['ImpactoCuerpoReceptor'][$i]);
        }
        
        $datos['ImpactoOtro'] = $request->get('ImpactoOtro');
        $datos['MitigacionOtro'] = $request->get('MitigacionOtro');
        for($i=0;$i<count($filtro['ImpactoOtro']);$i++){
            $filtro['ImpactoOtro'][$i]->setPrevencion($datos['ImpactoOtro'][$i]);
            $filtro['ImpactoOtro'][$i]->setMedidaMitigacion($datos['MitigacionOtro'][$i]);
            if($request->get('CalidadOtros')!=null){
                $filtro['ImpactoOtro'][$i]->setFrecuencia($request->get('CalidadOtros'));    
            }
            $entityManager->persist($filtro['ImpactoOtro'][$i]);
        }
        
 
        $datos['ResiduosSolidos'] = $request->get('ResiduosSolidos');
        $residuosSolidosRepository = $entityManager->getRepository(Residuo::class)->findOneby(['categoria'=>"ResiduoSolido",'tipo'=>$datos['ResiduosSolidos']['tipo'],'planta'=>$planta]);
        if($residuosSolidosRepository==null){
            $residuosSolidosRepository = new Residuo();
        }
        $residuosSolidosRepository->setCategoria('ResiduoSolido');
        $residuosSolidosRepository->setTipo($datos['ResiduosSolidos']['tipo']);
        $residuosSolidosRepository->setVolumen($datos['ResiduosSolidos']['cantidad']);
        $residuosSolidosRepository->setPlanta($planta);
        $entityManager->persist($residuosSolidosRepository);
        $entityManager->flush();
        $tramitePlantaExpendioRepository = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(['residuo'=>$residuosSolidosRepository]);
        if($tramitePlantaExpendioRepository==null){
            $tramitePlantaExpendioRepository = new TramitePlantaExpendio();
        }
        $tramitePlantaExpendioRepository->setResiduo($residuosSolidosRepository->getId());
        $tramitePlantaExpendioRepository->setEmpresaTransportadora($datos['ResiduosSolidos']['empresa']);
        $tramitePlantaExpendioRepository->setDisposicionFinal($datos['ResiduosSolidos']['destino']);
        $entityManager->persist($tramitePlantaExpendioRepository);
        $entityManager->flush();

        $datos['Residuos'] = $request->get('Residuos');

        if($datos['Residuos']['Peligrosos']['check']!=0){
            for($k=0;$k<count($datos['Residuos']['Peligrosos']['tipo']);$k++){
                $residuosRepository = $entityManager->getRepository(Residuo::class)->findOneby(['categoria'=>"Peligroso",'tipo'=>$datos['Residuos']['Peligrosos']['tipo'][$k],'planta'=>$planta]);
                if($residuosRepository==null){
                    $residuosRepository = new Residuo();
                }                
                $residuosRepository->setCategoria("Peligroso");
                $residuosRepository->setTipo($datos['Residuos']['Peligrosos']['tipo'][$k]);
                $residuosRepository->setVolumen($datos['Residuos']['Peligrosos']['volumen'][$k]);
                $residuosRepository->setPlanta($planta);
                $entityManager->persist($residuosRepository);
                $entityManager->flush();
                $tramitePlantaExpendioRepository = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(['residuo'=>$residuosRepository]);
                if($tramitePlantaExpendioRepository==null){
                    $tramitePlantaExpendioRepository = new TramitePlantaExpendio();
                }
                $tramitePlantaExpendioRepository->setResiduo($residuosRepository->getId());
                $tramitePlantaExpendioRepository->setEmpresaTransportadora($datos['Residuos']['Peligrosos']['empresa'][$k]);
                $tramitePlantaExpendioRepository->setDisposicionFinal($datos['Residuos']['Peligrosos']['destino'][$k]);
                $tramitePlantaExpendioRepository->setNumeroRegistro($datos['Residuos']['Peligrosos']['nrogenerador']);
                $entityManager->persist($tramitePlantaExpendioRepository);
            }            
        }

        if($datos['Residuos']['NoPeligrosos']['check']!=0){
            for($k=0;$k<count($datos['Residuos']['NoPeligrosos']['tipo']);$k++){
                $residuosRepository = $entityManager->getRepository(Residuo::class)->findOneby(['categoria'=>"NoPeligroso",'tipo'=>$datos['Residuos']['NoPeligrosos']['tipo'][$k],'planta'=>$planta]);
                if($residuosRepository==null){
                    $residuosRepository = new Residuo();
                }
                $residuosRepository->setCategoria("NoPeligroso");
                $residuosRepository->setTipo($datos['Residuos']['NoPeligrosos']['tipo'][$k]);
                $residuosRepository->setVolumen($datos['Residuos']['NoPeligrosos']['volumen'][$k]);
                $residuosRepository->setPlanta($planta);
                $entityManager->persist($residuosRepository);
                $entityManager->flush();
                $tramitePlantaExpendioRepository = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(['residuo'=>$residuosRepository]);
                if($tramitePlantaExpendioRepository==null){
                    $tramitePlantaExpendioRepository = new TramitePlantaExpendio();
                }
                $tramitePlantaExpendioRepository->setResiduo($residuosRepository->getId());
                $tramitePlantaExpendioRepository->setEmpresaTransportadora($datos['Residuos']['NoPeligrosos']['empresa'][$k]);
                $tramitePlantaExpendioRepository->setDisposicionFinal($datos['Residuos']['NoPeligrosos']['destino'][$k]);
                $entityManager->persist($tramitePlantaExpendioRepository);
            }            
        }
        
        $datos['Liquidos'] = $request->get('Liquidos');
        if($datos['Liquidos']['Desagote']['check']==1){
            for($k=0;$k<count($datos['Liquidos']['Desagote']['numero']);$k++){
                $residuosSolidosRepository = $entityManager->getRepository(Residuo::class)->findOneby(['categoria'=>"LiquidosDesagote",'tipo'=>11,'planta'=>$planta]);
                if($residuosSolidosRepository==null){
                    $residuosSolidosRepository = new Residuo();
                }
                $residuosSolidosRepository->setCategoria("LiquidosDesagote");
                $residuosSolidosRepository->setTipo(11);
                $residuosSolidosRepository->setPlanta($planta);
                $residuosSolidosRepository->setVolumen($datos['Liquidos']['Desagote']['numero'][$k]);
                $entityManager->persist($residuosSolidosRepository);
                $entityManager->flush();
                $tramitePlantaExpendioRepository = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(['residuo'=>$residuosSolidosRepository]);
                if($tramitePlantaExpendioRepository==null){
                    $tramitePlantaExpendioRepository = new TramitePlantaExpendio();
                }
                $tramitePlantaExpendioRepository->setResiduo($residuosSolidosRepository->getId());
                $tramitePlantaExpendioRepository->setEmpresaTransportadora($datos['Liquidos']['Desagote']['empresa'][$k]);
                $tramitePlantaExpendioRepository->setDisposicionFinal($datos['Liquidos']['Desagote']['destino'][$k]);
                $entityManager->persist($tramitePlantaExpendioRepository);
            }
            
        }
        if($datos['Liquidos']['RedCloacal']['check']==1){
            $residuosSolidosRepository = $entityManager->getRepository(Residuo::class)->findOneby(['categoria'=>"LiquidosRedCloacal",'tipo'=>11,'planta'=>$planta]);
            if($residuosSolidosRepository==null){
                $residuosSolidosRepository = new Residuo();
            }
            $residuosSolidosRepository->setCategoria('LiquidosRedCloacal');
            $residuosSolidosRepository->setTipo(11);
            $residuosSolidosRepository->setPlanta($planta);
            $entityManager->persist($residuosSolidosRepository);
            $entityManager->flush();
            $tramitePlantaExpendioRepository = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(['residuo'=>$residuosSolidosRepository]);
            if($tramitePlantaExpendioRepository==null){
                $tramitePlantaExpendioRepository = new TramitePlantaExpendio();
            }
            $tramitePlantaExpendioRepository->setResiduo($residuosSolidosRepository->getId());
            $tramitePlantaExpendioRepository->setEmpresaTransportadora($datos['Liquidos']['RedCloacal']['empresa']);
            $entityManager->persist($tramitePlantaExpendioRepository);
            
            if(isset($datos['Liquidos']['RedCloacal']['contrato']) and $datos['Liquidos']['RedCloacal']['contrato']!=null){
                $storageService = new StorageService($entityManager);
                $storageService->generarUID($request->files->get('Liquidos'));
                $storageService->crearDirectorio();
                $storageService->subirArchivo('9.1.1',$tramite,'TramitePlantaExpendio',$tramitePlantaExpendioRepository->getid());
            }                        
        }
        $datos['LiquidosResiduales'] = $request->get('LiquidosResiduales');        
        if($datos['LiquidosResiduales']['Otros']['check']==1){
            for($k=0;$k<count($datos['LiquidosResiduales']['procesoGenerado']);$k++){
                $otrosEfluenteRepository = $entityManager->getRepository(Efluente::class)->findOneby(['categoria'=>"LiquidosResiduales",'tipo'=>11,'planta'=>$planta,'procesoGenerador'=>$datos['LiquidosResiduales']['procesoGenerado'][$k]]);
                if($otrosEfluenteRepository==null){
                    $otrosEfluenteRepository = new Efluente();
                }
                $otrosEfluenteRepository->setCategoria("LiquidosResiduales");
                $otrosEfluenteRepository->setTipo(11);
                $otrosEfluenteRepository->setProcesoGenerador($datos['LiquidosResiduales']['procesoGenerado'][$k]);
                $otrosEfluenteRepository->setComponenteRelevante($datos['LiquidosResiduales']['componenteRelevante'][$k]);
                $otrosEfluenteRepository->setVolumen($datos['LiquidosResiduales']['cantidad'][$k]);
                $otrosEfluenteRepository->setUnidad($datos['LiquidosResiduales']['volumen'][$k]);
                $otrosEfluenteRepository->setPeriodoTiempo($datos['LiquidosResiduales']['periodoTiempo'][$k]);
                $otrosEfluenteRepository->setGestion($datos['LiquidosResiduales']['gestion'][$k]);
                $otrosEfluenteRepository->setReceptor($datos['LiquidosResiduales']['destino'][$k]);
                $otrosEfluenteRepository->setPlanta($planta);
                $entityManager->persist($otrosEfluenteRepository);
            }
        }
        $datos['Emision'] = $request->get('Emision');
        if($datos['Emision']['Gaseosa']['check']==1){
            for($k=0;$k<count($datos['Emision']['Gaseosa']['procesoGenerado']);$k++){
                $otrosEfluenteRepository = $entityManager->getRepository(Efluente::class)->findOneby(['categoria'=>"EmisionGaseosa",'tipo'=>11,'planta'=>$planta,'procesoGenerador'=>$datos['Emision']['Gaseosa']['procesoGenerado'][$k]]);
                if($otrosEfluenteRepository==null){
                    $otrosEfluenteRepository = new Efluente();
                }
                $otrosEfluenteRepository->setCategoria("EmisionGaseosa");
                $otrosEfluenteRepository->setTipo(11);
                $otrosEfluenteRepository->setProcesoGenerador($datos['Emision']['Gaseosa']['procesoGenerado'][$k]);
                $otrosEfluenteRepository->setComponenteRelevante($datos['Emision']['Gaseosa']['componenteRelevante'][$k]);                
                $otrosEfluenteRepository->setGestion($datos['Emision']['Gaseosa']['gestion'][$k]);
                $otrosEfluenteRepository->setReceptor($datos['Emision']['Gaseosa']['destino'][$k]);
                $otrosEfluenteRepository->setPlanta($planta);
                $entityManager->persist($otrosEfluenteRepository);
            }
        }
        $datos['Ruido'] = $request->get('Ruido');
        if($datos['Ruido']['check']==1){
            for($k=0;$k<count($datos['Ruido']['operacion']);$k++){
                $ruidoEfluenteRepository = $entityManager->getRepository(Efluente::class)->findOneby(['categoria'=>"Ruido",'tipo'=>11,'planta'=>$planta,'procesoGenerador'=>$datos['Ruido']['operacion'][$k]]);
                if($ruidoEfluenteRepository==null){
                    $ruidoEfluenteRepository = new Efluente();
                }
                $ruidoEfluenteRepository->setCategoria('Ruido');
                $ruidoEfluenteRepository->setTipo(11);
                $ruidoEfluenteRepository->setProcesoGenerador($datos['Ruido']['operacion'][$k]);
                $ruidoEfluenteRepository->setTratamiento($datos['Ruido']['tratamiento'][$k]);                
                $ruidoEfluenteRepository->setGestion($datos['Ruido']['observacion'][$k]);
                $ruidoEfluenteRepository->setPlanta($planta);
                $entityManager->persist($ruidoEfluenteRepository);
            }
        }
        $datos['Riesgo'] = $request->get('Riesgo');
        foreach(array_keys($datos['Riesgo']) as $tiporiesgo){            
            $riesgoPresunto = $entityManager->getRepository(RiesgoPresunto::class)->findOneBy(['planta'=>$planta,'proceso'=>$tiporiesgo]);
            if($riesgoPresunto==null){
                $riesgoPresunto = new RiesgoPresunto;
            }
            foreach($datos['Riesgo'][$tiporiesgo] as $riesgo){                
                if($riesgo!=""){                                
                    switch($riesgo){
                        case 'acustico':
                            $riesgoPresunto->setAcustico(1);
                            break;
                        case 'presion':
                            $riesgoPresunto->setPresion(1);
                            break;
                        case 'sustancia':
                            $riesgoPresunto->setSustanciaQuimica(1);
                            break;
                        case 'explosion':
                            $riesgoPresunto->setExplosion(1);
                            break;
                        case 'incendio':
                            $riesgoPresunto->setIncendio(1);
                            break;
                        default:
                            $riesgoPresunto->setOtro(1);
                            $riesgoPresunto->setObservaciones($riesgo);
                            break;
                    }
                }
            }
            $riesgoPresunto->setProceso($tiporiesgo);
            $riesgoPresunto->setPlanta($planta);
            $entityManager->persist($riesgoPresunto);
        }
        $entityManager->flush();
        $filtro['SitioContaminado'] = $entityManager->getRepository(SitioContaminado::class)->findOneBy(['planta'=>$planta]);
        return $this->render('expendioCombustible/formulario9.html.twig',$filtro);
    }
    
    /**
     * @Route("/formularioExpendio10", name="formularioExpendio10", methods={"POST"})
     */
    public function formulario10(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $empresa = $tramite->getEmpresa();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa,"tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$empresa,"domicilio"=>$domicilio]);
        $sitioContaminado = $request->get('SitioContaminado');
        if($sitioContaminado['check']==1){
            $sitioContaminadoRepository = $entityManager->getRepository(SitioContaminado::class)->findOneBy(['planta'=>$planta]);
            if($sitioContaminadoRepository==null){
                $sitioContaminadoRepository = new SitioContaminado;
            }
            $sitioContaminadoRepository->setDescripcion($sitioContaminado['descripcion']);
            $sitioContaminadoRepository->setPlanRemediacion($sitioContaminado['planRemediacio']);
            $sitioContaminadoRepository->setParametrosIntereses($sitioContaminado['parametrosInteres']);
            $sitioContaminadoRepository->setPlanta($planta);
            $entityManager->persist($sitioContaminadoRepository);
            $entityManager->flush();
        }
        return $this->redirectToRoute('misTramites');
    }
}