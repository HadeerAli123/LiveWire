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
<div class="row">
    <div class="col-12">

        <div class="card mb-30 radius-20">
            <div class="card-body pt-30">

                <h4 class="font-15 ">المستخدمين</h4>

                <div class="add-new-contact ml-20">
                    <a href="#" class="bg-success-light text-success btn ui-sortable-handle" data-toggle="modal"
                        data-target="#projectAddModal" style="float: left;">
                        مستخدم جديد
                    </a>
                </div>
                <div id="projectAddModal" class="modal fade">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content">
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                        <h4 class="mb-0"
                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                            إضف جديد</h4>
                                        <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close"
                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_name" class="mb-2 black bold">الاسم</label>
                                                <input type="text" class="theme-input-style" id="user_name" name="name"
                                                    placeholder="اكتب الاسم">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_username" class="mb-2 black bold">اسم المستخدم</label>
                                                <input type="text" class="theme-input-style" id="user_username"
                                                    name="username" placeholder="اكتب اسم المستخدم">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_email" class="mb-2 black bold">البريد
                                                    الإلكتروني</label>
                                                <input type="email" class="theme-input-style" id="user_email"
                                                    name="email" placeholder="ادخل البريد الإلكتروني">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label for="user_password" class="mb-2 black bold">كلمة المرور</label>
                                                <input type="password" class="theme-input-style" id="user_password"
                                                    name="password" placeholder="ادخل كلمة المرور">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="d-flex justify-content-center pt-3" style="    padding-bottom: 10px;">
                                <button type="submit" class="btn btn-primary ml-3">حفظ</button>
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                            </div>
                            </form>
                        </div>
                        <!-- End Modal Body -->
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Invoice List Table -->
                    <table class="text-nowrap bg-white dh-table">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>الاسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الالكترونى</th>
                                <th>الاجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $one)
                            @if (is_object($one) )
                            
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $one->name ?? '' }}</td>
                                <td>{{ $one->username ?? '' }}</td>
                                <td>{{ $one->email ?? ''}}</td>
                                <td>
                                    <a  class="bg-success-light text-success btn ui-sortable-handle"
                                        data-toggle="modal" data-target="#projectEditModal_{{$one->id}}">
                                         تعديل
                                    </a>
                                     <form action="{{ route('users.destroy', $one->id) }}" method="POST"
                                         style="display:inline;">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm bg-danger-light text-danger mr-10"
                                             onclick="return confirm(' هل أنت متأكد من الحذف ');">حذف</button>
                                     </form>
                                </td>

                                <div id="projectEditModal_{{$one->id}}" class="modal fade">
                                    <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <form action="{{ route('users.update',$one->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="contact-account-setting media-body d-flex justify-content-between align-items-center"
                                                        style="background: #e3e4e6; border-radius: 12px; padding-top: 20px; padding-bottom: 15px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                                        <h4 class="mb-0"
                                                            style="font-weight: bold; letter-spacing: 1px; text-align: left;padding-right: 10px;">
                                                             تعديل</h4>
                                                        <button type="button" class="close ml-2" data-dismiss="modal"
                                                            aria-label="Close"
                                                            style="padding-left: 10px;font-size: 2rem; background: none; border: none;">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_name"
                                                                    class="mb-2 black bold">الاسم</label>
                                                                <input type="text" class="theme-input-style"
                                                                    id="user_name" name="name" value="{{$one->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_username" class="mb-2 black bold">اسم
                                                                    المستخدم</label>
                                                                <input type="text" class="theme-input-style"
                                                                    id="user_username" name="username"
                                                                    value="{{$one->username}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_email" class="mb-2 black bold">البريد
                                                                    الإلكتروني</label>
                                                                <input type="email" class="theme-input-style"
                                                                    id="user_email" name="email"
                                                                    value="{{$one->email}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-4">
                                                                <label for="user_password" class="mb-2 black bold">كلمة
                                                                    المرور</label>
                                                                <input type="password" class="theme-input-style"
                                                                    id="user_password" name="password"
                                                                   >
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="d-flex justify-content-center pt-3"
                                                style="    padding-bottom: 10px;">
                                                <button type="submit" class="btn btn-primary ml-3">تعديل</button>
                                                <button type="reset" class="btn btn-secondary"
                                                    data-dismiss="modal">إلغاء</button>
                                            </div>
                                            </form>
                                        </div>
                                        <!-- End Modal Body -->
                                    </div>

                                </div>
                                
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
            </div>
        </div>

    </div>
</div>