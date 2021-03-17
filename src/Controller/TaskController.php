<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

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
         $task = $taskRepository->findAll();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {  
            $jsonData = array();  
            $idx = 0;  
            foreach($task as $tasks) {  
                $temp = array(
                    'name' => $tasks->getName(),  
                    'description' => $tasks->getDescription(),  
                );   
                $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        } else {

        return $this->render('task/index.html.twig',[
            'task' => $taskRepository->findAll(),
            'form' => $form->createView(),
        ]);
        }
    }

    /**
     * @Route("/task", name="task_ajax")
     */  
    public function ajaxAction(Request $request, TaskRepository $taskRepository)
     {
         $task = $taskRepository->findAll();
        if ($request->isXmlHttpRequest() || $request->query->get('id') == 1) {  
            $jsonData = array();  
            $idx = 0;  
            foreach($task as $tasks) {  
                $temp = array(
                    'name' => $tasks->getName(),  
                    'description' => $tasks->getDescription(),  
                );   
                $jsonData[$idx++] = $temp;  
            } 
            return new JsonResponse($jsonData); 
        } else { 
            return $this->render('task/index.html.twig'); 
        }
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
