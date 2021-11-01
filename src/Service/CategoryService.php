<?php

namespace App\Service;

class CategoryService
{
    private array $categories = [
        1 => [
            'id' => 1,
            'title' => 'Plans',
            'todos' => [1, 2, 3]
        ],
        2 => [
            'id' => 2,
            'title' => 'Homework',
            'todos' => [4, 5, 6]
        ],
        3 => [
            'id' => 3,
            'title' => 'Other',
            'todos' => [7, 8, 9]
        ]
    ];

    /**
     * @return array{title: string, todos: array}
     */
    final public function getAll(): array
    {
        return $this->categories;
    }
}
