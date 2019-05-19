<?php

namespace App\Entity;

class LiquidSearch {

    private $category;

    private $mark;


    public function getCategory(): ?int
    {
        return $this->category;
    }


    public function getMark(): ?string
    {
        return $this->mark;
    }
}