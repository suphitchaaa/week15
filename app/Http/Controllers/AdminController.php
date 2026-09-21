<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function blogs()
    {
        $blogs = Blog::paginate(3);

        return view('blogs', compact('blogs'));
    }

    function abouts()
    {
        $name = 'Suphitcha Piaza';
        $date = '6 กรกฎาคม 2026';
        return view('abouts', compact('name', 'date'));
    }
    function create()
    {
        return view('form');
    }
    function insert (Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required',
        ],[
            'title.required' => "กรุณาใส่ชื่อบทความ",
            'title.max' => "ชื่อบทความต้องไม่เกิน 50 ตัวอักษร",
            'content.required' => "กรุณาใส่เนื้อหาบทความ"
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content
        ];
            Blog::insert($data);
            return redirect('/author/blogs');
    }
        function delete($id){
            Blog::destroy($id);
            return redirect()->back();
        }
        function change($id){
            $blog = Blog::find($id);
            $data=[
                'status'=>$blog->status
            ];
            if($blog->status ==0){
                $data['status']=1;
            }else{
                $data['status']=0;
            }            
           Blog::find($id)->update($data);
            return redirect()->back();
        }
        function edit($id){
            $blog = Blog::find($id);
            return view('edit', compact('blog'));
        }
        function update(Request $request,$id){

        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required',
        ],[
            'title.required' => "กรุณาใส่ชื่อบทความ",
            'title.max' => "ชื่อบทความต้องไม่เกิน 50 ตัวอักษร",
            'content.required' => "กรุณาใส่เนื้อหาบทความ"
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content
        ];

        Blog::find($id)->update($data);
        return redirect('/author/blogs');
    }
}