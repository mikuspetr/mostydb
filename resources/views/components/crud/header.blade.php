<div class="crud-header">
    <h1>{{$slot}}</h1>
    @unlessrole('auditor')
    <a href="{{ $route }}" class="btn {{$btnClass}} crud-header__button">
        <i class="{{$btnIconClass}}"></i>
        {{ $btnText }}
    </a>
    @endunlessrole
</div>
