<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $title = "Rules";
        return view('admin.rules')->with(['title' => $title]);
    }

    public function getRules()
    {
        $rules = Rule::all();
        return response()->json(['rules' => $rules]);
    }

    public function getRule($id)
    {
        $rule = Rule::find($id);
        return response()->json(['rule' => $rule]);
    }

    public function createRule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rule' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        Rule::create($request->all());

        return response()->json(['success' => 'Rule created successfully!']);
    }

    public function editRule($id)
    {
        $rule = Rule::find($id);
        return response()->json(['rule' => $rule]);
    }

    public function updateRule(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rule' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $rule = Rule::find($id);
        $rule->rule = $request->rule;
        $rule->save();

        return response()->json(['success' => 'Rule has been updated']);
    }

    public function deleteRule($id)
    {
        $rule = Rule::find($id);
        $rule->delete();

        return response()->json(['success' => 'Rule has been deleted!']);
    }
}
