<div class="col-6 col-md-4">
    <div class="card mb-1">
        <img class="card-img-top" src="{{ $ITEM->photo }}">
        <h4 class="card-title text-center text-dark alert-warning py-1 m-0">
            <strong>{{ $ITEM->number }}</strong>
        </h4>

        <div class="card-body">
            <h5 class="card-subtitle text-center">{{$ITEM->name}}</h5>
            <div class="btn-group w-100 mt-3">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#dial_vision_{{ $ITEM->id }}" onclick="openVision(`{{ $ITEM->vision }}`, '{{ $ITEM->id }}')">
                    Visi
                </button>
                <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#dial_mission_{{ $ITEM->id }}" onclick="openMission(`{{ $ITEM->mission }}`, '{{ $ITEM->id }}')">
                    Misi
                </button>
            </div>
            {{--VOTE MODAL--}}
            @unless($admin || $ITEM->type_voted)
                <button class="btn btn-block btn-outline-info mt-2"
                        data-toggle="modal"
                        data-target="#voteModal_{{$ITEM->id}}">
                    <strong>Pilih</strong>
                </button>
                <div class="modal" id="voteModal_{{$ITEM->id}}">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi</h5>
                                <button class="close" data-toggle="modal"
                                        data-target="#voteModal_{{$ITEM->id}}">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Yakin memilih <span
                                        class="h5 font-weight-bold">{{ \Illuminate\Support\Str::title($ITEM->name) }}</span>
                                    dengan nomor urut <span
                                        class="h5 font-weight-bold">{{ $ITEM->number }}</span>&nbsp;?
                                </p>
                                <div class="alert alert-warning">
                                    <div>Tindakan ini tidak dapat dikembalikan atau diulang!</div>
                                    <div>Pilihlah dengan bijak!</div>
                                </div>
                                <form action="{{ route('post.vote') }}" method="post">
                                    <button class="btn btn-sm btn-block btn-info mt-2">
                                        <strong>Pilih</strong>
                                    </button>
                                    @csrf
                                    <input type="hidden" value="{{ $ITEM->id }}" name="candidate_id">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endunless
            {{--VOTE MODAL END--}}
        </div>
    </div>
</div>
