@extends('layouts.master')
@section('title', 'Gallery - ' . env('APP_NAME'))

@php
    $activeTab = request('tab', 'images');
    $youtubeEmbedUrl = function ($url) {
        if (!$url) {
            return null;
        }

        if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        if (preg_match('/v=([^\?&]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url;
    };
@endphp

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Gallery</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'images' ? 'active' : '' }}" data-bs-toggle="tab"
                            data-bs-target="#image-gallery-tab" type="button" role="tab">
                            Image Gallery
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $activeTab === 'videos' ? 'active' : '' }}" data-bs-toggle="tab"
                            data-bs-target="#video-gallery-tab" type="button" role="tab">
                            Video Gallery
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-4">
                    <div class="tab-pane fade {{ $activeTab === 'images' ? 'show active' : '' }}" id="image-gallery-tab"
                        role="tabpanel">
                        <form action="{{ route('galleries.images.store') }}" method="POST" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-md-8">
                                <label class="form-label">Upload Image(s)</label> <small class="text-muted">You can upload
                                    one or multiple images.</small>
                                <input type="file" name="images[]" class="form-control" accept="image/*" multiple
                                    required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Upload Images</button>
                            </div>
                        </form>

                        <hr>

                        <div class="row g-3">
                            @forelse ($images as $image)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <img src="{{ asset($image->image) }}" class="card-img-top" alt="Gallery Image"
                                            style="height: 220px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <form action="{{ route('galleries.images.destroy', $image->gallery_image_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger w-100">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">No images uploaded yet.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="tab-pane fade {{ $activeTab === 'videos' ? 'show active' : '' }}" id="video-gallery-tab"
                        role="tabpanel">
                        <form action="{{ route('galleries.videos.store') }}" method="POST" enctype="multipart/form-data"
                            class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">YouTube Video Link</label>
                                <input type="url" name="youtube_url" class="form-control"
                                    placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upload Video File</label>
                                <input type="file" name="video_file" class="form-control" accept="video/*">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Add Video</button>
                            </div>
                        </form>

                        <hr>

                        <div class="row g-3">
                            @forelse ($videos as $video)
                                <div class="col-lg-4 col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            @if ($video->youtube_url)
                                                <div class="ratio ratio-16x9 mb-2">
                                                    <iframe src="{{ $youtubeEmbedUrl($video->youtube_url) }}"
                                                        title="YouTube video" allowfullscreen></iframe>
                                                </div>
                                                <p class="small text-muted mb-2">{{ $video->youtube_url }}</p>
                                            @elseif($video->video_file)
                                                <video controls style="width: 100%; max-height: 260px;" class="mb-2">
                                                    <source src="{{ asset($video->video_file) }}">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @endif
                                            <form
                                                action="{{ route('galleries.videos.destroy', $video->gallery_video_id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this video?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger w-100">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">No videos added yet.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
