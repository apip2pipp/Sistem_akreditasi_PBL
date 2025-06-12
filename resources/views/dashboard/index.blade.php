@extends('layouts.template')
@vite('resources/css/app.css')
@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">



            <!-- ===========================================================-->
            <!-- ADMIN DASHBOARD -->
            <!-- ===========================================================-->
            <!-- Data User -->
            @if (auth()->user()->level->level_kode === 'ADM')
                <div class="col-lg-3 col-6">
                    <!-- small box -->

                    <div class="small-box bg-ijo6 text-ijo1">
                        <div class="inner">
                            <h3>{{ $dataUser }}</h3>

                            <p>Data User</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>


                <!-- Data level -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo1 text-ijo6">
                        <div class="inner">
                            <h3>{{ $dataLevel }}</h3>

                            <p>Data Level</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <!-- Data Criteria -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo6 text-ijo1">
                        <div class="inner">
                            <h3>{{ $totalCriteria }}</h3>

                            <p>Data Criteria</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <!-- Data Permission -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo1 text-ijo6">
                        <div class="inner">
                            <h3>{{ $totalPermission }}</h3>

                            <p>Data Permission</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body">
    <div class="p-4 rounded shadow-sm" style="background: #e6ffe6; border-left: 5px solid #2e7d32;">
        <h4 class="mb-3" style="font-weight: bold; color: #1b5e20;">
            <i class="fas fa-certificate"></i> Welcome, {{ auth()->user()->name }}!
        </h4>
        <p>
            This platform is designed to support the accreditation process. Accreditation is a critical mechanism used to evaluate and ensure the quality of educational institutions and programs.
        </p>
        <p>
            Through this system, we aim to collect, organize, and present essential data that reflect academic performance, institutional development, and continuous improvement efforts.
        </p>
        <p>
            Your participation is vital. By providing accurate and timely information, you contribute to enhancing transparency, accountability, and the overall quality assurance of our institution.
        </p>
        <hr>

    </div>
</div>


            @endif

            <!-- ===========================================================-->
            <!-- KOORDINATOR DASHBOARD -->
            <!-- ===========================================================-->
            @if (auth()->user()->level->level_kode === 'KDR')
                <!-- Data Penelitian -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo6 text-ijo1">
                        <div class="inner">
                            <h3>{{ $dataPenelitianKoordinator }}</h3>
                            <p>Data Penelitian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>


                <!-- Total Kriteria -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo1 text-ijo6">
                        <div class="inner">
                            <h3>{{ $totalCriteria }}</h3>
                            <p>Total Criteria</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>
            @endif

            <!-- ===========================================================-->
            <!-- DOSEN DASHBOARD -->
            <!-- ===========================================================-->
            @if (auth()->user()->level->level_kode === 'DSN')
                <!-- Data Penelitian -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo6 text-ijo1">
                        <div class="inner">
                            <h3>{{ $dataPenelitianDosen }}</h3>
                            <p>Data Penelitian</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>
            @endif



            <!-- ===========================================================-->
            <!-- KPS -->
            <!-- ===========================================================-->
            <!-- ===========================================================-->
            <!-- KPS DASHBOARD -->
            <!-- ===========================================================-->
            @if (in_array(auth()->user()->level->level_kode, ['KPD', 'DIR', 'KJM', 'KJR']))
                <!-- Total Dosen -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo6 text-ijo1">
                        <div class="inner">
                            <h3>{{ $totalDosen }}</h3>
                            <p>Total Team Akreditasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Akreditasi -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-ijo1 text-ijo6">
                        <div class="inner">
                            <h3>{{ $totalAkreditasi }}</h3>
                            <p>Total Akreditasi</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-university"></i>
                        </div>
                    </div>
                </div>
            @endif



            <!-- ===========================================================-->
            <!-- KAJUR -->
            <!-- ===========================================================-->



            <!-- ===========================================================-->
            <!-- KJM -->
            <!-- ===========================================================-->



            <!-- ===========================================================-->
            <!-- DIRUT -->
            <!-- ===========================================================-->

            {{--
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <!-- ./col -->
        </div>
    </div>
@endsection
