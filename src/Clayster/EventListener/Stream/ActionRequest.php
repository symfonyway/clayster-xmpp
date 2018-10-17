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
     * The action name. For waiting response.
     * @var string
     */
    private $name = null;

    /**
     * {@inheritDoc}
     */
    public function attachEvents()
    {
        $this->getOutputEventManager()
            ->attach('{urn:clayster:cdo}actionrequest', [$this, 'query'])
        ;

        $input = $this->getInputEventManager();
        $input->attach('{urn:clayster:cdo}actionresponse', [$this, 'result']);
        $input->attach('{urn:clayster:cdo}actionrequest', [$this, 'resultError']);
    }

    /**
     * Sending a query request for roster sets listener to blocking mode.
     *
     * @param \Fabiang\Xmpp\Event\XMLEvent $event
     * @return void
     */
    public function query(XMLEvent $event)
    {
        if (!$event->isStartTag()) {
            return;
        }

        /* @var $element \DOMElement */
        $element = $event->getParameter(0);
        if ($element->hasAttribute('name')) {
            $this->name = $element->getAttribute('name');
        }

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
            return;
        }

        if ($this->name == null) {
            $this->blocking = false;
            return;
        }

        $element = $event->getParameter(0);
        if (!$element->hasAttribute('name')) {
            $this->blocking = false;
            return;
        }

        if ($this->name == $element->getAttribute('name')) {
            $this->blocking = false;
        }
    }

    /**
     * Error result received.
     *
     * @param \Fabiang\Xmpp\Event\XMLEvent $event
     * @return void
     */
    public function resultError(XMLEvent $event)
    {
        if ($event->isEndTag()) {
            return;
        }

        if ($this->name == null) {
            $this->blocking = false;
            return;
        }

        $element = $event->getParameter(0);
        if (!$element->hasAttribute('name')) {
            $this->blocking = false;
            return;
        }

        if ($this->name == $element->getAttribute('name')) {
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
