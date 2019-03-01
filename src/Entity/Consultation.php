<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConsultationRepository")
 */
class Consultation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creneau;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dentiste", inversedBy="consultation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dentiste;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Patient", inversedBy="consultation")
     */
    private $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreneau(): ?\DateTimeInterface
    {
        return $this->creneau;
    }

    public function setCreneau(\DateTimeInterface $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getDentiste(): ?Dentiste
    {
        return $this->dentiste;
    }

    public function setDentiste(?Dentiste $dentiste): self
    {
        $this->dentiste = $dentiste;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
