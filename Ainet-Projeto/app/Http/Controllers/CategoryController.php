<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CategoryFormRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(): View
    {
        $allCategories = Category::paginate(20);
        debug($allCategories);
        return view('categories.index')->with('allCategories', $allCategories);
    }

    public function showCase(): View
    {
        // No need to pass the variable $categories to the view, because it is available through View::share
        // Check AppServiceProvider
        return view('categories.showcase');
    }

    public function show(Category $category): View
    {
        return view('categories.show')->with('category', $category);
    }

    public function create(): View
    {
        $newCategory = new Category();
        return view('categories.create')->with('category', $newCategory);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $newCategory = Category::create($request->validated());
        $url = route('categories.show', ['category' => $newCategory]);
        $htmlMessage = "Category <a href='$url'><strong>{$newCategory->id}</strong>
                    - '{$newCategory->name}'</a> has been created successfully!";
        return redirect()->route('categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function edit(Category $category): View
    {
        return view('categories.edit')->with('category', $category);
    }

    public function update(CategoryFormRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());
        $url = route('categories.show', ['category' => $category]);
        $htmlMessage = "Category <a href='$url'><strong>{$category->id}</strong> -
                    '{$category->name}'</a> has been updated successfully!";
        return redirect()->route('categories.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $url = route('categories.show', ['category' => $category]);
            $totalProducts = DB::scalar(
                'select count(*) from products where category_id = ?',
                [$category->id]
            );


            if ($totalProducts == 0) {
                $category->delete();
                $alertType = 'success';
                $alertMsg = "Category {$category->name} ({$category->id}) has been deleted successfully!";
            } else {
                $alertType = 'warning';
                $productsStr = match (true) {
                    $totalProducts <= 0 => "",
                    $totalProducts == 1 => "there is 1 product enrolled in it",
                    $totalProducts > 1 => "there are $totalProducts products enrolled in it",
                };

                $justification = $productsStr";
                $alertMsg = "Category <a href='$url'><u>{$category->name}</u></a> ({$category->id}) cannot be deleted because $justification.";
            }
        } catch (\Exception $error) {
            $alertType = 'danger';
            $alertMsg = "It was not possible to delete the category
                            <a href='$url'><u>{$category->name}</u></a> ({$category->id})
                            because there was an error with the operation!";
        }
        return redirect()->back()
            ->with('alert-type', $alertType)
            ->with('alert-msg', $alertMsg);
    }
}
