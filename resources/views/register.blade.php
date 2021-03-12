@extends('skeleton')

@section('title')
    Register 👋
@endsection

@section('container')
    <div class="row my-5">
        <div class="col col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="m-0">Register</h3>
                    <p class="card-subtitle mb-3 mt-1 text-info small">Gunakan NIS sebagai username</p>

                    <form method="post" action="/register">
                        @csrf
                        <div class="form-group has-validation">
                            <label for="username">Username</label>
                            <input class="form-control form-control-sm @error('username') is-invalid @enderror"
                                   type="text"
                                   id="username"
                                   value="{{old('username')}}"
                                   name="username" required>
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
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror"
                                   type="password"
                                   id="cpassword"
                                   name="password_confirmation" required>
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>


                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{route('login')}}">
                                <small>Sudah punya akun? Login &rightarrow;</small>
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
