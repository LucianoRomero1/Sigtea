<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Estado;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Viento;
use AppBundle\Entity\Recurso;
use AppBundle\Entity\UbicacionFeedlot;
use AppBundle\Entity\MemoriaDescriptivaFeedlot;
use AppBundle\Entity\Loteo;
use AppBundle\Entity\Topografia;
use AppBundle\Entity\Urbanizacion;
use AppBundle\Entity\Empresa;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\TratamientoPlantaExterior;
use AppBundle\Entity\ObjetoSubdivision;
use AppBundle\Entity\Efluente;
use AppBundle\Entity\Residuo;
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
use \DateTime;

class FeedLootsController extends BaseController
{
    /**
     * @Route("/formularioFeedLotsInformeAmbientalCumplimiento", name="formularioFeedLotsInformeAmbientalCumplimiento", methods={"GET"})
     */
    public function formularioFeedLoots(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        if($request->get("idTramite")!=0){
            
            $tramite = $this->getTramite($request->get("idTramite"));
            $empresa = $tramite->getEmpresa(); // COSAS A MODIFICAR
            $filtro['Empresa'] = $empresa;
            $filtro['Persona'] = $tramite->getEmpresa()->getPersona();
            
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
            if($domicilio!=null){
                $filtro['Domicilio'] = $domicilio;
            }

        }else{
            
            $tramite = new Tramite();

            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(8);

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
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        return $this->render('feedLoots/formularioFL1.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteFL2", name="tramiteFL2", methods={"POST"})
     */
    public function formularioFL2(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']);   

        $datos['Persona'] = $request->get('Persona');
        $datos['Domicilio'] = $request->get('Domicilio');

        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["depto"]);

        if ($datos['Persona']!=null){
            $persona = $entityManager->getRepository(Persona::class)->findOneBy(['cuit' => $datos["Persona"]["cuit"]]);
            if($persona== null){
                $persona = new Persona();            
            }        
            $persona->setRazonSocial($datos['Persona']["razonSocial"]);
            $persona->setCuit($datos["Persona"]["cuit"]);
            $entityManager->persist($persona);

            $empresa = $entityManager->getRepository(Empresa::class)->findOneBy(['persona'=>$persona]);
            if($empresa == null){
                $empresa = new Empresa();
            }
            $empresa->setFechaInicioActividad(new \DateTime(date("Y-m-d")));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);
            $entityManager->persist($empresa);
            $tramite -> setEmpresa( $empresa );

            // Domicilio 
            if ($datos['Domicilio'] != null){

                $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa" => $tramite->getEmpresa(), "tipo" => 1]);
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

            $entityManager -> flush();
        }


        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=> 2]);
        
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]);
        $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(["planta"=>$planta]);
        
        $ubicacionFeedlot = $entityManager->getRepository(UbicacionFeedlot::class)->findOneBy(['planta'=> $planta]);

        $filtro["Domicilio"] = $domicilio;
        $filtro["PartidaInmobiliaria"] = $partidaInmobiliaria;
        $filtro["Ubicacion"] = $ubicacionFeedlot;
        
        $filtro['paginaInicio'] = 'formularioFeedLotsInformeAmbientalCumplimiento';
        return $this->render('feedLoots/formularioFL2.html.twig', $filtro); 
        
    }

    /**
     * @Route("/tramiteFL3", name="tramiteFL3", methods={"POST"})
     */
    public function formularioFL3(Request $request){

        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']);  

        $datos['Domicilio'] = $request->get('Domicilio');
        $datos['Coordenadas'] = $request->get('Coordenadas');
        $datos['Ubicacion'] = $request->get('Ubicacion');

        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);

        if ($datos['Domicilio'] != null){

            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["calle"=>$datos['Domicilio']["calle"],"empresa"=>$tramite->getEmpresa(), "tipo" => 2]);
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

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa(),"domicilio" => $domicilio]);
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $planta->setDomicilio($domicilio);

            $entityManager->persist($planta);

            if($datos['Coordenadas'] != null){

                $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findOneBy(['numero'=>$datos['Coordenadas']['partida']]);
                if($partidaInmobiliaria == null){
                    $partidaInmobiliaria = new PartidaInmobiliaria();                
                }
                $partidaInmobiliaria->setNumero($datos['Coordenadas']['partida']);
                $partidaInmobiliaria->setLatitud($datos['Coordenadas']['lat']);
                $partidaInmobiliaria->setLongitud($datos['Coordenadas']['long']);
                $partidaInmobiliaria->setPlanta($planta);
                $entityManager->persist($partidaInmobiliaria);

                if($datos['Ubicacion'] != null){

                    $ubicacionFeedlot = $entityManager->getRepository(UbicacionFeedlot::class)->findOneBy(['planta'=> $planta]);

                    if ( $ubicacionFeedlot == null){
                        $ubicacionFeedlot = new UbicacionFeedlot();
                    }

                    $ubicacionFeedlot -> setDistanciaUrbana($datos['Ubicacion']['distanciaUrbana']);
                    $ubicacionFeedlot -> setDistanciaAsentamiento($datos['Ubicacion']['distanciaAsentamiento']);
                    $ubicacionFeedlot -> setDistanciaAnimal($datos['Ubicacion']['distanciaAnimal']);
                    $ubicacionFeedlot -> setDistanciaEspejoAgua($datos['Ubicacion']['distanciaEspejoAgua']);
                    $ubicacionFeedlot -> setDistanciaOtroEstablecimiento($datos['Ubicacion']['distanciaOtroEstablecimiento']);
                    $ubicacionFeedlot -> setPlanta($planta);

                    $entityManager -> persist ($ubicacionFeedlot);
                }
            }

            $entityManager -> flush();
        }
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $filtro['Descriptiva'] = $entityManager->getRepository(MemoriaDescriptivaFeedlot::class)->findOneBy(['planta'=> $planta]);

        $filtro['volverUrl'] = 'tramiteFL2';
        return $this->render('feedLoots/formularioFL3.html.twig', $filtro); 
        
    }

    /**
     * @Route("/tramiteFL4", name="tramiteFL4", methods={"POST"})
     */
    public function formularioFL4(Request $request){

        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Descriptiva'] = $request->get('Descriptiva');


        if ( $datos['Descriptiva'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $entityManager -> persist( $planta );

            $memoriaDescriptiva = $entityManager->getRepository(MemoriaDescriptivaFeedlot::class)->findOneBy(['planta'=> $planta]);

            if ( $memoriaDescriptiva == null){
                $memoriaDescriptiva = new MemoriaDescriptivaFeedlot();
            }
            
            $memoriaDescriptiva -> setCapacidadMaxima($datos['Descriptiva']['capacidadMaxima']);
            $memoriaDescriptiva -> setCantidadAnimal($datos['Descriptiva']['cantidadAnimal']);
            $memoriaDescriptiva -> setSuperficieEstablecimiento($datos['Descriptiva']['superficieEstablecimiento']);
            $memoriaDescriptiva -> setSuperficieAnimal($datos['Descriptiva']['superficieAnimal']);
            $memoriaDescriptiva -> setPlanta($planta);

            $entityManager -> persist ($memoriaDescriptiva);
            $entityManager -> flush ();
        }

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $filtro['Topografia'] = $entityManager->getRepository(Topografia::class)->findOneBy(['planta'=> $planta]);
        $filtro['volverUrl'] = 'tramiteFL3';
        return $this->render('feedLoots/formularioFL4.html.twig', $filtro); 
        
    }

      /**
     * @Route("/tramiteFL5", name="tramiteFL5", methods={"POST"})
     */
    public function formularioFL5(Request $request){

        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Topografia'] = $request->get('Topografia');
        if ( $datos['Topografia'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO                    

            $topografia = $entityManager->getRepository(Topografia::class)->findOneBy(['planta'=> $planta]);    

            if ( $topografia == null){
                $topografia = new Topografia();
            }
            $topografia -> setDescripcionSitio($datos['Topografia']['descripcionSitio']);
            $topografia -> setDescripcionPendientes($datos['Topografia']['descripcionPendientes']);
            $topografia -> setPlanta($planta);

            $entityManager ->persist($topografia);
            $entityManager ->flush();
        }
        
        $filtro['Topografia'] = $topografia;


        $filtro['volverUrl'] = 'tramiteFL4';
        return $this->render('feedLoots/formularioFL5.html.twig', $filtro); 
        
    }

      /**
     * @Route("/tramiteFL6", name="tramiteFL6", methods={"POST"})
     */
    public function formularioFL6(Request $request){
        
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Topografia'] = $request->get('Topografias');

        if ( $datos['Topografia'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO            

            $topografia = $entityManager->getRepository(Topografia::class)->findOneBy(['planta'=> $planta]);
            
            for($i = 0; $i<count($datos['Topografia']['tipoSuelo']); $i++){
                $topografia -> setTipoSuelo($datos['Topografia']['tipoSuelo'][$i]);
                $topografia -> setPermeabilidad($datos['Topografia']['permeabilidad'][$i]);
                $topografia -> setTratamientoSuelo($datos['Topografia']['tratamientoSuelo'][$i]);
                
                $topografia -> setPlanta($planta);

                $entityManager -> persist ($topografia);
            }
            
            $entityManager -> flush ();
        }

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $filtro['Topografia'] = $entityManager->getRepository(Topografia::class)->findOneBy(['planta'=> $planta]);

        $filtro['volverUrl'] = 'tramiteFL5';
        return $this->render('feedLoots/formularioFL6.html.twig', $filtro); 
        
    }

     /**
     * @Route("/tramiteFL7", name="tramiteFL7", methods={"POST"})
     */
    public function formularioFL7(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Topografia'] = $request->get('Topografia');

        if ( $datos['Topografia'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
            
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $entityManager -> persist( $planta );

            $topografia = $entityManager->getRepository(Topografia::class)->findOneBy(['planta'=> $planta]);

            if ( $topografia == null){
                $topografia = new Topografia();
            }
            
            $topografia -> setAbastecimientoAgua($datos['Topografia']['abastecimientoAgua']);
            $topografia -> setProfundidad($datos['Topografia']['profundidad']);
            $topografia -> setDistanciaBombeo($datos['Topografia']['distanciaBombeo']);
            
            $topografia -> setPlanta($planta);

            $entityManager -> persist ($topografia);
            $entityManager -> flush ();
        }

        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta" => $planta]);
        $filtro['Viento'] = $entityManager->getRepository(Viento::class)->findOneBy(['recurso'=> $recurso]);

        $filtro['volverUrl'] = 'tramiteFL6';
        return $this->render('feedLoots/formularioFL7.html.twig', $filtro); 
        
    }

     /**
     * @Route("/tramiteFL8", name="tramiteFL8", methods={"POST"})
     */
    public function formularioFL8(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Viento'] = $request->get('Viento');

        if ( $datos['Viento'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $entityManager -> persist( $planta );

            $recurso = $entityManager->getRepository(Recurso::class)->findOneBy(["planta" => $planta]);

            if ( $recurso == null){
                $recurso = new Recurso();
            }
            
            $recurso -> setPlanta($planta);
            $entityManager -> persist ($recurso);
            
            $viento = $entityManager->getRepository(Viento::class)->findOneBy(['recurso'=> $recurso]);

            if ( $viento == null){
                $viento = new Viento();
            }
            
            $viento -> setDireccionPredominante($datos['Viento']['direccionPredominante']);
            
            $viento -> setRecurso($recurso);

            $entityManager -> persist ($viento);
            $entityManager -> flush ();
        }
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $filtro['Efluente'] = $entityManager->getRepository(Efluente::class)->findOneBy(['planta'=> $planta]);
        $filtro['volverUrl'] = 'tramiteFL7';
        return $this->render('feedLoots/formularioFL8.html.twig', $filtro); 
        
    }

    /**
     * @Route("/tramiteFL9", name="tramiteFL9", methods={"POST"})
     */
    public function formularioFL9(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Efluente'] = $request->get('Efluente');

        if ( $datos['Efluente'] != null ){

            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
            
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $entityManager -> persist( $planta );

            $efluente = $entityManager->getRepository(Efluente::class)->findOneBy(['planta'=> $planta]);

            if ( $efluente == null){
                $efluente = new Efluente();
            }
            
            $efluente -> setGestion($datos['Efluente']['gestion']);
            
            $efluente -> setPlanta($planta);

            $entityManager -> persist ($efluente);
            $entityManager -> flush ();
        }
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
        $filtro['Residuo'] = $entityManager->getRepository(Residuo::class)->findOneBy(['planta'=> $planta]);
        $filtro['Tratamientos'] = $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(['residuo'=> $filtro['Residuo']]);

        $filtro['volverUrl'] = 'tramiteFL8';
        return $this->render('feedLoots/formularioFL9.html.twig', $filtro); 
        
    }

    /**
     * @Route("/tramiteFL10", name="tramiteFL10", methods={"POST"})
     */
    public function formularioFL10(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Residuo'] = $request->get('Residuo');
        $datos['Tratamientos'] = $request->get('Tratamientos');
        
        if ( $datos['Residuo'] != null ){
            
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa" => $tramite->getEmpresa()]); // PREGUNTAR A LUCIO SI VA DOMICILIO
            
            if($planta == null){
                $planta = new Planta();            
            }        
            $planta->setEmpresa($tramite->getEmpresa());
            $entityManager -> persist( $planta );

            $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(['planta'=> $planta]);

            if ( $residuo == null){
                $residuo = new Residuo();
            }
            
            $residuo -> setGestion($datos['Residuo']['gestion']);
            $residuo -> setPlanta($planta);

            $entityManager -> persist ($residuo);
            
            if ( $datos['Tratamientos'] != null ){
                for($i = 0; $i< count($datos['Tratamientos']['cantidad']); $i++){
                    $tratamiento = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneBy(["residuo"=> $residuo]);
                    if ($tratamiento == null){
                        $tratamiento = new TratamientoPlantaExterior();
                    }
                    $tratamiento -> setNombre($datos['Tratamientos']['cantidad'][$i]);
                    $tratamiento -> setEmpresaTransportista($datos['Tratamientos']['empresaTransportista'][$i]);
                    
                    $tratamiento -> setDisposicionFinal($datos['Tratamientos']['disposicionFinal'][$i]);
                    $tratamiento -> setResiduo( $residuo );
                    $entityManager -> persist( $tratamiento );
                }
            }
            $entityManager -> flush ();
        }
        $filtro['volverUrl'] = 'tramiteFL9';
        return $this->redirectToRoute('misTramites');
        
    }
}

