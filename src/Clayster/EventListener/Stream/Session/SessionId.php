<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 12.10.2018
 */

namespace Fabiang\Xmpp\Clayster\EventListener\Stream\Session;

use Fabiang\Xmpp\Event\XMLEvent;
use Fabiang\Xmpp\Clayster\EventListener\Stream\AbstractBlockingEventListener;

/**
 * Class SessionId
 * @package Fabiang\Xmpp\Clayster\EventListener\Stream\Session
 */
class SessionId extends AbstractBlockingEventListener
{
    /**
     * {@inheritDoc}
     */
    public function attachEvents()
    {
        $input = $this->getInputEventManager();
        $input->attach('{urn:clayster:cdo}sessionid', [$this, 'sessionId']);
    }

    public function sessionId(XMLEvent $event)
    {
        if (!$event->isEndTag()) {
            return;
        }

        /* @var $element \DOMElement */
        $element = $event->getParameter(0);
        if (null == $element) {
            return;
        }

        if (!($element instanceof \DOMElement)) {
            return;
        }

        $sessionId = trim($element->textContent);
        if (strlen($sessionId) == 0) {
            return;
        }

        // TODO add additional parameters
        $this->getOptions()->setSid($sessionId);
    }
}
