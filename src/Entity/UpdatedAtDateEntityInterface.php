<?php

namespace App\Entity;

interface UpdatedAtDateEntityInterface
{
    public function setUpdatedAt(\DateTimeInterface $updatedAt): UpdatedAtDateEntityInterface;

}
