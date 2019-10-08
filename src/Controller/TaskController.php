<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $taskRepository = $em->getRepository(Task::class);

        $tasks = $taskRepository->findBy([], ['id' => 'DESC']);

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController'
            , 'tasks' => $tasks
        ]);
    }

    public function detail(Task $task){
        if(!$task){
            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/detail.html.twig', [
           'task' => $task
        ]);
    }

    public function create(Request $request){
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setUser($this->getUser());
            $task->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView()
            , 'isNewRecord' => TRUE
        ]);
    }

    public function update(Request $request, Task $task){
        $user = $this->getUser();

        if(!$user || $user->getId() != $task->getUser()->getId()){
            return $this->redirectToRoute('tasks');
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $task->setUser($user);
            $task->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('tasks');
        }

        return $this->render('task/form.html.twig', [
            'form' => $form->createView()
            , 'isNewRecord' => FALSE
        ]);
    }

    public function myTasks(UserInterface $user){
        $tasks = $user->getTasks();

        return $this->render('task/my-tasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

}
