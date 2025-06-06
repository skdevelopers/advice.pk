{{-- resources/views/admin/properties/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Explore Properties')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // fire it once
                        window.showToast(@json(session('success')), 'success');
                    });
                </script>
            @endif
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

            // Kick off the first load
            fetchProperties("{{ route('admin.properties.index') }}");

            async function fetchProperties(url) {
                try {
                    const res = await axios.get(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept':           'application/json'
                        }
                    });

                    const props = res.data.data  || [];
                    const links = res.data.links || [];

                    listEl.innerHTML       = '';
                    paginationEl.innerHTML = '';

                    if (!props.length) {
                        noDataEl.classList.remove('hidden');
                        return;
                    }
                    noDataEl.classList.add('hidden');

                    props.forEach(p => {
                        listEl.insertAdjacentHTML('beforeend', renderCard(p));
                    });

                    links.forEach(l => {
                        if (!l.url) return;
                        paginationEl.insertAdjacentHTML('beforeend', `
          <a href="#" data-url="${l.url}"
             class="mx-1 mb-2 px-3 py-1 border rounded ${
                            l.active ? 'bg-green-600 text-white' : 'bg-white text-gray-800'
                        }">
            ${l.label.replace('&laquo;', '«').replace('&raquo;', '»')}
          </a>
        `);
                    });

                    paginationEl.querySelectorAll('a').forEach(a => {
                        a.addEventListener('click', e => {
                            e.preventDefault();
                            fetchProperties(a.dataset.url);
                        });
                    });

                } catch {
                    showToast('Failed to load properties.', 'error');
                    noDataEl.classList.remove('hidden');
                }
            }

            function renderCard(p) {
                // fallback if no media
                const fallback = p.property_image_url
                    || "{{ asset('assets/admin/images/error.png') }}";

                // build srcset from the responsive URLs your Resource returned
                const resp = p.property_image_responsive || {};
                const srcset = Object.entries(resp)
                    .map(([w, u]) => `${u} ${w}w`)
                    .join(', ');
                const sizes = '(max-width: 640px) 100vw, 640px';

                return `
                      <div class="group rounded-xl bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl overflow-hidden duration-500">
                        <div class="relative">
                          <img
                            src="${fallback}"
                            ${srcset ? `srcset="${srcset}" sizes="${sizes}"` : ''}
                            loading="lazy"
                            class="w-full h-48 object-cover"
                            alt="${p.title}"
                          >
                          <div class="absolute top-4 right-4">
                            <a href="#" class="btn btn-icon bg-white dark:bg-slate-900 rounded-full hover:text-red-600">
                              <i class="mdi mdi-heart text-[20px]"></i>
                            </a>
                          </div>
                        </div>
                        <div class="p-6">
                          <h3><a href="/admin/properties/${p.id}" class="text-lg font-medium hover:text-green-600">
                            ${p.title}
                          </a></h3>
                          <ul class="py-4 flex space-x-4 text-sm text-gray-600">
                            <li>Size: ${p.plot_size || '--'}</li>
                            <li>Beds: ${p.features?.bedrooms || 0}</li>
                            <li>Baths: ${p.features?.bathrooms || 0}</li>
                          </ul>
                          <div class="flex justify-between items-center mt-4">
                            <span class="font-semibold">PKR ${Number(p.price||0).toLocaleString()}</span>
                            <span>${renderStars(p.rating||0)} ${(p.rating||0).toFixed(1)}</span>
                          </div>
                        </div>
                      </div>
                    `;
            }

            function renderStars(r) {
                let out = '';
                for (let i = 0; i < 5; i++) {
                    out += `<i class="mdi mdi-star${i<r?'':'-outline'}"></i>`;
                }
                return `<span class="text-amber-400">${out}</span>`;
            }
        });
    </script>
@endpush




