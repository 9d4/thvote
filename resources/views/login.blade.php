@extends('skeleton')

@section('title')
    Login 👋
@endsection

@section('container')
    <div class="row my-5">
        <div class="col col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Login</h3>

                    <form method="post">
                        @csrf

                        @if(session('status'))
                            <div class="alert alert-danger">
                                {{session('status')}}
                            </div>
                        @endif

                        <div class="form-group has-validation">
                            <label for="username">Username</label>
                            <input class="form-control form-control-sm @error('username') is-invalid @enderror"
                                   type="number"
                                   id="username"
                                   value="{{old('username')}}"
                                   name="username">
                            @error('username')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control form-control-sm @error('password') is-invalid @enderror"
                                   type="password"
                                   id="password"
                                   value="{{old('password')}}"
                                   name="password">
                            @error('password')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{route('register')}}">
                                <small>Belum punya akun? Register &rightarrow;</small>
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
