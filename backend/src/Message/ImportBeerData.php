<?php

namespace App\Message;

class ImportBeerData
{
    private $content;

    /**
     * ImportBeerData constructor.
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}