<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Tramite;
use AppBundle\Entity\ListaTramites;
use AppBundle\Entity\Estado;

class AdminController extends BaseController
{
    /**
     * @Route("/admin/listadoTramite", name="admin/listadoTramite")
     */
    public function listadoTramitesAction(Request $request)
    {
        $filtro = $this->getFiltro($request);
        $entityManager = $this->getDoctrine()->getManager();
        $filtro['Tramites'] = $entityManager->getRepository(Tramite::class)->findAll();
        $filtro['ListadoTramites'] = $entityManager->getRepository(ListaTramites::class)->findAll();
        return $this->render('admin/listadoTramite.html.twig',$filtro);
    }

    /**
     * @Route("/admin/listaUsuarios", name="admin/listaUsuarios")
     */
    public function listaUsuariosAction(Request $request){
      
        $em = $this -> getDoctrine() -> getManager();
        $repository = $em -> getRepository('AppBundle:User');
        $users = $repository -> findAll();
        return $this->render('admin/listaUsuarios.html.twig',[
            'users' => $users
        ]);
    }
    
    /**
     * @Route("/admin/listaTramitesMensaje", name="admin/listaTramitesMensaje")
     */
    public function listaTramitesMensajeAction(Request $request){
        $filtro = $this->getFiltro($request);
        return $this->render('admin/listaTramitesMensaje.html.twig',$filtro);
    }        
}