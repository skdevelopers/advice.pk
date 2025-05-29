{{-- resources/views/admin/properties/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Explore Properties')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">

            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Explore Properties</h5>
                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block text-[16px] font-medium dark:text-white-100/70 hover:text-green-600">
                        <a href="{{ route('admin.properties.create') }}">Add Property</a>
                    </li>
                    <li class="inline-block mx-1 text-slate-500 dark:text-white-100/70">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block text-[16px] font-medium text-green-600">Properties</li>
                </ul>
            </div>

            <!-- Alerts -->
            <div id="alert-wrapper" class="mt-4 max-w-4xl mx-auto"></div>

            <!-- Property Grid & “No Data” -->
            <div class="grid grid-cols-1 mt-6">
                <div id="property-list" class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6"></div>
                <div id="no-properties" class="text-center text-slate-400 hidden">
                    <p>No properties found.</p>
                </div>
            </div>

            <!-- Pagination -->
            <div class="grid md:grid-cols-12 grid-cols-1 mt-6">
                <div class="md:col-span-12 text-center">
                    <div id="pagination" class="inline-flex flex-wrap justify-center"></div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const listEl       = document.getElementById('property-list');
            const noDataEl     = document.getElementById('no-properties');
            const paginationEl = document.getElementById('pagination');
            const alertWrapper = document.getElementById('alert-wrapper');

            // initial fetch
            fetchProperties("{{ route('admin.properties.index') }}");

            /**
             * Fetch via axios and render cards + pagination.
             * @param {string} url
             */
            function fetchProperties(url) {
                axios.get(url, { headers: { Accept: 'application/json' } })
                    .then(({ data }) => {
                        const props = data.data || [];
                        const links = data.links || [];

                        listEl.innerHTML       = '';
                        paginationEl.innerHTML = '';

                        if (props.length === 0) {
                            noDataEl.classList.remove('hidden');
                            return;
                        }
                        noDataEl.classList.add('hidden');

                        // render each card
                        props.forEach(p => listEl.insertAdjacentHTML('beforeend', renderPropertyCard(p)));

                        // render pagination
                        links.forEach(link => {
                            if (!link.url) return;
                            paginationEl.insertAdjacentHTML('beforeend', `
            <a href="#" data-url="${link.url}"
               class="mx-1 mb-2 px-3 py-1 border rounded ${
                                link.active ? 'bg-green-600 text-white'
                                    : 'bg-white text-gray-800'
                            }">
              ${link.label.replace('&laquo;', '«').replace('&raquo;', '»')}
            </a>
          `);
                        });

                        // hook pagination clicks
                        paginationEl.querySelectorAll('a').forEach(a => {
                            a.addEventListener('click', e => {
                                e.preventDefault();
                                fetchProperties(a.dataset.url);
                            });
                        });
                    })
                    .catch(() => {
                        showToast('Failed to load properties. Please try again later.', 'error');
                        noDataEl.classList.remove('hidden');
                    });
            }

            function renderPropertyCard(p) {
                const img = p.main_image_url
                    || "{{ asset('/assets/admin/images/hero.jpg') }}";

                return `
                        <div class="group rounded-xl bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl overflow-hidden duration-500">
                          <div class="relative">
                            <img src="${img}" alt="${p.title}" class="w-full h-48 object-cover">
                            <div class="absolute top-4 end-4">
                              <a href="#" class="btn btn-icon bg-white dark:bg-slate-900 !rounded-full text-slate-100 dark:text-slate-700 hover:text-red-600">
                                <i class="mdi mdi-heart text-[20px]"></i>
                              </a>
                            </div>
                          </div>
                          <div class="p-6">
                            <div class="pb-6">
                              <a href="/admin/properties/${p.id}" class="text-lg font-medium hover:text-green-600">
                                ${p.title}
                              </a>
                            </div>
                            <ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">
                              <li class="flex items-center me-4">
                                <i class="mdi mdi-arrow-expand-all text-2xl me-2 text-green-600"></i>
                                <span>${p.plot_size || '--'} </span>
                              </li>
                              <li class="flex items-center me-4">
                                <i class="mdi mdi-bed text-2xl me-2 text-green-600"></i>
                                <span>${p.features?.bedrooms || 0} Beds</span>
                              </li>
                              <li class="flex items-center">
                                <i class="mdi mdi-shower text-2xl me-2 text-green-600"></i>
                                <span>${p.features?.bathrooms || 0} Baths</span>
                              </li>
                            </ul>
                            <ul class="pt-6 flex justify-between items-center list-none">
                              <li>
                                <span class="text-slate-400">Price</span>
                                <p class="text-lg font-medium">
                                  PKR ${Number(p.price || 0).toLocaleString()}
                                </p>
                              </li>
                              <li>
                                <span class="text-slate-400">Rating</span>
                                <ul class="text-amber-400 list-none">
                                  ${renderStars(p.rating || 0)}
                                  <li class="inline text-black dark:text-white">
                                    ${(p.rating||0).toFixed(1)} (${p.reviews_count||0})
                                  </li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                        </div>`;
            }

            function renderStars(rating) {
                let stars = '';
                for (let i = 0; i < 5; i++) {
                    stars += `<li class="inline">
                  <i class="mdi mdi-star${i < rating ? '' : '-outline'}"></i>
                </li>`;
                }
                return stars;
            }
        });
    </script>
@endpush
