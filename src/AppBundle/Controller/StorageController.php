<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\StorageService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use AppBundle\Entity\Tramite;

class StorageController extends Controller
{
    /**
     * @Route("/actionTest", name="actionTest")
     */
    public function actionTest(Request $request)
    {
        $filtro = $this->getFiltro($request);
            
        return $this->render('default/archivos.html.twig',$filtro);
        

    }

    /**
     * @Route("/archivo",methods={"POST"}, name="archivo")
     */
    public function archivo(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $inciso = $_REQUEST['inciso'];
        $tramite = $entityManager->getRepository(Tramite::class)->find($_REQUEST['tramite']);
        
        foreach($request->files->get("files") as $file){

            $storage = new StorageService( $entityManager );
            
            if ($storage->generarUID($file)){

                $storage->crearDirectorio();
                $storage->subirArchivo($inciso, $tramite);
                
            }else{
                return new JsonResponse([
                    'success' => false,
                    'res' => "ERROR: Uno de sus archivos no es PDF"
                ]);
            }
        }
        return new JsonResponse([
            'success' => true,
            'res' => "Se cargaron correctamente el/los archivo/s!"
        ]);
    }

    /**
     * @Route("/actionDownload/{uid}", name="actionDownload")
     */
    public function actionDownload(Request $request,$uid)
    {
        // Recibo por get/ el uid

        $storage = new StorageService($this->getDoctrine()->getManager(),$uid);

        return new BinaryFileResponse($storage->getArchivo($uid));
    }

    public function getFiltro(Request $request){
        $rol = $request->query->all();
        $filtro = [];
        if(isset($rol)){
            $filtro = ['rol'=> $rol];            
        }
        return $filtro;
    }
    
}