<?php

namespace App\Entity;

use App\Entity\Mark;
use App\Entity\Category;

class LiquidSearch {

    private $category;

    private $mark;


    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category) 
    {
        $this->category = $category;
    }


    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(Mark $mark)
    {
        $this->mark = $mark;
    }
}