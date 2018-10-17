<?php
/**
 * Created by PhpStorm.
 * User: Alex alex.n@symfonyart.com
 * Date: 16.10.2018
 */

namespace Fabiang\Xmpp\Clayster\Protocol\Search;

use Fabiang\Xmpp\Clayster\Protocol\AbstractActionRequest;

/**
 * Class SearchResourcesByEntity
 * @package Fabiang\Xmpp\Clayster\Protocol\Search
 */
class SearchResourcesByEntity extends AbstractActionRequest
{
    /**
     * @var string
     */
    private $entityId;

    /**
     * SearchResourcesByEntity constructor.
     * @param string $entityId
     */
    public function __construct($entityId)
    {
        $this->entityId = $entityId;
    }

    /**
     * @inheritdoc
     */
    protected function addParameters()
    {
        $this->message .=
            '<entitysearch>' .
            "<searchresources><resourcesearchparameters><entity><entityid>{$this->entityId}</entityid></entity></resourcesearchparameters></searchresources>" .
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
