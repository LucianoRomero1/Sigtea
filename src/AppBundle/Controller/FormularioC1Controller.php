<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\Storage;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Estado;
use AppBundle\Entity\TramitePlantaExpendio;
use AppBundle\Entity\TratamientoPlantaExterior;
use AppBundle\Entity\MedidaCorrienteDesecho;
use AppBundle\Entity\MonitoreoResiduo;
use AppBundle\Entity\TipoMonitoreo;
use AppBundle\Entity\Residuo;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Planta;
use AppBundle\Entity\Perito;
use AppBundle\Entity\Empresa;
use \DateTime;

class FormularioC1Controller extends BaseController
{
    /**
     * @Route("/formularioc1", name="formularioc1", methods={"POST","GET"})
     */
    public function listadoTramitesAction(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
          
        if($request->get("idTramite")!=0){
            $tramite = $this->getTramite($request->get("idTramite"));
        }else{

            $listaTramite = $entityManager->getRepository(ListaTramites::class)->find(10);
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
        
        if($tramite->getEmpresa() != null){
            $filtro['Persona'] = $entityManager->getRepository(Persona::class)->find($tramite->getEmpresa()->getPersona()); 
        } 
        $filtro['Planta'] = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]); 
        $filtro['Residuo'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$filtro['Planta'], "tipo" => 1]);
        $filtro['PlantaExpendio'] = $entityManager->getRepository(TramitePlantaExpendio::class)->findBy(["residuo"=>$filtro['Residuo']]);
        $filtro['PlantaExterior'] =  $entityManager->getRepository(TratamientoPlantaExterior::class)->findBy(["residuo"=>$filtro['Residuo']]);
        $filtro['Medida'] = $entityManager->getRepository(MedidaCorrienteDesecho::class)->findBy(["residuo"=>$filtro['Residuo']]);
        $filtro['Monitoreo'] = $entityManager->getRepository(MonitoreoResiduo::class)->findBy(["residuo"=>$filtro['Residuo']]);
        $filtro['titulo'] = $tramite->getNombre();
        $filtro['idTramite'] = $tramite->getId();
        return $this->render('formularioc1/formularioc1.html.twig',$filtro);
    }

    /**
     * @Route("/formularioc2", name="formularioc2", methods={"POST", "GET"})
     */
    public function listadoTramitesAction2(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($request->get("idTramite"));
        $datos['Persona'] = $request->get('Persona');
        $datos['Planta'] = $request->get('Planta');
        $datos['Residuo'] = $request->get('Residuo');
        $datos['PlantaExpendio'] = $request->get('PlantaExpendio');
        $datos['PlantaExterior'] = $request->get('PlantaExterior');
        $datos['Medida'] = $request->get('Medida');
        $datos['Monitoreo'] = $request->get('Monitoreo');


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
        }

        if ($datos['Planta'] != null){
            $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]); 
            if ($planta == null){
                $planta = new Planta();
            }
            $planta -> setNombre($datos['Planta']["nombre"]);
            $planta -> setEmpresa($tramite->getEmpresa());
            $entityManager -> persist($planta);
            
        }
        if ($datos['Residuo'] != null){

            for($i=0;$i < count($datos['Residuo']['categoria']);$i++){
                
                $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"categoria" => $datos["Residuo"]["categoria"][$i], "tipo" => 1]);
                if ($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->SetTipo(1);
                $residuo->setProcesoGenerador($datos["Residuo"]["nombre"][$i]);
                $residuo->setCategoria($datos["Residuo"]["categoria"][$i]);
                $residuo->setComponenteRelevante($datos["Residuo"]["composicionQuimica"][$i]);
                $residuo->setEstadoFisico($datos["Residuo"]["estado"][$i]);
                $residuo->setVolumen($datos["Residuo"]["cantidad"][$i]);
                $residuo->setGestion($datos["Residuo"]["tratamiento"][$i]);
                $residuo->setReceptor($datos["Residuo"]["receptor"][$i]);
                $residuo->setPlanta($planta);
                $entityManager->persist($residuo);
                $entityManager -> flush();

                $tramitePlantaExpendio = $entityManager->getRepository(TramitePlantaExpendio::class)->findOneBy(["residuo"=>$residuo,"numeroDestruccion" => $datos["PlantaExpendio"]["destruccion"][$i]]);
                if ($tramitePlantaExpendio == null){
                    $tramitePlantaExpendio = new TramitePlantaExpendio();
                }
                $tramitePlantaExpendio -> setNumeroDestruccion($datos["PlantaExpendio"]["destruccion"][$i]);
                $tramitePlantaExpendio -> setEmpresaTransportadora($datos["PlantaExpendio"]["transportadora"][$i]);
                $tramitePlantaExpendio -> setResiduo($residuo);
                $entityManager -> persist($tramitePlantaExpendio);

                $tratamientoPlantaExterior = $entityManager->getRepository(TratamientoPlantaExterior::class)->findOneBy(["residuo"=>$residuo,"nombre" => $datos["PlantaExterior"]["nombre"][$i]]);
                if ($tratamientoPlantaExterior == null){
                    $tratamientoPlantaExterior = new TratamientoPlantaExterior();
                }
                $tratamientoPlantaExterior -> setNombre($datos["PlantaExterior"]["nombre"][$i]);
                $tratamientoPlantaExterior -> setNumeroDestruccion($datos["PlantaExterior"]["destruccion"][$i]);
                $tratamientoPlantaExterior -> setNumeroRegistro($datos["PlantaExterior"]["registro"][$i]);
                $tratamientoPlantaExterior -> setResiduo($residuo);
                $entityManager -> persist($tratamientoPlantaExterior);

                // MEDIDA CORRIENTE DESECHO
                $medidaCorriente = $entityManager->getRepository(MedidaCorrienteDesecho::class)->findOneBy(["residuo"=>$residuo,"nombre" => $datos["Medida"]["nombre"][$i]]);
                if ($medidaCorriente == null){
                    $medidaCorriente = new MedidaCorrienteDesecho();
                }
                $medidaCorriente -> setNombre($datos["Medida"]["nombre"][$i]);
                $medidaCorriente -> setResiduo($residuo);
                $entityManager -> persist($medidaCorriente);

                // TIPO MONITOREO
                $tipoMonitoreo = $entityManager->getRepository(TipoMonitoreo::class)->findOneBy(["descripcion" => $datos["Monitoreo"]["metodos"][$i]]);
                if ($tipoMonitoreo == null){
                    $tipoMonitoreo = new TipoMonitoreo();
                }
                $tipoMonitoreo -> setDescripcion($datos["Monitoreo"]["metodos"][$i]);
                $entityManager -> persist($tipoMonitoreo);
                
                // MONITOREO DE RESIDUO
                $monitoreo = $entityManager->getRepository(MonitoreoResiduo::class)->findOneBy(["residuo"=>$residuo,"descripcion" => $datos["Monitoreo"]["extraccion"][$i]]);
                if ($monitoreo == null){
                    $monitoreo = new MonitoreoResiduo();
                }
                $monitoreo -> setDescripcion($datos["Monitoreo"]["extraccion"][$i]);
                $monitoreo -> setResiduo($residuo);
                $monitoreo -> setTipoMonitoreo($tipoMonitoreo);
                $entityManager -> persist($monitoreo);

            }     
        }
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]); 
        $entityManager -> flush();
        for($i = 1; $i <= 17; $i++){
            $filtro['Storage' . $i] = $entityManager->getRepository(Storage::class)->findOneBy(["tramite" => $tramite, "inciso" => "C2." . $i]);
        }
        $filtro['titulo'] = $entityManager->getRepository(ListaTramites::class)->find(16)->getDescripcion();
        $filtro['ResiduosPeligrosos'] = $entityManager->getRepository(Residuo::class)->findBy(["planta"=>$planta, "tipo" => 2]);
        return $this->render('formularioc2/formularioc2.html.twig',$filtro);
    }

     /**
     * @Route("/formularioc2Back", name="formularioc2Back", methods={"POST", "GET"})
     */
    public function listadoTramitesAction3(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $tramite = $this->getTramite($request->get("idTramite"));
        $planta = $entityManager->getRepository(Planta::class)->findOneBy(["empresa"=>$tramite->getEmpresa()]); 

        $datos['ResiduosPeligrosos'] = $request->get('ResiduosPeligrosos');
        if($datos['ResiduosPeligrosos'] != null){
            for($i=0;$i < count($datos['ResiduosPeligrosos']['receptor']);$i++){
                $residuo = $entityManager->getRepository(Residuo::class)->findOneBy(["planta"=>$planta,"receptor" => $datos["ResiduosPeligrosos"]["receptor"][$i], "tipo" => 2]);
                if ($residuo == null){
                    $residuo = new Residuo();
                }
                $residuo->SetTipo(2);
                $residuo->setReceptor($datos["ResiduosPeligrosos"]["receptor"][$i]);
                $residuo->setVolumen($datos["ResiduosPeligrosos"]["volumen"][$i]);
                $residuo->setUnidad($datos["ResiduosPeligrosos"]["unidad"][$i]);
                $residuo->setGestion($datos["ResiduosPeligrosos"]["gestion"][$i]);
                $residuo->setComponenteRelevante($datos["ResiduosPeligrosos"]["componenteRelevante"][$i]);
                $residuo->setPlanta($planta);

                $entityManager->persist($residuo);
            }
        }

        $entityManager->flush();
        return $this->redirectToRoute('misTramites');

    }
}
