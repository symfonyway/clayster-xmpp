<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 12.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol;

use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class StartSession
 * @package Fabiang\Xmpp\Clayster\Protocol
 */
class StartSession implements ProtocolImplementationInterface
{
    /**
     * @var
     */
    private $sessionId;

    /**
     * StartSession constructor.
     * @param string $sessionId
     */
    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function toString()
    {
        $timeouts = new \DateTime();
        $timeouts->add(new \DateInterval('PT20S'));
        $timeouts->setTimezone(new \DateTimeZone('UTC'));
        $ackTimeouts = new \DateTime();
        $ackTimeouts->add(new \DateInterval('PT30S'));
        $ackTimeouts->setTimezone(new \DateTimeZone('UTC'));



        return '<message to="cdo.sandbox.clayster.com">' .
            '<actionrequest name="startsession" id="' . XML::generateId() . '" xmlns="urn:clayster:cdo" ' .
            'acktimeouts="'.$ackTimeouts->format('Y-m-d\TH:i:s\Z').'" timeouts="'.$timeouts->format('Y-m-d\TH:i:s\Z').'">' .
            '<entitystartsession>' .
            "<sessionid><string>{$this->sessionId}</string></sessionid>" .
            '</entitystartsession>' .
            '</actionrequest></message>'
        ;
    }
}
