@extends('skeleton')

@section('title') Pemilihan Calon @endsection

@section('container')
    @include('user.template.banner')
    @include('user.template.meta')

    @if(session('access_error'))
        <div class="alert alert-warning my-1">
            Impossible! Admin tidak bisa ngevote.
        </div>
    @endif

    @if(session('candidate_not_found'))
        <div class="alert alert-warning my-1">
            Tidak ditemukan!
        </div>
    @endif

    @if(session('already_voted'))
        <div class="alert alert-warning my-1">
            Sudah memilih calon {{ session('type_string') }}. Tidak dapat memilih lagi.
        </div>
    @endif

    @if (\App\Traits\HelpTrait::isVoteRunning())
        <div class="alert alert-info mt-2">
            Hasil dapat dilihat kurang lebih pada <span data-deadline="{{ \App\Traits\HelpTrait::getDeadline() }}" id="deadlineNotice"></span>
        </div>

        <div class="py-3">
            <section class="mb-5">
                <div class="alert alert-success d-flex justify-content-between align-items-center mb-2">
                    <div class="align-items-center d-flex">
                    <span class="h6 m-0 mr-2">
                        <strong>Calon Ketua</strong>
                    </span>
                    </div>
                    <div>
                        <span class="badge badge-success">{{ count($leaders) }} Calon</span>
                    </div>
                </div>
                @unless($admin)
                    <div class="mb-3 d-flex justify-content-end">
                        @if($leader_voted)
                            <span class="text-wrap text-success">Sudah Memilih</span>
                        @else
                            <span class="text-wrap text-warning">Belum Memilih</span>
                        @endif
                    </div>
                @endunless


                <div class="row">
                    @foreach($leaders as $ITEM)
                        @include('user.template.card')
                    @endforeach
                </div>
                <hr/>
            </section>

            <section class="mb-5">
                <div class="alert alert-info d-flex justify-content-between align-items-center mb-2">
                    <div class="align-items-center d-flex">
                    <span class="h6 text-wrap m-0 mr-2">
                        <strong>Calon Wakil Ketua</strong>
                    </span>
                    </div>
                    <div>
                        <span class="badge badge-primary">{{ count($co_leaders) }} Calon</span>
                    </div>
                </div>
                @unless($admin)
                    <div class="mb-3 d-flex justify-content-end">
                        @if($co_leader_voted)
                            <span class="text-wrap text-primary">Sudah Memilih</span>
                        @else
                            <span class="text-wrap text-warning">Belum Memilih</span>
                        @endif
                    </div>
                @endunless

                <div class="row">
                    @foreach($co_leaders as $ITEM)
                        @include('user.template.card')
                    @endforeach
                </div>
                <hr/>
            </section>
        </div>
    @elseif(!\App\Traits\HelpTrait::hasVoteFinished())
        <div class="py-3">
            <div class="alert alert-info text-center font-weight-bold">
                Mohon bersabar! Kami sedang memverifikasi data voting untuk menghindari kecurangan.
            </div>
        </div>
    @elseif(\App\Traits\HelpTrait::hasVoteFinished())
        <div class="py-3">
            <h5>Hasil Voting</h5>

            @foreach($results as $TYPE)
                <h5 class="font-weight-bold">{{ $TYPE->type }}<span class="badge badge-dark ml-3">{{ $TYPE->total_voter }} Voter</span>
                </h5>
                @foreach($TYPE->candidates as $CANDIDATE)
                    <div class="card card-body mb-2">

                        <div class="row">
                            <div class="col-2 col-sm-1 pr-0 d-flex align-items-center">
                                <span
                                    class="h4 text-black-50 font-weight-bold text-center mb-0">{{ $CANDIDATE->number }}</span>
                            </div>
                            <div class="col-10 col-sm-11">
                                <p class="m-0 card-text font-weight-bold">{{ \Illuminate\Support\Str::title($CANDIDATE->name) }}</p>
                                <div class="progress">
                                    <div class="progress-bar font-weight-bold" role="progressbar"
                                         style="width: {{ $CANDIDATE->percentage }}">{{ $CANDIDATE->percentage }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <hr/>
            @endforeach
        </div>
    @endif
@endsection
