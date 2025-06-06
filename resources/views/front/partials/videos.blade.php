{{-- front/partials/videos.blade.php --}}
<section class="bg-slate-100 py-10">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8 text-slate-900">VIDEOS OVERVIEW</h2>
        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 md:gap-8">
            <!-- Repeat for each video, ideally make this dynamic from DB -->
            @foreach([
                [
                    'link' => 'https://www.youtube.com/watch?v=nixgTZm_dyk',
                    'thumb' => 'assets/front/images/videos/video1.png',
                ],
                [
                    'link' => 'https://www.youtube.com/watch?v=ma1JqGBnM0c',
                    'thumb' => 'assets/front/images/videos/video2.png',
                ],
                [
                    'link' => 'https://www.youtube.com/watch?v=HGn7sH4RWbE',
                    'thumb' => 'assets/front/images/videos/video3.png',
                ],
            ] as $video)
                <div class="group rounded-xl bg-white shadow-sm hover:shadow-xl overflow-hidden transition-all duration-300 relative">
                    <a href="{{ $video['link'] }}" target="_blank" rel="noopener" class="block relative">
                        <img src="{{ asset($video['thumb']) }}" alt="Video Thumbnail"
                             class="w-full object-cover aspect-video">
                        <span class="absolute inset-0 flex justify-center items-center">
                        <img src="{{ asset('assets/front/images/play-btn.png') }}"
                             alt="Play"
                             class="w-14 h-14 md:w-20 md:h-20 opacity-90 drop-shadow-lg transition-transform group-hover:scale-110"
                             style="pointer-events: none;">
                    </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
