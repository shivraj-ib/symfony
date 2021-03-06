<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ToDoListRepository")
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please enter title")
     * @ORM\Column(type="string", length=250)
     */
    private $title;
    
    /**
     * @Assert\NotBlank(message="Please enter description")     
     * @ORM\Column(type="string", length=500)
     */
    private $description;
    
    /**
     * @Assert\GreaterThan("today",message="Please select a future date.")
     * @ORM\Column(type="date")
     */
    private $lastDate;
    
    public function getId() {
        return $this->id;
    }
 
    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getLastDate() {
        return $this->lastDate;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setLastDate(\DateTime $last_date) {
        $this->lastDate = $last_date;
    }
    
    /**
     * @Assert\IsTrue(message="The description field can not be same as title")
     */
    public function isDescriptionLegal()
    {
       return $this->title !== $this->description;
    }

}
