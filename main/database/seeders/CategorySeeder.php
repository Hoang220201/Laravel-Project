<?php

namespace Database\Seeders;

use App\Models\Category;
use Closure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    private $categories; // collection
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $this->categories = collect([
            ['name' => 'Front-End'],
            ['name' => 'Back-End'],
            ['name' => 'JavaScript'],
            ['name' => 'React'],
            ['name' => 'HTML'],
            ['name' => 'CSS'],
            ['name' => 'Jquery'],
            ['name' => 'PHP'],
            ['name' => 'Laravel'],
            ['name' => 'NodeJS']
        ]);

        $arrayCategories = $this->categories->transform(function ($category) {
            return array_merge($category, ['id' => Str::uuid(), 'slug' => str()->slug($category['name'])]);
        })->toArray();

        Category::factory()
            ->count(count($arrayCategories))
            ->state(new Sequence(...$arrayCategories))
            ->afterMaking(function (Category $category) {
                $parent_id = null;

                $categoryExistsInCollect = $this->createFunction(function () use ($category): Closure {
                    return fn(array $categories) => collect($categories)->contains($category->name);
                });

                if ($categoryExistsInCollect(['JavaScript', 'HTML', 'CSS']))
                    $parent_id = $this->getId('Front-End');
                else if ($categoryExistsInCollect(['React', 'Jquery']))
                    $parent_id = $this->getId('JavaScript');
                else if ($categoryExistsInCollect(['PHP', 'NodeJS']))
                    $parent_id = $this->getId('Back-End');
                else if ($categoryExistsInCollect(['Laravel']))
                    $parent_id = $this->getId('PHP');

                $category->parent_id = $parent_id;
            })
            // ->afterCreating(function (Category $category) {
            //     // ...

            //     print_r($category);
            // })
            ->create();
    }

    public function getId(string $name)
    {
        $category = $this->categories->firstWhere('name', $name);

        return $category ? $category['id'] : null;
    }

    public function createFunction(Closure $callback)
    {
        return $callback();
    }
}