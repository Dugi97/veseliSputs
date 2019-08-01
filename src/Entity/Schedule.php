<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;


    /**
     * @ORM\Column(type="string", length=25)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TimeSlot", inversedBy="schedule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $timeSlot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Boat", inversedBy="schedule")
     */
    private $boat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lunch", inversedBy="schedule")
     */
    private $lunch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
       $this->email = $email;
       return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getTimeSlot(): ?TimeSlot
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(?TimeSlot $timeSlot): self
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    public function getBoat(): ?Boat
    {
        return $this->boat;
    }

    public function setBoat(?Boat $boat): self
    {
        $this->boat = $boat;

        return $this;
    }

    public function getLunch(): ?Lunch
    {
        return $this->lunch;
    }

    public function setLunch(?Lunch $lunch): self
    {
        $this->lunch = $lunch;

        return $this;
    }
    public function __construct($username , $email , $phone ,Boat $boat ,Lunch $lunch ,TimeSlot $timeSlot)
    {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPhoneNumber($phone);
        $this->setBoat($boat);
        $this->setLunch($lunch);
        $this->setTimeSlot($timeSlot);
    }
}
