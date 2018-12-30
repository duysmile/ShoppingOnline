<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getUserByRole('user');
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of the staff.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStaff()
    {
        $users = User::getUserByRole('staff');
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (User::signUp($request, $request->only('role')['role'])['success']) {
            return redirect()->back()->with('success', 'Thêm user thành công.');
        }
        return redirect('admin/users/create')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }

    public function destroy(Request $request)
    {
        $id = $request->only('del-id')['del-id'];
        $user = User::find($id);
        if ($user->delete()) {
            return redirect()->back()->with('success', 'Đã khóa user thành công');
        }
        return redirect('admin/products')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
    }
}
