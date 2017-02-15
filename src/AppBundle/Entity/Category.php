<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @UniqueEntity(fields="name", message="La categorie  {{ value }} existe déjà.")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commentaries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add commentary
     *
     * @param \AppBundle\Entity\Commentary $commentary
     *
     * @return Category
     */
    public function addCommentary(\AppBundle\Entity\Commentary $commentary)
    {
        $this->commentaries[] = $commentary;
    
        return $this;
    }

    /**
     * Remove commentary
     *
     * @param \AppBundle\Entity\Commentary $commentary
     */
    public function removeCommentary(\AppBundle\Entity\Commentary $commentary)
    {
        $this->commentaries->removeElement($commentary);
    }

    /**
     * Get commentaries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaries()
    {
        return $this->commentaries;
    }
}
