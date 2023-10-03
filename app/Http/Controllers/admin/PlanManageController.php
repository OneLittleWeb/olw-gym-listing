<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PlanManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::paginate(10);
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
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
            'name' => 'required',
            'slug' => 'required',
            'stripe_name' => 'required',
            'stripe_id' => 'required',
            'price' => 'required',
            'abbreviation' => 'required',
        ]);
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->slug = $request->slug;
        $plan->stripe_name = $request->stripe_name;
        $plan->stripe_id = $request->stripe_id;
        $plan->price = $request->price;
        $plan->abbreviation = "/".$request->abbreviation;

        if ($request->has('dynamicIncludeFields')) {
            $plan->included = json_encode($request->dynamicIncludeFields);
        }
        if ($request->has('dynamicNotIncludeFields')) {
            $plan->not_included = json_encode($request->dynamicNotIncludeFields);
        }
        $plan->save();

        Toastr::success('Plan Successfully Saved :)', 'Success');
        return redirect()->route('admin.plan.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::find($id);
        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'stripe_name' => 'required',
            'stripe_id' => 'required',
            'price' => 'required',
            'abbreviation' => 'required',
        ]);

        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->slug = $request->slug;
        $plan->stripe_name = $request->stripe_name;
        $plan->stripe_id = $request->stripe_id;
        $plan->price = $request->price;
        $plan->abbreviation = substr( $request->abbreviation, 0, 1 ) === "/" ?  $request->abbreviation : "/".$request->abbreviation ;

        if ($request->has('dynamicIncludeFields')) {
            $plan->included = json_encode($request->dynamicIncludeFields);
        }
        if ($request->has('dynamicNotIncludeFields')) {
            $plan->not_included = json_encode($request->dynamicNotIncludeFields);
        }

        $plan->update();

        Toastr::success('Plan Successfully Updated :)', 'Success');
        return redirect()->route('admin.plan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::find($id);
        $plan->delete();
        Toastr::success('Plan Successfully Deleted :)', 'Success');
        return redirect()->route('admin.plan.index');
    }
}
