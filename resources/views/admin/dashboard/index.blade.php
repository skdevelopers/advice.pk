@extends('admin.layouts.app')

@section('content')
    @php
        $adminName = $adminName ?? 'Admin';
        $totalRevenue = $totalRevenue ?? 0;
        $transactions = $transactions ?? [
            (object)[ 'id' => 1 ]
        ];
        $properties = $properties ?? [
            (object)[
                'image' => 'placeholder.jpg',
                'title' => 'Property for sale.',
                'location' => 'Lahore, Pakistan',
                'growth' => 12.5
            ]
        ];
    @endphp

    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="flex justify-between items-center">
                <div>
                    <h5 class="text-xl font-semibold">Hello, {{ $adminName }}</h5>
                    <h6 class="text-slate-400">Welcome back!</h6>
                </div>
            </div>

            <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-1 mt-6 gap-6">
                <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                    <div class="p-5 flex items-center justify-between">
                                    <span class="me-3">
                                        <span class="text-slate-400 block">Total Revenue</span>
                                        <span class="flex items-center justify-between mt-1">
                                            <span class="text-2xl font-medium">$ <span class="counter-value" data-target="45890">42205</span></span>
                                        </span>
                                    </span>

                        <span class="flex justify-center items-center rounded-md size-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow-sm shadow-gray-100 dark:shadow-gray-700 text-green-600">
                                        <i class="mdi mdi-currency-usd text-[28px]"></i>
                                    </span>
                    </div>
                </div><!--end-->

                <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                    <div class="p-5 flex items-center justify-between">
                                    <span class="me-3">
                                        <span class="text-slate-400 block">Total Visitor</span>
                                        <span class="flex items-center justify-between mt-1">
                                            <span class="text-2xl font-medium"><span class="counter-value" data-target="2456">1857</span></span>
                                        </span>
                                    </span>

                        <span class="flex justify-center items-center rounded-md size-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow-sm shadow-gray-100 dark:shadow-gray-700 text-green-600">
                                        <i class="mdi mdi-account-group-outline text-[28px]"></i>
                                    </span>
                    </div>
                </div><!--end-->

                <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                    <div class="p-5 flex items-center justify-between">
                                    <span class="me-3">
                                        <span class="text-slate-400 block">Total Properties</span>
                                        <span class="flex items-center justify-between mt-1">
                                            <span class="text-2xl font-medium"><span class="counter-value" data-target="358">54</span></span>
                                        </span>
                                    </span>

                        <span class="flex justify-center items-center rounded-md size-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow-sm shadow-gray-100 dark:shadow-gray-700 text-green-600">
                                        <i class="mdi mdi-home-city-outline text-[28px]"></i>
                                    </span>
                    </div>
                </div><!--end-->

                <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                    <div class="p-5 flex items-center justify-between">
                                    <span class="me-3">
                                        <span class="text-slate-400 block">Properties for Sell</span>
                                        <span class="flex items-center justify-between mt-1">
                                            <span class="text-2xl font-medium"><span class="counter-value" data-target="243">60</span></span>
                                        </span>
                                    </span>

                        <span class="flex justify-center items-center rounded-md size-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow-sm shadow-gray-100 dark:shadow-gray-700 text-green-600">
                                        <i class="mdi mdi-home-lightning-bolt-outline text-[28px]"></i>
                                    </span>
                    </div>
                </div><!--end-->

                <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                    <div class="p-5 flex items-center justify-between">
                                    <span class="me-3">
                                        <span class="text-slate-400 block">Properties for Rent</span>
                                        <span class="flex items-center justify-between mt-1">
                                            <span class="text-2xl font-medium"><span class="counter-value" data-target="115">45</span></span>
                                        </span>
                                    </span>

                        <span class="flex justify-center items-center rounded-md size-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow-sm shadow-gray-100 dark:shadow-gray-700 text-green-600">
                                        <i class="mdi mdi-home-clock-outline text-[28px]"></i>
                                    </span>
                    </div>
                </div><!--end-->
            </div>

            <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
                <div class="lg:col-span-8">
                    <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                        <div class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                            <h6 class="text-lg font-semibold">Revenue Analytics</h6>
                            <select class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border !border-gray-200 dark:!border-gray-800 focus:ring-0">
                                <option value="Y" selected>Yearly</option>
                                <option value="M">Monthly</option>
                                <option value="W">Weekly</option>
                                <option value="T">Today</option>
                            </select>
                        </div>
                        <div id="mainchart" class="apex-chart px-4 pb-6">
                            <p class="text-center text-slate-400 pt-10">Chart loading...</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="relative overflow-hidden rounded-md shadow-sm dark:shadow-gray-700 bg-white dark:bg-slate-900">
                        <div class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                            <h6 class="text-lg font-semibold">Sales Data</h6>

                            <div class="position-relative">
                                <select class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border !border-gray-200 dark:!border-gray-800 focus:ring-0" id="yearchart">
                                    <option value="Y" selected>Yearly</option>
                                    <option value="M">Monthly</option>
                                    <option value="W">Weekly</option>
                                    <option value="T">Today</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-6">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Website</span>
                                    <span class="text-slate-400">50%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 50%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Team Member</span>
                                    <span class="text-slate-400">12%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 12%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Agents</span>
                                    <span class="text-slate-400">6%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 6%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Social Media</span>
                                    <span class="text-slate-400">15%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 15%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Digital Marketing</span>
                                    <span class="text-slate-400">12%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 12%"></div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="flex justify-between mb-2">
                                    <span class="text-slate-400">Via Others</span>
                                    <span class="text-slate-400">5%</span>
                                </div>
                                <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]">
                                    <div class="bg-green-600 h-[6px] rounded-full" style="width: 5%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
                <div class="xl:col-span-6 lg:col-span-12">
                    <div class="relative overflow-hidden rounded-md shadow-sm bg-white dark:bg-slate-900">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                            <h6 class="text-lg font-semibold">Recent Transactions</h6>
                        </div>
                        <div class="relative overflow-x-auto block w-full xl:max-h-[284px] max-h-[350px]" data-simplebar>
                            <table class="w-full text-start">
                                <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <th class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold">
                                            <div class="relative md:shrink-0">
                                                <img src="{{ asset('assets/admin/images/property/1.jpg') }}" class="object-cover size-12 min-w-[48px] rounded-md shadow-sm" alt="Transaction">
                                            </div>
                                        </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-4 py-3 text-center text-slate-400" colspan="5">No transactions available.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top PropertyController -->
                <div class="xl:col-span-3 lg:col-span-6">
                    <div class="relative overflow-hidden rounded-md shadow-sm bg-white dark:bg-slate-900">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
                            <h6 class="text-lg font-semibold">Top Properties</h6>
                        </div>
                        <div class="p-6" data-simplebar>
                            @forelse($properties as $property)
                                <div class="flex justify-between items-center mt-4">
                                    <div class="flex items-center">
                                        <div class="relative md:shrink-0">
                                            <img src="{{ asset('assets/admin/images/property/' . $property->image) }}" class="object-cover size-14 min-w-[56px] rounded-md shadow-sm" alt="">
                                        </div>
                                        <div class="ms-2">
                                            <a href="#" class="font-medium hover:text-green-600 block text-lg">{{ $property->title }}</a>
                                            <span class="text-slate-400">{{ $property->location }}</span>
                                        </div>
                                    </div>
                                    <span class="w-20 text-emerald-600 text-end">
                                    <i class="mdi mdi-arrow-top-right"></i> {{ $property->growth }}%
                                </span>
                                </div>
                            @empty
                                <p class="text-slate-400 text-sm">No top properties yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
    @push('scripts')
        <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/admin/js/plugins.init.js') }}"></script>
    @endpush

