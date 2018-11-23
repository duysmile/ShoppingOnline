<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::getCategories();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::getParentCategories();
        return view('admin.categories.add', compact('parentCategories'));
    }

    /**
     * Store a newly created categories in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        if (Category::saveCategory($request, Auth::user()->id)) {
            return redirect('admin/categories')->with('success', 'Thêm danh mục thành công.');
        }
        return redirect('admin/categories/create')->with('error', 'Vui lòng chọn danh mục cha.');
    }

    /**
     * Display the specified categories.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified categories.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parentCategories = Category::getParentCategories();
        $category = Category::find($id);
        return view('admin.categories.edit', compact(['category', 'parentCategories']));
    }

    /**
     * Update the specified categories in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $req = $request->only(['name', 'top', 'parent_id']);
        $category = Category::find($id);
        foreach ($req as $key => $value) {
            if($key == 'top') {
                $value = $value == 'true' ? true : false;
            }
            $category[$key] = $value;

        }
        if($category->save()){
            return redirect('admin/categories')->with('success', 'Chỉnh sửa danh mục thành công!');
        }
        return redirect("admin/categories/$id/edit")->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    /**
     * Remove the specified categories from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->only('del-id')['del-id'];
        $category = Category::find($id);
        if ($category->delete()) {
            return redirect('admin/categories')->with('success', 'Đã xóa danh mục thành công');
        }
        return redirect('admin/categories')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
