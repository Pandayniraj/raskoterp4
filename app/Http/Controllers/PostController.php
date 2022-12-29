<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Flash;
use Carbon\Carbon;

class PostController extends Controller
{
    //
    public function index(){
        $posts = Post::all();
        $page_title = 'Admin | Post Management';
        return view('others.post',compact('page_title','posts'));
     }
     public function create(){
         $page_title = 'Admin | Post Management';
         $page_description = 'Create new Post';
         return view('others.postcreate', compact('page_title','page_description'));
     }
     public function store(Request $request){
        //  dd($request->sn, $request->status);
         $input= Post::create([
             'Alias'=> $request->codenum,  
             'Name' => $request->post,
             'SortKey' => $request->sn,
             'IsEnable' => $request->status,
             'CreatedOn' => Carbon::now(),
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Post Successfully Created');
         return redirect('/admin/post');
     }
     public function edit($id){  
         $findpost = Post::find($id);
         $page_title = 'Admin | Post Management';
         $page_description = 'Update Post';
         return view('others.postedit', compact('findpost','page_title','page_description'));
     }
     public function update( Request $request, $id){
        
         $updatearea= Post::where('Id', $id)->update([
            'Alias'=> $request->codenum,  
             'Name' => $request->post,
             'SortKey' => $request->sn,
             'IsEnable' => $request->status,
             'UpdatedOn' => Carbon::now()
         ]);
         Flash::success('Post Successfully Updated');
         return redirect('/admin/post');
     }
     public function delete($id){
         $area = Post::where('Id', $id)->delete();
         Flash::success('Post Successfully Deleted');
         return redirect('/admin/post');
     }
}
