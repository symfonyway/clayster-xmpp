<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 21.09.2018
 */

namespace Fabiang\Xmpp\Clayster\EventListener\Stream;

use Fabiang\Xmpp\Event\XMLEvent;
use Fabiang\Xmpp\EventListener\AbstractEventListener;
use Fabiang\Xmpp\EventListener\BlockingEventListenerInterface;

/**
 * Class ActionRequest
 * @package Fabiang\Xmpp\Clayster\EventListener\Stream
 */
class ActionRequest extends AbstractEventListener implements BlockingEventListenerInterface
{
    /**
     * Blocking.
     *
     * @var boolean
     */
    private $blocking = false;

    /**
     * {@inheritDoc}
     */
    public function attachEvents()
    {
        $this->getOutputEventManager()
            ->attach('{urn:clayster:cdo}actionrequest', [$this, 'query'])
        ;

        $this->getInputEventManager()
            ->attach('{urn:clayster:cdo}actionresponse', [$this, 'result'])
        ;
    }

    /**
     * Sending a query request for roster sets listener to blocking mode.
     *
     * @return void
     */
    public function query()
    {
        $this->blocking = true;
    }

    /**
     * Result received.
     *
     * @param \Fabiang\Xmpp\Event\XMLEvent $event
     * @return void
     */
    public function result(XMLEvent $event)
    {
        if ($event->isEndTag()) {
            $element = $event->getParameter(0);
            $t = $element->textContent;

            $this->blocking = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isBlocking()
    {
        return $this->blocking;
    }
}
