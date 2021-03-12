@push('menu')
    @php
        $url = request()->fullUrl();
        $index = (route('admin.dash') == $url);
        $isLeaders = (route('admin.leaders') == $url);
        $isCoLeaders = (route('admin.coLeaders') == $url);
        $isResult = (route('admin.result') == $url);
        $isVerifiedUsers = (route('admin.verifiedUsers') == $url);
    @endphp

    <ul class="list-group mb-5 mb-md-0 sticky-top pt-1">
        <a class="list-group-item list-group-item-action @if($index) active @endif"
           href="{{route('admin.dash')}}"><span class="fas fa-tachometer-alt mr-2"></span>Dashboard</a>
        <a class="list-group-item list-group-item-action @if($isVerifiedUsers) active @endif"
           href="{{route('admin.verifiedUsers')}}"><span class="fas fa-user-check mr-1"></span>Verified Users</a>
        <a class="list-group-item list-group-item-action @if($isLeaders) active @endif"
           href="{{route('admin.leaders')}}"><span class="fas fa-id-badge mr-2"></span>Calon Ketua</a>
        <a class="list-group-item list-group-item-action @if($isCoLeaders) active @endif"
           href="{{route('admin.coLeaders')}}"><span class="fas fa-id-badge mr-2"></span>Calon Wakil</a>
        <a class="list-group-item list-group-item-action @if($isResult) active @endif"
           href="{{ route('admin.result') }}"><span class="fas fa-poll-h mr-2"></span>Hasil</a>
        <a class="list-group-item list-group-item-action"
           href="{{ route('index') }}"><span class="fas fa-user mr-2"></span>Tampilan User</a>
    </ul>
    @include('footer')
@endpush
