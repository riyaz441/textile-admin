<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\GalleryVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryMasterController extends Controller
{
    public function index()
    {
        $data['images'] = GalleryImage::orderBy('gallery_image_id', 'DESC')->get();
        $data['videos'] = GalleryVideo::orderBy('gallery_video_id', 'DESC')->get();

        return view('master.gallery.index', $data);
    }

    public function storeImages(Request $request)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        foreach ($request->file('images') as $file) {
            File::ensureDirectoryExists(public_path('assets/gallery/images'));
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/gallery/images'), $filename);

            GalleryImage::create([
                'image' => 'assets/gallery/images/' . $filename,
            ]);
        }

        return redirect()->route('galleries.index')->with('success', 'Image(s) uploaded successfully!');
    }

    public function storeVideo(Request $request)
    {
        $request->validate([
            'youtube_url' => [
                'nullable',
                'url',
                'regex:/^(https?:\\/\\/)?(www\\.)?(youtube\\.com|youtu\\.be)\\/.+$/i',
                'required_without:video_file',
            ],
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,mkv,webm|max:51200|required_without:youtube_url',
        ], [
            'youtube_url.regex' => 'Please enter a valid YouTube link.',
        ]);

        $videoData = [
            'youtube_url' => $request->youtube_url,
            'video_file' => null,
        ];

        if ($request->hasFile('video_file')) {
            File::ensureDirectoryExists(public_path('assets/gallery/videos'));
            $file = $request->file('video_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/gallery/videos'), $filename);
            $videoData['video_file'] = 'assets/gallery/videos/' . $filename;
        }

        GalleryVideo::create($videoData);

        return redirect()->route('galleries.index', ['tab' => 'videos'])->with('success', 'Video added successfully!');
    }

    public function destroyImage($id)
    {
        $image = GalleryImage::findOrFail($id);

        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return redirect()->route('galleries.index')->with('danger', 'Image deleted successfully!');
    }

    public function destroyVideo($id)
    {
        $video = GalleryVideo::findOrFail($id);

        if ($video->video_file && file_exists(public_path($video->video_file))) {
            unlink(public_path($video->video_file));
        }

        $video->delete();

        return redirect()->route('galleries.index', ['tab' => 'videos'])->with('danger', 'Video deleted successfully!');
    }
}
