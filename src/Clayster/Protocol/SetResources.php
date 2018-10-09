<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 09.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol;

use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class SetResources
 * @package Fabiang\Xmpp\Clayster\Protocol
 */
class SetResources implements ProtocolImplementationInterface
{
    /**
     * Devices serials number array.
     * @var array
     */
    private $serials;

    /**
     * SetResources constructor.
     * @param array $serials
     */
    public function __construct(array $serials)
    {
        $this->serials = $serials;
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        $message = '<message to="cdo.example.com">' .
            '<actionrequest name="setclaimkey" id="' . XML::generateId() . '" xmlns="urn:clayster:cdo">' .
                '<entitysetclaimkey>' .
                    '<claimkey>'
        ;

        foreach ($this->serials as $serial) {
            $message .= '<string>' . $serial . '</string>';
        }

        $message .= '</claimkey>'.
                '</entitysetclaimkey>' .
            '</actionrequest>' .
            '</message>'
        ;

        return $message;
    }
}
