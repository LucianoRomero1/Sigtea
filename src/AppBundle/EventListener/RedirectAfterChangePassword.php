<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RedirectAfterChangePassword implements EventSubscriberInterface{

    //Esto sirve para redireccionar a donde yo desee despues de resetear mi contraseña desde el boton '¿Olvidaste tu contraseña?'
    //Y no olvidarse de registrarlo en el services
    private $router;


    public function __construct(RouterInterface $router)
    {
        $this-> router = $router;
    }

    public function onResettingResetSuccess(FormEvent $event)
    {
        $url = $this->router->generate('fos_user_security_login');
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }


    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onResettingResetSuccess'
        ];
    }
}