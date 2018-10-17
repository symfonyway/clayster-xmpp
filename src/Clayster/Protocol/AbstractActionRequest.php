<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 16.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol;

use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class AbstractSearch
 * @package Fabiang\Xmpp\Clayster\Protocol\Search
 */
abstract class AbstractActionRequest implements ProtocolImplementationInterface
{
    static protected $TIME_FORMAT = 'Y-m-d\TH:i:s\Z';

    /**
     * XMPP XML message.
     * @var string
     */
    protected $message;

    /**
     * @return void
     */
    abstract protected function addParameters();

    /**
     * @return string
     */
    abstract protected function getActionRequestName();

    /**
     * @inheritdoc
     */
    public function toString()
    {
        $this->message = '<message to="cdo.sandbox.clayster.com" xml:lang="sv" type="normal">' .
            '<actionrequest xmlns="urn:clayster:cdo" name="' . $this->getActionRequestName(). '" id="' . XML::generateId() .
            '" acktimeouts="' . $this->getAckTimeouts() . '" timeouts="'.$this->getTimeouts().'">'
        ;

        $this->addParameters();

        return $this->message .= '</actionrequest></message>';
    }

    /**
     * @return string
     */
    private function getTimeouts()
    {
        $timeouts = new \DateTime();
        $timeouts->add(new \DateInterval('PT20S'));
        $timeouts->setTimezone(new \DateTimeZone('UTC'));

        return $timeouts->format(self::$TIME_FORMAT);
    }

    /**
     * @return string
     */
    private function getAckTimeouts()
    {
        $ackTimeouts = new \DateTime();
        $ackTimeouts->add(new \DateInterval('PT30S'));
        $ackTimeouts->setTimezone(new \DateTimeZone('UTC'));

        return $ackTimeouts->format(self::$TIME_FORMAT);
    }
}
