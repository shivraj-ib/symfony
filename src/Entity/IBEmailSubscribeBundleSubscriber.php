<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IBEmailSubscribeBundleSubscriberRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="You have already subscribed."
 * )
 */
class IBEmailSubscribeBundleSubscriber
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please enter email id")
     * @Assert\Email(message="the email '{{ value }}' is not a valid email.")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    public function getId()
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
