<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">


<style>
.theme-input-style {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #ccc !important;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.theme-input-style:focus {
    border-color: #4a57f5;
    outline: none;
}
</style>
<style>
table.dataTable thead th,
table.dataTable thead td,
table.dataTable tfoot th,
table.dataTable tfoot td {
    text-align: justify !important;
}
</style> 



<style>
.styled-select {
  width: 100%;
  height: 48px;
  padding: 10px 40px 10px 16px;
  border: 1.8px solid #d0d0d0;
  border-radius: 12px;
  background-color: #f8f9fa;
  color: #333;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23555' stroke-linecap='round' stroke-linejoin='round' stroke-width='2'%3E%3Cpath d='M2 4l4 4 4-4'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: left 16px center;
  background-size: 16px;
}

.styled-select:hover {
  border-color: #4a57f5;
  box-shadow: 0 0 6px rgba(74, 87, 245, 0.15);
}

.styled-select:focus {
  border-color: #4a57f5;
  outline: none;
  background-color: #fff;
  box-shadow: 0 0 6px rgba(74, 87, 245, 0.25);
}

option {
  padding-right: 25px;
}
</style>

<div class="row">
    <div class="col-12  ">
        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">
                <h6 class="font-15 "> الحملات الاعلانية</h6>
              <div class="row mb-3 align-items-center" style="margin-top: 20px;">

   <div class="col-md-3">
        <select class="styled-select" id="cat_id_filter">
            <option value=""> كل الفروع</option>
             @php
                $categories = App\Models\Category::all();
            @endphp
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request()->get('cat_id') == $cat->id ? 'selected' : '' }}>
                    🌿 {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>



 <div class="col-md-3">
        <select class="styled-select" id="status_filter">
            <option value=""> كل الحالات</option>
            <option value="pending">⏳ معلقة</option>
            <option value="active">🟢 نشطة</option>
            <option value="inactive">🔴 منتهية</option>
        </select>
    </div>


   

    <div class="col-md-2">
        <button class="btn btn-primary w-80" id="filter_btn" style="height: 48px;">
                
بحث <i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                   
                    <div class="col-md-4" style="display: block; float: left; text-align: end;">
                        <div class="add-new-contact ml-20" style="float: left;">
                            <button class="btn btn-success dropdown-toggle" type="button" id="actionsDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: #707072c4; border-color: #28a745; color: #fff;">
                                خيارات
                            </button>
                            <div class="dropdown-menu" aria-labelledby="actionsDropdown">
                                <a class="dropdown-item" href="{{ route('excel.files') }}">
                                    <i class="fas fa-file-excel text-primary"></i> ملفات الاكسيل
                                </a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#projectAddModal">
                                    <i class="fas fa-plus text-success"></i> حملة جديدة
                                </a>
                                <a class="dropdown-item" href="{{ route('excel.export',['id' => 'all']) }}">
                                    <i class="fas fa-file-export text-info"></i> تصدير الكل
                                </a>
                            </div>
                        </div>
                    </div>
                    <br /><br />
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>

                    <div id="projectAddModal" class="modal fade">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <!-- Modal Body -->
                                <div class="modal-body">
                                  
                               @livewire('ads-form')
                                </div>
                                <!-- End Modal Body -->
                            </div>
                        </div>
                    </div>
                </div>
                <br /><br />
                <div class="table-responsive">
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table" id="all_ads-table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>اسم الحملة</th>
                                <th>تاريخ الاعلان</th>
                                <th>الحالة</th>
                                <th>عدد زيارات اليوم</th>
                                <th>صورة او فيديو</th>
                                <th>الفروع</th>
                                <th>اللينك</th>
                                <th>QR كود</th>
                                <th>احصائيات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var table = $('#all_ads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('allAds.data') }}",
            type: 'GET', // تأكدي من أن الطلب يستخدم GET
            data: function(d) {
                d.cat_id = $('#cat_id_filter').val(); // فلترة الفرع
                d.status = $('#status_filter').val(); // فلترة الحالة
                console.log('Filters:', { cat_id: d.cat_id, status: d.status }); // تصحيح الأخطاء
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error:', xhr, error, thrown); // تصحيح الأخطاء
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name', searchable: true },
            { data: 'ads_date', name: 'ads_date' },
            { data: 'status', name: 'status' },
            { data: 'visits_count', name: 'visits_count' },
            { data: 'img', name: 'img' },
            { data: 'cat', name: 'cat' },
            { data: 'link', name: 'link' },
            { data: 'qr_code', name: 'qr_code', orderable: false, searchable: false },
            { data: 'statistics', name: 'statistics' },
            { data: 'actions', name: 'actions' }
        ],
        language: {
            url: "{{ asset('assets/js/datatables/ar.json') }}"
        }
    });

    // تحديث الجدول و URL عند النقر على زر البحث
    $('#filter_btn').on('click', function() {
        var catId = $('#cat_id_filter').val();
        var status = $('#status_filter').val();
        var newUrl = window.location.pathname;
        var params = [];

        if (catId) {
            params.push('cat_id=' + catId);
        }
        //////////
        if (status) {
            params.push('status=' + status);
        }

        /////////
        if (params.length > 0) {
            newUrl += '?' + params.join('&');
        }

        console.log('New URL:', newUrl); // تصحيح الأخطاء
        window.history.pushState({}, '', newUrl);
        table.ajax.reload(); // إعادة تحميل الجدول بناءً على الفلاتر
    });

    // تحديث السيلكت في المودال بناءً على الفرع المختار
 
    // إخفاء/إظهار قائمة الفروع في المودال بناءً على اختيار الفرع
    $('#cat_id_filter').on('change', function() {
        let val = $(this).val();
        if (val) {
            $('#cats_ids').closest('.form-group').hide();
            if (!$('input[name="cat_id"][type="hidden"]').length) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'cat_id',
                    value: val
                }).appendTo('form');
            } else {
                $('input[name="cat_id"][type="hidden"]').val(val);
            }
        } else {
            $('#cats_ids').closest('.form-group').show();
            $('input[name="cat_id"][type="hidden"]').remove();
        }
    });
});
</script>

<script>
function checkData(comp_id) {
    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{ route('checkData', ':id') }}".replace(':id', comp_id),
        success: function(res) {
            const hasCats = Array.isArray(res.cats) && res.cats.length > 0;
            if (hasCats) {
                const selectCats = $('#cats_ids');
                $('#branches').show();
                selectCats.empty().append('<option value="all">الكل</option>');
                $.each(res.cats, function(index, cat) {
                    selectCats.append('<option value="' + cat.id + '">' + cat.name + '</option>');
                });
            } else {
                $('#branches').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}

function editData(comp_id) {
    if (!comp_id) {
        $('#branches_2').hide();
        return;
    }

    $.ajax({
        type: 'get',
        dataType: "json",
        url: "{{ route('checkData', ':id') }}".replace(':id', comp_id),
        success: function(res) {
            if (res.cats && Array.isArray(res.cats) && res.cats.length > 0) {
                let select = $('#cats_ids_2');
                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.cats, function(index, cat) {
                    select.append('<option value="' + cat.id + '"' + (cat.isSelected ? ' selected' : '') + '>' + cat.name + '</option>');
                });
                $('#branches_2').show();
            }
            if (res.prods && Array.isArray(res.prods) && res.prods.length > 0) {
                let select = $('#product_ids_2');
                select.empty();
                select.append('<option value="all">الكل</option>');
                $.each(res.prods, function(index, prod) {
                    select.append('<option value="' + prod.id + '">' + prod.name + '</option>');
                });
            } else {
                $('#branches_2').hide();
            }
        },
        error: function(res) {}
    });
}
</script>

<script>
const startInput = document.getElementById('start_date');
const endInput = document.getElementById('end_date');
const output = document.getElementById('number_days');
const total_amount = document.getElementById('total_amount');
const amount_per_day = document.getElementById('amount_per_day');

function calculateDateDiff() {
    const start = new Date(startInput.value);
    const end = new Date(endInput.value);
    const perDayAmount = parseFloat(amount_per_day.value);

    if (!isNaN(start) && !isNaN(end)) {
        const diffTime = end - start;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
        output.value = diffDays;
        total_amount.value = (diffDays * perDayAmount);
    } else {
        output.value = '';
    }
}

startInput.addEventListener('change', calculateDateDiff);
endInput.addEventListener('change', calculateDateDiff);
amount_per_day.addEventListener('change', calculateDateDiff);


/////////////خاص بزرارا بدء الان 
function startNow(id) {
    if (!confirm('هل أنت متأكد من بدء الحملة الآن؟')) return;

    fetch(`/ads/start-now/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(err => console.error(err));
}
</script>

