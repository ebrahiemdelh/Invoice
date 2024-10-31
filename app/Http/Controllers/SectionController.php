<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSection;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\FlareClient\Flare;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Section::orderBy('id')->get();
        return view('sections.section', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddSection $request)
    {
        $id = $request->id;
        $validated = $request->validated();
        DB::table('sections')->insert([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name)
        ]);
        session()->flash('Add', 'تمت إضافة القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $validate = $request->validate(
            [
                'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
                'description' => 'required',
            ],
            [
                'section_name.required' => 'يجب إدخال اسم القسم',
                'section_name.unique' => 'هذا القسم مسجل بالفعل',
                'description.required' => 'تفاصيل القسم مطلوبة'
            ]
        );
        $data = Section::find($id);
        $data->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);
        session()->flash('Edit', 'تم تعديل بيانات القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('Delete', 'تم حذف القسم');
        return redirect('/sections');
    }
}
