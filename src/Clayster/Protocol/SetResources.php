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
     * Devices serial numbers array.
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
        $message = '<message to="cdo.sandbox.clayster.com">' .
//        $message = '<message to="cdo.example.com">' .
            '<actionrequest name="setresources" id="' . XML::generateId() . '" xmlns="urn:clayster:cdo">' .
                '<entitysetresources>' .
                    '<resources>' .
                        '<list>'
        ;

        foreach ($this->serials as $serial) {
            $message .= '<resource><path><resourcepath>' . "HomeGate/$serial" . '</resourcepath></path>' .
                '<capabilities><list><string>Secure smart home IOT platform</string></list></capabilities>' .
                '<supportedverbs><list><dataverb>GET</dataverb><dataverb>SET</dataverb></list></supportedverbs>' .
                '</resource>'
            ;
        }

        $message .=     '</list>' .
                    '</resources>'.
                '</entitysetresources>' .
            '</actionrequest>' .
            '</message>'
        ;

        return $message;
    }
}
