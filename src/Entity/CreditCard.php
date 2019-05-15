<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreditCard
 *
 * @ORM\Table(name="credit_card", indexes={@ORM\Index(name="fk_user_card", columns={"user"})})
 * @ORM\Entity
 */
class CreditCard
{
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=12, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="cvv", type="string", length=3, nullable=false, options={"fixed"=true})
     */
    private $cvv;

    /**
     * @var string
     *
     * @ORM\Column(name="end_date", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255, nullable=false)
     */
    private $owner;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id_user")
     * })
     */
    private $user;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
