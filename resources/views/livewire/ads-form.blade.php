<div>
    <form wire:submit.prevent="save">
        @csrf
        <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
            style="background: #e3e4e6; border-radius: 12px; padding: 20px 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
            <h4 class="mb-0" style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                إضافة حملة جديدة
            </h4>
            <button type="button" wire:click="$dispatch('close-modal')" class="close ml-2"
                style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">اسم الحملة <span class="text-danger">*</span></label>
                    <input type="text" wire:model="name" class="theme-input-style" placeholder="أدخل اسم الحملة">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">المشروع</label>
                    <p class="theme-input-style" style="height: 50px; font-size: 1.1rem; line-height:50px;">
                        {{ $company?->name ?? 'غير محدد' }}
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">تاريخ البدء <span class="text-danger">*</span></label>
                    <input type="date" wire:model="start_date" class="theme-input-style">
                    @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">تاريخ النهاية <span class="text-danger">*</span></label>
                    <input type="date" wire:model="end_date" class="theme-input-style">
                    @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">قيمة الإعلان لليوم <span class="text-danger">*</span></label>
                    <input type="number" wire:model="amount_per_day" class="theme-input-style">
                    @error('amount_per_day') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">عدد الأيام</label>
                    <input type="text" wire:model="number_days" class="theme-input-style" readonly>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">إجمالي القيمة</label>
                    <input type="number" wire:model="total_amount" class="theme-input-style" readonly>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">هاتف الحملة</label>
                    <input type="number" wire:model="phone" class="theme-input-style">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            @if(!$cat_id)
                <div class="col-12">
                    <div class="form-group mb-4">
                        <label class="mb-2 black bold">الفروع <span class="text-danger">*</span></label>
                        <select wire:model="cats_ids" class="theme-input-style" multiple style="min-height:120px; height:160px;">
                            <option value="all">الكل</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('cats_ids') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            @else
                <input type="hidden" wire:model="cats_ids" value="{{ $cat_id }}">
            @endif

            <div class="col-lg-12">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">رفع صورة أو فيديو أو PDF</label>
                    <input type="file" wire:model="image" class="theme-input-style" accept="image/*,video/*,application/pdf">
                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group mb-4">
                    <label class="mb-2 black bold">ملاحظة</label>
                    <textarea wire:model="note" class="theme-input-style" rows="3"></textarea>
                    @error('note') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
            <button type="submit" class="btn btn-primary ml-3">حفظ</button>
            <button type="button" wire:click="$dispatch('close-modal')" class="btn btn-secondary">إلغاء</button>
        </div>
    </form>
</div>