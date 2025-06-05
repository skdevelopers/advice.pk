<!-- Start Footer -->
<footer class="relative bg-slate-900 dark:bg-slate-800 mt-24">
    <div class="container relative">
        <div class="grid grid-cols-1">
            <div class="relative py-16">
                <!-- Subscribe Section -->
                <div class="relative w-full">
                    <div class="relative -top-40 bg-white dark:bg-slate-900 lg:px-8 px-6 py-10 rounded-xl shadow-lg dark:shadow-gray-700 overflow-hidden">
                        <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-[30px]">
                            <div class="md:text-start text-center z-1">
                                <h3 class="md:text-3xl text-2xl md:leading-normal leading-normal font-medium text-slate-900 dark:text-white">Subscribe to Newsletter!</h3>
                                <p class="text-slate-400 max-w-xl mx-auto">Subscribe to get latest updates and information.</p>
                            </div>
                            <div class="subcribe-form z-1">
                                <form class="relative max-w-lg md:ms-auto">
                                    <input type="email" id="subcribe" name="email" class="rounded-full bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700" placeholder="Enter your email :">
                                    <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white !rounded-full">Subscribe</button>
                                </form>
                            </div>
                        </div>
                        <div class="absolute -top-5 -start-5">
                            <div class="uil uil-envelope lg:text-[150px] text-7xl text-black/5 dark:text-white/5 ltr:-rotate-45 rtl:rotate-45"></div>
                        </div>
                        <div class="absolute -bottom-5 -end-5">
                            <div class="uil uil-pen lg:text-[150px] text-7xl text-black/5 dark:text-white/5 rtl:-rotate-90"></div>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px] -mt-24">
                        <div class="lg:col-span-4 md:col-span-12">
                            <a href="#" class="text-[22px] focus:outline-none">
                                <img src="{{ asset('assets/front/images/logo-light.png') }}" alt="logo">
                            </a>
                            <p class="mt-6 text-gray-300">A great platform to buy, sell and rent your properties.</p>
                        </div>
                        <div class="lg:col-span-2 md:col-span-4">
                            <h5 class="tracking-[1px] text-gray-100 font-semibold">Company</h5>
                            <ul class="list-none footer-list mt-6">
                                <li><a href="{{ url('/about') }}" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> About us</a></li>
                                <li class="mt-[10px]"><a href="/features" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Services</a></li>
                                <li class="mt-[10px]"><a href="/pricing" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Pricing</a></li>
                                <li class="mt-[10px]"><a href="/blog" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Blog</a></li>
                                <li class="mt-[10px]"><a href="/login" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Login</a></li>
                            </ul>
                        </div>
                        <div class="lg:col-span-3 md:col-span-4">
                            <h5 class="tracking-[1px] text-gray-100 font-semibold">Useful Links</h5>
                            <ul class="list-none footer-list mt-6">
                                <li><a href="/terms" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Terms of Services</a></li>
                                <li class="mt-[10px]"><a href="/privacy" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Privacy Policy</a></li>
                                <li class="mt-[10px]"><a href="/listing" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Listing</a></li>
                                <li class="mt-[10px]"><a href="/contact" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"><i class="uil uil-angle-right-b me-1"></i> Contact</a></li>
                            </ul>
                        </div>
                        <div class="lg:col-span-3 md:col-span-4">
                            <h5 class="tracking-[1px] text-gray-100 font-semibold">Contact Details</h5>
                            <div class="flex mt-6">
                                <i data-feather="map-pin" class="size-5 text-green-600 me-3"></i>
                                <div>
                                    <h6 class="text-gray-300 mb-2">Advice Associates Plaza no.1 Hub commercial, <br> Bahria town Phase 8 Rawalpindi / Islamabad, <br> Pakistan.</h6>
                                    <a href="https://goo.gl/maps/..." data-type="iframe" class="text-green-600 hover:text-green-700 duration-500 ease-in-out lightbox">View on Google map</a>
                                </div>
                            </div>
                            <div class="flex mt-6">
                                <i data-feather="mail" class="size-5 text-green-600 me-3"></i>
                                <div>
                                    <a href="mailto:contact@advice.pk" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out">contact@advice.pk</a>
                                </div>
                            </div>
                            <div class="flex mt-6">
                                <i data-feather="phone" class="size-5 text-green-600 me-3"></i>
                                <div>
                                    <a href="tel:+92331 54 54 249" class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out">+92331 54 54 249</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end grid-->
                </div>
                <!-- Subscribe -->
            </div>
        </div>
    </div>
    <div class="py-[30px] px-0 border-t border-gray-800 dark:border-gray-700">
        <div class="container relative text-center">
            <div class="grid md:grid-cols-2 items-center gap-6">
                <div class="md:text-start text-center">
                    <p class="mb-0 text-gray-300">
                        © {{ date('Y') }} Advice.pk Design with <i class="mdi mdi-heart text-red-600"></i> by
                        <a href="https://github.com/skdevelopers/" target="_blank" class="text-reset">Salman@advice.pk</a>.
                    </p>
                </div>
                <ul class="list-none md:text-end text-center">
                    <li class="inline"><a href="https://github.com/skdevelopers" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="shopping-cart" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://dribbble.com/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="dribbble" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://www.behance.net/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i class="uil uil-behance align-baseline"></i></a></li>
                    <li class="inline"><a href="http://linkedin.com/company/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="linkedin" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://www.facebook.com/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="facebook" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://www.instagram.com/advice.pk/" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="instagram" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://twitter.com/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="twitter" class="size-4"></i></a></li>
                    <li class="inline"><a href="mailto:support@advice.pk" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="mail" class="size-4"></i></a></li>
                    <li class="inline"><a href="https://github.com/skdevelopers/advice.pk" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i data-feather="file-text" class="size-4"></i></a></li>
                </ul>
            </div><!--end grid-->
        </div><!--end container-->
    </div>
</footer>
<!-- End Footer -->
