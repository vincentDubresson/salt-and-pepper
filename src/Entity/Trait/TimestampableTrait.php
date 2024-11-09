<?php

/**
 * This file is part of the Infinite CommonBundle project.
 *
 * (c) Infinite Networks Pty Ltd <http://www.infinite.net.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adds created at and updated at timestamps to entities. Requires that entities are
 * marked with the HasLifecycleCallbacks annotation.
 */
#[ORM\HasLifecycleCallbacks]
trait TimestampableTrait
{
    #[ORM\Column(type: 'datetime')]
    protected \DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTime $updatedAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    public function _timestampable_prePersist(): void
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    #[ORM\PreUpdate]
    public function _timestampable_preUpdate(): void
    {
        $this->updatedAt = new \DateTime('now');
    }
}
