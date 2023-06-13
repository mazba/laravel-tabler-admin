<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWebsite;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function __construct()
    {
        view()->share('current_uri', 'user-management');
        view()->share('module_name', __('User'));
        view()->share('task_name', __('User management'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = User::where('status', '!=', 99);
            return Datatables::eloquent($items)
                ->orderColumn('name', 'ASC')
                ->editColumn('status', function (User $item) {
                    return $item->status == 1
                        ? '<span class="badge bg-success me-1"></span> Active'
                        : '<span class="badge bg-danger me-1"></span> Inactive';
                })
                ->editColumn('created_at', function (User $item) {
                    return $item->created_at ? $item->created_at->format('M j, Y h:i A') : null;
                })
                ->editColumn('user_type', function (User $item) {
                    return ucfirst($item->user_type);
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<buton type="button" class="btn btn-orange btn-icon btn-sm edit-button" data-id="' . $row->id . '" title="Edit">
	                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                            </buton>';
                    return $btn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.user_management.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user_management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:3|confirmed',
            'user_type' => 'required',
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'email' => $request->input('email'),
            'user_type' => $request->input('user_type'),
            'created_at' => Carbon::now()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully created!'
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user_management
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user_management)
    {
        return view('admin.user_management.edit', compact('user_management'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user_management)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,id,' . $user_management->id,
            'price' => 'numeric|nullable',
            'user_type' => 'required',
        ]);
        $user_management->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'price' => $request->input('price', 0),
            'user_type' => $request->input('user_type'),
            'updated_at' => Carbon::now(),
            'currency' => $request->input('currency'),
            'status' => $request->input('status')
        ]);
        if ($request->has('password') && !empty($request->input('password')))
            $user_management->update([
                'password' => bcrypt($request->input('password'))
            ]);
        UserWebsite::where('user_id', $user_management->id)
            ->delete();
        $websites = explode(',', $request->input('website_ids'));
        $websites_ids = [];
        foreach ($websites as $website) {
            $website = Website::where(['domain' => $website])->first();
            if (isset($website->id))
                $websites_ids[] = $website->id;
        }
        if ($websites_ids)
            $user_management->websites()->attach($websites_ids);
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully updated!'
        ]);
    }

}