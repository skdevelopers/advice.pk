@extends('admin.layouts.app')

@section('title', 'Edit Sub-Sector - Advice Associates Dashboard')

@section('content')
    <div class="container-fluid px-3">
        <div class="layout-specing">
            {{-- Header & Breadcrumbs --}}
            <div class="md:flex justify-between items-center mb-6">
                <h5 class="text-lg font-semibold">Edit Sub-Sector</h5>
                <ul class="inline-flex space-x-2 text-sm">
                    <li>
                        <a href="{{ route('admin.societies.index') }}" class="hover:text-green-600">
                            Societies
                        </a>
                    </li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li>
                        <a href="{{ route('admin.subsectors.index') }}" class="hover:text-green-600">
                            Sub-Sectors
                        </a>
                    </li>
                    <li><i class="mdi mdi-chevron-right text-gray-400"></i></li>
                    <li class="text-green-600">Edit</li>
                </ul>
            </div>

            {{-- Alpine root --}}
            <div
                    x-data="initializeSubSectorEditor()"
                    class="rounded-md shadow-sm bg-white p-6 dark:bg-slate-900"
            >
                <form id="editSubSectorForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Parent Society & Parent SubSector --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">Parent Society</label>
                            <select x-model="form.society_id" name="society_id" class="w-full border px-3 py-2 rounded"
                                    required>
                                <option value="">— Select Society —</option>
                                @foreach($societies as $soc)
                                    <option value="{{ $soc->id }}">{{ $soc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Parent Sub-Sector (optional)</label>
                            <select x-model="form.parent_id" name="parent_id" class="w-full border px-3 py-2 rounded">
                                <option value="">— None —</option>
                                @foreach($allSubSectors as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Name & Title --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">Name</label>
                            <input
                                    type="text"
                                    x-model="form.name"
                                    name="name"
                                    @input="generateSlug()"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Slug</label>
                            <input
                                    type="text"
                                    x-model="form.slug"
                                    name="slug"
                                    class="w-full border px-3 py-2 rounded"
                                    required
                            >
                        </div>
                    </div>

                    {{-- Slug & Block --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">Title</label>
                            <input
                                    type="text"
                                    x-model="form.title"
                                    name="title"
                                    class="w-full border px-3 py-2 rounded"
                            >
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Block / Type</label>
                            <select
                                    x-model="form.block"
                                    name="block"
                                    class="w-full border px-3 py-2 rounded"
                            >
                                <option value="Block">Block</option>
                                <option value="Sector">Sector</option>
                                <option value="Zone">Zone</option>
                                <option value="Phase">Phase</option>
                            </select>
                        </div>
                    </div>

                    {{-- Meta Keywords & Meta Detail --}}
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-1 font-medium">Meta Keywords</label>
                            <input
                                    type="text"
                                    x-model="form.meta_keywords"
                                    name="meta_keywords"
                                    class="w-full border px-3 py-2 rounded"
                            >
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Meta Detail</label>
                            <input
                                    type="text"
                                    x-model="form.meta_detail"
                                    name="meta_detail"
                                    class="w-full border px-3 py-2 rounded"
                            >
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Detail</label>
                        <textarea
                                x-model="form.detail"
                                name="detail"
                                rows="4"
                                class="w-full border px-3 py-2 rounded"
                        ></textarea>
                    </div>

                    {{-- Image Preview & Upload --}}
                    <div class="mb-6">
                        <label class="block mb-1 font-medium">Featured Image</label>
                        <div class="preview-box h-48 mb-2 bg-gray-50 dark:bg-slate-800 flex items-center justify-center rounded overflow-hidden">
                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="max-h-48 object-contain">
                            </template>
                            <span x-show="! previewUrl">Click “Upload” to change image</span>
                        </div>
                        <input type="file"
                               name="sub_sector_image"
                               accept="image/*"
                               hidden
                               x-ref="fileInput"
                               @change="previewFile"
                        >
                        <button
                                type="button"
                                @click="$refs.fileInput.click()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                        >Upload Image
                        </button>
                    </div>

                    {{-- Submit --}}
                    <div class="text-right">
                        <button
                                type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded"
                        >Update Sub-Sector
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function initializeSubSectorEditor() {
            return {
                form: {!! json_encode($subSector->only([
                'society_id',
                'parent_id',
                'name',
                'title',
                'slug',
                'meta_keywords',
                'meta_detail',
                'detail',
                'block'
            ])) !!},

                // load existing image preview URL
                previewUrl: '{{ $subSector->getFirstMediaUrl("sub_sector_image") }}',

                generateSlug() {
                    this.form.slug = this.form.name
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                },

                previewFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = () => {
                        this.previewUrl = reader.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
        }

        document.getElementById('editSubSectorForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            axios.post(
                "{{ route('admin.subsectors.update', $subSector->id) }}",
                formData,
                {headers: {'Content-Type': 'multipart/form-data'}}
            )
                .then(res => {
                    window.showToast(res.data.message || 'Updated!', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.subsectors.index") }}';
                    }, 1200);
                })
                .catch(err => {
                    window.showToast(err.response?.data?.message || 'Error saving.', 'error');
                });
        });
    </script>
@endpush



