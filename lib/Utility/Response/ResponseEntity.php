<?php

namespace Utility\Response;

use Utility\ArrayableInterface;

/**
 * Class ResponseEntity
 */
abstract class ResponseEntity implements ArrayableInterface
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $related;

    /**
     * @var array
     */
    private $links;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->type = (string)$this->defineType();
        $this->data = $this->defineData();
        $this->related = $this->defineRelated();
        $this->links = $this->defineLinks();
    }

    /**
     * @return array|null
     */
    protected function defineData()
    {
        return null;
    }

    /**
     * @return string
     */
    protected abstract function defineType();

    /**
     * @return array
     */
    protected function defineRelated()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function defineLinks()
    {
        return array();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'type' => $this->type,
            'data' => $this->data,
            'related' => $this->related,
            'links' => $this->links,
        );
    }
}
