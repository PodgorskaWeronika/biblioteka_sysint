<?php
/**
 * Task Controller.
 */

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Form\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController.
 *
 * @Route("/task")
 *
 * @IsGranted("ROLE_USER")
 */

class TaskController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request        HTTP request
     * @param \App\Repository\TaskRepository            $taskRepository Task repository
     * @param \Knp\Component\Pager\PaginatorInterface   $paginator      Paginator
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="task_index",
     * )
     */
    public function index(Request $request, TaskRepository $taskRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $taskRepository->queryByAuthor($this->getUser()),
            $request->query->getInt('page', 1),
            TaskRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'task/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * show action
     * @param Task $Task
     * @return Response
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="task_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @IsGranted(
     *     "VIEW",
     *     subject="task",
     * )
     */

    public function show(Task $task): Response
    {
        return $this->render(
            'task/show.html.twig',
             ['task' => $task]
        );
    }
    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\TaskRepository        $taskRepository Task repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="task_create",
     * )
     */

    public function create(Request $request, TaskRepository $taskRepository): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setAuthor($this->getUser());
            $taskRepository->save($task);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/create.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Task                      $task           Task entity
     * @param \App\Repository\TaskRepository        $taskRepository Task repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="task_edit",
     * )
     *
     *     @IsGranted(
     *     "EDIT",
     *     subject="task",
     */

    public function edit(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
        $form = $this->createForm(TaskType::class, $task, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->save($task);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/edit.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }
    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Category                      $category           Category entity
     * @param \App\Repository\CategoryRepository        $categoryRepository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="task_delete",
     * )
     *
     *      @IsGranted(
     *     "DELETE",
     *     subject="task",
     */

    public function delete(Request $request, Task $task, TaskRepository $taskRepository): Response
    {
//        if ($Task->getTasks()->count()) {
//            $this->addFlash('warning', 'message_category_contains_tasks');
//
//            return $this->redirectToRoute('task_index');
//        }

        $form = $this->createForm(TaskType::class, $task, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $taskRepository->delete($task);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('task_index');
        }

        return $this->render(
            'task/delete.html.twig',
            [
                'form' => $form->createView(),
                'task' => $task,
            ]
        );
    }
}