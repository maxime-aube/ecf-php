<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="competence")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=ProfileCompetence::class, mappedBy="competence")
     */
    private $profileCompetences;

    public function __construct()
    {
        $this->profileCompetences = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|ProfileCompetence[]
     */
    public function getProfileCompetences(): Collection
    {
        return $this->profileCompetences;
    }

    public function addProfileCompetence(ProfileCompetence $profileCompetence): self
    {
        if (!$this->profileCompetences->contains($profileCompetence)) {
            $this->profileCompetences[] = $profileCompetence;
            $profileCompetence->setCompetence($this);
        }

        return $this;
    }

    public function removeProfileCompetence(ProfileCompetence $profileCompetence): self
    {
        if ($this->profileCompetences->removeElement($profileCompetence)) {
            // set the owning side to null (unless already changed)
            if ($profileCompetence->getCompetence() === $this) {
                $profileCompetence->setCompetence(null);
            }
        }

        return $this;
    }
}
