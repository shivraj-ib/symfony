<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\ToDoList;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Service\MessageGenerator;
use App\Event\TaskCreatedEvent;
use App\EventListner\TaskCreatedEventListner;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\EventSubscriber\TaskSubscriber;
use Psr\Log\LoggerInterface;

class DefaultController extends Controller
{
    /**
     * 
     * @Route("/",name="home_url")
     */
    public function index(MessageGenerator $messageGenerator)
    {
        $message = $messageGenerator->getHappyMessage();
        $this->addFlash('message', $message);
        $tasks = $this->getDoctrine()
        ->getRepository(ToDoList::class)
        ->findAll();
        return $this->render('index.html.twig',array('tasks' => $tasks));
    }
    
    /**
     * 
     * @Route("/new",name="add_new_task")
     */
    public function addNewItem(Request $request,TaskCreatedEventListner $listener,TaskSubscriber $subscriber) 
    {

        $task = new ToDoList();

        $form = $this->createFormBuilder($task)
                ->add('title', TextType::class)
                ->add('description', TextareaType::class)
                ->add('lastDate', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Add Task'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            /**Event handling **/
            //create new event object
            $event = new TaskCreatedEvent($task);
            //event dispatcher
            $dispatcher = new EventDispatcher();
            //bind even listner with event dispatcher
            $dispatcher->addSubscriber($subscriber);
            //dispatch event
            $dispatcher->dispatch($event::NAME, $event);
            
            
            $this->addFlash(
                'notice',
                'New task added!'
            );
            
            return $this->redirectToRoute('home_url');
        }

        return $this->render('new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
    /**
     * @Route("/delete/{id}",name="delete_task", requirements={"id"="\d+"})
     */
    public function deleteTask($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(ToDoList::class)->find($id);

        if (!$task) {
            $this->addFlash(
                'error',
                'No task found for id =' . $id
            );
            return $this->redirectToRoute('home_url');
        }
        
        $em->remove($task);
        $em->flush();
        
        $this->addFlash(
                'notice',
                'Task removed'
            );
        
        return $this->redirectToRoute('home_url');
    }
    
    /**
     * @Route("/edit/{id}",name="edit_task", requirements={"id"="\d+"})
     */
    public function editTask($id,Request $request){
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(ToDoList::class)->find($id);

        if (!$task) {
            $this->addFlash(
                'error',
                'No task found for id =' . $id
            );
            return $this->redirectToRoute('home_url');
        }
        
        $form = $this->createFormBuilder($task)
                ->add('title', TextType::class)
                ->add('description', TextareaType::class)
                ->add('lastDate', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Edit Task'))
                ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            
            $this->addFlash(
                'notice',
                'Task edited'
            );
            
            return $this->redirectToRoute('home_url');
        }

        return $this->render('new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
}