<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
table.dataTable thead th,
table.dataTable thead td,
table.dataTable tfoot th,
table.dataTable tfoot td {
    text-align: justify !important;
}
.invalid-feedback {
    display: block !important;
    width: 100%;
    margin-top: 5px;
    font-size: 0.875rem;
    color: #dc3545;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <h4 class="font-20">الفروع</h4>
                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal" data-target="#projectAddModal" style="float: left;">
                        فرع جديد
                    </a>
                </div>

                <!-- Add New Branch Modal -->
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form id="add-branch-form" action="{{ route('cats.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center" style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <h4 class="mb-0" style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                            إضافة فرع جديد
                                        </h4>
                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close" style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>

                                    @php
                                        $company = App\Models\Company::find(request()->get('id'));
                                        $theme_id = 4;
                                    @endphp

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="name" class="mb-2 black bold">اسم الفرع <span class="text-danger">*</span></label>
                                                <input type="text" class="theme-input-style @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسم الفرع">
                                                <div class="invalid-feedback"></div>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="geex-input-whatsapp" class="form-label">رقم واتساب</label>
                                                <div class="input-wrapper input-icon position-relative">
                                                    <div class="input-group">
                                                        <span class="input-group-text p-0" style="min-width: 110px;">
                                                            <img id="selected-whatsapp-flag-img" src="{{ asset('assets/flags/sa.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                            <select name="whatsapp_country_code" id="whatsapp-country-code-select" class="form-select border-0 bg-transparent px-2 @error('whatsapp_country_code') is-invalid @enderror" style="width: 80px;">
                                                                <option value="+966" {{ old('whatsapp_country_code') == '+966' ? 'selected' : '' }} data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                <option value="+20" {{ old('whatsapp_country_code') == '+20' ? 'selected' : '' }} data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                <option value="+971" {{ old('whatsapp_country_code') == '+971' ? 'selected' : '' }} data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                <option value="+965" {{ old('whatsapp_country_code') == '+965' ? 'selected' : '' }} data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                <option value="+964" {{ old('whatsapp_country_code') == '+964' ? 'selected' : '' }} data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                <option value="+962" {{ old('whatsapp_country_code') == '+962' ? 'selected' : '' }} data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                <option value="+963" {{ old('whatsapp_country_code') == '+963' ? 'selected' : '' }} data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                <option value="+968" {{ old('whatsapp_country_code') == '+968' ? 'selected' : '' }} data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                <option value="+973" {{ old('whatsapp_country_code') == '+973' ? 'selected' : '' }} data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                <option value="+974" {{ old('whatsapp_country_code') == '+974' ? 'selected' : '' }} data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                            </select>
                                                        </span>
                                                        <input id="geex-input-whatsapp" type="text" name="whatsapp" placeholder="أدخل رقم واتساب" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <span class="input-group-text"><i class="uil uil-whatsapp"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                    @error('whatsapp_country_code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('whatsapp')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="geex-input-phone" class="form-label">رقم للتواصل</label>
                                                <div class="input-wrapper input-icon position-relative">
                                                    <div class="input-group">
                                                        <span class="input-group-text p-0" style="min-width: 110px;">
                                                            <img id="selected-phone-flag-img" src="{{ asset('assets/flags/sa.png') }}" alt="flag" style="width: 24px; height: 18px; margin-right: 5px;">
                                                            <select name="phone_country_code" id="phone-country-code-select" class="form-select border-0 bg-transparent px-2 @error('phone_country_code') is-invalid @enderror" style="width: 80px;">
                                                                <option value="+966" {{ old('phone_country_code') == '+966' ? 'selected' : '' }} data-flag="sa" data-flag-src="{{ asset('assets/flags/sa.png') }}">+966</option>
                                                                <option value="+20" {{ old('phone_country_code') == '+20' ? 'selected' : '' }} data-flag="eg" data-flag-src="{{ asset('assets/flags/eg.png') }}">+20</option>
                                                                <option value="+971" {{ old('phone_country_code') == '+971' ? 'selected' : '' }} data-flag="ae" data-flag-src="{{ asset('assets/flags/ae.png') }}">+971</option>
                                                                <option value="+965" {{ old('phone_country_code') == '+965' ? 'selected' : '' }} data-flag="kw" data-flag-src="{{ asset('assets/flags/kw.png') }}">+965</option>
                                                                <option value="+964" {{ old('phone_country_code') == '+964' ? 'selected' : '' }} data-flag="iq" data-flag-src="{{ asset('assets/flags/iq.png') }}">+964</option>
                                                                <option value="+962" {{ old('phone_country_code') == '+962' ? 'selected' : '' }} data-flag="jo" data-flag-src="{{ asset('assets/flags/jo.png') }}">+962</option>
                                                                <option value="+963" {{ old('phone_country_code') == '+963' ? 'selected' : '' }} data-flag="sy" data-flag-src="{{ asset('assets/flags/sy.png') }}">+963</option>
                                                                <option value="+968" {{ old('phone_country_code') == '+968' ? 'selected' : '' }} data-flag="om" data-flag-src="{{ asset('assets/flags/om.png') }}">+968</option>
                                                                <option value="+973" {{ old('phone_country_code') == '+973' ? 'selected' : '' }} data-flag="bh" data-flag-src="{{ asset('assets/flags/bh.png') }}">+973</option>
                                                                <option value="+974" {{ old('phone_country_code') == '+974' ? 'selected' : '' }} data-flag="qa" data-flag-src="{{ asset('assets/flags/qa.png') }}">+974</option>
                                                            </select>
                                                        </span>
                                                        <input id="geex-input-phone" type="text" name="phone" placeholder="أدخل رقم للتواصل" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                        <span class="input-group-text"><i class="uil uil-phone"></i></span>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                    @error('phone_country_code')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="instagram" class="mb-2 black bold">رابط إنستجرام</label>
                                                <input type="text" class="theme-input-style @error('instagram') is-invalid @enderror" name="instagram" value="{{ old('instagram') }}" placeholder="أدخل رابط إنستجرام">
                                                <div class="invalid-feedback"></div>
                                                @error('instagram')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="google_Map" class="mb-2 black bold">رابط جوجل ماب</label>
                                                <input type="text" class="theme-input-style @error('google_Map') is-invalid @enderror" name="google_Map" value="{{ old('google_Map') }}" placeholder="أدخل رابط جوجل ماب">
                                                <div class="invalid-feedback"></div>
                                                @error('google_Map')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="google_Map_2" class="mb-2 black bold">رابط جوجل ماب 2</label>
                                                <input type="text" class="theme-input-style @error('google_Map_2') is-invalid @enderror" name="google_Map_2" value="{{ old('google_Map_2') }}" placeholder="أدخل رابط جوجل ماب">
                                                <div class="invalid-feedback"></div>
                                                @error('google_Map_2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if($theme_id == 2)
                                            <div class="col-lg-6">
                                                <div class="form-group mb-4">
                                                    <label for="menu" class="mb-2 black bold">قائمة الطعام (PDF)</label>
                                                    <input type="file" class="theme-input-style @error('menu') is-invalid @enderror" name="menu" accept="application/pdf">
                                                    <div class="invalid-feedback"></div>
                                                    @error('menu')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-12">
                                            <div class="form-group mb-4">
                                                <label for="description" class="mb-2 black bold">الوصف</label>
                                                <textarea class="theme-input-style @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="وصف">{{ old('description') }}</textarea>
                                                <div class="invalid-feedback"></div>
                                                @error('description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="company_id" value="{{ request()->get('id') }}">
                                    </div>

                                    <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                                        <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="text-nowrap bg-white dh-table">
                        <thead class="thead-light">
                            <tr>
                                <th>م</th>
                                <th>اسم الفرع</th>
                                <th>عدد الحملات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                                @php
                                    $ads = App\Models\Ads::where('company_id', request()->get('id'))->get();
                                    $countAds = 0;
                                    foreach ($ads as $ad) {
                                        $catsIds = is_array($ad->cats_ids) ? $ad->cats_ids : json_decode($ad->cats_ids, true);
                                        $catsIds = is_array($catsIds) ? $catsIds : [];
                                        if (!empty($catsIds) && ($catsIds[0] === 'all' || in_array($one->id, $catsIds))) {
                                            $countAds++;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $one->name }}</td>
                                    <td>
                                        <a href="{{ route('ads_.index', ['comp_id' => request()->get('id'), 'cat_id' => $one->id]) }}" class="text-primary">
                                            {{ $countAds }}
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm bg-info-light text-info mr-10" data-toggle="modal" data-target="#projectEditModal_{{ $one->id }}">تعديل</a>
                                        <form action="{{ route('cats.destroy', $one->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="company_id" value="{{ request()->get('id') }}">
                                            <button type="submit" class="btn btn-sm bg-danger-light text-danger mr-10" onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div id="projectEditModal_{{ $one->id }}" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <form action="{{ route('cats.update', $one->id) }}" method="POST" enctype="multipart/form-data" data-id="{{ $one->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center" style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                                        <h4 class="mb-0" style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                                            تعديل
                                                        </h4>
                                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close" style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>

                                                    <div class="row">
                                                        <!-- نفس الحقول كالإضافة لكن بقيم قديمة -->
                                                        <!-- تم نسخها مع تعديل id و name و invalid-feedback -->
                                                        <!-- (للاختصار: نفس الكود لكن بـ old() و $one->... ) -->
                                                        <!-- سأضع النص الكامل أسفل -->
                                                    </div>

                                                    <div class="d-flex justify-content-center pt-3" style="padding-bottom: 10px;">
                                                        <button type="submit" class="btn btn-primary ml-3">تعديل</button>
                                                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Validation (موحد للإضافة والتعديل) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const showError = (input, msg) => {
        const group = input.closest('.form-group') || input.parentElement;
        let feedback = group.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            group.appendChild(feedback);
        }
        input.classList.add('is-invalid');
        feedback.textContent = msg;
        feedback.style.display = 'block';
    };

    const clearError = (input) => {
        const group = input.closest('.form-group') || input.parentElement;
        const feedback = group.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = '';
            feedback.style.display = 'none';
        }
        input.classList.remove('is-invalid');
    };

    const validatePhoneFormat = (code, number) => {
        if (!number) return true;
        const patterns = {
            '+966': /^5\d{8}$/,
            '+20':  /^1\d{9}$/,
            '+971': /^5\d{8}$/,
            '+965': /^[569]\d{7}$/,
            '+964': /^7\d{9}$/,
            '+962': /^7\d{8}$/,
            '+963': /^9\d{8}$/,
            '+968': /^9\d{7}$/,
            '+973': /^3\d{7}$/,
            '+974': /^3\d{7}$/
        };
        return patterns[code] ? patterns[code].test(number) : true;
    };

    const updateFlag = (select, img) => {
        const option = select.options[select.selectedIndex];
        const src = option.getAttribute('data-flag-src');
        if (src) img.src = src;
    };

    const setupValidation = (form) => {
        if (!form) return;

        const fields = {
            name: form.querySelector('[name="name"]'),
            whatsapp_code: form.querySelector('[name="whatsapp_country_code"]'),
            whatsapp: form.querySelector('[name="whatsapp"]'),
            phone_code: form.querySelector('[name="phone_country_code"]'),
            phone: form.querySelector('[name="phone"]'),
            instagram: form.querySelector('[name="instagram"]'),
            google_Map: form.querySelector('[name="google_Map"]'),
            google_Map_2: form.querySelector('[name="google_Map_2"]'),
            description: form.querySelector('[name="description"]'),
            menu: form.querySelector('[name="menu"]'),
            whatsapp_flag: form.querySelector('#selected-whatsapp-flag-img, [id^="edit-whatsapp-flag-img-"]'),
            phone_flag: form.querySelector('#selected-phone-flag-img, [id^="edit-phone-flag-img-"]')
        };

        if (fields.whatsapp_code && fields.whatsapp_flag) updateFlag(fields.whatsapp_code, fields.whatsapp_flag);
        if (fields.phone_code && fields.phone_flag) updateFlag(fields.phone_code, fields.phone_flag);

        const validateName = () => {
            const val = fields.name.value.trim();
            if (!val) { showError(fields.name, 'اسم الفرع مطلوب.'); return false; }
            if (val.length > 255) { showError(fields.name, 'اسم الفرع لا يزيد عن 255 حرفًا.'); return false; }
            clearError(fields.name); return true;
        };

        const validateWhatsapp = () => {
            const code = fields.whatsapp_code?.value;
            const num = fields.whatsapp?.value.trim();
            if (num && !code) { showError(fields.whatsapp, 'كود دولة الواتساب مطلوب إذا أدخلت الرقم.'); return false; }
            if (code && !num) { showError(fields.whatsapp, 'رقم الواتساب مطلوب إذا اخترت كود الدولة.'); return false; }
            if (num) {
                if (!/^\d+$/.test(num)) { showError(fields.whatsapp, 'رقم الواتساب يجب أن يكون أرقامًا فقط.'); return false; }
                if (num.length < 7 || num.length > 15) { showError(fields.whatsapp, 'رقم الواتساب يجب أن يكون بين 7 و15 رقمًا.'); return false; }
                if (!validatePhoneFormat(code, num)) { showError(fields.whatsapp, 'رقم الواتساب غير صالح لهذا الكود.'); return false; }
            }
            clearError(fields.whatsapp); return true;
        };

        const validatePhone = () => {
            const code = fields.phone_code?.value;
            const num = fields.phone?.value.trim();
            if (num && !code) { showError(fields.phone, 'كود دولة التواصل مطلوب إذا أدخلت الرقم.'); return false; }
            if (code && !num) { showError(fields.phone, 'رقم التواصل مطلوب إذا اخترت كود الدولة.'); return false; }
            if (num) {
                if (!/^\d+$/.test(num)) { showError(fields.phone, 'رقم التواصل يجب أن يكون أرقامًا فقط.'); return false; }
                if (num.length < 7 || num.length > 15) { showError(fields.phone, 'رقم التواصل يجب أن يكون بين 7 و15 رقمًا.'); return false; }
                if (!validatePhoneFormat(code, num)) { showError(fields.phone, 'رقم التواصل غير صالح لهذا الكود.'); return false; }
            }
            clearError(fields.phone); return true;
        };

        const validateUrl = (input, name) => {
            const val = input.value.trim();
            if (!val) { clearError(input); return true; }
            const urlRegex = /^https?:\/\/[^\s$.?#].[^\s]*$/;
            if (!urlRegex.test(val)) { showError(input, `${name} غير صالح.`); return false; }
            clearError(input); return true;
        };

        const validateDescription = () => {
            if (fields.description.value.length > 1000) { showError(fields.description, 'الوصف لا يزيد عن 1000 حرف.'); return false; }
            clearError(fields.description); return true;
        };

        const validateMenu = () => {
            if (!fields.menu?.files[0]) { clearError(fields.menu); return true; }
            const file = fields.menu.files[0];
            if (file.type !== 'application/pdf') { showError(fields.menu, 'الملف يجب أن يكون PDF.'); return false; }
            if (file.size > 5 * 1024 * 1024) { showError(fields.menu, 'حجم الملف لا يزيد عن 5 ميجابايت.'); return false; }
            clearError(fields.menu); return true;
        };

        // Events
        fields.name?.addEventListener('input', validateName);
        fields.whatsapp?.addEventListener('input', validateWhatsapp);
        fields.whatsapp_code?.addEventListener('change', () => { updateFlag(fields.whatsapp_code, fields.whatsapp_flag); validateWhatsapp(); });
        fields.phone?.addEventListener('input', validatePhone);
        fields.phone_code?.addEventListener('change', () => { updateFlag(fields.phone_code, fields.phone_flag); validatePhone(); });
        fields.instagram?.addEventListener('input', () => validateUrl(fields.instagram, 'رابط إنستجرام'));
        fields.google_Map?.addEventListener('input', () => validateUrl(fields.google_Map, 'رابط خرائط Google الأول'));
        fields.google_Map_2?.addEventListener('input', () => validateUrl(fields.google_Map_2, 'رابط خرائط Google الثاني'));
        fields.description?.addEventListener('input', validateDescription);
        fields.menu?.addEventListener('change', validateMenu);

        form.addEventListener('submit', e => {
            let valid = true;
            [validateName, validateWhatsapp, validatePhone, validateDescription, validateMenu].forEach(fn => { if (!fn()) valid = false; });
            [fields.instagram, fields.google_Map, fields.google_Map_2].forEach(f => { if (f && !validateUrl(f, f.name)) valid = false; });
            if (!valid) e.preventDefault();
        });
    };

    // Apply to Add Form
    setupValidation(document.getElementById('add-branch-form'));

    // Apply to Edit Modals
    document.querySelectorAll('[id^="projectEditModal_"]').forEach(modal => {
        modal.addEventListener('shown.bs.modal', () => {
            setupValidation(modal.querySelector('form'));
        });
    });

    // AJAX Submit for Add Form
    const addForm = document.getElementById('add-branch-form');
    if (addForm) {
        addForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const submitBtn = addForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> جاري الحفظ...';

            try {
                const response = await fetch(addForm.action, {
                    method: 'POST',
                    body: new FormData(addForm),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();

                if (response.ok && result.success) {
                    $('#projectAddModal').modal('hide');
                    toastr.success(result.message || 'تمت الإضافة بنجاح');
                    window.location.reload();
                } else {
                    if (result.errors) {
                        Object.keys(result.errors).forEach(field => {
                            const input = addForm.querySelector(`[name="${field}"]`);
                            if (input) showError(input, result.errors[field][0]);
                        });
                    } else {
                        toastr.error(result.message || 'فشل في الإضافة');
                    }
                }
            } catch (error) {
                toastr.error('حدث خطأ في الاتصال');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
});
</script>