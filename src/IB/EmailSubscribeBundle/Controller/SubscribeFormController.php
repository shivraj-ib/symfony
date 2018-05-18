<?php
/**
 * Description of SubscribeFormController
 *
 * @author shivraj
 */


namespace App\IB\EmailSubscribeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\IBEmailSubscribeBundleSubscriber;

/**
 * @Route(name="ib_emailsubscribe_")
 */
class SubscribeFormController extends Controller
{
    
    /**
     * 
     * @Route("/add_new_subscriber",name="add_new")
     */
    public function addNewItem(Request $request) 
    {
        $subscriber = new IBEmailSubscribeBundleSubscriber();

        $form = $this->createFormBuilder($subscriber)
                ->setAction($this->generateUrl('ib_emailsubscribe_add_new'))
                ->add('email', EmailType::class)                
                ->add('save', SubmitType::class, array('label' => 'Subscribe'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $subscriber = $form->getData();
            
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($subscriber);
            $em->flush();            
            
            $this->addFlash(
                'notice',
                'You have subscribed successfully !!'
            );
            
            return $this->redirectToRoute('home_url');
        }

        return $this->render('@IBEmailSubscribe/form.html.twig', array(
                    'form' => $form->createView(),
        ));
    }
    
}
