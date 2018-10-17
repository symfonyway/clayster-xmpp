<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 16.10.2018
 */

namespace Fabiang\Xmpp\Clayster\EventListener\Stream;

use Fabiang\Xmpp\Event\XMLEvent;

/**
 * Class ResourceSearchObject
 * @package Fabiang\Xmpp\Clayster\EventListener\Stream
 */
class ResourceSearchObject extends AbstractBlockingEventListener
{
    /**
     * @inheritdoc
     */
    public function attachEvents()
    {
        $input = $this->getInputEventManager();
        $input->attach('{urn:clayster:cdo}resourcesearchobject', [$this, 'response']);
    }

    /**
     * @param \Fabiang\Xmpp\Event\XMLEvent $event
     */
    public function response(XMLEvent $event)
    {
        if ($event->isEndTag()) {
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

        /** @var \DOMNode $node */
        foreach ($element->childNodes as $node) {
            if ($node->nodeName == 'path') {
                $options = $this->getOptions()->getResponseContextOptions();
                $options['resource'][] = ['resource_path' => $node->textContent];
                $this->getOptions()->setResponseContextOptions($options);
            }
        }
    }
}
