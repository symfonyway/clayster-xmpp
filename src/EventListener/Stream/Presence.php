<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 20.09.2018
 */

namespace Fabiang\Xmpp\EventListener\Stream;

use Fabiang\Xmpp\Event\XMLEvent;
use Fabiang\Xmpp\EventListener\AbstractEventListener;
use Fabiang\Xmpp\EventListener\BlockingEventListenerInterface;

/**
 * Class Presence
 * @package Fabiang\Xmpp\EventListener\Stream
 */
class Presence extends AbstractEventListener implements BlockingEventListenerInterface
{
    /**
     * Blocking.
     *
     * @var boolean
     */
    protected $blocking = false;

    /**
     * {@inheritDoc}
     */
    public function attachEvents()
    {
        $this->getOutputEventManager()
            ->attach('{jabber:client}presence', [$this, 'query'])
        ;
        $this->getInputEventManager()
            ->attach('{jabber:client}presence', [$this, 'result'])
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
