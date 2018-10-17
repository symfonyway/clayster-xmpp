<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 11.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol;

use Fabiang\Xmpp\Protocol\ProtocolImplementationInterface;
use Fabiang\Xmpp\Util\XML;

/**
 * Class RequestSession
 * @package Fabiang\Xmpp\Clayster\Protocol
 */
class RequestSession implements ProtocolImplementationInterface
{
    /**
     * @var string
     */
    private $entityId;

    /**
     * @var
     */
    private $resourcePath;

    /**
     * RequestSession constructor.
     * @param string $entityId
     * @param string $resourcePath
     */
    public function __construct($entityId, $resourcePath)
    {
        $this->entityId = $entityId;
        $this->resourcePath = $resourcePath;
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

        $message = '<message to="cdo.sandbox.clayster.com">' .
            '<actionrequest name="requestsession" id="' . XML::generateId() . '" xmlns="urn:clayster:cdo" ' .
            'acktimeouts="'.$ackTimeouts->format('Y-m-d\TH:i:s\Z').'" timeouts="'.$timeouts->format('Y-m-d\TH:i:s\Z').'">' .
            '<entityrequestsession>' .
            '<targetentity>' .
            "<entityid>{$this->entityId}</entityid>" .
            '</targetentity>' .
'<resourceaccessrights><list>'.
    	'<resourceaccess>
    		<path>
    		    <resourcepath>'.$this->resourcePath.'</resourcepath>
    		</path>
    		<subordinates>
    			<boolean>false</boolean>
    		</subordinates>
    		<verbs>
	        	<list>
	            	<dataverb>GET</dataverb>
	                <dataverb>SET</dataverb>
	            </list>
    		</verbs>
    	</resourceaccess>' .
            '</list></resourceaccessrights>' .
            '</entityrequestsession></actionrequest></message>'
        ;

        return $message;
    }
}
