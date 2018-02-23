<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CoreShop\Behat\Service\SharedStorageInterface;
use CoreShop\Component\Core\Model\CategoryInterface;
use CoreShop\Component\Core\Model\StoreInterface;
use CoreShop\Component\Core\Repository\CategoryRepositoryInterface;
use CoreShop\Component\Resource\Factory\FactoryInterface;
use Pimcore\Model\DataObject\Folder;

final class CategoryContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var FactoryInterface
     */
    private $categoryFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(SharedStorageInterface $sharedStorage, FactoryInterface $categoryFactory, CategoryRepositoryInterface $categoryRepository)
    {
        $this->sharedStorage = $sharedStorage;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Given /^the site has a category "([^"]+)"$/
     */
    public function theSiteHasACategory(string $categoryName)
    {
        $category = $this->createCategory($categoryName);

        $this->saveCategory($category);
    }

    /**
     * @param string $categoryName
     * @param StoreInterface|null $store
     *
     * @return CategoryInterface
     */
    private function createCategory(string $categoryName, StoreInterface $store = null)
    {
        if (null === $store && $this->sharedStorage->has('store')) {
            $store = $this->sharedStorage->get('store');
        }

        /** @var CategoryInterface $category */
        $category = $this->categoryFactory->createNew();

        $category->setKey($categoryName);
        $category->setParent(Folder::getByPath('/'));
        $category->setName($categoryName, 'en');

        if (null !== $store) {
            $category->setStores([$store->getId()]);
        }

        return $category;
    }

    /**
     * @param CategoryInterface $category
     */
    private function saveCategory(CategoryInterface $category)
    {
        $category->save();
        $this->sharedStorage->set('category', $category);
    }
}