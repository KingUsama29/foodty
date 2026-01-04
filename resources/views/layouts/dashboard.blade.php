<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard FoodTY</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS kamu --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    {{-- ================= HEADER (MOBILE & DESKTOP) ================= --}}
    @include('partials.headerDashboard')

    {{-- ================= WRAPPER ================= --}}
    <div class="container-fluid">
        <div class="row">

            {{-- ================= SIDEBAR (DESKTOP ONLY) ================= --}}
            <aside class="col-lg-3 col-xl-2 d-none d-lg-flex flex-column p-0 bg-white border-end"
                style="position: fixed; top:56px; left:0; height: calc(100vh - 56px);">

                <div class="sidebar-scroll" style="height:100%; overflow-y:auto; overflow-x:hidden;">
                    @include('partials.sidebarDashboard')
                </div>
            </aside>


            {{-- ================= MAIN CONTENT ================= --}}
            <main class="col-12 col-lg-9 col-xl-10 ms-auto p-3"
                style="
                    height: calc(100vh - 56px);
                    overflow-y: auto;
                    margin-top: 56px;
                ">
                <div class="dashboard-content">
                    @yield('content')
                </div>

            </main>


        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
