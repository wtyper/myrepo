<?php
namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();
        if (!$request->hasPreviousSession() || !$user->getLocale()) {
            return;
        }
        $request->getSession()->set('_locale', $user->getLocale());
    }
}
