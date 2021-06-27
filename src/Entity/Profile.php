<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 */
class Profile
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayedToPeers;

    /**
     * @ORM\Column(type="text")
     */
    private $essay;

    /**
     * @ORM\OneToMany(targetEntity=Experience::class, mappedBy="profile")
     */
    private $experiences;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="profile")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="profile")
     */
    private $document;

    /**
     * @ORM\OneToMany(targetEntity=ProfileCompetence::class, mappedBy="profile")
     */
    private $profileCompetence;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $openToWork;

    public function __construct()
    {
        $this->experiences = new ArrayCollection();
        $this->document = new ArrayCollection();
        $this->profileCompetence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getDisplayedToPeers(): ?bool
    {
        return $this->displayedToPeers;
    }

    public function setDisplayedToPeers(bool $displayedToPeers): self
    {
        $this->displayedToPeers = $displayedToPeers;

        return $this;
    }

    public function getEssay(): ?string
    {
        return $this->essay;
    }

    public function setEssay(string $essay): self
    {
        $this->essay = $essay;

        return $this;
    }

    /**
     * @return Collection|Experience[]
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences[] = $experience;
            $experience->setProfile($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): self
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getProfile() === $this) {
                $experience->setProfile(null);
            }
        }

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
     * @return Collection|Document[]
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->document->contains($document)) {
            $this->document[] = $document;
            $document->setProfile($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->document->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getProfile() === $this) {
                $document->setProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfileCompetence[]
     */
    public function getProfileCompetence(): Collection
    {
        return $this->profileCompetence;
    }

    public function addProfileCompetence(ProfileCompetence $profileCompetence): self
    {
        if (!$this->profileCompetence->contains($profileCompetence)) {
            $this->profileCompetence[] = $profileCompetence;
            $profileCompetence->setProfile($this);
        }

        return $this;
    }

    public function removeProfileCompetence(ProfileCompetence $profileCompetence): self
    {
        if ($this->profileCompetence->removeElement($profileCompetence)) {
            // set the owning side to null (unless already changed)
            if ($profileCompetence->getProfile() === $this) {
                $profileCompetence->setProfile(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOpenToWork(): ?bool
    {
        return $this->openToWork;
    }

    public function setOpenToWork(?bool $openToWork): self
    {
        $this->openToWork = $openToWork;

        return $this;
    }
}
