<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Loteo;
use AppBundle\Entity\Urbanizacion;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\ObjetoSubdivision;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Formulario;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\DimensionamientoLoteo;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Representante;
use AppBundle\Entity\EmpresaHasRepresentante;
use AppBundle\Entity\PartidaInmobiliaria;
use AppBundle\Entity\Planta;
use AppBundle\Entity\DestinoSuelo;
use AppBundle\Entity\ResumenEjecutivo;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Tanque;
use AppBundle\Entity\SustanciaTanque;
use AppBundle\Entity\CaracterizacionEntorno;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\Agua;
use AppBundle\Entity\Suelo;
use AppBundle\Entity\OtroRecurso;
use AppBundle\Entity\ElectricaAdquirida;
use AppBundle\Entity\ElectricaPropia;
use AppBundle\Entity\Gas;
use AppBundle\Entity\OtraEnergia;
use AppBundle\Service\StorageService;
use AppBundle\Entity\TipoImpacto;
use AppBundle\Entity\Impacto;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\TipoResiduo;
use AppBundle\Entity\ListadoTipoResiduo;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\TipoEfluente;
use AppBundle\Entity\EmisionGaseosa;
use AppBundle\Entity\TipoEmision;
use AppBundle\Entity\Plano;
use AppBundle\Entity\TipoAgua; 
use AppBundle\Entity\Proceso; 
use AppBundle\Entity\TratamientoPlantaExterior; 
use AppBundle\Entity\SitioContaminado; 
use AppBundle\Entity\MarcoLegal; 
use AppBundle\Entity\ListaTramites; 
use \DateTime;


class InformeAmbientalController extends BaseController
{
     /**
     * @Route("/formularioIndustriasPresentacion", name="formularioIndustriasPresentacion", methods={"GET"})
     */
    public function formularioIndustrias(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if($request->get("idTramite")!=0){

            $tramite = $this->getTramite($request->get("idTramite"));
            $persona = $tramite->getEmpresa()->getPersona();
            $empresa = $tramite -> getEmpresa();
            $resumenEjecutivo = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>2]);
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            $plano = $entityManager->getRepository(Plano::class)->findOneBy(['planta'=> $planta]);
            $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['planta' => $planta]);


            if($empresa != null && $domicilioLegal != null && $domicilioReal != null && $resumenEjecutivo != null && $planta != null && $partidaInmobiliaria != null) {

                $filtro['Persona'] = $empresa->getPersona();
                $filtro['DomicilioLegal'] = $domicilioLegal;
                $filtro['DomicilioReal'] = $domicilioReal;
                $filtro['Plano'] = $plano;
                $filtro['ResumenEjecutivo'] = $resumenEjecutivo;
                $filtro['PartidaInmobiliaria'] = $partidaInmobiliaria;
                $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "1.1"]);
                
            }

        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(4);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $tramite->setEstado($estado);
            $tramite->setFechaCreacion(new DateTime());
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
            
            $tramite->setPerito($perito);
            $entityManager->persist($tramite);
            $entityManager->flush();
        }
        
        $filtro['idTramite'] = $tramite->getId();  
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo']= $tramite->getNombre();
        return $this->render('informeAmbiental/formularioIAC1.html.twig', $filtro); 
    }
    
    /**
     * @Route("/formularioExpendioCombustiblePresentacion", name="formularioExpendioCombustiblePresentacion", methods={"GET"})
     */
    public function formularioExpendioCombustiblePresentacion(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if($request->get("idTramite")!=0){

            $tramite = $this->getTramite($request->get("idTramite"));
            $persona = $tramite->getEmpresa()->getPersona();
            $empresa = $tramite -> getEmpresa();
            $resumenEjecutivo = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
            $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>2]);
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            $plano = $entityManager->getRepository(Plano::class)->findOneBy(['planta'=> $planta]);
            $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['planta' => $planta]);


            if($empresa != null && $domicilioLegal != null && $domicilioReal != null && $resumenEjecutivo != null && $planta != null && $partidaInmobiliaria != null) {

                $filtro['Persona'] = $empresa->getPersona();
                $filtro['DomicilioLegal'] = $domicilioLegal;
                $filtro['DomicilioReal'] = $domicilioReal;
                $filtro['Plano'] = $plano;
                $filtro['ResumenEjecutivo'] = $resumenEjecutivo;
                $filtro['PartidaInmobiliaria'] = $partidaInmobiliaria;
                $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "1.1"]);
                
            }

        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(11);
            $tramite = new Tramite();
            $tramite->setNombre($listaTramite->getDescripcion());
            $tramite->setEstado($estado);
            $tramite->setFechaCreacion(new DateTime());
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
            
            $tramite->setPerito($perito);
            $entityManager->persist($tramite);
            $entityManager->flush();
        }
        
        $filtro['idTramite'] = $tramite->getId();  
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['titulo']= $tramite->getNombre();
        return $this->render('informeAmbiental/formularioIAC1.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteIAC3", name="tramiteIAC3", methods={"POST"})
     */
    public function formularioIAC3( Request $request)
    {
        $filtro = $this->getFiltro($request);    
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);

        $datos['Persona'] = $request->get('Persona');
        $datos['ResumenEjecutivo'] = $request->get('ResumenEjecutivo');
        $datos['DomicilioLegal'] = $request->get('DomicilioLegal');
        $datos['DomicilioReal'] = $request->get('DomicilioReal');
        $datos['Plano'] = $request->get('Plano');
        $datos['PartidaInmobiliaria'] = $request->get('PartidaInmobiliaria');

        $provinciaLegal = $entityManager->getRepository(Provincia::class)->find($datos['DomicilioLegal']["provincia"]);
        $localidadLegal = $entityManager->getRepository(Localidad::class)->find($datos['DomicilioLegal']["localidad"]);
        $departamentoLegal = $entityManager->getRepository(Departamento::class)->find($datos['DomicilioLegal']["departamento"]);
        $provinciaReal = $entityManager->getRepository(Provincia::class)->find($datos['DomicilioReal']["provincia"]);
        $localidadReal = $entityManager->getRepository(Localidad::class)->find($datos['DomicilioReal']["localidad"]);
        $departamentoReal = $entityManager->getRepository(Departamento::class)->find($datos['DomicilioReal']["departamento"]);

        if($datos['Persona'] != null){
            $cuit = trim($datos['Persona']["cuit"]);
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $cuit]);
            if($persona== null){
                $persona = new Persona();            
            }    
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
            $persona->setCuit($cuit);
            $entityManager->persist($persona);

            $empresa = $tramite -> getEmpresa();
            if($empresa == null){
                $empresa = new Empresa();
            }
            $empresa->setFechaInicioActividad(new \DateTime(date('y-m-d') ));
            $empresa->setTipoPersona(0);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);
            $tramite->setEmpresa($empresa);
            $entityManager->persist($empresa);

            if($datos['ResumenEjecutivo'] != null){
                $resumenEjecutivo = $entityManager->getRepository(ResumenEjecutivo::class)->findOneBy(["empresa" => $empresa]);
                if($resumenEjecutivo == null){
                    $resumenEjecutivo = new ResumenEjecutivo();
                }
                $resumenEjecutivo->setNroExpediente($datos['ResumenEjecutivo']['numero']);
                $resumenEjecutivo->setDescripcion($datos['ResumenEjecutivo']['descripcion']);
                $resumenEjecutivo->setEmpresa($empresa);
                $entityManager->persist($resumenEjecutivo);

                if($datos['DomicilioLegal'] != null){
                    $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>1]);
                    if($domicilioLegal == null){
                        $domicilioLegal = new Domicilio();            
                    }  
                    $domicilioLegal->setCalle($datos['DomicilioLegal']["calle"]);
                    $domicilioLegal->setNumero($datos['DomicilioLegal']["numero"]);
                    $domicilioLegal->setPiso($datos['DomicilioLegal']["piso"]);
                    $domicilioLegal->setDepto($datos['DomicilioLegal']["depto"]);
                    $domicilioLegal->setTelefono($datos['DomicilioLegal']["telefono"]);
                    $domicilioLegal->setEmail($datos['DomicilioLegal']["email"]);
                    $domicilioLegal->setEmpresa($empresa);
                    
                    $domicilioLegal->setProvincia($provinciaLegal);
                    $domicilioLegal->setDepartamento($departamentoLegal);
                    $domicilioLegal->setLocalidad($localidadLegal);
                    $domicilioLegal->setTipo(1);
        
                    $entityManager->persist($domicilioLegal);

                    if($datos['DomicilioReal'] != null){
                        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
                        if($domicilioReal == null){
                            $domicilioReal = new Domicilio();            
                        }  
                        $domicilioReal->setCalle($datos['DomicilioReal']["calle"]);
                        $domicilioReal->setNumero($datos['DomicilioReal']["numero"]);
                        $domicilioReal->setPiso($datos['DomicilioReal']["piso"]);
                        $domicilioReal->setDepto($datos['DomicilioReal']["depto"]);
                        $domicilioReal->setTelefono($datos['DomicilioReal']["telefono"]);
                        $domicilioReal->setEmail($datos['DomicilioReal']["email"]);
                        $domicilioReal->setEmpresa($tramite->getEmpresa());
                        
                        $domicilioReal->setProvincia($provinciaReal);
                        $domicilioReal->setDepartamento($departamentoReal);
                        $domicilioReal->setLocalidad($localidadReal);
                        $domicilioReal->setTipo(2);
            
                        $entityManager->persist($domicilioReal);

                        if($datos['Plano'] != null){

                            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
                            if($planta == null){
                                $planta = new Planta();            
                            }  
                            $planta-> setEmpresa($tramite->getEmpresa());
                            $planta-> setDomicilio($domicilioReal);
                            $entityManager->persist($planta);

                            $plano = $entityManager->getRepository(Plano::class)->findOneBy(["planta"=>$planta]);
                            if($plano == null){
                                $plano = new Plano();            
                            }  
                            $plano->setDescripcion($datos['Plano']["descripcion"]);
                            $plano->setPlanta($planta);
                            $entityManager->persist($plano);
                        
                            if($datos['PartidaInmobiliaria'] != null){

                                $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['planta' => $planta]);
                                if($partidaInmobiliaria == null){
                                    $partidaInmobiliaria = new PartidaInmobiliaria();
                                }
                                $partidaInmobiliaria->setLatitud($datos['PartidaInmobiliaria']['latitud']);
                                $partidaInmobiliaria->setLongitud($datos['PartidaInmobiliaria']['longitud']);
                                $partidaInmobiliaria->setPlanta($planta);
                                $entityManager->persist($partidaInmobiliaria);
                            }
                        }
                        
                    }
                
                }
            }
            $entityManager->flush();
        }

        $filtro['paginaInicio'] = 'formularioIndustriasPresentacion';

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $tanque = $entityManager->getRepository(Tanque::class)->findBy(["planta"=>$planta]); 
        $filtro['Tanque'] = $tanque;
        $filtro['SustanciaTanque'] = $entityManager->getRepository(SustanciaTanque::class)->findBy(["tanque"=>$tanque]); 
        $filtro['Procesos'] = $entityManager->getRepository(Proceso::class)->findBy(['planta'=>$planta, 'tipo'=> 1]);
        $filtro['ProcesoOperacion'] = $entityManager->getRepository(Proceso::class)->findOneBy(['planta'=>$planta, 'tipo'=> 2]);
        $filtro['ProcesoOtro'] = $entityManager->getRepository(Proceso::class)->findOneBy(['planta'=>$planta, 'tipo'=> 3]);
        $filtro['ProcesoAlmacenamiento'] = $entityManager->getRepository(Proceso::class)->findOneBy(['planta'=>$planta, 'tipo'=> 4]);
        
        $archivos = $entityManager->getRepository(Storage::class)->findBy(['tramite'=>$tramite]);
        foreach($archivos as $archivo){
            if(substr($archivo->getInciso(),0,3) == "3.1"){
                $filtro['ImagenesProcesos']['archivos'][] = $archivo->getNombre();
            }
        }

        for($i = 2; $i <= 5; $i++) {
            $filtro['Storage' . $i] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "3." . $i]);
        }

        return $this->render('informeAmbiental/formularioIAC3.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC4", name="tramiteIAC4", methods={"POST"})
     */
    public function tramiteIAC4( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);

        $datos['Tanque'] = $request->get('Tanque');
        $datos['SustanciaTanque'] = $request->get('SustanciaTanque');
        $datos['Procesos'] = $request->get('Procesos');
        $datos['ImagenesProcesos'] = $request->files->get('Procesos');
        $datos['ProcesoOperacion'] = $request->get('ProcesoOperacion');
        $datos['ProcesoOtro'] = $request->get('ProcesoOtro');
        $datos['ProcesoAlmacenamiento'] = $request->get('ProcesoAlmacenamiento');

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
 

        if($datos['Procesos']!= null){
            $storageService = new StorageService($entityManager);
            for( $i = 0; $i < count($datos['Procesos']['descripcion']); $i++){
                $proceso = $entityManager->getRepository(Proceso::class)->findOneBy(["planta"=>$planta, "tipo"=>1,'descripcion'=>$datos['Procesos']['descripcion'][$i]]);
                if($proceso == null){
                    $proceso = new Proceso();
                }
                $proceso->setDescripcion($datos['Procesos']['descripcion'][$i]);
                $proceso->setTipo(1);
                $proceso->setPlanta($planta);
                $entityManager->persist($proceso);
                if(isset($datos['ImagenesProcesos']['archivos'][$i])){
                    $storageService->generarUID($datos['ImagenesProcesos']['archivos'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('3.1.'.$i,$tramite,'ImagenesProcesos',$proceso->getId());
                }
            }
        }

        if($datos['ProcesoOperacion']!= null){
            $proceso = $entityManager->getRepository(Proceso::class)->findOneBy(["planta"=>$planta, "tipo"=>2]);
            if($proceso == null){
                $proceso = new Proceso();
            }
            $proceso->setDescripcion($datos['ProcesoOperacion']['descripcion']);
            $proceso->setTipo(2);
            $proceso->setPlanta($planta);
            $entityManager->persist($proceso);
        }

        if($datos['ProcesoOtro']!= null){
            $proceso = $entityManager->getRepository(Proceso::class)->findOneBy(["planta"=>$planta, "tipo"=>3]);
            if($proceso == null){
                $proceso = new Proceso();
            }
            $proceso->setDescripcion($datos['ProcesoOtro']['descripcion']);
            $proceso->setTipo(3);
            $proceso->setPlanta($planta);
            $entityManager->persist($proceso);
        }

        if($datos['ProcesoAlmacenamiento']!= null){
            $proceso = $entityManager->getRepository(Proceso::class)->findOneBy(["planta"=>$planta, "tipo"=>4]);
            if($proceso == null){
                $proceso = new Proceso();
            }
            $proceso->setDescripcion($datos['ProcesoAlmacenamiento']['descripcion']);
            $proceso->setTipo(4);
            $proceso->setPlanta($planta);
            $entityManager->persist($proceso);
        }   
       
        if($datos['Tanque'] != null){

            for( $i = 0; $i < count($datos['Tanque']['unidad']); $i++){
                $tanque = $entityManager->getRepository(Tanque::class)->findOneBy(['planta'=> $planta,  'unidad'=>$datos['Tanque']['unidad'][$i]]); 
                if($tanque == null){
                    $tanque= new Tanque();            
                }  
                $tanque->setUnidad($datos['Tanque']["unidad"][$i]);
                $tanque->setPlanta($planta);
                $entityManager->persist($tanque);

                if($datos['SustanciaTanque']!=null){
                    
                    $sustanciaTanque = $entityManager->getRepository(SustanciaTanque::class)->findOneBy(['tanque' => $tanque, 'sustancia' => $datos['SustanciaTanque']['sustancia'][$i]]);
                    if($sustanciaTanque == null){
                        $sustanciaTanque = new SustanciaTanque();
                    }        
                    $sustanciaTanque->setSustancia($datos['SustanciaTanque']['sustancia'][$i]);
                    $sustanciaTanque->setCapacidad($datos['SustanciaTanque']['capacidad'][$i]);
                    $sustanciaTanque->setEstadoFisico($datos['SustanciaTanque']['estadoFisico'][$i]);
                    $sustanciaTanque->setPresurizado($datos['SustanciaTanque']['presurizado'][$i]);
                    $sustanciaTanque->setPeligrosidad($datos['SustanciaTanque']['peligrosidad'][$i]);
                    $sustanciaTanque->setNormaSeguridad($datos['SustanciaTanque']['normaSeguridad'][$i]);
                    $sustanciaTanque->setNroNorma($datos['SustanciaTanque']['nroNorma'][$i]);
                    $sustanciaTanque->setTanque($tanque);

                    $entityManager->persist($sustanciaTanque);

                }
            }       
            
        }
        $entityManager->flush();
        
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $caracterizacion = $entityManager -> getRepository(CaracterizacionEntorno::class)->findOneBy(["planta" => $planta]); 
        if($caracterizacion != null){
            $filtro['CaracterizacionEntorno'] = $caracterizacion;
        }
        
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "4.1"]);
        $filtro['volverUrl'] = 'tramiteIAC3';
        return $this->render('informeAmbiental/formularioIAC4.html.twig', $filtro);
        
    }

    /**
     * @Route("/tramiteIAC5", name="tramiteIAC5", methods={"POST"})
     */
    public function tramiteIAC5( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);

        $datos['Caracterizacion'] = $request->get('Caracterizacion');
       

        if($datos['Caracterizacion'] != null){

            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            }  

            $caracterizacion = $entityManager -> getRepository(CaracterizacionEntorno::class)->findOneBy(["planta" => $planta]);

            if($caracterizacion == null){
                $caracterizacion = new CaracterizacionEntorno();
            }
            $caracterizacion->setDescripcionInmediata($datos['Caracterizacion']['descripcion']);
            $caracterizacion->setViaAcceso($datos['Caracterizacion']['viaAcceso']);
            $caracterizacion->setPlanta($planta);

            $entityManager->persist($caracterizacion);

            

            $entityManager->flush();
        }
        
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]); 
        $otroRecurso = $entityManager->getRepository(OtroRecurso::class)->findBy(["recurso"=>$recurso]);

        $filtro['AguasSubterraneas'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso, 'tipoAgua' => 1]);
        $filtro['AguasSuperficiales'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso, 'tipoAgua' => 2]); 
        $filtro['AguasPublicas'] = $entityManager->getRepository(Agua::class)->findBy(["recurso"=>$recurso, 'tipoAgua' => 3]);
        $filtro['Suelos'] = $entityManager->getRepository(Suelo::class)->findBy(["recurso"=>$recurso]);
        $filtro['OtroRecurso'] = $otroRecurso;

        $archivos = $entityManager->getRepository(Storage::class)->findBy(['tramite'=>$tramite]);
        foreach($archivos as $archivo){
            if(substr($archivo->getInciso(),0,3) == "5.1"){
                $filtro['ImagenesOtroRecurso']['archivos'][] = $archivo->getNombre();
            }
        }


        $filtro['volverUrl'] = 'tramiteIAC4';
        return $this->render('informeAmbiental/formularioIAC5.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC6", name="tramiteIAC6", methods={"POST"})
     */
    public function formularioIAC6( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]); 
        if($recurso == null){
            $recurso = new Recurso();
        }
        $recurso->setPlanta($planta);
        $entityManager->persist($recurso);


        $datos['AguasSubterraneas'] = $request->get('AguasSubterraneas');
        $datos['AguasSuperficiales'] = $request->get('AguasSuperficiales');
        $datos['AguasPublicas'] = $request->get('AguasPublicas');
        $datos['Suelos'] = $request->get('Suelos');
        $datos['OtroRecurso'] = $request->get('OtroRecurso');
        $datos['ImagenesOtroRecurso'] = $request->files->get('OtroRecurso');

        $aguaSubterranea = $entityManager->getRepository(TipoAgua::class)->findOneBy(["nombre"=>'Agua Subterranea']); 
        $aguaSuperficial = $entityManager->getRepository(TipoAgua::class)->findOneBy(["nombre"=>'Agua Superficial']); 
        $aguaPublica = $entityManager->getRepository(TipoAgua::class)->findOneBy(["nombre"=>'Agua de Red Publica']); 

        if($datos['AguasSubterraneas'] != null && $datos['AguasSubterraneas']['check']=='Si'){

            for( $i = 0; $i < count($datos['AguasSubterraneas']['nroPerforacion']); $i++){
                $agua = $entityManager->getRepository(Agua::class)->findOneBy(["recurso"=>$recurso,'tipoAgua' => 1, 'nroPerforacion'=>$datos['AguasSubterraneas']['nroPerforacion'][$i]]);
                if($agua == null){
                    $agua = new Agua();
                }
                
                $agua->setNroPerforacion($datos['AguasSubterraneas']['nroPerforacion'][$i]);
                $agua->setUbicacionPlano($datos['AguasSubterraneas']['ubicacion'][$i]);
                $agua->setCantidad($datos['AguasSubterraneas']['cantidad'][$i]);
                $agua->setUnidad($datos['AguasSubterraneas']['unidad'][$i]);
                $agua->setTiempo($datos['AguasSubterraneas']['tiempo'][$i]);
                $agua->setTipoAgua($aguaSubterranea);
                $agua->setRecurso($recurso);
                
                $entityManager->persist($agua);
                
            }
        }

        if($datos['AguasSuperficiales'] != null && $datos['AguasSuperficiales']['check']=='Si'){

            for( $i = 0; $i < count($datos['AguasSuperficiales']['nombre']); $i++){
                $agua = $entityManager->getRepository(Agua::class)->findOneBy(["recurso"=>$recurso,'tipoAgua' => 2, 'nombre'=>$datos['AguasSuperficiales']['nombre'][$i]]);
                if($agua == null){
                    $agua = new Agua();
                }
                $agua->setNombre($datos['AguasSuperficiales']['nombre'][$i]);
                $agua->setUbicacionPlano($datos['AguasSuperficiales']['ubicacion'][$i]);
                $agua->setCantidad($datos['AguasSuperficiales']['cantidad'][$i]);
                $agua->setUnidad($datos['AguasSuperficiales']['unidad'][$i]);
                $agua->setTiempo($datos['AguasSuperficiales']['tiempo'][$i]);
                $agua->setTipoAgua($aguaSuperficial);
                $agua->setRecurso($recurso);
                
                $entityManager->persist($agua);
                
            }
        }

        if($datos['AguasPublicas'] != null && $datos['AguasPublicas']['check']=='Si'){

            for( $i = 0; $i < count($datos['AguasPublicas']['nombre']); $i++){
                $agua = $entityManager->getRepository(Agua::class)->findOneBy(["recurso"=>$recurso,'tipoAgua' => 3, 'nombre'=>$datos['AguasPublicas']['nombre'][$i]]);
                if($agua == null){
                    $agua = new Agua();
                }
                $agua->setNombre($datos['AguasPublicas']['nombre'][$i]);
                $agua->setCantidad($datos['AguasPublicas']['cantidad'][$i]);
                $agua->setUnidad($datos['AguasPublicas']['unidad'][$i]);
                $agua->setTiempo($datos['AguasPublicas']['tiempo'][$i]);
                $agua->setTipoAgua($aguaPublica);
                $agua->setRecurso($recurso);
                
                $entityManager->persist($agua);
                
            }
        }

        if($datos['Suelos'] != null && $datos['Suelos']['check']=='Si'){

            if($datos['Suelos']['checkDos']=='Si'){
                for( $i = 0; $i < count($datos['Suelos']['sitioExtraccion']); $i++){
                    $suelo = $entityManager->getRepository(Suelo::class)->findOneBy(["recurso"=>$recurso, "sitioExtraccion"=>$datos['Suelos']['sitioExtraccion'][$i]]);
                    if($suelo == null){
                        $suelo = new Suelo();
                    }
                    $suelo->setDescripcionUso($datos['Suelos']['descripcionUso']);
                    $suelo->setSitioExtraccion($datos['Suelos']['sitioExtraccion'][$i]);
                    $suelo->setLatitud($datos['Suelos']['latitud'][$i]);
                    $suelo->setLongitud($datos['Suelos']['longitud'][$i]);
                    $suelo->setCantidadTiempo($datos['Suelos']['cantidadTiempo'][$i]);
                    $suelo->setAutorizacionMinisterio($datos['Suelos']['autorizacionMinisterio'][$i]);
                    $suelo->setRecurso($recurso);
                    $entityManager->persist($suelo);
                }
            }
            if($datos['Suelos']['checkDos']=='No'){

                $suelo = $entityManager->getRepository(Suelo::class)->findOneBy(["recurso"=>$recurso]);
                if($suelo == null){
                    $suelo = new Suelo();
                }
                $suelo->setDescripcionUso($datos['Suelos']['descripcionUso']);
                $suelo->setOrigenGestion($datos['Suelos']['origenGestion']);
                $suelo->setRecurso($recurso);
                $entityManager->persist($suelo);
            }       
        }

        if($datos['OtroRecurso']!=null){
            $storageService = new StorageService($entityManager);
            for( $i = 0; $i < count($datos['OtroRecurso']['etapa']); $i++){
                $otroRecurso = $entityManager->getRepository(OtroRecurso::class)->findOneBy(["recurso"=>$recurso, 'etapaProceso'=>$datos['OtroRecurso']['etapa'][$i]]);
                if($otroRecurso == null){
                    $otroRecurso = new OtroRecurso();
                }
                $otroRecurso->setTipo($datos['OtroRecurso']['tipo'][$i]);
                $otroRecurso->setExtraccionCaptacion($datos['OtroRecurso']['extraccion'][$i]);
                $otroRecurso->setEtapaProceso($datos['OtroRecurso']['etapa'][$i]);
                $otroRecurso->setCantidadTiempo($datos['OtroRecurso']['cantidad'][$i]);
                $otroRecurso->setRecurso($recurso);
                
                $entityManager->persist($otroRecurso);

                if(isset($datos['ImagenesOtroRecurso']['archivos'][$i])){
                    $storageService->generarUID($datos['ImagenesOtroRecurso']['archivos'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('5.1.'.$i,$tramite,'ImagenesOtroRecurso',$otroRecurso->getId());
                }
                
            }
        }

        $entityManager->flush();
       
        $electricaAdquirida = $entityManager->getRepository(ElectricaAdquirida::class)->findBy(["recurso"=>$recurso]);
        $electricaPropia = $entityManager->getRepository(ElectricaPropia::class)->findBy(["recurso"=>$recurso]);
        $gas = $entityManager->getRepository(Gas::class)->findBy(["recurso"=>$recurso]);
        $otraEnergia = $entityManager->getRepository(OtraEnergia::class)->findBy(["recurso"=>$recurso]);

        $filtro['ElectricaAdquirida'] = $electricaAdquirida;
        $filtro['ElectricaPropia'] = $electricaPropia;
        $filtro['Gases'] = $gas;
        $filtro['OtraEnergia'] = $otraEnergia;
        $filtro['volverUrl'] = 'tramiteIAC5';
        return $this->render('informeAmbiental/formularioIAC6.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC7", name="tramiteIAC7", methods={"POST"})
     */
    public function formularioIAC7( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
       
        $datos['ElectricaAdquirida'] = $request->get('ElectricaAdquirida');
        $datos['ElectricaPropia'] = $request->get('ElectricaPropia');
        $datos['Gases'] = $request->get('Gases');
        $datos['OtraEnergia'] = $request->get('OtraEnergia');

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        if($domicilioReal == null){
            $domicilioReal = new Domicilio();            
        }  

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        if($planta == null){
            $planta = new Planta();            
        }  

        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta"=>$planta]); 
        if($recurso == null){
            $recurso = new Recurso();
        }

        if($datos['ElectricaAdquirida'] != null && $datos['ElectricaAdquirida']['check']=='Si'){

            for( $i = 0; $i < count($datos['ElectricaAdquirida']['nombre']); $i++){
                $electricaAdquirida = $entityManager->getRepository(ElectricaAdquirida::class)->findOneBy(["recurso"=>$recurso, 'nombre'=> $datos['ElectricaAdquirida']['nombre'][$i]]);
                if($electricaAdquirida == null){
                    $electricaAdquirida = new ElectricaAdquirida();
                }
                $electricaAdquirida->setNombre($datos['ElectricaAdquirida']['nombre'][$i]);
                $electricaAdquirida->setCantidad($datos['ElectricaAdquirida']['cantidad'][$i]);
                $electricaAdquirida->setRecurso($recurso);
                
                $entityManager->persist($electricaAdquirida);
                
            } 
        }

        if($datos['ElectricaPropia'] != null && $datos['ElectricaPropia']['check']=='Si'){
                
            for( $i = 0; $i < count($datos['ElectricaPropia']['metodo']); $i++){
                $electricaPropia = $entityManager->getRepository(ElectricaPropia::class)->findOneBy(["recurso"=>$recurso, 'metodo'=>$datos['ElectricaPropia']['metodo'][$i]]);
                if($electricaPropia == null){
                    $electricaPropia = new ElectricaPropia();
                }
                $electricaPropia->setMetodo($datos['ElectricaPropia']['metodo'][$i]);
                $electricaPropia->setConsumo($datos['ElectricaPropia']['consumo'][$i]);
                $electricaPropia->setFuente($datos['ElectricaPropia']['fuente'][$i]);
                $electricaPropia->setRecurso($recurso);
                
                $entityManager->persist($electricaPropia);
                
            }
        }

        if($datos['Gases'] != null && $datos['Gases']['check'] =='Si'){
                
            for( $i = 0; $i < count($datos['Gases']['nombre']); $i++){
                $gas = $entityManager->getRepository(Gas::class)->findOneBy(["recurso"=>$recurso, 'nombre'=> $datos['Gases']['nombre'][$i]]);
                if($gas == null){
                    $gas = new Gas();
                }
                $gas->setNombre($datos['Gases']['nombre'][$i]);
                $gas->setConsumo($datos['Gases']['consumo'][$i]);
                $gas->setTipo($datos['Gases']['tipo'][$i]);
                $gas->setRecurso($recurso);
                
                $entityManager->persist($gas);  
            }
        }

        
        if($datos['OtraEnergia'] != null && $datos['OtraEnergia']['check'] =='Si'){
                
            for( $i = 0; $i < count($datos['OtraEnergia']['tipo']); $i++){
                $otraEnergia = $entityManager->getRepository(OtraEnergia::class)->findOneBy(["recurso"=>$recurso, 'tipo'=>$datos['OtraEnergia']['tipo'][$i]]);
                if($otraEnergia == null){
                    $otraEnergia = new OtraEnergia();
                }
                $otraEnergia->setTipo($datos['OtraEnergia']['tipo'][$i]);
                $otraEnergia->setNombre($datos['OtraEnergia']['nombre'][$i]);
                $otraEnergia->setConsumo($datos['OtraEnergia']['consumo'][$i]);
                $otraEnergia->setRecurso($recurso);
                
                $entityManager->persist($otraEnergia);
                
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
        $filtro['volverUrl'] = 'tramiteIAC6';

        
        return $this->render('informeAmbiental/formularioIAC7.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC8", name="tramiteIAC8", methods={"POST"})
     */
    public function tramiteIAC8( Request $request)
    {
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
        $filtro['ResiduosRsu'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, 'tipoResiduo' => 1]);
        $filtro['ResiduosPeligrosos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, 'tipoResiduo' => 2]);
        $filtro['ResiduosIndustriales'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, 'tipoResiduo' => 3]);
        $filtro['ResiduosPatologicos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, 'tipoResiduo' => 4]);
        $filtro['OtrosResiduos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, 'tipoResiduo' => 5]);

        $filtro['EfluentesIndustriales'] = $entityManager->getRepository(Efluente::class)->findBy(["planta"=>$planta, 'tipoEfluente' => 1]);
        $filtro['EfluentesSanitarios'] = $entityManager->getRepository(Efluente::class)->findBy(["planta"=>$planta, 'tipoEfluente' => 2]);
        
        $filtro['EmisionesPuntuales'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta, 'tipoEmision' => 1]);
        $filtro['EmisionesDifusas'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(["planta"=>$planta, 'tipoEmision' => 2]);

        $filtro['volverUrl'] = 'tramiteIAC7';
        return $this->render('informeAmbiental/formularioIAC8.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC9", name="tramiteIAC9", methods={"POST"})
     */

    public function tramiteIAC9( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        

        $datos['ResiduosRsu'] = $request->get('ResiduosRsu');
        $datos['ResiduosPeligrosos'] = $request->get('ResiduosPeligrosos');
        $datos['ResiduosIndustriales'] = $request->get('ResiduosIndustriales');
        $datos['ResiduosPatologicos'] = $request->get('ResiduosPatologicos');
        $datos['OtrosResiduos'] = $request->get('OtrosResiduos');

        $datos['EfluentesIndustriales'] = $request->get('EfluentesIndustriales');
        $datos['EfluentesSanitarios'] = $request->get('EfluentesSanitarios');
        
        $datos['EmisionesPuntuales'] = $request->get('EmisionesPuntuales');
        $datos['EmisionesDifusas'] = $request->get('EmisionesDifusas');

        if($datos['ResiduosRsu']!= null){

            $residuoRsu = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo"=>'Residuo Solido Urbano']); 
            $tipoResiduo = $entityManager->getRepository(TipoResiduo::class)->findAll();
            for( $i = 0; $i < count($datos['ResiduosRsu']['categoria']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneby(['tipoResiduo'=> 1 ,'planta'=> $planta, 'categoria'=>$datos['ResiduosRsu']['categoria'][$i]]);
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setCategoria($datos['ResiduosRsu']['categoria'][$i]);
                $residuo->setProcesoGenerador($datos['ResiduosRsu']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['ResiduosRsu']['periodoTiempo'][$i]);
                $residuo->setTipoResiduo($residuoRsu); 
                $residuo->setPlanta($planta);
                
                $entityManager->persist($residuo);
                
            }
        } 

        if($datos['ResiduosPeligrosos']!= null && $datos['ResiduosPeligrosos']['check'] == 'Si'){
            $residuoPeligroso = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo"=>'Residuo Peligroso']); 
            $nroGenerador = $datos['ResiduosPeligrosos']['nrogenerador'];
            for( $i = 0; $i < count($datos['ResiduosPeligrosos']['tipo']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneby(['tipoResiduo'=> 2 ,'planta'=> $planta, 'tipo'=>$datos['ResiduosPeligrosos']['tipo'][$i]]);
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setTipo($datos['ResiduosPeligrosos']['tipo'][$i]);
                $residuo->setProcesoGenerador($datos['ResiduosPeligrosos']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['ResiduosPeligrosos']['periodoTiempo'][$i]);
                $residuo->setNroGenerador($nroGenerador);
                $residuo->setTipoResiduo($residuoPeligroso); 
                $residuo->setPlanta($planta);
                
                $entityManager->persist($residuo);
                
            }
        }

        if($datos['ResiduosIndustriales']!= null && $datos['ResiduosIndustriales']['check'] == 'Si'){
            $residuoIndustrial = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo"=>'Residuo Industrial No Peligroso']);
            for( $i = 0; $i < count($datos['ResiduosIndustriales']['tipo']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneby(['tipoResiduo'=> 3 ,'planta'=> $planta, 'tipo'=>$datos['ResiduosIndustriales']['tipo'][$i]]);
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setTipo($datos['ResiduosIndustriales']['tipo'][$i]);
                $residuo->setProcesoGenerador($datos['ResiduosIndustriales']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['ResiduosIndustriales']['periodoTiempo'][$i]);
                $residuo->setTipoResiduo($residuoIndustrial); 
                $residuo->setPlanta($planta);
                
                $entityManager->persist($residuo);
                
            }
        }

        if($datos['ResiduosPatologicos']!= null && $datos['ResiduosPatologicos']['check'] == 'Si'){
            $residuoPatologico = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo"=>'Residuo Patologico']); 
            for( $i = 0; $i < count($datos['ResiduosPatologicos']['categoria']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneby(['tipoResiduo'=> 4 ,'planta'=> $planta, 'categoria'=>$datos['ResiduosPatologicos']['categoria'][$i]]);
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setCategoria($datos['ResiduosPatologicos']['categoria'][$i]);
                $residuo->setProcesoGenerador($datos['ResiduosPatologicos']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['ResiduosPatologicos']['periodoTiempo'][$i]);
                $residuo->setTipoResiduo($residuoPatologico); 
                $residuo->setPlanta($planta);
                
                $entityManager->persist($residuo);
                
            }
        }

        if($datos['OtrosResiduos']!= null && $datos['OtrosResiduos']['check'] == 'Si'){
            $otroResiduo = $entityManager->getRepository(TipoResiduo::class)->findOneBy(["tipo"=>'Otro Residuo']); 
            for( $i = 0; $i < count($datos['OtrosResiduos']['categoria']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneby(['tipoResiduo'=> 5 ,'planta'=> $planta, 'categoria'=>$datos['OtrosResiduos']['categoria'][$i]]);
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setCategoria($datos['OtrosResiduos']['categoria'][$i]);
                $residuo->setProcesoGenerador($datos['OtrosResiduos']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['OtrosResiduos']['periodoTiempo'][$i]);
                $residuo->setTipoResiduo($otroResiduo);
                $residuo->setPlanta($planta);
                
                $entityManager->persist($residuo);
                
            }
            
        }

        if($datos['EfluentesIndustriales']!= null && $datos['EfluentesIndustriales']['check'] == 'Si'){
            $efluenteLiquido = $entityManager->getRepository(TipoEfluente::class)->findOneBy(["tipo"=>'Efluentes Liquidos Industriales']); 
            for( $i = 0; $i < count($datos['EfluentesIndustriales']['tipo']); $i++){
                $efluente = $entityManager->getRepository(Efluente::class)->findOneby(['tipoEfluente'=> 1 ,'planta'=> $planta,'tipo'=>$datos['EfluentesIndustriales']['tipo'][$i]]);
                if($efluente == null){
                    $efluente = new Efluente();
                }
                $efluente->setTipo($datos['EfluentesIndustriales']['tipo'][$i]);
                $efluente->setProcesoGenerador($datos['EfluentesIndustriales']['procesoGenerador'][$i]);
                $efluente->setPeriodoTiempo($datos['EfluentesIndustriales']['periodoTiempo'][$i]);
                $efluente->setTipoEfluente($efluenteLiquido); 
                $efluente->setPlanta($planta);
                
                $entityManager->persist($efluente);
                
            }
        }

        if($datos['EfluentesSanitarios']!= null && $datos['EfluentesSanitarios']['check'] == 'Si'){
            for( $i = 0; $i < count($datos['EfluentesSanitarios']['caudal']); $i++){
                $efluenteSanitario = $entityManager->getRepository(TipoEfluente::class)->findOneBy(["tipo"=>'Efluentes Sanitarios']); 
                $efluente = $entityManager->getRepository(Efluente::class)->findOneby(['tipoEfluente'=> 2 ,'planta'=> $planta,'caudal'=>$datos['EfluentesSanitarios']['caudal'][$i]]);
                if($efluente == null){
                    $efluente = new Efluente();
                }
                $efluente->setCaudal($datos['EfluentesSanitarios']['caudal'][$i]);
                $efluente->setPeriodoTiempo($datos['EfluentesSanitarios']['periodoTiempo'][$i]);
                $efluente->setTipoEfluente($efluenteSanitario); 
                $efluente->setPlanta($planta);
                
                $entityManager->persist($efluente);
                
            }
        }

        if($datos['EmisionesPuntuales']!= null && $datos['EmisionesPuntuales']['check'] == 'Si'){

            $emisionPuntual = $entityManager->getRepository(TipoEmision::class)->findOneBy(["tipo"=>'Puntuales']); 

            for( $i = 0; $i < count($datos['EmisionesPuntuales']['tipo']); $i++){
                $emision = $entityManager->getRepository(EmisionGaseosa::class)->findOneby(['tipoEmision'=> 1 ,'planta'=> $planta,'tipo'=>$datos['EmisionesPuntuales']['tipo'][$i]]);
                if($emision == null){
                    $emision = new EmisionGaseosa();
                }
                $emision->setTipo($datos['EmisionesPuntuales']['tipo'][$i]);
                $emision->setProcesoGenerador($datos['EmisionesPuntuales']['procesoGenerador'][$i]);
                $emision->setChimenea($datos['EmisionesPuntuales']['chimenea'][$i]);
                $emision->setEmision($datos['EmisionesPuntuales']['emision'][$i]);
                $emision->setTipoEmision($emisionPuntual); 
                $emision->setPlanta($planta);
                
                $entityManager->persist($emision);
                
            }
        }

        if($datos['EmisionesDifusas']!= null && $datos['EmisionesDifusas']['check'] == 'Si'){
            for( $i = 0; $i < count($datos['EmisionesDifusas']['tipo']); $i++){
                $emisionDifusa = $entityManager->getRepository(TipoEmision::class)->findOneBy(["tipo"=>'Difusas']); 
                $emision = $entityManager->getRepository(EmisionGaseosa::class)->findOneby(['tipoEmision'=> 2 ,'planta'=> $planta,'tipo'=>$datos['EmisionesDifusas']['tipo'][$i]]);
                if($emision == null){
                    $emision = new EmisionGaseosa();
                }
                $emision->setTipo($datos['EmisionesDifusas']['tipo'][$i]);
                $emision->setProcesoGenerador($datos['EmisionesDifusas']['procesoGenerador'][$i]);
                $emision->setEmision($datos['EmisionesDifusas']['emision'][$i]);
                $emision->setTipoEmision($emisionDifusa); 
                $emision->setPlanta($planta);
                
                $entityManager->persist($emision);
                
            }
        }


        $entityManager->flush();

        $archivos = $entityManager->getRepository(Storage::class)->findBy(['tramite'=>$tramite]);
        foreach($archivos as $archivo){
            if (substr($archivo->getInciso(),0,3) == "9.10" && substr($archivo->getInciso(),-1) == "1"){
                $filtro['ImagenesContaminados']['archivosPm'][] = $archivo->getNombre();
            }elseif (substr($archivo->getInciso(),0,3) == "9.10" && substr($archivo->getInciso(),-1) == "2"){
                $filtro['ImagenesContaminados']['archivosPr'][] = $archivo->getNombre();
            }
        }

        for($i = 1; $i <= 8 ; $i++) {
            $filtro['Storage' . $i] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "9." . $i]);
        }
        $filtro['ResiduosRsu'] = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 1 ,'planta'=> $planta]);
        $filtro['TratamientoResiduosRsu'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=>$filtro['ResiduosRsu']]);
        $filtro['ResiduosPeligrosos'] = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 2 ,'planta'=> $planta]);
        $filtro['TratamientoResiduosPeligrosos'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=>$filtro['ResiduosPeligrosos']]);
        $filtro['ResiduosIndustriales'] = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 3 ,'planta'=> $planta]);
        $filtro['TratamientoResiduosIndustriales'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=>$filtro['ResiduosIndustriales']]);
        $filtro['ResiduosPatologicos'] = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 4 ,'planta'=> $planta]);
        $filtro['TratamientoResiduosPatologicos'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=>$filtro['ResiduosPatologicos']]);
        $filtro['OtrosResiduos'] = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 5 ,'planta'=> $planta]);
        $filtro['TratamientoOtrosResiduos'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=>$filtro['OtrosResiduos']]);
        $filtro['EfluentesIndustriales'] = $entityManager->getRepository(Efluente::class)->findBy(['tipoEfluente'=> 1 ,'planta'=> $planta]);
        $filtro['EfluentesSanitarios'] = $entityManager->getRepository(Efluente::class)->findBy(['tipoEfluente'=> 2 ,'planta'=> $planta]);
        $filtro['EmisionesPuntuales'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(['tipoEmision'=> 1 ,'planta'=> $planta]);
        $filtro['EmisionesDifusas'] = $entityManager->getRepository(EmisionGaseosa::class)->findBy(['tipoEmision'=> 2 ,'planta'=> $planta]);
        $filtro['SitiosContaminados'] = $entityManager->getRepository(SitioContaminado::class)->findBy(['planta'=> $planta]);
        $filtro['MarcoLegal'] = $entityManager->getRepository(MarcoLegal::class)->findBy(['empresa'=> $tramite->getEmpresa()]);

        $filtro['volverUrl'] = 'tramiteIAC8';
        return $this->render('informeAmbiental/formularioIAC9.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC10", name="tramiteIAC10", methods={"POST"})
     */

    public function tramiteIAC10( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        

        $datos['ResiduosRsu'] = $request->get('ResiduosRsu');
        $datos['ResiduosPeligrosos'] = $request->get('ResiduosPeligrosos');
        $datos['ResiduosIndustriales'] = $request->get('ResiduosIndustriales');
        $datos['ResiduosPatologicos'] = $request->get('ResiduosPatologicos');
        $datos['OtrosResiduos'] = $request->get('OtrosResiduos');

        $datos['EfluentesIndustriales'] = $request->get('EfluentesIndustriales');
        $datos['EfluentesSanitarios'] = $request->get('EfluentesSanitarios');
        
        $datos['EmisionesPuntuales'] = $request->get('EmisionesPuntuales');
        $datos['EmisionesDifusas'] = $request->get('EmisionesDifusas');

        $datos['SitiosContaminados'] = $request->get('SitiosContaminados');
        $datos['ImagenesContaminados'] = $request->files->get('SitiosContaminados');
        $datos['MarcoLegal'] = $request->get('MarcoLegal');

        if($datos['ResiduosRsu']!= null){
            for( $i = 0; $i < count($datos['ResiduosRsu']['gestion']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 1 ,'planta'=> $planta]);
                $tratamientoPlanta = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneby(['residuo'=> $residuo[$i] , 'empresaTransportista'=>$datos['ResiduosRsu']['empresaTransportista'][$i]]);
                if($tratamientoPlanta == null){
                    $tratamientoPlanta = new TratamientoPlantaExterior();
                }
                $residuo[$i]->setGestion($datos['ResiduosRsu']['gestion'][$i]);
                $tratamientoPlanta->setEmpresaTransportista($datos['ResiduosRsu']['empresaTransportista'][$i]);
                $tratamientoPlanta->setDisposicionFinal($datos['ResiduosRsu']['disposicionFinal'][$i]);
                $tratamientoPlanta->setResiduo($residuo[$i]);
                $entityManager->persist($residuo[$i]);
                $entityManager->persist($tratamientoPlanta);
            }
        } 

        if($datos['ResiduosPeligrosos']!= null ){
            for( $i = 0; $i < count($datos['ResiduosPeligrosos']['gestion']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 2 ,'planta'=> $planta]);
                $tratamientoPlanta = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneby(['residuo'=> $residuo[$i] , 'empresaTransportista'=>$datos['ResiduosRsu']['empresaTransportista'][$i]]);
                if($tratamientoPlanta == null){
                    $tratamientoPlanta = new TratamientoPlantaExterior();
                }
                $residuo[$i]->setGestion($datos['ResiduosPeligrosos']['gestion'][$i]);
                $tratamientoPlanta->setEmpresaTransportista($datos['ResiduosPeligrosos']['empresaTransportista'][$i]);
                $tratamientoPlanta->setDisposicionFinal($datos['ResiduosPeligrosos']['disposicionFinal'][$i]);
                $tratamientoPlanta->setResiduo($residuo[$i]);
                $entityManager->persist($residuo[$i]);
                $entityManager->persist($tratamientoPlanta);
            }
        }

        if($datos['ResiduosIndustriales']!= null ){
            for( $i = 0; $i < count($datos['ResiduosIndustriales']['gestion']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 3 ,'planta'=> $planta]);
                $tratamientoPlanta = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneby(['residuo'=> $residuo[$i] , 'empresaTransportista'=>$datos['ResiduosRsu']['empresaTransportista'][$i]]);
                if($tratamientoPlanta == null){
                    $tratamientoPlanta = new TratamientoPlantaExterior();
                }
                $residuo[$i]->setGestion($datos['ResiduosIndustriales']['gestion'][$i]);
                $tratamientoPlanta->setEmpresaTransportista($datos['ResiduosIndustriales']['empresaTransportista'][$i]);
                $tratamientoPlanta->setDisposicionFinal($datos['ResiduosIndustriales']['disposicionFinal'][$i]);
                $tratamientoPlanta->setResiduo($residuo[$i]);
                $entityManager->persist($residuo[$i]);
                $entityManager->persist($tratamientoPlanta);
            }
        }

        if($datos['ResiduosPatologicos']!= null ){
            for( $i = 0; $i < count($datos['ResiduosPatologicos']['gestion']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 4 ,'planta'=> $planta]);
                $tratamientoPlanta = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneby(['residuo'=> $residuo[$i] , 'empresaTransportista'=>$datos['ResiduosRsu']['empresaTransportista'][$i]]);
                if($tratamientoPlanta == null){
                    $tratamientoPlanta = new TratamientoPlantaExterior();
                }
                $residuo[$i]->setGestion($datos['ResiduosPatologicos']['gestion'][$i]);
                $tratamientoPlanta->setEmpresaTransportista($datos['ResiduosPatologicos']['empresaTransportista'][$i]);
                $tratamientoPlanta->setDisposicionFinal($datos['ResiduosPatologicos']['disposicionFinal'][$i]);
                $tratamientoPlanta->setResiduo($residuo[$i]);
                $entityManager->persist($residuo[$i]);
                $entityManager->persist($tratamientoPlanta);
            }
        }

        if($datos['OtrosResiduos']!= null ){ 
            for( $i = 0; $i < count($datos['OtrosResiduos']['gestion']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findBy(['tipoResiduo'=> 5 ,'planta'=> $planta]);
                $tratamientoPlanta = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneby(['residuo'=> $residuo[$i] , 'empresaTransportista'=>$datos['ResiduosRsu']['empresaTransportista'][$i]]);
                if($tratamientoPlanta == null){
                    $tratamientoPlanta = new TratamientoPlantaExterior();
                }
                $residuo[$i]->setGestion($datos['OtrosResiduos']['gestion'][$i]);
                $tratamientoPlanta->setEmpresaTransportista($datos['OtrosResiduos']['empresaTransportista'][$i]);
                $tratamientoPlanta->setDisposicionFinal($datos['OtrosResiduos']['disposicionFinal'][$i]);
                $tratamientoPlanta->setResiduo($residuo[$i]);
                $entityManager->persist($residuo[$i]);
                $entityManager->persist($tratamientoPlanta);            
            }        
        }

        if($datos['EfluentesIndustriales']!= null ){
            for( $i = 0; $i < count($datos['EfluentesIndustriales']['descarga']); $i++){
                $efluente = $entityManager->getRepository(Efluente::class)->findBy(['tipoEfluente'=> 1 ,'planta'=> $planta]);
                $efluente[$i]->setDescarga($datos['EfluentesIndustriales']['descarga'][$i]);
                $efluente[$i]->setTratamiento($datos['EfluentesIndustriales']['tratamiento'][$i]);
                $efluente[$i]->setReceptor($datos['EfluentesIndustriales']['receptor'][$i]);
                $entityManager->persist($efluente[$i]);
            }
        }

        if($datos['EfluentesSanitarios']!= null ){
            for( $i = 0; $i < count($datos['EfluentesSanitarios']['tratamiento']); $i++){
                $efluente = $entityManager->getRepository(Efluente::class)->findBy(['tipoEfluente'=> 2 ,'planta'=> $planta]);
                $efluente[$i]->setTratamiento($datos['EfluentesSanitarios']['tratamiento'][$i]);
                $entityManager->persist($efluente[$i]);
            }
        }

        if($datos['EmisionesPuntuales']!= null ){
            for( $i = 0; $i < count($datos['EmisionesPuntuales']['funcionamiento']); $i++){
                $emision = $entityManager->getRepository(EmisionGaseosa::class)->findBy(['tipoEmision'=> 1 ,'planta'=> $planta]);
                $emision[$i]->setFuncionamiento($datos['EmisionesPuntuales']['funcionamiento'][$i]);
                $emision[$i]->setTratamiento($datos['EmisionesPuntuales']['tratamiento'][$i]);
                $entityManager->persist($emision[$i]);
            }
        }

        if($datos['EmisionesDifusas']!= null ){
            for( $i = 0; $i < count($datos['EmisionesDifusas']['tratamiento']); $i++){
                $emision = $entityManager->getRepository(EmisionGaseosa::class)->findBy(['tipoEmision'=> 2 ,'planta'=> $planta]);
                $emision[$i]->setTratamiento($datos['EmisionesDifusas']['tratamiento'][$i]);
                $entityManager->persist($emision[$i]);
            }
        }

        if($datos['SitiosContaminados'] != null && $datos['SitiosContaminados']['check'] == 'Si'){
            for( $i = 0; $i < count($datos['SitiosContaminados']['ubicacionGeoreferencial']); $i++){
                $sitioContaminado = $entityManager->getRepository(SitioContaminado::class)->findOneBy(['planta'=> $planta, 'ubicacionGeoreferencial'=> $datos['SitiosContaminados']['ubicacionGeoreferencial'][$i]]);
                if($sitioContaminado == null){
                    $sitioContaminado = new SitioContaminado();
                }
                $sitioContaminado->setUbicacionGeoreferencial($datos['SitiosContaminados']['ubicacionGeoreferencial'][$i]);
                $sitioContaminado->setDescripcion($datos['SitiosContaminados']['descripcion'][$i]);
                $sitioContaminado->setParametrosIntereses($datos['SitiosContaminados']['parametrosInteres'][$i]);
                $sitioContaminado->setPlanMonitoreo($datos['SitiosContaminados']['planMonitoreo'][$i]);
                $sitioContaminado->setPlanRemediacion($datos['SitiosContaminados']['planRemediacion'][$i]);
                $sitioContaminado->setPlanta($planta);

                $entityManager->persist($sitioContaminado);
                $storageService = new StorageService($entityManager);
                if(isset($datos['ImagenesContaminados']['archivosPm'][$i])){
                    $storageService->generarUID($datos['ImagenesContaminados']['archivosPm'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('9.10.'.$i.'.1',$tramite,'ImagenesContaminados',$sitioContaminado->getId());
                }
                if(isset($datos['ImagenesContaminados']['archivosPr'][$i])){
                    $storageService->generarUID($datos['ImagenesContaminados']['archivosPr'][$i]);
                    $storageService->crearDirectorio();
                    $storageService->subirArchivo('9.10.'.$i.'.2',$tramite,'ImagenesContaminados',$sitioContaminado->getId());
                }
            }
        }

        if($datos['MarcoLegal'] != null ){
            for( $i = 0; $i < count($datos['MarcoLegal']['tipoNorma']); $i++){
                $marcoLegal = $entityManager->getRepository(MarcoLegal::class)->findOneBy(['empresa'=> $tramite->getEmpresa(), 'tipoNorma'=> $datos['MarcoLegal']['tipoNorma'][$i]]);
                if($marcoLegal == null){
                    $marcoLegal = new MarcoLegal();
                }
                $marcoLegal->setTipoNorma($datos['MarcoLegal']['tipoNorma'][$i]);
                $marcoLegal->setTema($datos['MarcoLegal']['tema'][$i]);
                $marcoLegal->setAplicacionEspecifica($datos['MarcoLegal']['aplicacionEspecifica'][$i]);
                $marcoLegal->setEmpresa($tramite->getEmpresa());

                $entityManager->persist($marcoLegal);
            }            
        }

        $entityManager->flush();
        $filtro['volverUrl'] = 'tramiteIAC9';

        return $this->redirectToRoute('misTramites');
        // return $this->render('informeAmbiental/formularioIAC10.html.twig', $filtro);
    }

    /**
     * @Route("/tramiteIAC11", name="tramiteIAC11", methods={"POST"})
     */

    public function tramiteIAC11( Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $filtro['volverUrl'] = 'tramiteIAC10';
        
        return $this->redirectToRoute('misTramites');
    }

}