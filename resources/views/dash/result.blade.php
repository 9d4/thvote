@extends('dash.app')

@section('title') Hasil @endsection

@section('right')
    <h5>Hasil</h5>
    @unless(\App\Traits\HelpTrait::isVoteReset())
        <p class="text-muted">@if(\App\Traits\HelpTrait::hasVoteFinished()) Hasil Akhir @else Hasil Sementara @endif</p>

        @foreach($results as $TYPE)
            <h5 class="font-weight-bold">{{ $TYPE->type }}<span class="badge badge-dark ml-3">{{ $TYPE->total_voter }} Voter</span>
            </h5>
            @foreach($TYPE->candidates as $CANDIDATE)
                <div class="card card-body mb-2">

                    <div class="row">
                        <div class="col-2 col-sm-1 pr-0 d-flex align-items-center">
                            <span class="h4 text-black-50 font-weight-bold text-center mb-0">{{ $CANDIDATE->number }}</span>
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
    @endunless
@endsection
