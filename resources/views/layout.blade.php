@include('includes/head')

<!-- ✅ خلي السطر ده جوه ملف includes/head.blade.php -->
@livewireStyles 

<style>
    .card {
        border-radius: 20px !important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .breadcrumb {
        border-radius: 20px !important;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;   
    }
</style>

<body>
    <!-- Offcanval Overlay -->
    <div class="offcanvas-overlay"></div>

    <div class="wrapper">
        @include('includes/header')

        <div class="main-wrapper">
            @include('includes/sidebar')

            <div class="main-content">
                <div class="container-fluid">
                    @include('includes/crumb')

                    <!-- محتوى الصفحة -->
                    @include($view)
                    
                    <!-- ✅ هنا استدعاء الكومبوننت -->
                    <div>
                        @livewire('counter')
                    </div>
                </div>
            </div>
        </div>

        @include('includes/footer')
    </div>

    <!-- ✅ ده ضروري جدًا يتحط قبل نهاية الـ body -->
    @livewireScripts
</body>
</html>
