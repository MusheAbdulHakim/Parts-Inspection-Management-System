@props(['text'=>$text ?? 'Button','target'=>$target ?? '','link'=>$link ?? 'javascript:void(0);', 'id'=> $id ?? ''])
<a href="{{($link)}}">
    <button type="button" id="{{$id}}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{$target}}">
        <i data-feather="plus"></i> {{$text}}
    </button>
</a>