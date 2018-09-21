<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 21.09.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol;

use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class SetClaimKey
 * @package Fabiang\Xmpp\Clayster\Protocol
 */
class SetClaimKey implements ProtocolImplementationInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * SetClaimKey constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return '<message to="cdo.sandbox.clayster.com" xmlns="jabber:client">' .
            '<actionrequest xmlns="urn:clayster:cdo" id="' . XML::generateId() . '" name="setclaimkey">' .
            '<entitysetclaimkey><claimkey><string>' . $this->key . '</string></claimkey></entitysetclaimkey>' .
            '</actionrequest></message>'
        ;
    }
}
