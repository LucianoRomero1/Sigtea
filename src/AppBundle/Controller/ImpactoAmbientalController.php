<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\StorageService;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\CaracterizacionEntorno;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Proyecto;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\ListaTramites;
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
use AppBundle\Entity\EmpresaHasRepresentante;
use AppBundle\Entity\Planta;
use AppBundle\Entity\PartidaInmobiliaria;
use AppBundle\Entity\Producto;
use AppBundle\Entity\SubProducto;
use AppBundle\Entity\MateriaPrima;
use AppBundle\Entity\Insumo;
use AppBundle\Entity\SustanciaAuxiliar;
use AppBundle\Entity\SustanciaRiesgosa;
use AppBundle\Entity\CategoriaResiduoPeligroso;
use AppBundle\Entity\InmuebleAnexo;
use AppBundle\Entity\Servicio;
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

class  ImpactoAmbientalController extends BaseController
{
    /**
     * @Route("/formularioIndustriasInformeAmbientalCumplimiento", name="formularioIndustriasInformeAmbientalCumplimiento", methods={"GET"})
     */
    public function formularioImpactoAmbiental(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->get("idTramite")!=0){
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $empresa = $tramite->getEmpresa();
            $filtro['Empresa'] = $empresa;
            $filtro['Persona'] = $empresa->getPersona();
            $filtro['ResumenEjecutivo'] = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            // $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa" => $empresa]);
            
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilio!=null){
                $filtro['Domicilio'] = $domicilio;
            }
        }else{
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(5);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
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
        $filtro['idTramite'] = $tramite->getId();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo']= $tramite->getNombre();
        
        return $this->render('impactoAmbiental/formularioEIAA1.html.twig',$filtro);        
    }
    
    /**
     * @Route("/formularioAcopioGranosIAC", name="formularioAcopioGranosIAC", methods={"GET"})
     */
    public function formularioAcopioGranosIAC(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->get("idTramite")!=0){
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $empresa = $this->getFormulario($tramite->getId())->getEmpresa();
            $filtro['Empresa'] = $empresa;
            $filtro['Persona'] = $this->getFormulario($tramite->getId())->getEmpresa()->getPersona();
            $filtro['ResumenEjecutivo'] = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            // $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa" => $empresa]);
            
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilio!=null){
                $filtro['Domicilio'] = $domicilio;
            }
        }else{
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(13);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
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
        $filtro['idTramite'] = $tramite->getId();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo']= $tramite->getNombre();
        
        return $this->render('impactoAmbiental/formularioEIAA1.html.twig',$filtro);        
    }
    
    /**
     * @Route("/tramiteEIAA1", name="tramiteEIAA1", methods={"POST"})
     */
    public function tramiteEIA1A(Request $request)
    {
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        
        $datos['ResumenEjecutivo'] = $request->get('Resumen');
        $datos['Persona'] = $request->get('Persona');
        $datos['Empresa'] = $request->get('Empresa');
        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);

        if($datos['Persona']!=null){
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
            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(['tipoPersona'=>$datos['Empresa']["tipoEntidad"]]);
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
        if ($datos['ResumenEjecutivo'] != null){

            $resumenEjecutivo = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            if ($resumenEjecutivo == null){
                $resumenEjecutivo = new ResumenEjecutivo();
            }

            $resumenEjecutivo->setNroExpediente($datos['ResumenEjecutivo']['expediente']);
            $resumenEjecutivo->setDescripcion($datos['ResumenEjecutivo']['Descripcion']);
            $resumenEjecutivo->setEmpresa($empresa);
            $entityManager->persist($resumenEjecutivo);
        }

        $entityManager->flush();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $empresa = $tramite->getEmpresa();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>2]);
        if($domicilio!=null){
            $filtro['Domicilio'] = $domicilio;
        }
        $filtro['Coordenadas'] = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["numero"=>0]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
        $filtro['Caracterizacion'] = $entityManager->getRepository(CaracterizacionEntorno::class)->findOneBy(["planta" => $planta]);
        $filtro['Factor'] = $entityManager->getRepository(FactorAfectacion::class)->findBy(["caracterizacionEntorno" => $filtro['Caracterizacion']]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.5.4"]);
        $filtro['Storage5'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.5.5"]);
        $filtro['Storage6'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3.5.6"]);
        $filtro['paginaInicio'] = "formularioIndustriasInformeAmbientalCumplimiento";
        return $this->render('impactoAmbiental/formularioEIAA3.html.twig',$filtro); 
    }


    /**
     * @Route("/tramiteEIAA3", name="tramiteEIAA3", methods={"POST"})
     */
    public function tramiteEIA3A(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);   
        // $planta = $entityManager->getRepository(Planta::class)->find($filtro['idPlanta']); 
        $datos['Domicilio'] = $request->get('Domicilio');
        $datos['Coordenadas'] = $request->get('Coordenadas');
        $datos['Caracterizacion'] = $request->get('Caracterizacion');
        $datos['Factor'] = $request->get('Factor');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos['Domicilio'] !=null){
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa(), "tipo" => 2]);
            if($domicilio == null){
                $domicilio = new Domicilio();            
            }        
            $domicilio->setCalle($datos['Domicilio']["calle"]);
            $domicilio->setNumero($datos['Domicilio']["numero"]);
            $domicilio->setPiso($datos['Domicilio']["piso"]);
            $domicilio->setDepto($datos['Domicilio']["depto"]);
            $domicilio->setTelefono("");
            $domicilio->setEmail("");
            $domicilio->setEmpresa($tramite->getEmpresa());
            
            $domicilio->setProvincia($provincia);
            $domicilio->setDepartamento($departamento);
            $domicilio->setLocalidad($localidad);
            $domicilio->setTipo(2);
            $entityManager->persist($domicilio);
        }
        if ($datos['Coordenadas'] != null){

            $partidaInmobiliaria = new PartidaInmobiliaria();
            $partidaInmobiliaria->setNumero(0);
            $partidaInmobiliaria->setLatitud($datos["Coordenadas"]["lat"]);
            $partidaInmobiliaria->setLongitud($datos["Coordenadas"]["long"]);
            
            // $tramite->getEmpresa()
            if ($planta == null){
                $planta = new Planta();
                $planta->setEmpresa($tramite->getEmpresa());
            }
            
            $partidaInmobiliaria->setPlanta($planta);
            $entityManager->persist($planta);
            $entityManager->persist($partidaInmobiliaria);
        }
        
        if ($datos['Caracterizacion'] != null){
            
            $caracterizacion = $entityManager -> getRepository(CaracterizacionEntorno::class)->findOneBy(["planta" => $planta]);

            if($caracterizacion == null){
                $caracterizacion = new CaracterizacionEntorno();
            }
            $caracterizacion->setDescripcionInmediata($datos['Caracterizacion']['descripcion']);
            $caracterizacion->setViaAcceso($datos['Caracterizacion']['acceso']);
            $caracterizacion->setSituacionAmbiental($datos['Caracterizacion']['situacion']);
            $caracterizacion->setPlanta($planta);

            $entityManager->persist($caracterizacion);

        }
        if ($datos['Factor'] != null){

            for($i = 0; $i < count($datos['Factor']['factor']); $i++){
                $factor = $entityManager -> getRepository(FactorAfectacion::class)->findOneBy(["caracterizacionEntorno" => $caracterizacion, "factor" => $datos['Factor']['factor'][$i]]);
                if ($factor == null){
                    $factor = new FactorAfectacion();
                }
                
                $factor->setFactor($datos['Factor']['factor'][$i]);
                $factor->setDescripcion($datos['Factor']['descripcion'][$i]);
                $factor->setCaracterizacionEntorno($caracterizacion);
                $entityManager->persist($factor);
            }

            
        }
        
        $entityManager->flush();
        
        $filtro['Proyecto'] = $entityManager->getRepository(Proyecto::class)->findOneBy(["empresa" => $tramite->getEmpresa()]);
        $filtro['EtapasConstructivas'] = $entityManager->getRepository(EtapaConstructiva::class)->findBy(["proyecto" => $filtro['Proyecto']]);

        $filtro['Residuos'] = $entityManager->getRepository(Residuo::class)->findAll();
        $filtro['Efluentes'] = $entityManager->getRepository(Efluente::class)->findAll();
        $filtro['Emisiones'] = $entityManager->getRepository(EmisionGaseosa::class)->findAll();

        $filtro['EtapasOperativas'] = $entityManager->getRepository(EtapaOperativa::class)->findBy(["proyecto" => $filtro['Proyecto']]);
        $filtro['Recursos'] = $entityManager->getRepository(UsoRecurso::class)->findBy(["proyecto" => $filtro['Proyecto']]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.3"]);


        return $this->render('impactoAmbiental/formularioEIAA4.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA4", name="tramiteEIAA4", methods={"POST"})
     */
    public function tramiteEIA4A(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        
        $datos['EtapaConstructiva'] = $request->get('EtapaConstructiva');
        $datos['EtapaOperativa'] = $request->get('EtapaOperativa');
        $datos['Proyecto'] = $request->get('Proyecto');
        $datos['Recurso'] = $request->get('Recurso');

        if ($datos['Proyecto'] != null){

            $proyecto = $entityManager->getRepository(Proyecto::class)->findOneBy(["empresa" => $tramite->getEmpresa()]);

            if ($proyecto == null){
                $proyecto = new Proyecto();
            }
            $proyecto->setDefinicion($datos['Proyecto']['definicion']);
            $proyecto->setEmpresa($tramite->getEmpresa());
            $proyecto->setCierre($datos['Proyecto']['cierre']);
            $proyecto->setProduccionAnual($datos['Proyecto']['anual']);
            $proyecto->setCantidadTurnoHorario($datos['Proyecto']['horario']);
            $entityManager->persist($proyecto);
        }

        if ($datos['Recurso'] != null){

            for ($i = 0; $i < count($datos['Recurso']['recurso']); $i++){

                $recurso = $entityManager->getRepository(UsoRecurso::class)->findOneBy(["proyecto" => $proyecto]);
                if ($recurso == null){
                    $recurso = new UsoRecurso();
                }
                $recurso -> setRecurso($datos['Recurso']['recurso'][$i]);
                $recurso -> setExtraccion($datos['Recurso']['extraccion'][$i]);
                $recurso -> setProceso($datos['Recurso']['proceso'][$i]);
                $recurso -> setCantidadTiempo($datos['Recurso']['cantidad'][$i]);
                $recurso -> setProyecto($proyecto);
                $entityManager->persist($recurso);
            }
        }
        
        if ($datos['EtapaConstructiva'] != null){

            for ($i = 0; $i < count($datos['EtapaConstructiva']['tarea']); $i++){

                $etapaConstructiva = $entityManager->getRepository(EtapaConstructiva::class)->findOneBy(["proyecto" => $proyecto, "tarea" => $datos['EtapaConstructiva']['tarea'][$i]]);

                if ($etapaConstructiva == null){
                    $etapaConstructiva = new EtapaConstructiva();
                }
                $etapaConstructiva->setTarea($datos['EtapaConstructiva']['tarea'][$i]);
                $etapaConstructiva->setDescripcion($datos['EtapaConstructiva']['descripcion'][$i]);
                $etapaConstructiva->setInsumo($datos['EtapaConstructiva']['insumo'][$i]);
                $etapaConstructiva->setProyecto($proyecto);

                $entityManager->persist($etapaConstructiva);
                
                if ($datos['EtapaConstructiva']['Residuo'][$i + 1] != null){

                    for ($j = 0; $j < count($datos['EtapaConstructiva']['Residuo'][$i + 1]); $j++){
                        // $subTipoResiduo = $entityManager->getRepository(SubTipoResiduo::class)->findOneBy(["nombre" => $datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['tipo']]);
                        // if ($subTipoResiduo == null){
                        //     $subTipoResiduo = new SubTipoResiduo();
                        // }
                        // $subTipoResiduo -> setNombre($datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['tipo']);
                        // $entityManager->persist($subTipoResiduo);

                        $tipoResiduo = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo" => $datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['tipo']]);
                        if ($tipoResiduo == null){
                            $tipoResiduo = new TipoResiduo();
                        }
                        $tipoResiduo -> setTipo($datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['tipo']);
                        // $tipoResiduo -> setSubTipoResiduo($subTipoResiduo);
                        $entityManager->persist($tipoResiduo);

                        $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["tipoResiduo" => $tipoResiduo, "etapaConstructiva" => $etapaConstructiva]);
                        if ($residuo == null){
                            $residuo = new Residuo();
                        }
                        $residuo -> setTipoResiduo($tipoResiduo);
                        $residuo -> setCategoria($datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['residuo']);
                        $residuo -> setTipo($datos['EtapaConstructiva']['Residuo'][$i + 1][$j]['tipo']);
                        $residuo -> setEtapaConstructiva($etapaConstructiva);
                        $entityManager->persist($residuo);

                    }

                }
                
                if ($datos['EtapaConstructiva']['Efluente'][$i + 1] != null){
                    for ($j = 0; $j < count($datos['EtapaConstructiva']['Efluente'][$i + 1]); $j++){

                        $tipoEfluente = $entityManager->getRepository(TipoEfluente::class)->findOneBy(["tipo" => $datos['EtapaConstructiva']['Efluente'][$i + 1][$j]['efluente']]);
                        if ($tipoEfluente == null){
                            $tipoEfluente = new TipoEfluente();
                        }
                        $tipoEfluente -> setTipo($datos['EtapaConstructiva']['Efluente'][$i + 1][$j]['efluente']);
                        $entityManager->persist($tipoEfluente);
                        $efluente = $entityManager->getRepository(Efluente::class)->findOneBy(["tipoEfluente" => $tipoEfluente, "etapaConstructiva" => $etapaConstructiva]);
                        if ($efluente == null){
                            $efluente = new Efluente();
                        }
                        $efluente -> setTipoEfluente($tipoEfluente);
                        $efluente -> setEtapaConstructiva($etapaConstructiva);
                        $entityManager -> persist($efluente);
                    }

                }

                if ($datos['EtapaConstructiva']['Emision'][$i + 1] != null){
                    for ($j = 0; $j < count($datos['EtapaConstructiva']['Emision'][$i + 1]); $j++){

                        $tipoEmision = $entityManager->getRepository(TipoEmision::class)->findOneBy(["tipo" => $datos['EtapaConstructiva']['Emision'][$i + 1][$j]['tipo']]);
                        if ($tipoEmision == null){
                            $tipoEmision = new TipoEmision();
                        }
                        $tipoEmision -> setTipo($datos['EtapaConstructiva']['Emision'][$i + 1][$j]['tipo']);
                        
                        $entityManager->persist($tipoEmision);

                        $emision = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["tipoEmision" => $tipoEmision, "etapaConstructiva" => $etapaConstructiva]);
                        if ($emision == null){
                            $emision = new EmisionGaseosa();
                        }
                        $emision -> setTipoEmision($tipoEmision);
                        $emision -> setCategoria($datos['EtapaConstructiva']['Emision'][$i + 1][$j]['emision']);
                        $emision -> setEtapaConstructiva($etapaConstructiva);
                        $entityManager->persist($emision);
                    }
                }
            }
            
        }
        
        if ($datos['EtapaOperativa'] != null){

            for ($i = 0; $i < count($datos['EtapaOperativa']['proceso']); $i++){

                $etapaOperativa = $entityManager->getRepository(EtapaOperativa::class)->findOneBy(["proyecto" => $proyecto, "proceso" => $datos['EtapaOperativa']['proceso'][$i]]);
                if ($etapaOperativa == null){
                    $etapaOperativa = new EtapaOperativa();
                }

                $etapaOperativa->setTarea($datos['EtapaOperativa']['tarea']);
                $etapaOperativa->setProceso($datos['EtapaOperativa']['proceso'][$i]);
                $etapaOperativa->setDescripcion($datos['EtapaOperativa']['descripcion'][$i]);
                $etapaOperativa->setMateriaPrima($datos['EtapaOperativa']['materia'][$i]);
                $etapaOperativa->setProducto($datos['EtapaOperativa']['producto'][$i]);
                $etapaOperativa->setProyecto($proyecto);
                $entityManager->persist($etapaOperativa);

                if ($datos['EtapaOperativa']['Residuo'][$i + 1] != null){

                    for ($j = 0; $j < count($datos['EtapaOperativa']['Residuo'][$i + 1]); $j++){

                        // $subTipoResiduo = $entityManager->getRepository(SubTipoResiduo::class)->findOneBy(["nombre" => $datos['EtapaOperativa']['Residuo'][$i + 1][$j]['tipo']]);
                        // if ($subTipoResiduo == null){
                        //     $subTipoResiduo = new SubTipoResiduo();
                        // }
                        // $subTipoResiduo -> setNombre($datos['EtapaOperativa']['Residuo'][$i + 1][$j]['tipo']);
                        // $entityManager->persist($subTipoResiduo);
                        $tipoResiduo = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo" => $datos['EtapaOperativa']['Residuo'][$i + 1][$j]['tipo']]);
                        if ($tipoResiduo == null){
                            $tipoResiduo = new TipoResiduo();
                        }
                        $tipoResiduo -> setTipo($datos['EtapaOperativa']['Residuo'][$i + 1][$j]['tipo']);
                        // $tipoResiduo -> setSubTipoResiduo($subTipoResiduo);
                        $entityManager->persist($tipoResiduo);

                        $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["tipoResiduo" => $tipoResiduo, "etapaOperativa" => $etapaOperativa]);
                        if ($residuo == null){
                            $residuo = new Residuo();
                        }
                        $residuo -> setTipoResiduo($tipoResiduo);
                        $residuo -> setCategoria($datos['EtapaOperativa']['Residuo'][$i + 1][$j]['residuo']);
                        $residuo -> setTipo($datos['EtapaOperativa']['Residuo'][$i + 1][$j]['tipo']);
                        $residuo -> setEtapaOperativa($etapaOperativa);
                        $entityManager->persist($residuo);

                    }

                }

                if ($datos['EtapaOperativa']['Efluente'][$i + 1] != null){
                    for ($j = 0; $j < count($datos['EtapaOperativa']['Efluente'][$i + 1]); $j++){

                        $tipoEfluente = $entityManager->getRepository(TipoEfluente::class)->findOneBy(["tipo" => $datos['EtapaOperativa']['Efluente'][$i + 1][$j]['efluente']]);
                        if ($tipoEfluente == null){
                            $tipoEfluente = new TipoEfluente();
                        }
                        $tipoEfluente -> setTipo($datos['EtapaOperativa']['Efluente'][$i + 1][$j]['efluente']);
                        $entityManager->persist($tipoEfluente);
                        $efluente = $entityManager->getRepository(Efluente::class)->findOneBy(["tipoEfluente" => $tipoEfluente, "etapaOperativa" => $etapaOperativa]);
                        if ($efluente == null){
                            $efluente = new Efluente();
                        }
                        $efluente -> setTipoEfluente($tipoEfluente);
                        $efluente -> setEtapaOperativa($etapaOperativa);
                        $entityManager -> persist($efluente);

                    }

                }

                if ($datos['EtapaOperativa']['Emision'][$i + 1] != null){
                    for ($j = 0; $j < count($datos['EtapaOperativa']['Emision'][$i + 1]); $j++){

                        $tipoEmision = $entityManager->getRepository(TipoEmision::class)->findOneBy(["tipo" => $datos['EtapaOperativa']['Emision'][$i + 1][$j]['tipo']]);
                        if ($tipoEmision == null){
                            $tipoEmision = new TipoEmision();
                        }
                        $tipoEmision -> setTipo($datos['EtapaOperativa']['Emision'][$i + 1][$j]['tipo']);
                        
                        $entityManager->persist($tipoEmision);

                        $emision = $entityManager->getRepository(EmisionGaseosa::class)->findOneBy(["tipoEmision" => $tipoEmision, "etapaOperativa" => $etapaOperativa]);
                        if ($emision == null){
                            $emision = new EmisionGaseosa();
                        }
                        $emision -> setTipoEmision($tipoEmision);
                        $emision -> setCategoria($datos['EtapaOperativa']['Emision'][$i + 1][$j]['emision']);
                        $emision -> setEtapaOperativa($etapaOperativa);
                        $entityManager->persist($emision);
                    }
                }
            }
        }
        $entityManager->flush();
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        $filtro['Impactos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta" => $planta]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "5.1"]);

        return $this->render('impactoAmbiental/formularioEIAA5.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA5", name="tramiteEIAA5", methods={"POST"})
     */
    public function tramiteEIA5A(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        $datos['Impacto'] = $request->get('Impacto');
        $datos['TipoImpacto'] = $request->get('TipoImpacto');
        
        if ($datos['Impacto'] != null){
            $impacto = $entityManager->getRepository(Impacto::class)->findOneBy(["planta" => $planta]);

            if ($impacto == null){
                $impacto = new Impacto();
            }
            $impacto->setDescripcion($datos['Impacto']['descripcion']);
            $impacto->setPlanta($planta);
            $entityManager->persist($impacto);
        }

        if ($datos['TipoImpacto'] != null){

            for($i = 0; $i < count($datos['TipoImpacto']['tipo']); $i++){
                $impacto = $entityManager->getRepository(Impacto::class)->findOneBy(["planta" => $planta]);

                if ($impacto == null){
                    $impacto = new Impacto();
                }
                $impacto->setDescripcion($datos['TipoImpacto']['tipo'][$i]);
                $impacto->setPlanta($planta);
                $entityManager->persist($impacto);
                
            }
        }
        $entityManager->flush();
        
        $filtro['EfluentesLiquidos'] = $entityManager->getRepository(Efluente::class)->findBy(["planta" => $planta]);
        $filtro['ResiduosPeligrosos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta" => $planta, "tipo" => 2]);
        $filtro['ResiduosNoPeligrosos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta" => $planta, "tipo" => 3]);
        $filtro['ResiduosSolidos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta" => $planta, "tipo" => 4]);
        $filtro['ResiduosPatologicos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta" => $planta, "tipo" => 5]);
        $filtro['ResiduosOtros'] = $entityManager->getRepository(Residuo::class)->findBy(["planta" => $planta, "tipo" => 6]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "6.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "6.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "6.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "6.4"]);
        $filtro['Storage5'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "6.5"]);

        return $this->render('impactoAmbiental/formularioEIAA6-1.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA61", name="tramiteEIAA61", methods={"POST"})
     */
    public function tramiteEIA61(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['ResiduosPeligrosos'] = $request->get('ResiduosPeligrosos');
        $datos['ResiduosNoPeligrosos'] = $request->get('ResiduosNoPeligrosos');
        $datos['ResiduosSolidos'] = $request->get('ResiduosSolidos');
        $datos['ResiduosPatologicos'] = $request->get('ResiduosPatologicos');
        $datos['ResiduosOtros'] = $request->get('ResiduosOtros');
        $datos['EfluentesLiquidos'] = $request->get('EfluentesLiquidos');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        if ($datos['ResiduosPeligrosos']['existen'] == "SI"){

            for($i = 0; $i< count($datos['ResiduosPeligrosos']['item']); $i++){
                $residuoPeligroso = $entityManager->getRepository(Residuo::class)->findOneBy(["procesoGenerador" => $datos['ResiduosPeligrosos']['proceso'][$i], "periodoTiempo" => $datos['ResiduosPeligrosos']['tiempo'][$i], "estadoFisico" => $datos['ResiduosPeligrosos']['estado'][$i]]);
                if ( $residuoPeligroso == null ){
                    $residuoPeligroso = new Residuo();
                }
                $residuoPeligroso -> setNroGenerador($datos['ResiduosPeligrosos']['nrogenerador']);
                $residuoPeligroso -> setTipo(2);
                $residuoPeligroso -> setCategoria($datos['ResiduosPeligrosos']['item'][$i]);
                $residuoPeligroso -> setProcesoGenerador($datos['ResiduosPeligrosos']['proceso'][$i]);
                $residuoPeligroso -> setEstadoFisico($datos['ResiduosPeligrosos']['estado'][$i]);
                $residuoPeligroso -> setPeriodoTiempo($datos['ResiduosPeligrosos']['tiempo'][$i]);
                $residuoPeligroso -> setGestion($datos['ResiduosPeligrosos']['tratamiento'][$i]);
                $residuoPeligroso -> setReceptor($datos['ResiduosPeligrosos']['receptor']);
                $residuoPeligroso -> setPlanta($planta);

                $categoriaResiduoPeligroso = $entityManager->getRepository(CategoriaResiduoPeligroso::class)->findOneBy(["categoria" => $datos['ResiduosPeligrosos']['categoriaY'][$i],"nombre" => $datos['ResiduosPeligrosos']['categoriaH'][$i]]);
                if ($categoriaResiduoPeligroso == null){
                    $categoriaResiduoPeligroso = new CategoriaResiduoPeligroso();
                }
                $categoriaResiduoPeligroso -> setCategoria($datos['ResiduosPeligrosos']['categoriaY'][$i]);
                $categoriaResiduoPeligroso -> setNombre($datos['ResiduosPeligrosos']['categoriaH'][$i]);

                $residuoPeligroso -> setCategoriaResiduoPeligroso($categoriaResiduoPeligroso);

                $entityManager -> persist( $categoriaResiduoPeligroso );
                $entityManager -> persist( $residuoPeligroso );
            }

        }
        if ($datos['ResiduosNoPeligrosos']['existen']){
            for($i = 0; $i< count($datos['ResiduosNoPeligrosos']['item']); $i++){
                $residuoPeligroso = $entityManager->getRepository(Residuo::class)->findOneBy(["procesoGenerador" => $datos['ResiduosNoPeligrosos']['proceso'][$i], "periodoTiempo" => $datos['ResiduosNoPeligrosos']['tiempo'][$i], "estadoFisico" => $datos['ResiduosNoPeligrosos']['estado'][$i]]);
                if ( $residuoPeligroso == null ){
                    $residuoPeligroso = new Residuo();
                }
                $residuoPeligroso -> setTipo(3);
                $residuoPeligroso -> setCategoria($datos['ResiduosNoPeligrosos']['item'][$i]);
                $residuoPeligroso -> setProcesoGenerador($datos['ResiduosNoPeligrosos']['proceso'][$i]);
                $residuoPeligroso -> setComponenteRelevante($datos['ResiduosNoPeligrosos']['componentes'][$i]);
                $residuoPeligroso -> setEstadoFisico($datos['ResiduosNoPeligrosos']['estado'][$i]);
                $residuoPeligroso -> setPeriodoTiempo($datos['ResiduosNoPeligrosos']['tiempo'][$i]);
                $residuoPeligroso -> setGestion($datos['ResiduosNoPeligrosos']['tratamiento'][$i]);
                $residuoPeligroso -> setReceptor($datos['ResiduosNoPeligrosos']['receptor']);
                $residuoPeligroso -> setPlanta($planta);

                $entityManager -> persist( $residuoPeligroso );
            }
        }
        if ($datos['ResiduosSolidos'] != null){
            
            for($i = 0; $i< count($datos['ResiduosSolidos']['item']); $i++){
                $residuoPeligroso = $entityManager->getRepository(Residuo::class)->findOneBy(["categoria" => $datos['ResiduosSolidos']['item'][$i], "estadoFisico" => $datos['ResiduosSolidos']['estado'][$i]]);
                if ( $residuoPeligroso == null ){
                    $residuoPeligroso = new Residuo();
                }
                $residuoPeligroso -> setTipo(4);
                $residuoPeligroso -> setCategoria($datos['ResiduosSolidos']['item'][$i]);
                $residuoPeligroso -> setComponenteRelevante($datos['ResiduosSolidos']['categoria'][$i]);
                $residuoPeligroso -> setEstadoFisico($datos['ResiduosSolidos']['estado'][$i]);
                $residuoPeligroso -> setPeriodoTiempo($datos['ResiduosSolidos']['cantidad'][$i]);
                $residuoPeligroso -> setGestion($datos['ResiduosSolidos']['tratamiento'][$i]);
                $residuoPeligroso -> setReceptor($datos['ResiduosSolidos']['receptor']);
                $residuoPeligroso -> setPlanta($planta);

                $entityManager -> persist( $residuoPeligroso );
            }
        }
        if ($datos['ResiduosPatologicos']['existen'] == "SI"){

            for($i = 0; $i< count($datos['ResiduosPatologicos']['item']); $i++){
                $residuoPatologico = $entityManager->getRepository(Residuo::class)->findOneBy(["categoria" => $datos['ResiduosPatologicos']['item'][$i], "procesoGenerador" => $datos['ResiduosPatologicos']['proceso'][$i]]);
                if ( $residuoPatologico == null ){
                    $residuoPatologico = new Residuo();
                }
                $residuoPatologico -> setTipo(5);
                $residuoPatologico -> setNroGenerador($datos['ResiduosPatologicos']['nroGenerador']);
                $residuoPatologico -> setCategoria($datos['ResiduosPatologicos']['item'][$i]);
                $residuoPatologico -> setProcesoGenerador($datos['ResiduosPatologicos']['proceso'][$i]);
                $residuoPatologico -> setPeriodoTiempo($datos['ResiduosPatologicos']['tiempo'][$i]);
                $residuoPatologico -> setGestion($datos['ResiduosPatologicos']['tratamiento'][$i]);
                $residuoPatologico -> setReceptor($datos['ResiduosPatologicos']['receptor']);
                $residuoPatologico -> setPlanta($planta);

                $entityManager -> persist( $residuoPatologico );
            }
        }

        if ($datos['ResiduosOtros']['existen'] == "SI"){
            for($i = 0; $i< count($datos['ResiduosOtros']['item']); $i++){
                $otroResiduo = $entityManager->getRepository(Residuo::class)->findOneBy(["categoria" => $datos['ResiduosOtros']['item'][$i], "estadoFisico" => $datos['ResiduosOtros']['estado'][$i]]);
                if ( $otroResiduo == null ){
                    $otroResiduo = new Residuo();
                }
                $otroResiduo -> setTipo(6);
                $otroResiduo -> setCategoria($datos['ResiduosOtros']['item'][$i]);
                $otroResiduo -> setEstadoFisico($datos['ResiduosOtros']['estado'][$i]);
                $otroResiduo -> setComponenteRelevante($datos['ResiduosOtros']['componentes'][$i]);
                $otroResiduo -> setProcesoGenerador($datos['ResiduosOtros']['proceso'][$i]);
                $otroResiduo -> setPeriodoTiempo($datos['ResiduosOtros']['tiempo'][$i]);
                $otroResiduo -> setGestion($datos['ResiduosOtros']['tratamiento'][$i]);
                $otroResiduo -> setPlanta($planta);

                $entityManager -> persist( $otroResiduo );
            }
        }

        if ($datos['EfluentesLiquidos']['existen'] == "SI"){

            for($i = 0; $i< count($datos['EfluentesLiquidos']['nombre']); $i++){

                $efluente = $entityManager->getRepository( Efluente::class )->findOneBy(["planta" => $planta, "categoria" => $datos['EfluentesLiquidos']['nombre'][$i]]);
                if ($efluente == null){
                    $efluente = new Efluente();
                }
                $efluente -> setCategoria($datos['EfluentesLiquidos']['nombre'][$i]);
                $efluente -> setDescarga($datos['EfluentesLiquidos']['descarga'][$i]);
                $efluente -> setCaudal($datos['EfluentesLiquidos']['caudal'][$i]);
                $efluente -> setProcesoGenerador ($datos['EfluentesLiquidos']['proceso'][$i]);
                $efluente -> setComponenteRelevante ($datos['EfluentesLiquidos']['relevante'][$i]);
                $efluente -> setTratamiento ($datos['EfluentesLiquidos']['tratamiento'][$i]);
                $efluente -> setReceptor ($datos['EfluentesLiquidos']['receptor'][$i]);
                $efluente -> setPlanta( $planta );
                $entityManager -> persist ($efluente);

            }
        }

        $entityManager->flush();
        $filtro['Emisiones'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=> $planta, "tipo" => "Fuente puntual"]);
        $filtro['EmisionesDifusas'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=> $planta, "tipo" => "Emisión difusa"]);
        $filtro['Impactos'] = $entityManager->getRepository(Impacto::class)->findBy(["planta" => $planta]);
        $filtro['Medidas'] = $entityManager->getRepository(MedidaEficiencia::class)->findBy(["planta" => $planta]);
        return $this->render('impactoAmbiental/formularioEIAA6-2.html.twig',$filtro); 
    }
    
    /**
     * @Route("/tramiteEIAA62", name="tramiteEIAA62", methods={"POST"})
     */
    public function tramiteEIA62(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Emisiones'] = $request->get('Emisiones');
        $datos['EmisionesDifusas'] = $request->get('EmisionesDifusas');
        $datos['Impactos'] = $request->get('Impactos');
        $datos['Medidas'] = $request->get('Medidas');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
        
        if ($datos['Emisiones']['existen'] == "SI"){
            
            for($i = 0; $i< count($datos['Emisiones']['item']); $i++){
                $tipoEmision = $entityManager->getRepository( TipoEmision::class )->findOneBy(["tipo" => "Fuente puntual"]);
                if ($tipoEmision == null){
                    $tipoEmision = new TipoEmision();
                }
                $tipoEmision -> setTipo("Fuente puntual");

                $emision = $entityManager->getRepository( EmisionGaseosa::class )->findOneBy(["planta" => $planta, "nombre" => $datos['Emisiones']['item'][$i], "tipoEmision" => $tipoEmision]);
                if ($emision == null){
                    $emision = new EmisionGaseosa();
                }
                $emision -> setTipo("Fuente puntual");
                $emision -> setNombre($datos['Emisiones']['item'][$i]);
                $emision -> setFuncionamiento($datos['Emisiones']['funcionamiento'][$i]);
                $emision -> setCaudal($datos['Emisiones']['caudal'][$i]);
                $emision -> setProcesoGenerador ($datos['Emisiones']['proceso'][$i]);
                $emision -> setContaminante ($datos['Emisiones']['contaminante'][$i]);
                $emision -> setChimenea ($datos['Emisiones']['chimenea'][$i]);
                $emision -> setTratamiento ($datos['Emisiones']['tratamiento'][$i]);
                $emision -> setTipoEmision ($tipoEmision);
                $emision -> setPlanta( $planta );
                $entityManager -> persist ($emision);
                $entityManager -> persist ($tipoEmision);

            }
        }

        if ($datos['EmisionesDifusas']['existen'] == "SI"){
            
            for($i = 0; $i< count($datos['EmisionesDifusas']['item']); $i++){

                $tipoEmision = $entityManager->getRepository( TipoEmision::class )->findOneBy(["tipo" => "Emisión difusa"]);
                if ($tipoEmision == null){
                    $tipoEmision = new TipoEmision();
                }
                $tipoEmision -> setTipo("Emisión difusa");

                $emision = $entityManager->getRepository( EmisionGaseosa::class )->findOneBy(["planta" => $planta, "nombre" => $datos['EmisionesDifusas']['item'][$i], "tipoEmision" => $tipoEmision]);
                if ($emision == null){
                    $emision = new EmisionGaseosa();
                }
                $emision -> setTipo("Emisión difusa");
                $emision -> setNombre($datos['EmisionesDifusas']['item'][$i]);
                $emision -> setSitio($datos['EmisionesDifusas']['sitio'][$i]);
                $emision -> setProcesoGenerador ($datos['EmisionesDifusas']['proceso'][$i]);
                $emision -> setContaminante ($datos['EmisionesDifusas']['contaminante'][$i]);
                $emision -> setTratamiento ($datos['EmisionesDifusas']['tratamiento'][$i]);
                $emision -> setTipoEmision ($tipoEmision);
                $emision -> setPlanta( $planta );
                $entityManager -> persist ($emision);
                $entityManager -> persist ($tipoEmision);

            }
        }
        
        for($i = 0; $i< count($datos['Impactos']['muestreo']); $i++){

            $impacto  = $entityManager->getRepository( Impacto::class )->findOneBy(["id" => $datos['Impactos']['id'][$i]]);

            if ( $impacto != null){
                $impacto -> setDescripcion( $datos['Impactos']['descripcion'][$i] );
                $impacto -> setMedidaImplementacion( $datos['Impactos']['medida'][$i] );
                $impacto -> setPlazo( $datos['Impactos']['plazo'][$i] );
                $impacto -> setParametroMonitoreo( $datos['Impactos']['parametro'][$i] );
                $impacto -> setFrecuencia( $datos['Impactos']['frecuencia'][$i] );
                $impacto -> setPuntoMuestreo( $datos['Impactos']['muestreo'][$i] );
                $impacto -> setNormativaReferencia( $datos['Impactos']['referencia'][$i] );
                $impacto -> setPlanta( $planta );
                $entityManager -> persist ( $impacto );
            }

        }

        if ($datos['Medidas'] != null){
            for($i = 0; $i < count($datos['Medidas']['medida']); $i++){
                $medida = $entityManager -> getRepository( MedidaEficiencia::class)->findOneBy(["planta" => $planta, "medida" => $datos['Medidas']['medida'][$i]]);

                if ($medida == null){
                    $medida = new MedidaEficiencia();
                }

                $medida -> setMedida( $datos['Medidas']['medida'][$i]);
                $medida -> setPlanta( $planta );
                $entityManager -> persist ($medida);
            }
        }

        $entityManager->flush();

        $filtro['Riesgo'] = $entityManager->getRepository(Riesgo::class)->findOneBy(["planta"=> $planta]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.3"]);
        return $this->render('impactoAmbiental/formularioEIAA7.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA7", name="tramiteEIAA7", methods={"POST"})
     */
    public function tramiteEIA7(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        $datos['Riesgo'] = $request->get('Riesgo');

        if ($datos['Riesgo'] != null){
            $riesgo = $entityManager->getRepository(Riesgo::class)->findOneBy(["planta"=> $planta]);
            if ($riesgo == null){
                $riesgo = new Riesgo();
            }
            $riesgo -> setCategorizacion($datos['Riesgo']['categorizacion']);
            $riesgo -> setPlanContingencia($datos['Riesgo']['contingencia']);
            $riesgo -> setPlanta($planta);
            $entityManager -> persist( $riesgo );
        }
        $entityManager->flush();
        
        $filtro['Marcos'] = $entityManager->getRepository(MarcoLegal::class)->findBy(["empresa"=> $tramite->getEmpresa()]);
        return $this->render('impactoAmbiental/formularioEIAA8.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA8", name="tramiteEIAA8", methods={"POST"})
     */
    public function tramiteEIA8(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Marco'] = $request->get('Marco');
        $empresa = $tramite->getEmpresa();
        
        if($datos['Marco'] != null){
            for($i = 0; $i< count($datos['Marco']['tipo']); $i++){
                $marco = $entityManager->getRepository(MarcoLegal::class)->findOneBy(["empresa"=> $empresa, "tipoNorma" => $datos['Marco']['tipo'][$i]]);
                if ($marco == null){
                    $marco = new MarcoLegal();
                }
                $marco -> setTipoNorma($datos['Marco']['tipo'][$i]);
                $marco -> setTema($datos['Marco']['tema'][$i]);
                $marco -> setAplicacionEspecifica($datos['Marco']['aplicacion'][$i]);
                $marco -> setEmpresa( $empresa );
                $entityManager -> persist( $marco );
            }
        }
        $entityManager->flush();
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);

        $filtro['EmpresaActividad'] = $entityManager->getRepository(EmpresaHasActividad::class)->findBy(["empresa"=> $empresa]);
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
        if ($empresaHasActividad != null){
            $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
        }
        $filtro['Sustancias'] = $entityManager->getRepository(SustanciaRiesgosa::class)->findBy(["planta"=> $planta]);
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.1"]);
        $filtro['Storage2'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.2"]);
        $filtro['Storage3'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.3"]);
        $filtro['Storage4'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9.4"]);
        return $this->render('impactoAmbiental/formularioEIAA9.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA9", name="tramiteEIAA9", methods={"POST"})
     */
    public function tramiteEIA9(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $datos['Sustancia'] = $request->get('Sustancia');
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=> $tramite->getEmpresa()]);
        $empresa = $tramite->getEmpresa();
        $datos['ActividadEmpresa'] = $request->get('actividadEmpresa');
        
        if ($datos['Sustancia']['existen'] == 'SI'){

            for($i = 0; $i < count($datos['Sustancia']['nombre']); $i++){

                $sustancia = $entityManager->getRepository(SustanciaRiesgosa::class)->findOneBy(["planta"=> $planta, "nombre" => $datos['Sustancia']['nombre'][$i]]);
                if ( $sustancia == null ){
                    $sustancia = new SustanciaRiesgosa();
                }
                $sustancia -> setNombre( $datos['Sustancia']['nombre'][$i] );
                $sustancia -> setCantidad( $datos['Sustancia']['cantidad'][$i] );
                $sustancia -> setPlanta( $planta );
                $entityManager -> persist( $sustancia );
            }
        }
        if($datos['ActividadEmpresa'] !=null){
            for($i=0;$i<count($datos['ActividadEmpresa']);$i++){
                $actividad = $entityManager->getRepository(Actividad::class)->findOneBy(["id" => $datos['ActividadEmpresa'][$i]]);
                $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=> $empresa, "actividad" => $request->get('actividadEmpresa')[$i]]);
                if ($empresaHasActividad == null){
                    $empresaHasActividad = new EmpresaHasActividad();
                }
                $empresaHasActividad->setActividad($actividad);
                $empresaHasActividad->setTipo($request->get('prse')[$i]);
                $empresaHasActividad->setEmpresa($empresa);
            }            
            $entityManager->persist($empresaHasActividad);
        }
        $entityManager->flush();
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "10.1"]);

        return $this->render('impactoAmbiental/formularioEIAA10.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA10", name="tramiteEIAA10", methods={"POST"})
     */
    public function tramiteEIA10(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "11.1"]);

        return $this->render('impactoAmbiental/formularioEIAA11.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA11", name="tramiteEIAA11", methods={"POST"})
     */
    public function tramiteEIA11(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "12.1"]);

        return $this->render('impactoAmbiental/formularioEIAA12.html.twig',$filtro); 
    }

    /**
     * @Route("/tramiteEIAA12", name="tramiteEIAA12", methods={"POST"})
     */
    public function tramiteEIA12(Request $request)
    {
        $filtro = $this->getFiltro($request);
        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        
        // $entityManager->flush();
        

        return $this->redirectToRoute('misTramites');
    }
}




