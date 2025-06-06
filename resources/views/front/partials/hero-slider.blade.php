{{-- resources/views/front/partials/hero.blade.php --}}
<section class="swiper-slider-hero relative block h-screen" id="home">
    <div class="swiper-container absolute end-0 top-0 size-full">
        <div class="swiper-wrapper">
            <div class="swiper-slide flex items-center overflow-hidden">
                <div class="slide-inner absolute end-0 top-0 size-full slide-bg-image flex items-center bg-center"
                     data-background="{{ asset('assets/front/images/bg/02.jpg') }}">
                    <div class="absolute inset-0 bg-black/70"></div>
                    <div class="container relative">
                        <div class="grid grid-cols-1">
                            <div class="text-center">
                                <h1 class="font-semibold text-white lg:leading-normal leading-normal text-4xl lg:text-6xl mb-6">Find the perfect <br>
                                    <span class="typewrite" data-period="2000" data-type='[ "home", "villa", "office" ]'></span> for you
                                </h1>

                                <p class="text-white/70 text-xl max-w-xl mx-auto">
                                    A great platform to buy, sell and rent your properties.
                                </p>
                                <div class="mt-6">
                                    <a href="#" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">See More</a>
                                </div>
                            </div>
                        </div><!--end grid-->
                    </div><!--end container-->
                </div><!-- end slide-inner -->
            </div> <!-- end swiper-slide -->
        </div><!-- end swiper-wrapper -->
        <div class="swiper-button-next bg-transparent size-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-green-600 hover:border-green-600 rounded-full text-center"></div>
        <div class="swiper-button-prev bg-transparent size-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-green-600 hover:border-green-600 rounded-full text-center"></div>
    </div><!--end container-->
</section>
