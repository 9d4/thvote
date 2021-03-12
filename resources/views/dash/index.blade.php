@extends('dash.app')

@section('title') Dashboard @endsection

@section('right')
    <div class="card card-body mb-2">
        <div class="d-flex justify-content-between align-items-center">
            <span class="card-text">
                Status Voting
                <span
                    class="badge @if($vote_running) badge-success @elseif($vote_reset) badge-dark @elseif($vote_paused) badge-warning @else badge-danger @endif">
                     @if($vote_running) Berjalan @elseif($vote_reset) Belum Dimulai @elseif($vote_paused) Dijeda @else
                        Berhenti @endif
                </span>
            </span>

            <div class="">
                @if($vote_running)
                    <form class="d-inline" action="{{ route('admin.post.pauseVote') }}" method="post">
                        <button class="btn btn-sm alert-warning" type="submit">Jeda!</button>
                        @csrf
                    </form>

                    <form class="d-inline" action="{{ route('admin.post.stopVote') }}" method="post">
                        <button class="btn btn-sm alert-danger" type="submit">Hentikan!</button>
                        @csrf
                    </form>
                @elseif(!$vote_finish)
                    <form class="d-inline" action="{{ route('admin.post.startVote') }}" method="post">
                        <button class="btn btn-sm alert-success" type="submit">Mulai!</button>
                        @csrf
                    </form>
                @endif
                @unless($vote_reset)
                    <form class="d-inline" action="{{ route('admin.post.resetVote') }}" method="post">
                        <button class="btn btn-sm btn-danger" type="submit">Reset Voting</button>
                        @csrf
                    </form>
                @endunless
            </div>
        </div>
        <div class="alert alert-info mb-0 mt-2">
            <p class="m-0">Mulai!, pengguna dapat melihat calon dan mulai memilih.</p>
            <p class="m-0">Hentikan!, Voting selesai dan pengguna dapat melihat hasil.</p>
            <p class="m-0">Jeda!, Ada kesalahan data? Jeda saja!</p>
            <p class="m-0"><strong>Reset!</strong>, Kembalikan ke awal.</p>
        </div>
    </div>

    <div class="card card-body mb-2">
        @error('banner_image')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        @if (session('image_changed'))
            <div class="alert alert-success">
                Berhasil mengubah gambar banner.
            </div>
        @endif

        <form class="form-group row mb-0" enctype="multipart/form-data" method="post"
              action="{{ route('admin.post.changeBanner') }}">
            <label class="col-sm-3 col-form-label">Ganti Banner</label>
            <div class="col-sm-7">
                <div class="custom-file">
                    <label class="custom-file-label">Pilih file</label>
                    <input class="custom-file-input" type="file" name="banner_image">
                </div>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">Ganti</button>
            </div>
            @csrf
        </form>
    </div>

    <div class="card card-body mb-2">
        @error('deadline')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @enderror

        @if (session('deadline_changed'))
            <div class="alert alert-success">
                Berhasil mengatur deadline.
            </div>
        @endif

        <form class="form-group row mb-0 align-items-center" method="post" action="{{ route('admin.post.changeDeadline') }}">
            <label class="col-sm-3 col-form-label">Deadline</label>
            <div class="col-sm-7">
                <input class="form-control form-control-sm" type="datetime-local" name="deadline" value="{{ \App\Traits\HelpTrait::getDeadlineForInput() }}">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-sm btn-primary d-flex ml-auto" type="submit">Atur</button>
            </div>
            @csrf
        </form>
        <div class="alert alert-info mt-2 mb-0">
            Deadline <b>tidak</b> akan menghentikan voting secara otomatis. Hanya untuk mengingatkan pengguna kapan dapat melihat hasil.
        </div>
    </div>

    <div class="card card-body">
        <form class="form-group form-row mb-0 d-flex align-items-center" method="post" action="{{ route('admin.verifyVote') }}">
            <label class="col-form-label col-9">Verify Voting</label>
            @csrf
            <div class="col-3">
            <button class="d-flex ml-auto btn btn-sm btn-warning">Verify</button>
            </div>
        </form>
        <p class="alert alert-info card-text">Digunakan untuk menghapus user yang tidak berhak atau tidak terverifikasi secara otomatis.</p>
    </div>
@endsection
