<?php

namespace Lavary\Menu\Element;

use Lavary\Menu\Common\Attr;

class Ol extends Element implements ElementInterface
{
    /**
     * Stores attributes of the <ul> tag
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Stores attributes of the inner <ul> tags
     *
     * @var array
     */
    protected $dropdown = [];

    /**
     * Instantiates the formatter
     *
     */
    public function __construct(array $attributes = [], array $dropdown = [])
    {
        $this->attributes = $attributes;
        $this->dropdown   = $dropdown;
    }

    /**
     * Returns the menu as an unordered list.
     *
     * @param \Lavary\Menu\Collection $collection
     *
     * @return string
     */
    public function render(\Lavary\Menu\Collection $collection)
    {
        return '<ol' . Attr::printAttributes($this->attributes) . '>' . static::populate($collection, 'ol', $this->dropdown) . '</ol>';
    }
}
