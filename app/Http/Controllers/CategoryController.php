<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        view()->share('current_uri','category');
        view()->share('module_name',__('Settings'));
        view()->share('task_name',__('Category'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = Category::where('status','!=',99);
            return Datatables::eloquent($items)
                ->orderColumn('title', 'ASC')
                ->editColumn('status', function (Category $item) {
                    return $item->status == 1
                        ? '<span class="badge bg-success me-1"></span> Active'
                        : '<span class="badge bg-danger me-1"></span> Inactive';
                })
                ->editColumn('created_at', function (Category $item) {
                    return $item->created_at ? $item->created_at->format('M j, Y h:i A') : null;
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<buton type="button" class="btn btn-orange btn-icon btn-sm edit-button" data-id="'.$row->id.'" title="Edit">
	                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" /><path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" /><line x1="16" y1="5" x2="19" y2="8" /></svg>
                            </buton>';
                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'title'=>'required|max:255|unique:categories',
        ]);
        Category::create([
            'title'=>$request->input('title'),
            'created_at'=> Carbon::now()
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Successfully created!'
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title'=>'required|max:255|unique:categories,title,'.$category->id
        ]);
        $category->update([
            'title'=>$request->input('title'),
            'updated_at'=> Carbon::now()
        ]);
        return response()->json([
            'status'=>'success',
            'message'=>'Successfully updated!'
        ]);
    }

}
