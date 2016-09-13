<?php

namespace App\Entity\Present;

trait PostPresent
{
    public function isExcellent()
    {
        return $this->is_excellent == 'yes' ? true : false;
    }
}
