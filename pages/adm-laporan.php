<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Laporan Pesanan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Laporan Pesanan
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-sm-6 mb-3 sm-0">
                    <div class="card">
                        <div class="card-body">
                            <form action="pages/controller/laporan-bulanan.php" method="POST">
                                <div>
                                    <p class="text-center">Data Laporan Bulanan</p>
                                    <hr>
                                </div>
                                <div class="mb-3">
                                    <label for="bulanSelect" class="form-label">Bulan</label>
                                    <select id="bulanSelect" name="bulan" class="form-select">
                                        <option value="">Pilih Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tahunSelectBulan" class="form-label">Tahun</label>
                                    <select id="tahunSelectBulan" name="tahun" class="form-select">
                                        <option value="">Pilih Tahun</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <!-- Tambahkan tahun yang diperlukan -->
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="pages/controller/laporan-tahunan.php" method="POST">
                                <div>
                                    <p class="text-center">Data Laporan Tahunan</p>
                                    <hr>
                                </div>
                                <div class="mb-3">
                                    <label for="tahunSelect" class="form-label">Tahun</label>
                                    <select id="tahunSelect" name="tahun" class="form-select">
                                        <option value="">Pilih Tahun</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <!-- Tambahkan tahun yang diperlukan -->
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->