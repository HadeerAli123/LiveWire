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
                      @livewire('ads-table')

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
               
                </div>
            </div>
        </div>
    </div>
</div>
