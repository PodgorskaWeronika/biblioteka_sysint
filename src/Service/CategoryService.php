<?php
/**
 * Category service.
 */
namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use PhpCsFixer\FixerConfiguration\DeprecatedFixerOption;

/**
 * Class CategoryService.
 */
class CategoryService
{
    private $categoryRepository;

    private $paginator;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository Category repository
     * @param $paginator                             Paginator interface
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator)
        {
            $this->categoryRepository = $categoryRepository;
            $this->paginator = $paginator;
        }

    public function createPaginatedList(int $page): PaginatorInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    public function save(Category $category ):void
    {
        $this->categoryRepository->save($category);
    }

    public function delete(Category $category):void
    {
        $this->categoryRepository->delete($category);
    }

}