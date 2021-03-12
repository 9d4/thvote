@extends('dash.app')

@section('title') Verified Users List @endsection

@section('right')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Daftar User Terverifikasi <span>[{{ count($verified_usernames) }}]</span></h5>

        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addNewVerifiedUser">Tambahkan</button>
        <div class="modal" id="addNewVerifiedUser">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        Tambahkan Verified User
                    </div>
                    <div class="modal-body">
                        <form class="form-group form-row" method="post" action="{{ route('admin.addVerifiedUser') }}">
                            <input class="form-control form-control-sm col-9" type="text" name="verified_username">
                            @csrf
                            <div class="col-3">
                                <button class="btn btn-sm btn-primary d-flex ml-auto">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th style="min-width: 129px">Username</th>
                    <th style="min-width: 211px">Verified at</th>
                    <th style="min-width: 35px">Action</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $counter = 0;
                @endphp

                @foreach($verified_usernames as $_ITEM)
                    <tr>
                        <th>{{ ++$counter }}</th>
                        <td>{{ $_ITEM->username }}</td>
                        <td>{{ $_ITEM->created_at }}</td>
                        <td>
                            <form method="post" action="{{ route('admin.removeVerifiedUser') }}">
                                <button class="btn btn-sm btn-danger btn-block font-weight-bold"><span
                                        class="fas fa-user-slash"></span>&nbsp;Remove
                                </button>@csrf <input type="hidden" value="{{ $_ITEM->username }}"
                                                      name="verified_username"></form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
