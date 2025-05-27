@extends('admin.layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">

        <h2 class="text-2xl font-bold mb-6">Edit Property</h2>

        <form action="{{ route('admin.properties.update', $property) }}"
              method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- (All fields same as create, but prefilled) --}}
            @include('admin.properties.partials.form-fields', ['property' => $property])

            {{-- Images preview and upload --}}
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium">Current Main Image</label>
                    <img src="{{ $property->getFirstMediaUrl('main_image')
                    ?: asset('images/defaults/property-placeholder.jpg') }}"
                         class="w-full h-40 object-cover rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Replace Main Image</label>
                    <input type="file" name="main_image" class="w-full border rounded px-3 py-2">
                    @error('main_image')<p class="text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">Gallery</label>
                <div class="grid grid-cols-3 gap-2 mb-2">
                    @foreach($property->getMedia('gallery') as $media)
                        <div class="relative">
                            <img src="{{ $media->getUrl() }}" class="object-cover h-24 w-full rounded">
                        </div>
                    @endforeach
                </div>
                <input type="file" name="gallery[]" multiple class="w-full border rounded px-3 py-2">
                @error('gallery.*')<p class="text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Update Property
            </button>
        </form>
    </div>
@endsection
