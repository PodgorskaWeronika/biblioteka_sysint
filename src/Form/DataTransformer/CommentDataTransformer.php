<?php
/**
 * Comment data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class CommentDataTransformer.
 */
class CommentDataTransformer implements DataTransformerInterface
{
    /**
     * Comment repository.
     *
     * @var \App\Repository\CommentRepository
     */
    private $repository;

    /**
     * CommentDataTransformer constructor.
     *
     * @param \App\Repository\CommentRepository $repository Comment repository
     */
    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Transform array of comments to string of names.
     *
     * @param \Doctrine\Common\Collections\Collection $comments Comment entity collection
     *
     * @return string Result
     */
    public function transform($comments): string
    {
        if (null == $comments) {
            return '';
        }

        $commentNames = [];

        foreach ($comments as $comment) {
            $commentNames[] = $comment->getTitle();
        }

        return implode(',', $commentNames);
    }

    /**
     * Transform string of comment names into array of Comment entities.
     *
     * @param string $value String of comment names
     *
     * @return array Result
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function reverseTransform($value): array
    {
        $commentTitles = explode(',', $value);

        $comments = [];

        foreach ($commentTitles as $commentTitle) {
            if ('' !== trim($commentTitle)) {
                $comment = $this->repository->findOneByTitle(strtolower($commentTitle));
                if (null == $comment) {
                    $comment = new Comment();
                    $comment->setTitle($commentTitle);
                    $this->repository->save($comment);
                }
                $comments[] = $comment;
            }
        }

        return $comments;
    }
}