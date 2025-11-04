<div>
    <h5 class="mb-3">الحملات الإعلانية</h5>

    {{-- ✅ الفلاتر --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-select" wire:model.live="cat_id">
                <option value="">كل الفروع</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">🌿 {{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select class="form-select" wire:model.live="status">
                <option value="">كل الحالات</option>
                <option value="pending">⏳ معلقة</option>
                <option value="active">🟢 نشطة</option>
                <option value="inactive">🔴 منتهية</option>
            </select>
        </div>
    </div>

    {{-- ✅ الجدول --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>م</th>
                    <th>اسم الحملة</th>
                    <th>الحالة</th>
                    <th>تاريخ البداية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ads as $index => $ad)
                    <tr>
                        <td>{{ $ads->firstItem() + $index }}</td>
                        <td>{{ $ad->name }}</td>
                        <td>
                            @if($ad->status == 'pending') ⏳ معلقة
                            @elseif($ad->status == 'active') 🟢 نشطة
                            @else 🔴 منتهية @endif
                        </td>
                        <td>$start = Carbon::parse($ad->start_date)->format('Y-m-d');
</td>
                        <td>
                            @if($ad->status == 'pending')
                                <button wire:click="startNow({{ $ad->id }})" class="btn btn-sm btn-success">
                                    بدء الآن
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">لا توجد حملات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $ads->links() }}

    @if (session('message'))
        <div class="alert alert-success mt-2">{{ session('message') }}</div>
    @endif
</div>
