<?php

namespace Jaguero\SimpleFaqBundle\Event;

use Flowcode\DashboardBundle\Event\ListPluginsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ListPluginsSubscriber implements EventSubscriberInterface
{
    protected $router;
    protected $translator;

    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ListPluginsEvent::NAME => array('handler', 0),
        );
    }


    public function handler(ListPluginsEvent $event)
    {
        $plugins = $event->getPluginDescriptors();

        /* add default */
        $plugins[] = array(
            "name" => "Simple FAQ",
            "image" => null,
            "version" => "v0.1",
            "settings" => $this->router->generate('admin_question'),
            "description" => $this->translator->trans('plugin.description', array(), 'JagueroSimpleFaq'),
            "website" => null,
            "authors" => array(
                array(
                    "name" => "Juan Manuel Aguero",
                    "email" => "jaguero@flowcode.com.ar",
                    "website" => "http://juanmaaguero.com",
                ),
            ),
        );

        $event->setPluginDescriptors($plugins);

    }
}