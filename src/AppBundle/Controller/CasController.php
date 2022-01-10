<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Usuario;

class CasController extends Controller {

    /**
     * @Route("/validar", name="validar" , methods={"POST"})
     */
    public function validar(Request $request){
        //$usuario['Usuario'] = $request->get('Usuario');
        //$entityManager = $this->getDoctrine()->getManager();
        //$usuario = $entityManager->getRepository(Usuario::class)->findOneBy([ "iup"=> $usuario['Usuario']['iup'] ]);
        //$usuarios = $entityManager->getRepository(Usuario::class)->findAll();
        $filtro = $this->getFiltro($request);
        return $this->redirectToRoute("misTramites");
    }

    public function failureAction() {//
        $this->addFlash('info'
                , 'El usuario autenticado no posee los permisos necesarios.'
                . ' <a href="' . $this->generateUrl('admin_login_cas') . '" title="Reintentar">Reintentar aquí</a>'
        );
        return $this->render('failureCAS.html.twig');
    }

    public function getFiltro(Request $request){
        $valores = $request->query->all();
        $filtro = [];
        if($valores != []){
            $filtro = ['rol'=> $valores];            
        }else{
            $filtro = ['rol'=> ""];            
        }
        if($request->get("idTramite")!= null ){
            $filtro = ['idTramite' => $request->get('idTramite')];
        }
        return $filtro;
    }
}
