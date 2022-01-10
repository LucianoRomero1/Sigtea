<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\StorageService;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Loteo;
use AppBundle\Entity\MarcoLegal;
use AppBundle\Entity\ResumenEjecutivo;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Urbanizacion;
use AppBundle\Entity\AreaMedioUrbanizacion;
use AppBundle\Entity\AreaUrbanizacionMedio;
use AppBundle\Entity\AreaNaturalProtegida;
use AppBundle\Entity\AfectacionA;
use AppBundle\Entity\ServidumbreAmbiental;
use AppBundle\Entity\MedidaPreventiva;
use AppBundle\Entity\EmpresaHasActividad;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Formulario;
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
use AppBundle\Entity\EmisionGaseosa;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\RiesgoPresunto;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Tanque;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Departamento;
use \DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ImpactoAmbientalFinUrbanizacionController extends BaseController
{
    /**
     * @Route("/formularioUrbanizacionEstudioImpactoAmbiental", name="formularioUrbanizacionEstudioImpactoAmbiental", methods={"GET"})
     */
    public function formularioUrbanizacionEstudioImpactoAmbiental(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->get("idTramite")!=0){
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $empresa = $tramite->getEmpresa();
            $filtro['Empresa'] = $empresa;
            $filtro['Persona'] = $tramite->getEmpresa()->getPersona();
            $filtro['Loteo'] = $entityManager->getRepository(Loteo::class)->findOneBy(["tramite" => $tramite]);
            
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilio!=null){
                $filtro['Domicilio'] = $domicilio;
            }
        }else{
            $tramite = new Tramite();
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(2);

            if ($listaTramite != null){
                $tramite->setNombre( $listaTramite -> getDescripcion() );
                $estado = $entityManager->getRepository(Estado::class)->find(1);
                $tramite->setEstado( $estado );
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
        }          
        $filtro['idTramite'] = $tramite->getId();
        $filtro['usuario'] = $this->getUser();
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();

        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU1.html.twig',$filtro);        
    }

    /**
     * @Route("/tramiteEIAFU1", name="tramiteEIAFU1", methods={"POST"})
     */
    public function tramiteEIAFU1(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);   
        $datos['Loteo'] = $request->get('Loteo');
        $datos['Persona'] = $request->get('Persona');
        $datos['Empresa'] = $request->get('Empresa');
        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);

        if ($datos['Persona']!=null){
            $cuit = trim($datos['Persona']["cuit"][0]).trim($datos['Persona']["cuit"][1]).trim($datos['Persona']["cuit"][2]);
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
            if($persona== null){
                $persona = new Persona();            
            }        
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
            $persona->setCuit($cuit);
            $entityManager->persist($persona);
        }
        if($datos['Empresa']!=null){
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(['tipoPersona'=>$datos['Empresa']["tipoEntidad"],'persona'=>$persona]);
            if($empresa== null){
                $empresa = new Empresa();            
            }
            $empresa->setFechaInicioActividad(new \DateTime(date("Y-m-d"))); // No trae fecha en este formulario.
            $empresa->setTipoPersona($datos['Empresa']["tipoEntidad"]);
            $empresa->setDeposito(0); // No trae deposito en este formulario.
            $empresa->setPersona($persona);
            $entityManager->persist($empresa);
            $tramite->setEmpresa($empresa);
            $entityManager->persist($tramite);
        }
        if ($datos['Domicilio'] != null){
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa(), "tipo" => 1]);
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
            $domicilio->setTipo(1);

            $entityManager->persist($domicilio);
        }
        if ($datos['Loteo'] != null){

            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(["tramite" => $tramite]);
            if ($loteo == null){
                $loteo = new Loteo();
            }

            $loteo->setNombre($datos['Loteo']['nombre']);
            $loteo->setNumeroExpediente($datos['Loteo']['numero']);
            $loteo->setTramite($tramite);
            $entityManager->persist($loteo);
        }

        $entityManager->flush();
        $empresa = $tramite->getEmpresa();
        $filtro['ResumenEjecutivo'] = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU2.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU2", name="tramiteEIAFU2", methods={"POST"})
     */
    public function tramiteEIAFU2(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);  
        $datos['ResumenEjecutivo'] = $request->get('Resumen');
        $empresa = $tramite->getEmpresa();
        
        if ($datos['ResumenEjecutivo'] != null){

            $resumenEjecutivo = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            if ($resumenEjecutivo == null){
                $resumenEjecutivo = new ResumenEjecutivo();
            }

            $resumenEjecutivo->setNroExpediente($datos['ResumenEjecutivo']['expediente']);
            $resumenEjecutivo->setDescripcion($datos['ResumenEjecutivo']['descripcion']);
            $resumenEjecutivo->setEmpresa($empresa);
            $entityManager->persist($resumenEjecutivo);
        }

        $entityManager->flush();
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        $filtro['Storage'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => 3]);
        
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU3.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU3", name="tramiteEIAFU3", methods={"POST"})
     */
    public function tramiteEIAFU3(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.2"]);
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU4.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU4", name="tramiteEIAFU4", methods={"POST"})
     */
    public function tramiteEIAFU4(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    

        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.4"]);
        $filtro['Storage5'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.5"]);
        $filtro['Storage6'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.6"]);
        $filtro['Storage7'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.7"]);
        $filtro['Storage8'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.8"]);
        $filtro['Storage9'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.9"]);
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU5.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU5", name="tramiteEIAFU5", methods={"POST"})
     */
    public function tramiteEIAFU5(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $empresa = $tramite->getEmpresa();
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";

        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(["empresa" => $empresa]);
        $filtro['AreaMedioUrbanizacion'] = $entityManager->getRepository(AreaMedioUrbanizacion::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        $filtro['AreaUrbanizacionMedio'] = $entityManager->getRepository(AreaUrbanizacionMedio::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        $filtro['AreaNaturalProtegida'] = $entityManager->getRepository(AreaNaturalProtegida::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        $filtro['AfectacionA'] = $entityManager->getRepository(AfectacionA::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        $filtro['ServidumbreAmbiental'] = $entityManager->getRepository(ServidumbreAmbiental::class)->findOneBy(["urbanizacion" => $urbanizacion]);

        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU6.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU6", name="tramiteEIAFU6", methods={"POST"})
     */
    public function tramiteEIAFU6(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);   
        $empresa = $tramite->getEmpresa();

        $datos['A'] = $request->get('A');
        $datos['B'] = $request->get('B');
        $datos['C'] = $request->get('C');
        $datos['D'] = $request->get('D');
        $datos['E'] = $request->get('E');
        
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(["empresa" => $empresa]);
        if ($urbanizacion == null){
            $urbanizacion = new Urbanizacion();
        }
        $urbanizacion->setEmpresa($empresa);
        $entityManager->persist($urbanizacion);

        // A

        $areaMedioUrbanizacion = $entityManager->getRepository(AreaMedioUrbanizacion::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        if ($areaMedioUrbanizacion != null){
            $entityManager -> remove( $areaMedioUrbanizacion );
        }
        $areaMedioUrbanizacion = new AreaMedioUrbanizacion();

        foreach($datos['A'] as $a){
            switch($a){
                case "Externalidades de actividades industriales":
                    $areaMedioUrbanizacion -> setActividadIndustrial(1);
                    break;
                case "Externalidades de actividades de servicios":
                    $areaMedioUrbanizacion -> setActividadServicio(1);
                    break;
                case "Externalidades de actividades agropecuarias":
                    $areaMedioUrbanizacion -> setActividadAgropecuaria(1);
                    break;
                case "Cercanias a plantas de tratamiento de efluentes":
                    $areaMedioUrbanizacion -> setPlantaTratamiento(1);
                    break;
                case "Actividades pecuarias":
                    $areaMedioUrbanizacion -> setActividadPecuaria(1);
                    break;
                case "Cría de ganado (bovino,porcino)":
                    $areaMedioUrbanizacion -> setCriaGanado(1);
                    break;
                case "Aves de corral":
                    $areaMedioUrbanizacion -> setAveCorral(1);
                    break;
                case "Externalidades por la proximidad de rutas":
                    $areaMedioUrbanizacion -> setProximidadRuta(1);
                    break;
                case "Oferta de transporte público":
                    $areaMedioUrbanizacion -> setTransportePublico(1);
                    break;
                case "Ferrocarriles":
                    $areaMedioUrbanizacion -> setFerrocarriles(1);
                    break;
                case "Aeropuertos":
                    $areaMedioUrbanizacion -> setAeropuerto(1);
                    break;
                case "Actividades agrícolas":
                    $areaMedioUrbanizacion -> setActividadAgricola(1);
                    break;
                case "Vertederos de RSU":
                    $areaMedioUrbanizacion -> setVertederosRsu(1);
                    break;
                case "Generación de residuos":
                    $areaMedioUrbanizacion -> setGeneracionResiduo(1);
                    break;
                case "Otros":
                    $areaMedioUrbanizacion -> setOtros($datos["A"]["otros"]);
                    break;
            }
        }
        
        $areaMedioUrbanizacion -> setUrbanizacion($urbanizacion);
        $entityManager->persist($areaMedioUrbanizacion);

        // B

        $areaUrbanizacionMedio = $entityManager->getRepository(AreaUrbanizacionMedio::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        if ($areaUrbanizacionMedio != null){
            $entityManager -> remove( $areaUrbanizacionMedio );
        }

        $areaUrbanizacionMedio = new AreaUrbanizacionMedio();

        foreach($datos['B'] as $b){
            switch($b){
                case "Ofertas de nuevas viviendas":
                    $areaUrbanizacionMedio -> setOfertaNuevaVivienda(1);
                    break;
                case "Aspectos socioeconómicos":
                    $areaUrbanizacionMedio -> setAspectoSocioEconomico(1);
                    break;
                case "Incremento en el tráfico vehicular":
                    $areaUrbanizacionMedio -> setIncrementoTraficoVehicular(1);
                    break;
                case "Afectación a los medios físicos(agua, suelo y aire)":
                    $areaUrbanizacionMedio -> setAfectacionMedioFisico(1);
                    break;
                case "Uso de aguas subterráneas":
                    $areaUrbanizacionMedio -> setUsoAguasSubterranea(1);
                case "Otros":
                    $areaUrbanizacionMedio -> setOtros($datos["B"]["otros"]);
                    break;
            }
        }

        $areaUrbanizacionMedio -> setUrbanizacion($urbanizacion);
        $entityManager->persist($areaUrbanizacionMedio);

        // C

        $areaNaturalProtegida = $entityManager->getRepository(AreaNaturalProtegida::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        if ($areaNaturalProtegida != null){
            $entityManager -> remove( $areaNaturalProtegida );
        }

        $areaNaturalProtegida = new AreaNaturalProtegida();

        foreach($datos['C'] as $c){
            switch($c){
                case "Riberas":
                    $areaNaturalProtegida -> setRibera(1);
                    break;
                case "Crestas de barrancas":
                    $areaNaturalProtegida -> setCrestaBarranca(1);
                    break;
                case "Otros":
                    $areaNaturalProtegida -> setOtros($datos["C"]["otros"]);
                    break;
            }
        }

        $areaNaturalProtegida -> setUrbanizacion($urbanizacion);
        $entityManager->persist($areaNaturalProtegida);

        // D

        $afectacionA = $entityManager->getRepository(AfectacionA::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        if ($afectacionA != null){
            $entityManager -> remove( $afectacionA );
        }

        $afectacionA = new AfectacionA();

        foreach($datos['D'] as $d){
            switch($d){
                case "Aspectos bióticos":
                    $afectacionA -> setAspectoBiotico(1);
                    break;
                case "Cobertura vegetal":
                    $afectacionA -> setCoberturaVegetal(1);
                    break;
                case "Fauna":
                    $afectacionA -> setFauna(1);
                    break;
                case "Otros":
                    $afectacionA -> setOtros($datos["D"]["otros"]);
                    break;
            }
        }

        $afectacionA -> setUrbanizacion($urbanizacion);
        $entityManager->persist( $afectacionA );

        // E

        $servidumbreAmbiental = $entityManager->getRepository(ServidumbreAmbiental::class)->findOneBy(["urbanizacion" => $urbanizacion]);
        if ($servidumbreAmbiental != null){
            $entityManager -> remove( $servidumbreAmbiental );
        }

        $servidumbreAmbiental = new ServidumbreAmbiental();

        foreach($datos['E'] as $e){
            switch($e){
                case "Electroductos":
                    $servidumbreAmbiental -> setElectroducto(1);
                    break;
                case "Gas":
                    $servidumbreAmbiental -> setGas(1);
                    break;
                case "Hídricas":
                    $servidumbreAmbiental -> setHidrica(1);
                    break;
                case "Otros":
                    $servidumbreAmbiental -> setOtros($datos["E"]["otros"]);
                    break;
            }
        }

        $servidumbreAmbiental -> setUrbanizacion($urbanizacion);
        $entityManager->persist( $servidumbreAmbiental );


        $entityManager->flush();

        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU7.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU7", name="tramiteEIAFU7", methods={"POST"})
     */
    public function tramiteEIAFU7(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $empresa = $tramite->getEmpresa();
        
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";
        
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(["empresa" => $empresa]);

        $filtro['MedidaPreventiva'] = $entityManager->getRepository(MedidaPreventiva::class)->findOneBy(["urbanizacion" => $urbanizacion]);

        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU8.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU8", name="tramiteEIAFU8", methods={"POST"})
     */
    public function tramiteEIAFU8(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['MedidaPreventiva'] = $request->get('MedidaPreventiva');
        $empresa = $tramite->getEmpresa();

        if ($datos['MedidaPreventiva'] != null){

            $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(["empresa" => $empresa]);
            if ($urbanizacion == null){
                $urbanizacion = new Urbanizacion();
            }
            $urbanizacion->setEmpresa($empresa);
            $entityManager->persist($urbanizacion);

            $medidaPreventiva = $entityManager->getRepository(MedidaPreventiva::class)->findOneBy(["urbanizacion" => $urbanizacion]);
            if ( $medidaPreventiva == null){
                $medidaPreventiva = new MedidaPreventiva();
            }

            $medidaPreventiva -> setInfraestructuraSaneamiento( $datos["MedidaPreventiva"]["Saneamiento"] );
            $medidaPreventiva -> setDescripcionMitigacionImpacto( $datos["MedidaPreventiva"]["Mitigacion"] );
            $medidaPreventiva -> setUrbanizacion( $urbanizacion );
            $entityManager -> persist( $medidaPreventiva );

        }

        $entityManager->flush();
        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";

        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.1"]);
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU9.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU9", name="tramiteEIAFU9", methods={"POST"})
     */
    public function tramiteEIAFU9(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);  
        $empresa = $tramite->getEmpresa();  

        $filtro['paginaInicio'] = "formularioUrbanizacionEstudioImpactoAmbiental";

        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "10.1"]);
        $filtro['Marco'] = $entityManager->getRepository(MarcoLegal::class)->findOneBy(["empresa" => $empresa]);
        return $this->render('impactoAmbientalFinUrbanizacion/formularioEIAFU10.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAFU10", name="tramiteEIAFU10", methods={"POST"})
     */
    public function tramiteEIAFU10(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Marco'] = $request->get('Marco');
        $empresa = $tramite->getEmpresa();
        if ($datos['Marco'] != null){

            $marco = $entityManager->getRepository(MarcoLegal::class)->findOneBy(["empresa" => $empresa]);
            if ( $marco == null){
                $marco = new MarcoLegal();
            }

            $marco -> setAplicacionEspecifica( $datos["Marco"]["especifica"] );
            $marco -> setEmpresa( $empresa );
            $entityManager -> persist( $marco );

        }

        $entityManager->flush();

        return $this->redirectToRoute('misTramites');
    }
}