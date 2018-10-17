<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 16.10.2018
 */

namespace Fabiang\Xmpp\Clayster\EventListener\Stream;

use Fabiang\Xmpp\Event\XMLEvent;

class EntitySearchObject extends AbstractBlockingEventListener
{
    /**
     * @inheritdoc
     */
    public function attachEvents()
    {
        $input = $this->getInputEventManager();
        $input->attach('{urn:clayster:cdo}entitysearchobject', [$this, 'response']);
    }

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
            if ($node->nodeName == 'entity') {
                $options = $this->getOptions()->getResponseContextOptions();
                $options['entity'][] = ['id' => $node->textContent];
                $this->getOptions()->setResponseContextOptions($options);
            }
        }
    }
}
