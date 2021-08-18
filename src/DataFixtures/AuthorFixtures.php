<?php
/**
 * Author fixture.
 */

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AuthorFixtures
 * @package App\DataFixtures
 */
class AuthorFixtures extends AbstractBaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'author', function ($i) {
            $author = new Author();
            $author->setName($this->faker->word);
            $author->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $author->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

            return $author;
        });

        $manager->flush();
    }
}
