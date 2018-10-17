<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 12.10.2018
 */

namespace Fabiang\Xmpp\Clayster\EventListener\Stream;

use Fabiang\Xmpp\EventListener\BlockingEventListenerInterface;
use Fabiang\Xmpp\EventListener\AbstractEventListener;

/**
 * Class BaseBlockingEventListener
 * @package Fabiang\Xmpp\Clayster\EventListener\Stream
 */
abstract class AbstractBlockingEventListener extends AbstractEventListener implements BlockingEventListenerInterface
{
    /**
     * Blocking.
     *
     * @var boolean
     */
    private $blocking = false;

    /**
     * Start blocking stream.
     */
    public function startBlocking()
    {
        $this->setBlocking(true);
    }

    /**
     * Sets Blocking
     *
     * @param bool $blocking
     *
     * @return AbstractBlockingEventListener
     */
    public function setBlocking($blocking)
    {
        $this->blocking = $blocking;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isBlocking()
    {
        return $this->blocking;
    }
}
