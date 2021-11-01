<?php

namespace App\Controller;

use App\Service\CategoryService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/todo", name="todo_")
 */
class TodoController extends AbstractController
{
    private CategoryService $categoryService;

    private array $todos = [
        1 => [
            'id' => 1,
            'title' => 'Some todo 1',
            'description' => 'Lorem ipsun 1',
            'checked' => false,
            'category_id' => 1
        ],
        2 => [
            'id' => 2,
            'title' => 'Some todo 2',
            'description' => 'Lorem ipsun 2',
            'checked' => true,
            'category_id' => 1
        ],
        3 => [
            'id' => 3,
            'title' => 'Some todo 3',
            'description' => 'Lorem ipsun 3',
            'checked' => true,
            'category_id' => 1
        ],
        4 => [
            'id' => 4,
            'title' => 'Some todo 4',
            'description' => 'Lorem ipsun 4',
            'checked' => false,
            'category_id' => 2
        ],
        5 => [
            'id' => 5,
            'title' => 'Some todo 5',
            'description' => 'Lorem ipsun 5',
            'checked' => false,
            'category_id' => 2
        ],
        6 => [
            'id' => 6,
            'title' => 'Some todo 6',
            'description' => 'Lorem ipsun 6',
            'checked' => true,
            'category_id' => 2
        ],
        7 => [
            'id' => 7,
            'title' => 'Some todo 7',
            'description' => 'Lorem ipsun 7',
            'checked' => false,
            'category_id' => 3
        ],
        8 => [
            'id' => 8,
            'title' => 'Some todo 8',
            'description' => 'Lorem ipsun 8',
            'checked' => false,
            'category_id' => 3
        ],
        9 => [
            'id' => 9,
            'title' => 'Some todo 9',
            'description' => 'Lorem ipsun 9',
            'checked' => true,
            'category_id' => 3
        ]
    ];

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @Route("/", name="todo_list")
     */
    public function list(): Response
    {
        return $this->render('todo/list.html.twig', [
            'todos' => $this->todos,
        ]);
    }

    /**
     * @Route("/{categoryId}", name="list_by_category", requirements={"categoryId"="\d+"})
     * @throws Exception
     */
    public function listByCategory(string $categoryId): Response
    {
        if (!isset($this->categories[(int)$categoryId])) {
            throw new Exception('You ask for category that not exists');
        }

        $categories = $this->categoryService->getAll();
        $category = $categories[(int)$categoryId] ?? null;
        $todosIds = $category['todos'];

        $todos = array_filter($this->todos, static function (array $todo) use ($todosIds) {
            return in_array($todo['id'], $todosIds, true);
        });

        return $this->render('todo/list.html.twig', [
            'todos' => $todos
        ]);
    }

    /**
     * @Route("/{categoryId}/{todoId}", name="get", requirements={"categoryId"="\d+", "todoId"="\d+"})
     * @throws Exception
     */
    public function getTodo(int $categoryId, int $todoId): Response
    {
        if (!isset($this->categories[$categoryId])) {
            throw new Exception('You ask for category that not exists');
        }

        $categories = $this->categoryService->getAll();
        $category = $categories[$categoryId] ?? null;
        $todosIds = $category['todos'];

        $todos = array_filter($this->todos, static function (array $todo) use ($todosIds) {
            return in_array($todo['id'], $todosIds, true);
        });

        if (!isset($todos[$todoId])) {
            throw new Exception('There is no todo in selected category');
        }

        $todo = $todos[$todoId];

        return $this->render('todo/item.html.twig', [
            'todo' => $todo
        ]);
    }
}
