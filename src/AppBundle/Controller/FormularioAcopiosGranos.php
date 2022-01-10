<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Provincia;
use AppBundle\Entity\Localidad;
use AppBundle\Entity\Formulario;
use AppBundle\Entity\Departamento;
use AppBundle\Entity\Grupo;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Storage;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Planta;
use AppBundle\Entity\EmpresaHasActividad;
use AppBundle\Entity\FormacionPersonal;
use AppBundle\Entity\DimencionamientoPlanta;
use AppBundle\Entity\Almacenamiento;
use AppBundle\Entity\TipoAlmacenamiento;
use AppBundle\Entity\BarreraArtificial;
use AppBundle\Entity\BarreraVegetal;
use AppBundle\Entity\ProcesoGrano;
use AppBundle\Entity\ProductoServicioAuxiliar;
use AppBundle\Entity\TipoAplicacionAuxiliar;
use AppBundle\Entity\Ruido;
use AppBundle\Entity\TipoRuido;
use AppBundle\Entity\TipoImpacto;
use AppBundle\Entity\Impacto;
use AppBundle\Service\StorageService;
use AppBundle\Entity\TipoOperacion;
use AppBundle\Entity\TratamientoPlantaPropia;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\Gas;
use AppBundle\Entity\ListaTramites;
use \DateTime;


class FormularioAcopiosGranos extends BaseController
{
    /**
     * @Route("/formularioAcopioGranosEstudioImpactoAmbiental", name="formularioAcopioGranosEstudioImpactoAmbiental", methods={"GET"})
     */
    public function formularioAcopiosGranos(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if($request->get("idTramite")!=0){
            
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $persona = $tramite->getEmpresa()->getPersona();
            $empresa = $tramite -> getEmpresa();
            $domicilioLegal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>2]);
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=>$empresa]);
            
            if($empresa != null && $domicilioLegal != null && $domicilioReal != null && $empresa != null && $planta != null) {

                $filtro['Persona'] = $empresa->getPersona();
                $filtro['DomicilioLegal'] = $domicilioLegal;
                $filtro['DomicilioReal'] = $domicilioReal;
                $filtro['Empresa'] = $empresa;
                $filtro['Planta'] = $planta;
                $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
                $filtro['Grupo'] = $entityManager->getRepository(Actividad::class)->find($empresaHasActividad->getActividad());
                
            }
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(6);
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
        $filtro['grupos'] = $entityManager->getRepository(Grupo::class)->findAll();
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['EmpresaActividad'] = $entityManager->getRepository(EmpresaHasActividad::class)->findBy(["empresa"=> $tramite->getEmpresa()]);
        
        return $this->render('acopioGranos/formularioAG1.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteAG2", name="tramiteAG2", methods={"POST"})
     */
    public function formularioAG2(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);

        $datos['Persona'] = $request->get('Persona');
        $datos['DomicilioLegal'] = $request->get('DomicilioLegal');
        $datos['Planta'] = $request->get('Planta');
        $datos['DomicilioReal'] = $request->get('DomicilioReal');
        $datos['Empresa'] = $request->get('Empresa');
        $datos['ActividadEmpresa'] = $request->get('ActividadEmpresa');      
        
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

            if($datos['Empresa'] != null){
                $empresa = $tramite -> getEmpresa();
                if($empresa == null){
                    $empresa = new Empresa();
                }
                $empresa->setFechaInicioActividad(new \DateTime($datos['Empresa']["fechaInicio"]));
                $empresa->setTipoPersona(0);
                $empresa->setDeposito(0);
                $empresa->setPersona($persona);
                $tramite->setEmpresa($empresa);
                $entityManager->persist($empresa);
             
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

                        if($datos['Planta'] != null){
                            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
                            if($planta == null){
                                $planta = new Planta();            
                            }  
                            $planta -> setNombre($datos['Planta']["nombre"]);
                            $planta -> setEmpresa($tramite->getEmpresa());
                            $planta -> setDomicilio($domicilioReal);
                            $entityManager->persist($planta);

                                  
                            if($datos['ActividadEmpresa']!=null){
                              
                                for($i=0;$i<count($datos['ActividadEmpresa']);$i++){
                                    $actividad = $entityManager->getRepository(Actividad::class)->findOneBy(["id" => $datos['ActividadEmpresa'][$i]]);
                                    $empresaHasActividad = $entityManager->getRepository(EmpresaHasActividad::class)->findOneBy(["empresa"=> $empresa, "actividad" => $request->get('ActividadEmpresa')[$i]]);
                                    if ($empresaHasActividad == null){
                                        $empresaHasActividad = new EmpresaHasActividad();
                                    }
                                    $empresaHasActividad->setActividad($actividad);
                                    $empresaHasActividad->setTipo($request->get('prse')[$i]);
                                    $empresaHasActividad->setEmpresa($empresa);

                                    $entityManager->persist($empresaHasActividad);
                                    
                                }                                       
                            }                   
                        }
                    }
                }
            }

            $entityManager->flush();
        }

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $dimensionPlanta = $entityManager->getRepository(DimencionamientoPlanta::class)->findOneBy(["planta"=>$planta]); 
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        if($dimensionPlanta != null && $domicilioReal != null){
            $filtro['DimensionPlanta'] = $dimensionPlanta;
            $filtro['DomicilioReal'] = $domicilioReal;
        }
        $filtro['paginaInicio'] = "formularioAcopioGranosEstudioImpactoAmbiental";
        return $this->render('acopioGranos/formularioAG2.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG3", name="tramiteAG3", methods={"POST"})
     */
    public function formularioAG3(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['DimensionPlanta'] = $request->get('DimensionPlanta');
        $datos['DomicilioReal'] = $request->get('DomicilioReal');
        if($datos['DimensionPlanta'] != null){

            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=> 2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            } 
             
            $dimensionPlanta = $entityManager->getRepository(DimencionamientoPlanta::class)->findOneBy(["planta"=>$planta]); 
            if($dimensionPlanta == null){
                $dimensionPlanta = new DimencionamientoPlanta();
            }
            $dimensionPlanta->setPlanta($planta);
            $dimensionPlanta->setSuperficieCubierta($datos['DimensionPlanta']["superficieCubierta"]);
            $dimensionPlanta->setSuperficieSinEdificar($datos['DimensionPlanta']["sinEdificar"]);
            $dimensionPlanta->setSuperficieInstalada($datos['DimensionPlanta']["superficieInstalada"]);
            $dimensionPlanta->setSuperficieTotal($datos['DimensionPlanta']["superficieTotal"]);
            $entityManager->persist($dimensionPlanta);

            if($datos['DomicilioReal'] != null){
                $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
                if($domicilioReal == null){
                    $domicilioReal = new Domicilio();            
                } 
                $domicilioReal->setZonificacion($datos['DomicilioReal']['zonificacion']);
                $entityManager->persist($domicilioReal);
 
            }

            $entityManager->flush();

        }

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $formacionPersonal = $entityManager->getRepository(FormacionPersonal::class)->findOneBy(["planta"=>$planta]);
        if($planta != null && $formacionPersonal != null){
            $filtro['Planta'] = $planta;
            $filtro['FormacionPersonal'] = $formacionPersonal;
        }
        $filtro['volverUrl'] = "tramiteAG2";
        return $this->render('acopioGranos/formularioAG3.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG4", name="tramiteAG4", methods={"POST"})
     */
    public function formularioAG4(Request $request){
        $filtro = $this->getFiltro($request);  
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);      

        $datos['Planta'] = $request->get('Planta');
        $datos['FormacionPersonalObrero'] = $request->get('FormacionPersonalObrero');
        $datos['FormacionPersonalTecnico'] = $request->get('FormacionPersonalTecnico');
        $datos['FormacionPersonalProfesional'] = $request->get('FormacionPersonalProfesional');
        $datos['FormacionPersonal'] = $request->get('FormacionPersonal');

        if($datos['Planta'] != null){

            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            } 
            $planta->setPeriodoServicio($datos["Planta"]["periodoServicio"]);

            if($datos['FormacionPersonalObrero'] != null){
           
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
    
                
            }
            $entityManager->flush();
        }

        //modificar tipoImpacto
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
        $filtro['volverUrl'] = "tramiteAG3";
        return $this->render('acopioGranos/formularioAG4.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG5", name="tramiteAG5", methods={"POST"})
     */
    public function formularioAG5(Request $request){
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

        
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 

        $filtro['AlmacenamientoSilos'] = $entityManager->getRepository(Almacenamiento::class)->findBy(['planta' => $planta, 'tipoAlmacenamiento'=> 4]);
        $filtro['AlmacenamientoCeldas'] = $entityManager->getRepository(Almacenamiento::class)->findBy(['planta' => $planta, 'tipoAlmacenamiento'=> 5]);
        $filtro['AlmacenamientoOtros'] = $entityManager->getRepository(Almacenamiento::class)->findBy(['planta' => $planta, 'tipoAlmacenamiento'=> 3]);


        $filtro['volverUrl'] = "tramiteAG4";
        return $this->render('acopioGranos/formularioAG5.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG6", name="tramiteAG6", methods={"POST"})
     */
    public function formularioAG6(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);  
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]);       
        
        $datos['AlmacenamientoSilos'] = $request->get('AlmacenamientoSilos');
        $datos['AlmacenamientoCeldas'] = $request->get('AlmacenamientoCeldas');
        $datos['AlmacenamientoOtros'] = $request->get('AlmacenamientoOtros');
       
        if($datos['AlmacenamientoSilos'] != null){

            for( $i = 0; $i < count($datos['AlmacenamientoSilos']['cantidad']); $i++){
                $tipo = $entityManager->getRepository(TipoAlmacenamiento::class)->find(4); //4 porque es el id que coincide con silos
                $almacenamiento = $entityManager->getRepository(Almacenamiento::class)->findOneBy(['planta' => $planta, 'tipoAlmacenamiento' => 4 , 'cantidad'=>$datos['AlmacenamientoSilos']['cantidad'][$i]]); 
                if($almacenamiento == null){
                    $almacenamiento = new Almacenamiento();
                }

                $almacenamiento->setCantidad($datos['AlmacenamientoSilos']['cantidad'][$i]);
                $almacenamiento->setUnidad($datos['AlmacenamientoSilos']['unidad'][$i]);
                $almacenamiento->setPeriodo($datos['AlmacenamientoSilos']['periodo'][$i]);
                $almacenamiento->setTipoAlmacenamiento($tipo); 
                $almacenamiento->setPlanta($planta);

                $entityManager->persist($almacenamiento);
            }
        }
        if($datos['AlmacenamientoCeldas'] != null){
            for( $i = 0; $i < count($datos['AlmacenamientoCeldas']['cantidad']); $i++){
                $tipo = $entityManager->getRepository(TipoAlmacenamiento::class)->find(5); //5 porque es el id que coincide con celdas
                $almacenamiento = $entityManager->getRepository(Almacenamiento::class)->findOneBy(['planta' => $planta, 'tipoAlmacenamiento' => 5 , 'cantidad'=>$datos['AlmacenamientoCeldas']['cantidad'][$i]]); 
                if($almacenamiento == null){
                    $almacenamiento = new Almacenamiento();
                }

                $almacenamiento->setCantidad($datos['AlmacenamientoCeldas']['cantidad'][$i]);
                $almacenamiento->setUnidad($datos['AlmacenamientoCeldas']['unidad'][$i]);
                $almacenamiento->setPeriodo($datos['AlmacenamientoCeldas']['periodo'][$i]);
                $almacenamiento->setTipoAlmacenamiento($tipo); 
                $almacenamiento->setPlanta($planta);

                $entityManager->persist($almacenamiento);
            }
        }

        if($datos['AlmacenamientoOtros'] != null){
            for( $i = 0; $i < count($datos['AlmacenamientoOtros']['cantidad']); $i++){
                $tipo = $entityManager->getRepository(TipoAlmacenamiento::class)->find(3); //3 porque es el id que coincide con otros
                $almacenamiento = $entityManager->getRepository(Almacenamiento::class)->findOneBy(['planta' => $planta, 'tipoAlmacenamiento' => 3 , 'cantidad'=>$datos['AlmacenamientoOtros']['cantidad'][$i]]); 
                if($almacenamiento == null){
                    $almacenamiento = new Almacenamiento();
                }

                $almacenamiento->setCantidad($datos['AlmacenamientoOtros']['cantidad'][$i]);
                $almacenamiento->setUnidad($datos['AlmacenamientoOtros']['unidad'][$i]);
                $almacenamiento->setPeriodo($datos['AlmacenamientoOtros']['periodo'][$i]);
                $almacenamiento->setTipoAlmacenamiento($tipo); 
                $almacenamiento->setPlanta($planta);

                $entityManager->persist($almacenamiento);
            }
        }
        

        $entityManager->flush();

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
       

        $filtro['BarreraArtificial'] = $entityManager->getRepository(BarreraArtificial::class)->findBy(['planta' => $planta]);
        $filtro['BarreraVegetal'] = $entityManager->getRepository(BarreraVegetal::class)->findBy(['planta' => $planta]);
        $filtro['maxDate'] = date("Y-m-d");
        $filtro['volverUrl'] = "tramiteAG5";
        return $this->render('acopioGranos/formularioAG6.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG7", name="tramiteAG7", methods={"POST"})
     */
    public function formularioAG7(Request $request){
        $filtro = $this->getFiltro($request);  
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);    
        
        $datos['BarreraArtificial'] = $request->get('BarreraArtificial');
        $datos['BarreraVegetal'] = $request->get('BarreraVegetal');

        if(  $datos['BarreraArtificial'] != null && $datos['BarreraVegetal'] != null){

            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            } 

            for( $i = 0; $i < count($datos['BarreraArtificial']['ubicacion']); $i++){
                $barreraArtificial = $entityManager->getRepository(BarreraArtificial::class)->findOneBy(['planta' => $planta, 'ubicacion'=>$datos['BarreraArtificial']['ubicacion'][$i]]); 
                if($barreraArtificial == null){
                    $barreraArtificial = new BarreraArtificial();
                }
                $barreraArtificial->setNumero($i + 1);
                $barreraArtificial->setUbicacion($datos['BarreraArtificial']['ubicacion'][$i]);
                $barreraArtificial->setTipo($datos['BarreraArtificial']['tipo'][$i]);
                $barreraArtificial->setAltura($datos['BarreraArtificial']['altura'][$i]);
                $barreraArtificial->setLongitud($datos['BarreraArtificial']['longitud'][$i]);
                $barreraArtificial->setMaterial($datos['BarreraArtificial']['material'][$i]);
                $barreraArtificial->setPlanta($planta);

                $entityManager->persist($barreraArtificial);
            }

            for( $i = 0; $i < count($datos['BarreraVegetal']['ubicacion']); $i++){
                $barreraVegetal = $entityManager->getRepository(BarreraVegetal::class)->findOneBy(['planta' => $planta, 'ubicacion'=>$datos['BarreraVegetal']['ubicacion'][$i]]); 
                if($barreraVegetal == null){
                    $barreraVegetal = new BarreraVegetal();
                }
                $barreraVegetal->setNumero($i + 1);
                $barreraVegetal->setUbicacion($datos['BarreraVegetal']['ubicacion'][$i]);
                $barreraVegetal->setGeneroEspecie($datos['BarreraVegetal']['especie'][$i]);
                $barreraVegetal->setFechaPlantacion(new \DateTime($datos['BarreraVegetal']['fecha'][$i]));
                $barreraVegetal->setSistemaPlantacion($datos['BarreraVegetal']['sistema'][$i]);
                $barreraVegetal->setNumeroArboles($datos['BarreraVegetal']['numeroArboles'][$i]);
                $barreraVegetal->setPlanta($planta);

                $entityManager->persist($barreraVegetal);
            }

            $entityManager -> flush();
        }

        $filtro['TipoAplicacion'] = $entityManager->getRepository(TipoAplicacionAuxiliar::class)->findAll();


        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findBy(['planta' => $planta]);
        $servicioAuxiliar =   $entityManager->getRepository(ProductoServicioAuxiliar::class)->findBy(['planta' => $planta]);
        if($procesoGrano != null && $servicioAuxiliar != null){
            $filtro['ProcesoGrano'] = $procesoGrano;
            $filtro['ServicioAuxiliar'] = $servicioAuxiliar;
        }
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);

        $filtro['volverUrl'] = "tramiteAG6";
        return $this->render('acopioGranos/formularioAG7.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG8", name="tramiteAG8", methods={"POST"})
     */
    public function formularioAG8(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);        
       
        $datos['ProcesoGrano'] = $request->get('ProcesoGrano');
        $datos['ServicioAuxiliar'] = $request->get('ServicioAuxiliar');
        $datos['TipoAplicacionServicio'] = $request->get('TipoAplicacionServicio');
        
        if($datos['ProcesoGrano'] != null){

            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            }  

            for( $i = 0; $i < count($datos['ProcesoGrano']['etapaA']['paso']); $i++){
               
                $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findOneBy(['planta' => $planta, 'operatoria'=>$datos['ProcesoGrano']['etapaA']['operatoria'][$i]]); 
                if($procesoGrano == null){
                    $procesoGrano = new ProcesoGrano();
                }
                $procesoGrano->setEtapa('Etapa A');
                $procesoGrano->setPaso($i + 1);
                $procesoGrano->setOperatoria($datos['ProcesoGrano']['etapaA']['operatoria'][$i]);
                $procesoGrano->setObservacion($datos['ProcesoGrano']['etapaA']['observaciones'][$i]);
                $procesoGrano->setPlanta($planta);
                $entityManager->persist($procesoGrano);

            }
            for( $i = 0; $i < count($datos['ProcesoGrano']['etapaB']['paso']); $i++){
               
                $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findOneBy(['planta' => $planta, 'operatoria'=>$datos['ProcesoGrano']['etapaB']['operatoria'][$i]]); 
                if($procesoGrano == null){
                    $procesoGrano = new ProcesoGrano();
                }
                $procesoGrano->setEtapa('Etapa B');
                $procesoGrano->setPaso($i + 1);
                $procesoGrano->setOperatoria($datos['ProcesoGrano']['etapaB']['operatoria'][$i]);
                $procesoGrano->setObservacion($datos['ProcesoGrano']['etapaB']['observaciones'][$i]);
                $procesoGrano->setPlanta($planta);
                $entityManager->persist($procesoGrano);
            }
            for( $i = 0; $i < count($datos['ProcesoGrano']['etapaC']['paso']); $i++){
               
                $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findOneBy(['planta' => $planta, 'operatoria'=>$datos['ProcesoGrano']['etapaC']['operatoria'][$i]]); 
                if($procesoGrano == null){
                    $procesoGrano = new ProcesoGrano();
                }
                $procesoGrano->setEtapa('Etapa C');
                $procesoGrano->setPaso($i + 1);
                $procesoGrano->setOperatoria($datos['ProcesoGrano']['etapaC']['operatoria'][$i]);
                $procesoGrano->setObservacion($datos['ProcesoGrano']['etapaC']['observaciones'][$i]);
                $procesoGrano->setPlanta($planta);
                $entityManager->persist($procesoGrano);
            }
            for( $i = 0; $i < count($datos['ProcesoGrano']['etapaD']['paso']); $i++){
               
                $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findOneBy(['planta' => $planta, 'operatoria'=>$datos['ProcesoGrano']['etapaD']['operatoria'][$i]]); 
                if($procesoGrano == null){
                    $procesoGrano = new ProcesoGrano();
                }
                $procesoGrano->setEtapa('Etapa D');
                $procesoGrano->setPaso($i + 1);
                $procesoGrano->setOperatoria($datos['ProcesoGrano']['etapaD']['operatoria'][$i]);
                $procesoGrano->setObservacion($datos['ProcesoGrano']['etapaD']['observaciones'][$i]);
                $procesoGrano->setPlanta($planta);
                $entityManager->persist($procesoGrano);
            }
            for( $i = 0; $i < count($datos['ProcesoGrano']['etapaE']['paso']); $i++){
               
                $procesoGrano = $entityManager->getRepository(ProcesoGrano::class)->findOneBy(['planta' => $planta, 'operatoria'=>$datos['ProcesoGrano']['etapaE']['operatoria'][$i]]); 
                if($procesoGrano == null){
                    $procesoGrano = new ProcesoGrano();
                }
                $procesoGrano->setEtapa('Etapa E');
                $procesoGrano->setPaso($i + 1);
                $procesoGrano->setOperatoria($datos['ProcesoGrano']['etapaE']['operatoria'][$i]);
                $procesoGrano->setObservacion($datos['ProcesoGrano']['etapaE']['observaciones'][$i]);
                $procesoGrano->setPlanta($planta);
                $entityManager->persist($procesoGrano);
            }

            if($datos['ServicioAuxiliar'] != null){
                for( $i = 0; $i < count($datos['ServicioAuxiliar']['descripcion']); $i++){
                    $tipoAplicacion = $entityManager->getRepository(TipoAplicacionAuxiliar::class)->find($datos['TipoAplicacionServicio']["nombre"][$i]);
                    $servicioAuxiliar = $entityManager->getRepository(ProductoServicioAuxiliar::class)->findOneBy(['planta' => $planta, 'descripcion'=>$datos['ServicioAuxiliar']['descripcion'][$i]]); 
                    if($servicioAuxiliar == null){
                        $servicioAuxiliar = new ProductoServicioAuxiliar();
                    }
                    $servicioAuxiliar->setNumero($i + 1);
                    $servicioAuxiliar->setDescripcion($datos['ServicioAuxiliar']['descripcion'][$i]);
                    $servicioAuxiliar->setCantidad($datos['ServicioAuxiliar']['cantidad'][$i]);
                    $servicioAuxiliar->setUnidad($datos['ServicioAuxiliar']['unidad'][$i]);
                    $servicioAuxiliar->setResponsable($datos['ServicioAuxiliar']['responsable'][$i]);
                    $servicioAuxiliar->setTipoAplicacionAuxiliar($tipoAplicacion);
                    $servicioAuxiliar->setPlanta($planta);

                    $entityManager->persist($servicioAuxiliar);
                }
            }
          

            $entityManager->flush();
        }

        $filtro['TipoRuido'] = $entityManager->getRepository(TipoRuido::class)->findAll();

        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
        $ruido = $entityManager->getRepository(Ruido::class)->findBy(['planta' => $planta]); 
        if($ruido != null){
            $filtro['Ruido'] = $ruido;
        }
        $filtro['volverUrl'] = "tramiteAG7";
        return $this->render('acopioGranos/formularioAG8.html.twig', $filtro);   
    }

    /**
     * @Route("/tramiteAG9", name="tramiteAG9", methods={"POST"})
     */
    public function formularioAG9(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);        

        $datos['Ruido'] = $request->get('Ruido');
        $datos['TipoRuido'] = $request->get('TipoRuido');
        
        if($datos['Ruido'] != null){
            $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]);
            if($domicilioReal == null){
                $domicilioReal = new Domicilio();            
            }  

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]); 
            if($planta == null){
                $planta = new Planta();            
            } 

            for( $i = 0; $i < count($datos['Ruido']['nombre']); $i++){
                $tipoRuido = $entityManager->getRepository(TipoRuido::class)->find($datos['TipoRuido']["nombre"][$i]);
                $ruido = $entityManager->getRepository(Ruido::class)->findOneBy(['planta' => $planta, 'nombre'=>$datos['Ruido']['nombre'][$i]]); 
                if($ruido == null){
                    $ruido = new Ruido();
                }
                $ruido->setNombre($datos['Ruido']['nombre'][$i]);
                $ruido->setHorario($datos['Ruido']['horario'][$i]);
                $ruido->setCaracteristica($datos['Ruido']['caracteristica'][$i]);
                $ruido->setPlanta($planta);
                $ruido->setTipoRuido($tipoRuido);

                $entityManager->persist($ruido);
            }

            $entityManager->flush();
        }
        
        $filtro['Residuos'] = $entityManager->getRepository(Residuo::class)->findBy(['planta' => $planta]); 
        $filtro['TratamientoPlantaPropia'] = $entityManager->getRepository(TratamientoPlantaPropia::class)->findBy(['residuo' => $filtro['Residuos']]); 
        $filtro['TipoOperacion'] = $entityManager->getRepository(TipoOperacion::class)->findBy(['tratamientoPlantaPropia' =>  $filtro['TratamientoPlantaPropia']]);
    
        $recurso = $entityManager->getRepository(Recurso::class)->findBy(['planta' => $planta]); 
        $filtro['Gases'] = $entityManager->getRepository(Gas::class)->findBy(['recurso' => $recurso]); 
        $filtro['volverUrl'] = "tramiteAG8";
        return $this->render('acopioGranos/formularioAG9.html.twig', $filtro);   
    }


    /**
     * @Route("/tramiteAG10", name="tramiteAG10", methods={"POST"})
     */
    public function formularioAG10(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);   
        $domicilioReal = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>2]); 
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilioReal]);   
        
        $datos['Residuos'] = $request->get('Residuos');
        $datos['Gases'] = $request->get('Gases');

        if($datos['Residuos']!= null){

            for( $i = 0; $i < count($datos['Residuos']['categoria']); $i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(['planta'=> $planta,'categoria'=>$datos['Residuos']['categoria'][$i]]); 
                if($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->setCategoria($datos['Residuos']['categoria'][$i]);
                $residuo->setProcesoGenerador($datos['Residuos']['procesoGenerador'][$i]);
                $residuo->setPeriodoTiempo($datos['Residuos']['periodoTiempo'][$i]);
                $residuo->setPlanta($planta);
                $entityManager->persist($residuo);

                $tratamientoPlantaPropia = $entityManager->getRepository(TratamientoPlantaPropia::class)->findOneBy(['residuo'=> $residuo, 'tratamientoIncompleto'=>$datos['Residuos']['tratamientoPlanta'][$i]]);
                if($tratamientoPlantaPropia == null){
                    $tratamientoPlantaPropia = new TratamientoPlantaPropia();
                }
                $tratamientoPlantaPropia->setTratamientoIncompleto($datos['Residuos']['tratamientoPlanta'][$i]);
                $tratamientoPlantaPropia->setResiduo($residuo);
                $entityManager->persist($tratamientoPlantaPropia);

                $tipoOperacion = $entityManager->getRepository(TipoOperacion::class)->findOneBy(['tratamientoPlantaPropia'=> $tratamientoPlantaPropia, 'operacion'=>$datos['Residuos']['tipoOperacion'][$i]]);
                if($tipoOperacion == null){
                    $tipoOperacion = new TipoOperacion();
                }
                $tipoOperacion->setOperacion($datos['Residuos']['tipoOperacion'][$i]);
                $tipoOperacion->setTratamientoPlantaPropia($tratamientoPlantaPropia);
                $entityManager->persist($tipoOperacion);    
            }

        }

        if($datos['Gases']!= null){
            $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(['planta' => $planta]); 
            if($recurso == null){
                $recurso = new Recurso();
            }
            $recurso->setPlanta($planta);
            $entityManager->persist($recurso);
            for( $i = 0; $i < count($datos['Gases']['nombre']); $i++){
                $gas = $entityManager->getRepository(Gas::class)->findOneBy(['recurso' => $recurso, 'nombre'=>$datos['Gases']['nombre'][$i]]); 
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

        $entityManager->flush();
       
        $filtro['volverUrl'] = "tramiteAG9";
        return $this->redirectToRoute('misTramites')   ;
    }
}

