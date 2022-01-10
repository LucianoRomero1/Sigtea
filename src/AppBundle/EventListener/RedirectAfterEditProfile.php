<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RedirectAfterEditProfile implements EventSubscriberInterface{


    private $router;

    public function __construct(RouterInterface $router)
    {
        $this-> router = $router;
    }

    public function onProfileEditSuccess(FormEvent $event)
    {
        $url = $this->router->generate('fos_user_profile_show');
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }


    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onProfileEditSuccess'
        ];
    }

}