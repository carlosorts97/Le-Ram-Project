<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sizes
 *
 * @ORM\Table(name="sizes", indexes={@ORM\Index(name="fk_stock_size", columns={"stock"}), @ORM\Index(name="IDX_B69E876923A0E66", columns={"article"})})
 * @ORM\Entity
 */
class Sizes
{
    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $size;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="come_up", type="float", precision=10, scale=2, nullable=false)
     */
    private $comeUp;

    /**
     * @var \Articles
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Articles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article", referencedColumnName="id_article")
     * })
     */
    private $article;

    /**
     * @var \Stock
     *
     * @ORM\ManyToOne(targetEntity="Stock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stock", referencedColumnName="id_stock")
     * })
     */
    private $stock;

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getComeUp(): ?float
    {
        return $this->comeUp;
    }

    public function setComeUp(float $comeUp): self
    {
        $this->comeUp = $comeUp;

        return $this;
    }

    public function getArticle(): ?Articles
    {
        return $this->article;
    }

    public function setArticle(?Articles $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }


}
