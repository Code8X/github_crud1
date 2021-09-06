<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;





class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['categories'] = Category::orderBy('id', 'desc')->get();

        //  $post_query = Post::Where('user_id',auth()->id());

        $post_query = Post::withCount('comments')->Where('user_id', auth()->id());

        // ---------tim kiem dung va gan dung
        if ($request->category) {
            $post_query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }
        if ($request->keyword) {
            $post_query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->sortByComments && in_array($request->sortByComments, ['asc', 'desc'])) {
            $post_query->orderBy('comments_count', $request->sortByComments);
        }
        //----------------------------------------------------------------------
        // $data['posts']= $post_query->orderBy('id','desc')->get();
        $data['posts'] = $post_query->orderBy('id', 'DESC')->paginate(2);

        return view('post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::orderby('id', 'desc')->get();
        $data['tags'] = Tag::orderby('id', 'desc')->get();

        return view('post.create', $data);
    }
    // get list master data
    public function getmasterdata()
    {
        $data['categories'] = Category::orderby('id', 'desc')->get();
        $data['tags'] = Tag::orderby('id', 'desc')->get();
        return view('post.masterdata', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg',
                'category' => 'required',
                'tags' => 'required|array'
            ],
            [
                'category.required' =>  'please select a category.',
                'tags.required' => 'please select altest one tag.'
            ]
        );


        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('post_images'), $image_name); // move vao: public\post_images
        }

        //dd(public_path('post_images'));

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $image_name, //luu ten file hinh
            'user_id' => auth()->id(),
            'category_id' => $request->category
        ]);

       // insert to table post_tag (post_id, tag_id)
            $post->tags()->sync($request->tags); // call function tags trong model Post.

           return redirect()->route('posts.index')->with('success', 'Post successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd($id);
        $data['posts'] =$post= Post::findOrFail($id);

        //policy cach 1.
        // if($posts->user_id !=auth()->id())
        // {
        //     abort(403);
        // }
        // policy cach 2
        $this->authorize('view', $post);

        return view('post.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['posts'] =$post= Post::findOrFail($id);
        $this->authorize('update', $post);

        $data['categories'] = Category::orderby('id', 'desc')->get();
        $data['tags'] = Tag::orderby('id', 'desc')->get();

        return view('post.edit', $data);
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
        $post = Post::findOrFail($id);

        $this->authorize('update', $post); //** */

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'category' => 'required',
            'tags' => 'required|array'
        ], [
            'category.required' => 'Please select a category.',
            'tags.required' => 'Please select atlest one tag.'
        ]);


        if ($request->hasFile('image')) { // kiem tra co chon file chua

            $image = $request->file('image'); // luu file hinhf vao hien $image

            $image_name = time() . '.' . $image->extension(); // dat ten moi cho file
            $image->move(public_path('post_images'), $image_name); // luu file vao thu muc

            $old_path = public_path() . '/post_images/' . $post->image; // lay file da luu trc do

            //kiem tra file da ton tai khoong. neu ton tai thi xoa
              if (File_exists($old_path)) {
                unlink($old_path); //delete fiel
          }
        }
        else {
             $image_name = $post->image;
        }

        $post->update([
         'title'=>$request->title,
         'description'=>$request->description,
         'image'=>$image_name,
         'user_id'=>auth()->id(),
         'category_id'=>$request->category
        ]);

       $post->tags()->sync($request->tags);

        return redirect()->route('posts.index')->with('success','Post successfully updated');
    }


//           if(\File::exists($old_path)){
//           \File::delete($old_path);
//         }

    //       //$old_path= Storage::disk('public')->path("post_image/$post->image");


    //     $publicpath = Storage::disk('public');
    //     $filename = "post_image/$post->image";
    //     $checkfile = $publicpath->exists($filename);

    //      $test = [$old_path, $checkfile];
    //      $files = Storage::files($old_path);

    //      //dd( $publicpath->delete($filename));
    //    //  Storage::move('/public', $image_name);
    //     Storage::move($publicpath , $image_name);

    //         if ($checkfile) {
    //            dd($test);
    //            // $publicpath->delete($filename);
    //         }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
         $this->authorize('delete', $post);


        $old_path = public_path() . '/post_images/' . $post->image; // lay file da luu trc do

        //kiem tra file da ton tai khoong. neu ton tai thi xoa
          if (File_exists($old_path)) {
            unlink($old_path); //delete fiel
     }

         $post->delete();

         return redirect()->route('posts.index')->with('success', 'Post successfully deleted.');
    }
}
