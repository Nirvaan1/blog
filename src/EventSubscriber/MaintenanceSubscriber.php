<?php

namespace App\EventSubscriber;

use Symfony\Bundle\TwigBundle\DependencyInjection\Compiler\TwigEnvironmentPass;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    public function __construct(
     private Environment $twig
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
                KernelEvents::RESPONSE => 'methodCallOnKernelResponse'
        ];
    }

    public function methodCallOnKernelResponse(ResponseEvent $responseEvent)
    {
        $maintenance = false;
        if ($maintenance){
            $content = $this->twig->render('maintenance/maintenance.html.twig');

            $response = new Response($content);

            $responseEvent->setResponse($response);
        }
        return $responseEvent->getResponse()->getContent();
    }
}