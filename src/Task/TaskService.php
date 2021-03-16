<?php 

namespace App\Task;

use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TaskService
{
    private $session;
    private $taskRepository;
    public function __construct(SessionInterface $session, TaskRepository $taskRepository)
    {
        $this->session = $session;
        $this->taskRepository = $taskRepository;
    }

    protected function getTask():array
    {
        return $this->session->get('task', []);
    }

    public function getTotal() :int
    {
        $total = 0;
        foreach ($this->getTask() as $id => $this->taskRepository->ge)
        {
            $counter = $this->taskRepository->find($id);
            
        }
        return $total;
    }
}