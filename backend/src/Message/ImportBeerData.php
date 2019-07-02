<?php

namespace App\Message;

class ImportBeerData
{
    private $content;

    /**
     * ImportBeerData constructor.
     * @param array $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}