<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
    return view('admin.category.index',compact('category'));
    }
    public function add()
    {
        return view('admin.category.add');
    } 
    public function insert(Request $request)
    {
       $category =new Category();
       if($request->hasfile('image'))
       {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time().'.'.$ext;
        $file->move('assets/uploads/category',$filename);
        $category->image = $filename;
       }
       $category->name = $request->input('name');
       $category->slug = $request->input('slug');
       $category->description = $request->input('description');
       $category->status = $request->input('status') == TRUE ? '1':'0';
       $category->popular = $request->input('popular') == TRUE ? '1':'0';
       $category->meta_title = $request->input('meta_title', 'default_value');
       $category->meta_keywords = $request->input('meta_keywords', 'default_value');
       $category->meta_descrip = $request->input('meta_description');
       $category->save();
       return redirect('/dashboard')->with('status',"Category Added Successfuly");
    } 

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if($category->image)
        {
            $path = 'assets/uploads/category/'.$category->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
        }
        $category->delete();
        return redirect('category')->with('status',"Category Deleted Successfuly");
    }
    
    public function storagesysunits(){
        return view('layouts.storagesys&units');
    }
    public function sofasarmchairs(){
        return view('layouts.sofas&armchairs');
    }   
    public function tableschairs(){
        return view('layouts.tables&chairs');
    }
}
