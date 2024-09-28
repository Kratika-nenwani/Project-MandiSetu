<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index(){
        $data = Banner::where('type', 'featured')->pluck('image');
        $id = Banner::where('type', 'featured')->pluck('id');
        if($data->isNotEmpty())
        {
            return response()->json([
            'banner' => $data,
            'id'=>$id,
        ], 200);
        
        }
        else
        {
        return response()->json([
            'message' => 'No banners found.',
            'banner'=>$data,
            'id'=>$id,
        ], 200);
        }
        
    }

    public function index1(){
        $data = News::all();
        if($data->isNotEmpty()){
        return response()->json([
            'news' => $data,
        ], 200);
        }
        else
        {
            return response()->json([
            'message' => 'No news found.',
            'news'=>$data,
        ], 200);
        }
    }
   public function upload_news(Request $request)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'date' => 'nullable',
        'description' => 'required',
        'link' => 'nullable',
    ]);

    $news = new News;
    $news->title = $request->input('title');
    $news->date = $request->input('date');
    $news->description = $request->input('description');
    $news->link = $request->input('link');

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '.' . $ext;
        $file->move(public_path('NewsImages'), $filename); // Save image to public/NewsImages
        $news->image = $filename;
    }

    $news->save();

    return response()->json([
        'message' => 'News item created successfully.',
        'news' => $news,
    ], 200);
    }
    
    public function delete_news($id)
    {
    $news = News::find($id);

    if (!$news) {
        return response()->json([
            'message' => 'News item not found.',
        ], 200);
    }

    if ($news->image) {
        $imagePath = public_path('NewsImages/' . $news->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $news->delete();

    return response()->json([
        'message' => 'News item deleted successfully.',
    ], 200);
    }



    public function uploadBanner(Request $request)
    {
    $request->validate([
        'image' => 'required',
    ]);

    $images = [];

    if ($request->hasFile('image')) {
        foreach ($request->file('image') as $index => $file) {
            // Use microtime to generate a more unique filename
            $ext = $file->getClientOriginalExtension();
            $imageName = time() . '_' . $index . '.' . $ext; // Append the index to ensure uniqueness
            $file->move('BannerImages/' . $request->name, $imageName);
            
            // Store the banner in the database
            $banner = new Banner();
            $banner->image = $imageName;
            $banner->type = "featured";
            $banner->save();

            // Add image name to the array
            $images[] = $imageName;
        }
    }

    return response()->json([
        'message' => 'Banners uploaded successfully.',
        'banners' => $images,
    ], 200);
    }

     public function deleteBanner(Request $request,$id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            $imagePath = public_path('BannerImages/' . $banner->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            $banner->delete();

            return response()->json([
                'message' => 'Banner deleted successfully.',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Banner not found.',
            ], 404);
        }
    }

}
