<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 16.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol\Search;

use Fabiang\Xmpp\Clayster\Protocol\AbstractActionRequest;

/**
 * Class SearchEntities
 * @package Fabiang\Xmpp\Clayster\Protocol\Search
 */
class SearchEntitiesByOwner extends AbstractActionRequest
{
    /**
     * @var string
     */
    private $ownerId;

    /**
     * SearchEntitiesByOwner constructor.
     * @param string $ownerId
     */
    public function __construct($ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @inheritdoc
     */
    protected function addParameters()
    {
        $this->message .=
            '<entitysearch>' .
            '<searchentities>' .
            '<entitysearchparameters>' .
            "<owner><entityid>{$this->ownerId}</entityid></owner>" .
            '</entitysearchparameters>' .
            '</searchentities>' .
            '<maxitems><integer>2147483647</integer></maxitems>' .
            '<startindex><integer>0</integer></startindex>' .
            '</entitysearch>'
        ;
    }

    /**
     * @inheritdoc
     */
    protected function getActionRequestName()
    {
        return 'search';
    }
}
