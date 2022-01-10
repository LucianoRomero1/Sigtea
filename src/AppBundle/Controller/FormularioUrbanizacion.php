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
use AppBundle\Entity\FactibilidadServicio;
use AppBundle\Entity\Storage;
use AppBundle\Entity\ListaTramites;
use \DateTime;


class FormularioUrbanizacion extends BaseController{

    /**
     * @Route("/formularioUrbanizacionPresentacion", name="formularioUrbanizacionPresentacion", methods={"GET"})
     */
    public function formularioUrbanizacion(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
            $subdivision = $entityManager->getRepository(ObjetoSubdivision::class)->findOneBy(["tramite"=>$tramite]); 
            if ($subdivision!=null) $filtro['Subdivision'] = $subdivision;            
        }else{
            $estado = $entityManager->getRepository(Estado::class)->find(1);
            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(1);
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
        
        
        return $this->render('urbanizacion/formularioU1.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteU2", name="tramiteU2", methods={"POST"})
     */
    public function formularioU2(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();  
        $tramite = $this->getTramite($request->get("idTramite"));
        $filtro['Subdivision'] = $request->get('Subdivision');
        if($tramite->getEmpresa() != null){
            $filtro['Persona'] = $entityManager->getRepository(Persona::class)->find($tramite->getEmpresa()->getPersona()); 
        } 
        $filtro['paginaInicio'] = 'formularioUrbanizacionPresentacion';
        return $this->render('urbanizacion/formularioU2.html.twig', $filtro); 
        
    }

    /**
     * @Route("/tramiteU3", name="tramiteU3", methods={"POST"})
     */
    public function formularioU3(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $datos['Persona'] = $request->get('Persona');
        $datos['Subdivision'] = $request->get('Subdivision');

        if($datos['Persona']!=null){
            $cuit = trim($datos['Persona']["cuit"]);
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
            $empresa->setFechaInicioActividad(new \DateTime(date("Y-m-d")));
            $empresa->setTipoPersona(1);
            $empresa->setDeposito(0);
            $empresa->setPersona($persona);
            $entityManager->persist($empresa);
            $tramite->setEmpresa($empresa);

            $entityManager->persist($tramite);

            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(["tramite"=>$tramite]);
            if($loteo == null){
                $loteo = new Loteo();
                $loteo->setTramite($tramite);
                $entityManager->persist($loteo);
            }
            
            $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(["empresa"=>$empresa, "loteo"=>$loteo]);
            if($urbanizacion == null){
                $urbanizacion = new Urbanizacion();
            }
            $urbanizacion->setLoteo($loteo);
            $urbanizacion->setEmpresa($empresa);
            $entityManager->persist($urbanizacion);

            $objetoSubdivision = $entityManager->getRepository(ObjetoSubdivision::class)->findOneBy(['tramite' => $tramite]);
            if($objetoSubdivision == null){
                $objetoSubdivision = new ObjetoSubdivision();            
            }
            $objetoSubdivision->setObjeto($datos['Subdivision']); 
            $objetoSubdivision->setTramite($tramite);
            $objetoSubdivision->setUrbanizacion($urbanizacion);
            $entityManager->persist($objetoSubdivision);
            
            $entityManager->flush();  
        }

        
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$empresa, "tipo"=>1]);
        if($domicilio != null){
            $filtro["Domicilio"] = $domicilio;
        }
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        $filtro['volverUrl'] = 'tramiteU2';
        
        return $this->render('urbanizacion/formularioU3.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteU4", name="tramiteU4", methods={"POST"})
     */
    public function formularioU4(Request $request){
        $filtro = $this->getFiltro($request);        
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 
        
        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        

        if($datos['Domicilio']!=null){
            $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(["empresa"=>$tramite->getEmpresa(), "tipo"=>1]);
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
            $entityManager->flush();
        }
        
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"1"]);
        
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        }

        $filtro['volverUrl'] = 'tramiteU3';
        return $this->render('urbanizacion/formularioU4.html.twig', $filtro); 
    }


    /**
     * @Route("/tramiteU5", name="tramiteU5", methods={"POST"})
     */
    public function formularioU5(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 

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
        
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"2"]);
        
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        }
        $filtro['volverUrl'] = 'tramiteU4';
        return $this->render('urbanizacion/formularioU5.html.twig', $filtro); 
    }


    /**
     * @Route("/tramiteU6", name="tramiteU6", methods={"POST"})
     */
    public function formularioU6(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 
        $datos['Persona'] = $request->get('Persona');
        $datos['Representante'] = $request->get('Representante');
        if($datos['Persona']!= null){
            for( $i = 0; $i < count($datos['Persona']['razonSocial']); $i++){
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
        $representantes = $entityManager->getRepository(Representante::class)->findBy(["tipo"=>"3"]);
        $empresaHasRepresentante = $entityManager->getRepository(EmpresaHasRepresentante::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"representante"=>$representantes]);  
        if($empresaHasRepresentante != null){
            $filtro["Representantes"] = $empresaHasRepresentante;
        } 
        $filtro['volverUrl'] = 'tramiteU5';      
        return $this->render('urbanizacion/formularioU6.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteU7", name="tramiteU7", methods={"POST"})
     */
    public function formularioU7(Request $request){
        //Salteo esta pagina porque es sobre el perito
        $filtro = $this->getFiltro($request);       
        return $this->render('urbanizacion/formularioU7.html.twig', $filtro); 
    }

       /**
     * @Route("/tramiteU8", name="tramiteU8", methods={"POST"})
     */
    public function formularioU8(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        
        $tramite = $this->getTramite($filtro['idTramite']); 
        
        $datos['Persona'] = $request->get('Persona');

        if($datos['Persona']!=null){
            $cuit = trim($datos['Persona']["cuit"]);
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
        
        

        $filtro['volverUrl'] = 'tramiteU6';
        $filtro['provincias'] = $entityManager->getRepository(Provincia::class)->findAll();
        
        $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(['tipo' => 2, 'empresa'=>$tramite->getEmpresa()]);
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilio]); 
        $partidaInmobiliaria = $entityManager->getRepository(PartidaInmobiliaria::class)->findBy(["planta"=>$planta]);
        $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]); 

        if($partidaInmobiliaria != null && $domicilio != null && $loteo != null && $urbanizacion != null){
            $filtro['PartidaInmobiliaria'] = $partidaInmobiliaria;
            $filtro['Domicilio'] = $domicilio;
            $filtro['Loteo'] = $loteo;
            $filtro['Urbanizacion'] = $urbanizacion;
        }
        $filtro['Storage1'] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "7.1"]);
        return $this->render('urbanizacion/formularioU8.html.twig', $filtro); 
    }

    
    /**
     * @Route("/tramiteU9", name="tramiteU9", methods={"POST"})
     */
    public function formularioU9(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager(); 
        $tramite = $this->getTramite($filtro['idTramite']);

        
        $datos['Loteo'] = $request->get('Loteo');    
        $datos['Urbanizacion'] = $request->get('Urbanizacion');
        $datos['Coordenadas'] = $request->get('Coordenadas');
        $datos['Domicilio'] = $request->get('Domicilio');
        $provincia = $entityManager->getRepository(Provincia::class)->find($datos['Domicilio']["provincia"]);
        $localidad = $entityManager->getRepository(Localidad::class)->find($datos['Domicilio']["localidad"]);
        $departamento = $entityManager->getRepository(Departamento::class)->find($datos['Domicilio']["departamento"]);
        
        if($datos['Loteo'] != null ){
            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
            if($loteo == null){
                $loteo = new Loteo();
            }
            $loteo->setNombre($datos['Loteo']['nombre']);
            $loteo->setTramite($tramite);
            $entityManager->persist($loteo);

            if($datos['Urbanizacion'] != null){
                $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]); 
                if($urbanizacion == null){
                    $urbanizacion = new Urbanizacion();
                }
                $urbanizacion->setCalleRuta($datos['Urbanizacion']['calleRuta']);
                $urbanizacion->setNumeroKm($datos['Urbanizacion']['numeroKm']);
                $urbanizacion->setEntreCalles($datos['Urbanizacion']['entreCalles']);
                $urbanizacion->setLoteo($loteo);
                $urbanizacion->setEmpresa($tramite->getEmpresa());
                $entityManager->persist($urbanizacion);

                if($datos['Domicilio'] != null){

                    $domicilio = $entityManager->getRepository(Domicilio::class)->findOneBy(['tipo' => 2, 'empresa'=>$tramite->getEmpresa(), 'zonificacion'=>$datos['Domicilio']["zona"]]); 
                    if($domicilio == null){
                        $domicilio = new Domicilio();            
                    }
                    $domicilio->setEmpresa($tramite->getEmpresa());
                    $domicilio->setZonificacion($datos['Domicilio']["zona"]);
                    $domicilio->setProvincia($provincia);
                    $domicilio->setDepartamento($departamento);
                    $domicilio->setLocalidad($localidad);
                    $domicilio->setTipo(2);
        
                    $entityManager->persist($domicilio);
                    $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa(),"domicilio"=>$domicilio]);
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
                    
                }
                
            }
            $entityManager->flush();
        }
        
        $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]); 
        $dimensionamiento = $entityManager->getRepository(DimensionamientoLoteo::class)->findOneBy(['urbanizacion' => $urbanizacion]);
        $suelo = $entityManager->getRepository(DestinoSuelo::class)->findBy(['urbanizacion' => $urbanizacion]); 
        if($dimensionamiento != null && $suelo != null){
            $filtro['Dimensionamiento'] = $dimensionamiento;
            $filtro['DestinoSuelo'] = $suelo;
        }
        
        $filtro['volverUrl'] = 'tramiteU8';
        return $this->render('urbanizacion/formularioU9.html.twig', $filtro); 
    }

    
    /**
     * @Route("/tramiteU10", name="tramiteU10", methods={"POST"})
     */
    public function formularioU10(Request $request){
        $filtro = $this->getFiltro($request);  
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 
       
        
        
        $datos['Dimensionamiento'] = $request->get('Dimensionamiento');   
        $datos['DestinoSuelo'] = $request->get('DestinoSuelo'); 

        if($datos['Dimensionamiento'] != null){
            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
            if($loteo == null){
                $loteo = new Loteo();
            }

            $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]);
            if($urbanizacion == null){
                $urbanizacion = new Urbanizacion();
            }

            $dimensionamiento = $entityManager->getRepository(DimensionamientoLoteo::class)->findOneBy(['urbanizacion' => $urbanizacion]);  
            if($dimensionamiento == null){
                $dimensionamiento = new DimensionamientoLoteo();
            }
            $dimensionamiento->setSuperficieTotal($datos['Dimensionamiento']['superficieTotal']);
            $dimensionamiento->setCantidadLotes($datos['Dimensionamiento']['cantidadLotes']);
            $dimensionamiento->setSuperficieTotalLoteada($datos['Dimensionamiento']['superficieLoteada']);
            $dimensionamiento->setUrbanizacion($urbanizacion);
            $entityManager->persist($dimensionamiento);

            if($datos['DestinoSuelo'] != null){
                for( $i = 0; $i < count($datos['DestinoSuelo']['verdes']['nombre']); $i++){
                    $suelo = $entityManager->getRepository(DestinoSuelo::class)->findOneBy(['urbanizacion' => $urbanizacion, 'tipo' => 'Espacios Verdes', 'porcentaje'=>$datos['DestinoSuelo']['verdes']['porcentaje'][$i]]); 
                    if($suelo == null){
                        $suelo = new DestinoSuelo();
                    }
                    $suelo->setTipo('Espacios Verdes');
                    $suelo->setNombre($datos['DestinoSuelo']['verdes']['nombre'][$i]);
                    $suelo->setSuperficie($datos['DestinoSuelo']['verdes']['superficie'][$i]);
                    $suelo->setPorcentaje($datos['DestinoSuelo']['verdes']['porcentaje'][$i]);
                    $suelo->setUrbanizacion($urbanizacion);
                    $entityManager->persist($suelo);
                }
                
                for( $i = 0; $i < count($datos['DestinoSuelo']['retardadores']['nombre']); $i++){
                    $suelo = $entityManager->getRepository(DestinoSuelo::class)->findOneBy(['urbanizacion' => $urbanizacion, 'tipo' => 'Retardadores Hidricos', 'superficie'=>$datos['DestinoSuelo']['retardadores']['superficie'][$i]]); 
                    if($suelo == null){
                        $suelo = new DestinoSuelo();
                    }
                    $suelo->setTipo('Retardadores Hidricos');
                    $suelo->setNombre($datos['DestinoSuelo']['retardadores']['nombre'][$i]);
                    $suelo->setSuperficie($datos['DestinoSuelo']['retardadores']['superficie'][$i]);
                    $suelo->setUrbanizacion($urbanizacion);
                    $entityManager->persist($suelo);
                }

                for( $i = 0; $i < count($datos['DestinoSuelo']['equipamiento']['nombre']); $i++){
                    $suelo = $entityManager->getRepository(DestinoSuelo::class)->findOneBy(['urbanizacion' => $urbanizacion, 'tipo' => 'Equipamiento Comunitario', 'superficie'=>$datos['DestinoSuelo']['equipamiento']['superficie'][$i]]); 
                    if($suelo == null){
                        $suelo = new DestinoSuelo();
                    }
                    $suelo->setTipo('Equipamiento Comunitario');
                    $suelo->setNombre($datos['DestinoSuelo']['equipamiento']['nombre'][$i]);
                    $suelo->setSuperficie($datos['DestinoSuelo']['equipamiento']['superficie'][$i]);
                    $suelo->setUrbanizacion($urbanizacion);
                    $entityManager->persist($suelo);
                }
                
            }
            $entityManager->flush();
        }

        
        $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]);
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]);
        if($loteo != null && $urbanizacion != null){
            $filtro['Loteo'] = $loteo;
            $filtro['Urbanizacion'] = $urbanizacion;
        }

        $filtro['volverUrl'] = 'tramiteU9';
        return $this->render('urbanizacion/formularioU10.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteU11", name="tramiteU11", methods={"POST"})
     */
    public function formularioU11(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']); 

        $datos['Loteo'] = $request->get('Loteo');   
        $datos['Urbanizacion'] = $request->get('Urbanizacion'); 
        if($datos['Loteo'] != null){
            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
            if($loteo == null){
                $loteo = new Loteo();
            }
            $loteo->setDescripcionProyecto($datos['Loteo']['descripcion']);
            $entityManager->persist($loteo);

            if($datos['Urbanizacion'] != null){
                if($datos['Urbanizacion']['check'] == 'Si'){
                    $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]);
                    if($urbanizacion == null){
                        $urbanizacion = new Urbanizacion();
                    }
                    $urbanizacion->setDesarrolloEtapa($datos['Urbanizacion']['etapa']);
                    $entityManager->persist($urbanizacion);
                }
                else if($datos['Urbanizacion']['check'] == 'No'){
                    $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]);
                    if($urbanizacion == null){
                        $urbanizacion = new Urbanizacion();
                    }
                    $urbanizacion->setDesarrolloEtapa(null);
                    $entityManager->persist($urbanizacion);
                }
               
            }
            $entityManager->flush();
        }

        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, "empresa"=>$tramite->getEmpresa()]);
        if($urbanizacion != null){
            $filtro['Urbanizacion'] = $urbanizacion;
        }

        $filtro['volverUrl'] = 'tramiteU10';
        return $this->render('urbanizacion/formularioU11.html.twig', $filtro); 
    }

    /**
     * @Route("/tramiteU12", name="tramiteU12", methods={"POST"})
     */
    public function formularioU12(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        

        $datos['Urbanizacion'] = $request->get('Urbanizacion');
        if($datos['Urbanizacion'] != null){
            
            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
            if($loteo == null){
                $loteo = new Loteo();
            }
            $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, 'empresa'=>$tramite->getEmpresa()]);
            if($urbanizacion == null){
                $urbanizacion = new Urbanizacion();
            }
            $urbanizacion->setRiesgoHidrico($datos['Urbanizacion']['riesgo']);
            $entityManager->persist($urbanizacion);
            $entityManager->flush();
        }

        
        $factibilidadServicio = $entityManager->getRepository(FactibilidadServicio::class)->findOneBy(['urbanizacion' => $urbanizacion]);
        if($factibilidadServicio != null){
            $filtro['Factibilidad'] = $factibilidadServicio;
        }

        $filtro['volverUrl'] = 'tramiteU11';
        return $this->render('urbanizacion/formularioU12.html.twig', $filtro); 
    }
    
    /**
     * @Route("/tramiteU13", name="tramiteU13", methods={"POST"})
     */
    public function formularioU13(Request $request){
        $filtro = $this->getFiltro($request);     
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $datos['Factibilidad'] = $request->get('Factibilidad');
        
        if($datos['Factibilidad'] != null){
            
            $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
            if($loteo == null){
                $loteo = new Loteo();
            }
            $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, 'empresa'=>$tramite->getEmpresa()]);
            if($urbanizacion == null){
                $urbanizacion = new Urbanizacion();
            }
            $factibilidadServicio = $entityManager->getRepository(FactibilidadServicio::class)->findOneBy(['urbanizacion' => $urbanizacion, 'otras' => null]);
            if($factibilidadServicio != null){
                $entityManager->remove($factibilidadServicio);
            }
            $factibilidadServicio = new FactibilidadServicio();
            foreach($datos['Factibilidad'] as $tipo){
                switch($tipo){
                    case 'todos':
                        $factibilidadServicio->setRecoleccionRsu(1);
                        $factibilidadServicio->setCloacasRed(1);
                        $factibilidadServicio->setGas(1);
                        $factibilidadServicio->setEnergiaElectrica(1);
                        $factibilidadServicio->setAguaPotable(1);
                        $factibilidadServicio->setTransportePublico(1);
                        break;
                    case 'rsu':
                        $factibilidadServicio->setRecoleccionRsu(1);
                        break;
                    case 'cloacas':
                        $factibilidadServicio->setCloacasRed(1);
                        break;
                    case 'gas':
                        $factibilidadServicio->setGas(1);
                        break;
                    case 'electrica':
                        $factibilidadServicio->setEnergiaElectrica(1);
                        break;
                    case 'agua':
                        $factibilidadServicio->setAguaPotable(1);
                        break;
                    case 'transporte':
                        $factibilidadServicio->setTransportePublico(1);
                        break;
                }
            }
            $factibilidadServicio->setUrbanizacion($urbanizacion);
            $entityManager->persist($factibilidadServicio);
            $entityManager->flush();
        }

        for($i = 1; $i <= 19; $i++) {
            $filtro['Storage' . $i] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "12." . $i]);
        }
        $factibilidadServicio = $entityManager->getRepository(FactibilidadServicio::class)->findOneBy(['urbanizacion' => $urbanizacion]);
        $otrasFactibilidades = $entityManager->getRepository(FactibilidadServicio::class)->findBy(['urbanizacion' => $urbanizacion, 'recoleccionRsu' => null, 'cloacasRed' => null, 'gas' => null, 'energiaElectrica' => null, 'aguaPotable' => null, 'transportePublico' => null]);
        if($factibilidadServicio != null){
            $filtro['Factibilidad'] = $factibilidadServicio;
            $filtro['Factibilidades'] = $otrasFactibilidades;
        }else{
            $factibilidadServicio = new FactibilidadServicio();
        }
       
        
        $filtro['volverUrl'] = 'tramiteU12';
        return $this->render('urbanizacion/formularioU13.html.twig', $filtro); 
    }
    
    /**
     * @Route("/tramiteU14", name="tramiteU14", methods={"POST"})
     */
    public function formularioU14(Request $request){
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($filtro['idTramite']);
        $loteo = $entityManager->getRepository(Loteo::class)->findOneBy(['tramite' => $tramite]); 
        $urbanizacion = $entityManager->getRepository(Urbanizacion::class)->findOneBy(['loteo' => $loteo, 'empresa'=>$tramite->getEmpresa()]);
        $datos['Factibilidades'] = $request->get('Factibilidades');
        
        if($datos['Factibilidades'] != null){
            
            for( $i = 0; $i < count($datos['Factibilidades']['otras']); $i++){

                $factibilidadServicio = $entityManager->getRepository(FactibilidadServicio::class)->findOneBy(['urbanizacion' => $urbanizacion, 'otras' => $datos['Factibilidades']['otras'][$i]]);
                if ($factibilidadServicio == null){
                    $factibilidadServicio = new FactibilidadServicio();
                }
                $factibilidadServicio->setOtras($datos['Factibilidades']['otras'][$i]);
                $factibilidadServicio->setUrbanizacion($urbanizacion);
                $entityManager->persist($factibilidadServicio);
            }
            $entityManager->flush();
            
        }

        return $this->redirectToRoute('misTramites');
    }


}