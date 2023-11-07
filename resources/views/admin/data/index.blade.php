@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
    <style>
        #uploadExcelQuestion {
            cursor: pointer
        }
    </style>
@endsection
@section('content')
    <div class="card bg-light m-4 rounded shadow border-0">
        <div class="card-header p-4 d-flex">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal"> <span class="me-1">
                    <i class="fas fa-plus-circle fa-lg">
                    </i> </span> Tambah Data </button>
            <button class="btn btn-success"> <span class="me-1"> <i class="fa-solid fa-file-excel fa-lg"></i> </span>
                Upload
                Excel </button>
            <span class="ms-2 mt-2" align="center" id="uploadExcelQuestion"> <i
                    class="fa-solid fa-circle-question fa-xl"></i> </span>
        </div>
        <div class="card-header p-4">
            <h1> THIS SECTION IS FOR FILTERS </h1>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success mb-3" id="refresh"><i class="fa-solid fa-arrows-rotate me-1"
                    id="refreshIcon"></i> Refresh </button>
            <div class="table-responsive">
                <table id="tableData" style="width:100%" class="table table-striped table-bordered table-hover"
                    border="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Timestamp</th>
                            <th>Witel</th>
                            <th>ID Valins</th>
                            <th>Eviden 1</th>
                            <th>Eviden 2</th>
                            <th>Eviden 3</th>
                            <th>ID Valins lama</th>
                            <th>ASO</th>
                            <th>Ket. ASO</th>
                            <th>RAM3</th>
                            <th>Ket. RAM3</th>
                            <th>Rekon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($data->updated_at != null)
                                        {{ $data->updated_at }}
                                    @else
                                        @if ($data->timestamp_bawaan == null)
                                            <b style="color: red">ANOMALY</b>
                                        @else
                                            {{ $data->timestamp_bawaan }}
                                        @endif
                                    @endif
                                </td>
                                <td> {{ $data->witel }} </td>
                                <td> {{ $data->id_valins }} </td>
                                @if (empty($data->id_eviden1))
                                    <td><a target="_blank"> <img src="" class="evidenImg"
                                                alt="Tidak ada Image/Error" style="width: 300px"> </a></td>
                                @else
                                    <td><a href="{{ $data->eviden1 }}" target="_blank"> <img
                                                src="https://drive.google.com/uc?id={{ $data->id_eviden1 }}"
                                                class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>
                                    </td>
                                @endif
                                @if (empty($data->id_eviden2))
                                    <td><a target="_blank"> <img src="" class="evidenImg"
                                                alt="Tidak ada Image/Error" style="width: 300px"> </a></td>
                                @else
                                    <td><a href="{{ $data->eviden2 }}" target="_blank"> <img
                                                src="https://drive.google.com/uc?id={{ $data->id_eviden2 }}"
                                                class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>
                                    </td>
                                @endif
                                @if (empty($data->id_eviden3))
                                    <td><a target="_blank"> <img src="" class="evidenImg"
                                                alt="Tidak ada Image/Error" style="width: 300px"> </a></td>
                                @else
                                    <td><a href="{{ $data->eviden3 }}" target="_blank"> <img
                                                src="https://drive.google.com/uc?id={{ $data->id_eviden3 }}"
                                                class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>
                                    </td>
                                @endif
                                <td> {{ $data->id_valins_lama }} </td>
                                <td> {{ $data->approve_aso == 'null' ? '' : $data->approve_aso }} </td>
                                <td> {{ $data->keterangan_aso }} </td>
                                <td> {{ $data->ram3 }} </td>
                                <td> {{ $data->keterangan_ram3 }} </td>
                                <td> {{ $data->rekon }} </td>
                                <td align="center">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-auto mb-1">
                                            <button class="btn btn-warning" type="button" style="color: white;"
                                                data-data-id="{{ $data['id'] }}"
                                                data-valins-id="{{ $data['id_valins'] }}" id="btnEdit"> Edit
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-danger" type="button"
                                                data-data-id="{{ $data['id'] }}"
                                                data-valins-id="{{ $data['id_valins'] }}" id="btnHapus"> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> Tambah Data </h2>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <form class="p-3" id="tambahDataForm">

                                    <input type="hidden" name="csrfHidden" id="csrfHidden" value="{{ csrf_token() }}" />

                                    <label for="formWitel"> Witel <span style="color:red"> * </span> </label>
                                    <select name="formWitel" id="formWitel" class="form-control mb-2">
                                        <option value="TIDAK MEMILIH WITEL" id="formWitel_default" default> Pilih
                                        </option>
                                        <option value="BANDUNG"> Bandung </option>
                                        <option value="BANDUNG BARAT"> Bandung Barat </option>
                                        <option value="CIREBON"> Cirebon </option>
                                        <option value="KARAWANG"> Karawang </option>
                                        <option value="SUKABUMI"> Sukabumi </option>
                                        <option value="TASIKMALAYA"> Tasikmalaya </option>
                                    </select>

                                    <label for="formIdValins"> ID Valins <span style="color:red"> * </span> </label>
                                    <input type="number" name="formIdValins" id="formIdValins"
                                        class="form-control mb-2" />

                                    <label for="formEviden1"> Eviden 1 <span style="color:red"> * </span> </label>
                                    <textarea name="formEviden1" id="formEviden1" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formEviden2"> Eviden 2 </label>
                                    <textarea name="formEviden2" id="formEviden2" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formEviden3"> Eviden 3 </label>
                                    <textarea name="formEviden3" id="formEviden3" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formIdValinsLama"> ID Valins Lama </label>
                                    <input type="number" name="formIdValinsLama" id="formIdValinsLama"
                                        class="form-control mb-2" />

                                    <label for="formRekon"> Rekon <span style="color:red"> * </span> </label>
                                    <select name="formRekon" id="formRekon" class="form-control mb-2">
                                        <option value="TIDAK MEMILIH REKON" id="formRekon_default" default> Pilih
                                        </option>
                                        <option value="JANUARI"> Januari </option>
                                        <option value="FEBRUARI"> Februari </option>
                                        <option value="MARET"> Maret </option>
                                        <option value="APRIL"> April </option>
                                        <option value="MEI"> Mei </option>
                                        <option value="JUNI"> Juni </option>
                                        <option value="JULI"> Juli </option>
                                        <option value="AGUSTUS"> Agustus </option>
                                        <option value="SEPTEMBER"> September </option>
                                        <option value="OKTOBER"> Oktober </option>
                                        <option value="NOVEMBER"> November </option>
                                        <option value="DESEMBER"> Desember </option>
                                    </Select>

                                    <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                            style="color: red">*</span> wajib diisi <span class="ms-5"> <button
                                                type="button" id="clearBtn">clear</button> </span> </small>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 80%;">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalBtn">Batalkan</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary"> <span
                            class="spinner-border spinner-border-sm me-1" id="submitSpinner"
                            style="display: none;"></span> Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editDataModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> Edit Data: <span id="idValins_here"></span> </h2>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <section id="serverError" style="display: none;">
                                    <h2 class="p-5" style="color: red;"> SERVER ERROR </h2>
                                </section>

                                <section id="serverSuccess">
                                    <form class="p-3" id="editDataForm">

                                        <input type="hidden" name="edit_csrfHidden" id="edit_csrfHidden"
                                            value="{{ csrf_token() }}" />
                                        <input type="hidden" name="edit_dataId" id="edit_dataId">
                                        <input type="hidden" name="edit_hiddenIdValins" id="edit_hiddenIdValins">

                                        <label for="edit_formWitel"> Witel <span style="color:red"> * </span> </label>
                                        <select name="edit_formWitel" id="edit_formWitel" class="form-control mb-2">
                                            <option value="TIDAK MEMILIH WITEL" id="edit_formWitel_default" default> Pilih
                                            </option>
                                            <option value="BANDUNG" id="witel_BANDUNG"> Bandung </option>
                                            <option value="BANDUNG BARAT" id="witel_BANDUNG BARAT"> Bandung Barat
                                            </option>
                                            <option value="CIREBON" id="witel_CIREBON"> Cirebon </option>
                                            <option value="KARAWANG" id="witel_KARAWANG"> Karawang </option>
                                            <option value="SUKABUMI" id="witel_SUKABUMI"> Sukabumi </option>
                                            <option value="TASIKMALAYA" id="witel_TASIKMALAYA"> Tasikmalaya </option>
                                        </select>

                                        <label for="edit_formIdValins"> ID Valins <span style="color:red"> * </span>
                                        </label>
                                        <input type="number" name="edit_formIdValins" id="edit_formIdValins"
                                            class="form-control mb-2" />

                                        <label for="edit_formEviden1"> Eviden 1 <span style="color:red"> * </span>
                                        </label>
                                        <textarea name="edit_formEviden1" id="edit_formEviden1" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formEviden2"> Eviden 2 </label>
                                        <textarea name="edit_formEviden2" id="edit_formEviden2" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formEviden3"> Eviden 3 </label>
                                        <textarea name="edit_formEviden3" id="edit_formEviden3" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formIdValinsLama"> ID Valins Lama </label>
                                        <input type="number" name="edit_formIdValinsLama" id="edit_formIdValinsLama"
                                            class="form-control mb-2" />

                                        <label for="edit_formRekon"> Rekon <span style="color:red"> * </span> </label>
                                        <select name="edit_formRekon" id="edit_formRekon" class="form-control mb-2">
                                            <option value="TIDAK MEMILIH REKON" id="edit_formRekon_default" default> Pilih
                                            </option>
                                            <option value="JANUARI" id="rekon_JANUARI"> Januari </option>
                                            <option value="FEBRUARI" id="rekon_FEBRUARI"> Februari </option>
                                            <option value="MARET" id="rekon_MARET"> Maret </option>
                                            <option value="APRIL" id="rekon_APRIL"> April </option>
                                            <option value="MEI" id="rekon_MEI"> Mei </option>
                                            <option value="JUNI" id="rekon_JUNI"> Juni </option>
                                            <option value="JULI" id="rekon_JULI"> Juli </option>
                                            <option value="AGUSTUS" id="rekon_AGUSTUS"> Agustus </option>
                                            <option value="SEPTEMBER" id="rekon_SEPTEMBER"> September </option>
                                            <option value="OKTOBER" id="rekon_OKTOBER"> Oktober </option>
                                            <option value="NOVEMBER" id="rekon_NOVEMBER"> November </option>
                                            <option value="DESEMBER" id="rekon_DESEMBER"> Desember </option>
                                        </Select>

                                        <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                                style="color: red">*</span> wajib diisi <span class="ms-5"> <button
                                                    type="button" id="edit_clearBtn">clear</button> </span> </small>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 100%;">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" id="edit_closeModalBtn">Batalkan</button>
                    <button type="submit" id="edit_submitBtn" class="btn btn-primary"> <span
                            class="spinner-border spinner-border-sm me-1" id="edit_submitSpinner"
                            style="display: none;"></span> Submit</button>
                </div>
                </form>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal Upload Excel Question -->
    <div class="modal fade" id="excelQuestionModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> Tutorial upload data Excel </h2>
                </div>
                <div class="modal-body m-4">

                    <ul>
                        <li> Tekan tombol <span style="color: green; font-weight: bold;"> Upload Excel </span> </li>
                        <li> Tipe file yang di upload harus ber-tipe <span style="font-weight: bold;"> .XLSX </span> </li>
                        <li> Pastikan file <span style="font-weight: bold;"> .XLSX </span> memiliki heading row dengan
                            kolom yang sesuai: </li>
                        <ul style="font-style: italic;">
                            <li>TIMESTAMP</li>
                            <li>WITEL</li>
                            <li>ID VALINS</li>
                            <li>EVIDEN 1</li>
                            <li>EVIDEN 2</li>
                            <li>ID VALINS LAMA</li>
                            <li>EVIDEN 3</li>
                            <li>APPROVE ASO</li>
                            <li>KET ASO</li>
                            <li>RAM 3</li>
                            <li>REKON</li>
                            <li>KET RAM3</li>
                        </ul>
                        <img src="https://cdn.discordapp.com/attachments/758697084039462913/1171050943106797568/image.png?ex=655b452d&is=6548d02d&hm=43965ed1d1d7270031b584806a745d12889090d740e3fc4b5759dabf0c6703bf&"
                            alt="Gagal memuat gambar" class="form-control mt-2">
                        <button class="btn btn-success mt-2" id="downloadBtn"><span><i
                                    class="fa-solid fa-download fa-fade me-2"></i></span> Download Template </button>
                        <li class="mt-2"> Jika upload file sukses dan sudah sesuai format, maka anda telah berhasil!
                        </li>
                    </ul>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="edit_closeModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container top-0 end-0 mt-2 me-2 position-fixed">
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningLengkapiForm">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Lengkapi form! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningIDValinsDuplikat">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> ID Valins terdeteksi duplikat! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningURLTidakValid">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Format URL tidak valid! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-dangerGagalCreate">
            <div class="d-flex">
                <i class="fa-solid fa-circle-xmark fa-fade fa-2xl"></i>
                <div class="toast-body">
                    <h6> Data gagal ditambahkan! coba lagi nanti </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successCreate">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil ditambahkan! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successUpdate">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil diupdate! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successDelete">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil dihapus! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-dangerGagalHapus">
            <div class="d-flex">
                <i class="fa-solid fa-circle-xmark fa-fade fa-2xl"></i>
                <div class="toast-body">
                    <h6> Akun gagal dihapus! coba lagi nanti </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $('.evidenImg').on('error', function() {
            $(this).parent('a').removeAttr('href');
        });
        $(function() {
            $(document).ready(function() {
                $('#tableData').DataTable();
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/data/main.js') }}"></script>
@endsection
