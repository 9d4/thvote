@extends('dash.app')

{{--PARENT SECTIONS--}}
@section('title') @yield('title') @endsection
{{--END--}}

@section('right')
    @error('photo')
    <div class="alert alert-danger mb-3">
        Gagal mengupload gambar, pilih gambar lainnya! Perhatikan ukuran file!
    </div>
    @enderror

    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="m-0">Daftar Calon @yield('candidates.type')</h5>

            @unless(\App\Traits\HelpTrait::isVoteRunning())
                <button class="btn btn-sm btn-primary"
                        data-toggle="modal"
                        data-target="#modalNewCandidate">
                    Tambahkan Calon @yield('candidates.type')
                </button>
                {{--MODAL NEW--}}
                <div class="modal fade" id="modalNewCandidate">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Data Calon</h5>
                                <button class="close" data-toggle="modal" data-target="#modalNewCandidate">&times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="@yield('candidates.newAction')" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nomor</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm"
                                                   id="number"
                                                   name="number"
                                                   type="number"
                                                   value="{{old('number')}}"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="name">Nama</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm"
                                                   type="text"
                                                   name="name"
                                                   value="{{old('name')}}"
                                                   id="name" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="vision">Visi</label>
                                        <div class="col-sm-10">
                                <textarea class="form-control"
                                          id="vision"
                                          name="vision"
                                          required>{{old('vision')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="mission">Misi</label>
                                        <div class="col-sm-10">
                                <textarea class="form-control"
                                          id="mission"
                                          name="mission" required>{{old('mission')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="photo">Foto</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input class="form-control-file form-control"
                                                       type="file"
                                                       id="photo"
                                                       value="{{old('photo')}}"
                                                       name="photo" required>
                                                <label class="custom-file-label" for="photo">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{--MODAL NEW END--}}
            @endunless
        </div>

        @if(session('numberExists'))
            <div class="alert alert-danger alert-dismissible mb-2">
                <span>Nomor sudah ada!</span>
                <button class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="row">
            @foreach($candidates as $CANDIDATE)
                <div class="col-6 col-sm-4">
                    <div class="card mb-2">
                        <img src="{{ $CANDIDATE->photo }}" class="card-img-top">
                        <h4 class="card-title text-center text-dark alert-warning py-1 m-0">
                            <strong>{{ $CANDIDATE->number }}</strong>
                        </h4>

                        <div class="card-body">
                            {{--MAIN CARD--}}
                            <h5 class="card-subtitle text-center">{{$CANDIDATE->name}}</h5>
                            <div class="btn-group w-100 mt-3">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#dial_vision_{{ $CANDIDATE->id }}" onclick="openVision(`{{ $CANDIDATE->vision }}`, '{{ $CANDIDATE->id }}')">
                                    Visi
                                </button>
                                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#dial_mission_{{ $CANDIDATE->id }}" onclick="openMission(`{{ $CANDIDATE->mission }}`, '{{ $CANDIDATE->id }}')">
                                    Misi
                                </button>
                            </div>
                            {{--MAIN CARD END--}}

                            @unless(\App\Traits\HelpTrait::isVoteRunning())
                                {{--DELETE DIALOG--}}
                                <button class="btn btn-sm btn-block btn-danger mt-2"
                                        data-toggle="modal"
                                        data-target="#deleteModal_{{$CANDIDATE->id}}">
                                    Delete
                                </button>

                                <div class="modal fade " id="deleteModal_{{$CANDIDATE->id}}">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi</h5>
                                                <button class="close" data-toggle="modal"
                                                        data-target="#deleteModal_{{$CANDIDATE->id}}">
                                                    &times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Yakin ingin menghapus calon nomor {{ $CANDIDATE->number }}</p>
                                                <form class="my-2"
                                                      action="{{route('admin.deleteCandidate', ['id' => $CANDIDATE->id])}}"
                                                      method="post">
                                                    @csrf
                                                    <button class="btn btn-sm btn-block btn-danger mt-2">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--DELETE DIALOG END--}}
                            @endunless

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
