@extends('admin.layouts.app')

@section('title', 'Add City')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <!-- Page Header -->
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Add City</h5>

                <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                    <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white-100/70 hover:text-green-600 dark:hover:text-white">
                        <a href="{{ route('admin.cities.index') }}">View Cities</a>
                    </li>
                    <li class="inline-block text-base text-slate-950 dark:text-white-100/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                        <i class="mdi mdi-chevron-right"></i>
                    </li>
                    <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white">Add City</li>
                </ul>
            </div>

            <!-- Page Content -->
            <div class="grid grid-cols-1 mt-6">
                <div class="rounded-md shadow-sm dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">

                    <form id="createCityForm">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">City Name</label>
                            <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-gray-700">Slug</label>
                            <input type="text" name="slug" id="slug" class="w-full border px-3 py-2 rounded" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select name="status" id="status" class="w-full border px-3 py-2 rounded">
                                <option value="enabled">Enabled</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn bg-green-600 text-white px-4 py-2 rounded" id="submitBtn">
                                Add City
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate slug
        document.getElementById('name').addEventListener('input', function () {
            document.getElementById('slug').value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        });

        // Form submit with centralized toast
        document.getElementById('createCityForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';

            try {
                const response = await axios.post('{{ route("admin.cities.store") }}', formData);
                window.showToast(response.data.message || 'City added successfully!', 'success');
                setTimeout(() => window.location.href = '{{ route("admin.cities.index") }}', 1200);
            } catch (error) {
                if (error.response?.data?.errors) {
                    Object.values(error.response.data.errors).forEach(messages => {
                        window.showToast(messages.join('\n'), 'error');
                    });
                } else {
                    window.showToast('Failed to save city. Please try again.', 'error');
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Add City';
            }
        });
    </script>
@endpush
