<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task", methods={"GET","POST"})
     * @Route("/task{id}", name="task_edit", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em, TaskRepository $taskRepository):Response
    {   
        $task = new Task();        
          
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('task');
        }
        return $this->render('task/index.html.twig',[
            'task' => $taskRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }  
    

    /**
     * @Route("/task{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Task $task): Response
    {
        if($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }
        return $this->redirectToRoute('task');
    }

    
}
