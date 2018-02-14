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

class DefaultController extends Controller
{
    /**
     * 
     * @Route("/",name="home_url")
     */
    public function index()
    {
        $tasks = $this->getDoctrine()
        ->getRepository(ToDoList::class)
        ->findAll();
        return $this->render('index.html.twig',array('tasks' => $tasks));
    }
    
    /**
     * 
     * @Route("/new",name="add_new_task")
     */
    public function addNewItem(Request $request) 
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

            return $this->redirectToRoute('home_url');
        }

        return $this->render('new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}