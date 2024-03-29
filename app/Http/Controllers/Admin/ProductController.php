<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\ControlPlan;
use App\Models\Feature;
use App\Models\Project;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware(['role_or_permission:super-admin|view-products|create-product|edit-product|destroy-product']);
    }


    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $products = Product::get();
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('project', function($row){
                    return $row->project->name ?? '';
                })
                ->addColumn('plan', function($row){
                    return '<a href="'.route('control-plans.index').'"> '.$row->controlPlan->name ?? "".'</a>';
                })
                ->addColumn('preview', function($row){
                    return '<a data-input="thumbnail" data-preview="holder" class="btn btn-primary filemanager">
                    <i data-feather="eye"></i> Preview
                    </a>';
                })
                ->addColumn('docs', function($row){
                    return $row->files;
                })
                ->addColumn('created_at',function($row){
                    return date_format(date_create($row->created_at),'d M Y');
                })
                ->addColumn('action',function ($row){
                    $editbtn = '<a href="'.route('products.edit',$row->id).'" class="edit"><button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="'.$row->id.'" data-route="'.route('products.destroy',$row->id).'" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></a>';
                    if(!can('edit-product')){
                        $editbtn = '';
                    }
                    if(!can('destroy-product')){
                        $deletebtn = '';
                    }
                    $btn = $editbtn.' '.$deletebtn;
                    return $btn;
                })
                ->rawColumns(['action','plan','preview'])
                ->make(true);
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $control_plans = ControlPlan::get();
        $projects = Project::get();
        return view('admin.products.create',compact(
            'control_plans','projects'
        ));
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
            'part_no' => 'required|unique:products,part_no',
            'plan' => 'required',
        ]);
        Product::create([
            'part_no' => $request->part_no,
            'project_id' => $request->project,
            'control_plan_id' => $request->plan,
            'docs' => $request->filepath,
            'description' => $request->description,
        ]);
        $notification = notify("product has been updated");
        return redirect()->route('products.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Fetch Product By part_no
     * @param \Illuminate\Http\Request $request
     */
    public function getProduct(Request $request){
        if($request->ajax()){
            $product = Product::where('part_no', $request->part_no)->first();
            if(!empty($product)){
                $project = $product->project->name ?? null;
                $control_plan = $product->controlPlan->name ?? null;
                $features = $product->controlPlan->features ?? null;
                $work_instruction = $product->controlPlan->workInstruction;
                return response()->json([
                    'product' => $product,
                    'project_name' => $project,
                    'control_plan' => $control_plan,
                    'work_instruction' => $work_instruction,
                    'features' => $features,
                ]);
            }
        }else{
            return abort(404);
        }
    }

    /**
     * Fet feature by id
     *
     * @param \Illuminate\Http\Request $request
     */
    public function getFeature(Request $request){
        if($request->ajax()){
            $names = array_map(function($feature){
                $result = Feature::find($feature);
                return [
                    'name' => $result->name." ({$result->type}) ",
                    'type' => $result->type,
                    'target' => $result->target,
                    'upper_limit' => $result->upper_limit,
                    'lower_limit' => $result->lower_limit,
                    'control_method' => $result->control_method,
                    'tool' => $result->inspectionTool->tool_id ?? null,
                ];
            }, $request->features);
            return response()->json($names);
        }else{
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $control_plans = ControlPlan::get();
        $projects = Project::get();
        return view('admin.products.edit',compact(
            'control_plans','product','projects'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'part_no' => 'required',
            'plan' => 'required',
        ]);
        $product->update([
            'part_no' => $request->part_no,
            'project_id' => $request->project,
            'control_plan_id' => $request->plan,
            'docs' => $request->filepath,
            'description' => $request->description,
        ]);
        $notification = notify("product has been updated");
        return redirect()->route('products.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Product::findOrFail($request->id)->delete();
    }
}
