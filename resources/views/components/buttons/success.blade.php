@props(['text'=>$text ?? 'Button','target'=>$target ?? '','link'=>$link ?? 'javascript:void(0);'])
<a href="{{$link}}">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="{{$target}}">
        {{$text}}
    </button>
</a>
