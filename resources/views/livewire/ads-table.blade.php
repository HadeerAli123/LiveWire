<div>
    <h5 class="mb-3">الحملات الإعلانية</h5>

<div class="mb-5">
    @livewire('flash-component')
</div>
    {{-- الفلاتر --}}
    <div class="row mb-3 align-items-center">
        <div class="col-md-3">
            <select class="styled-select" wire:model.live="cat_id">
                <option value="">كل الفروع</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">🌿 {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select class="styled-select" wire:model.live="status">
                <option value="">كل الحالات</option>
                <option value="pending">معلقة</option>
                <option value="active">نشطة</option>
                <option value="inactive">منتهية</option>
            </select>
        </div>

        <div class="col-md-6 text-end">
            <button class="btn btn-success dropdown-toggle" type="button"
                    data-toggle="dropdown" style="background:#707072c4;border-color:#28a745;color:#fff;">
                خيارات
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('excel.files') }}"><i class="fas fa-file-excel text-primary"></i> ملفات الاكسيل</a>
                <a class="dropdown-item" wire:click="$dispatch('openAddModal')" data-toggle="modal" data-target="#projectAddModal">
                    <i class="fas fa-plus text-success"></i> حملة جديدة
                </a>
                <a class="dropdown-item" href="{{ route('excel.export',['id'=>'all']) }}"><i class="fas fa-file-export text-info"></i> تصدير الكل</a>
            </div>
        </div>
    </div>

    {{-- الجدول --}}
    <div class="table-responsive">
        <table class="text-nowrap bg-white dh-table">
            <thead class="thead-light">
                <tr>
                    <th>م</th>
                    <th>اسم الحملة</th>
                    <th>تاريخ الإعلان</th>
                    <th>الحالة</th>
                    <th>زيارات اليوم</th>
                    <th>صورة/فيديو</th>
                    <th>الفروع</th>
                    <th>اللينك</th>
                    <th>QR كود</th>
                    <th>إحصائيات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ads as $i => $ad)
                    <tr>
                        <td>{{ $ads->firstItem() + $i }}</td>
                        <td>{{ $ad->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($ad->start_date)->format('Y-m-d') }}</td>
                        <td>
                            @if($ad->status=='pending') معلقة
                            @elseif($ad->status=='active') نشطة
                            @else منتهية @endif
                        </td>
                        <td>{{ $ad->visits_count ?? 0 }}</td>
                        <td>
                            @if($ad->image)
                                @php $ext = pathinfo($ad->image, PATHINFO_EXTENSION); @endphp
                                @if(in_array($ext,['jpg','jpeg','png','gif']))
                                    <img src="{{ Storage::url($ad->image) }}" style="width:60px;">
                                @elseif($ext=='mp4')
                                    <video width="80" controls><source src="{{ Storage::url($ad->image) }}"></video>
                                @elseif($ext=='pdf')
                                    <a href="{{ Storage::url($ad->image) }}" target="_blank">PDF</a>
                                @endif
                            @endif
                        </td>
                        
<td>{{ $ad->category?->name }}</td>
                  
                        <td><a href="{{ $ad->link }}" target="_blank">الرابط</a></td>
                        <td>
                            @if($ad->qr_code)
                                <img src="{{ Storage::url($ad->qr_code) }}" width="50">
                            @endif
                        </td>
                        <td><a href="#" class="text-info">عرض</a></td>
                        <td>
                            @if($ad->status=='pending')
                                <button wire:click="startNow({{ $ad->id }})"
                                        class="btn btn-sm btn-success">بدء الآن</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="11" class="text-center">لا توجد حملات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $ads->links() }}

    @if(session('message'))
        <div class="alert alert-success mt-3">{{ session('message') }}</div>
    @endif
</div>