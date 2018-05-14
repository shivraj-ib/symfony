<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Event;
use Symfony\Component\EventDispatcher\Event;
use App\Entity\ToDoList;
/**
 * Description of TaskCreatedEvent
 *
 * @author shivraj
 */
class TaskCreatedEvent extends Event
{
    const NAME = 'task.created';

    protected $task;

    public function __construct(ToDoList $task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }
}