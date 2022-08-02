@if (Session::has('alert')) 
    @php
        $type = Session::get('alert-type', '');
    @endphp
    @switch ($type) 
        @case ('info'):
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-body d-flex align-items-center">
                    <i data-feather="info" class="me-50"></i>
                    <span><b>Info!</b>. {{ Session::get('alert') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @break;
        @case ('success'):
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body d-flex align-items-center">
                    <i data-feather="info" class="me-50"></i>
                    <span><b>Success!</b>. {{ Session::get('alert') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @break;
        @case ('warning'):
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-body d-flex align-items-center">
                    <i data-feather="info" class="me-50"></i>
                    <span><b>Warning!</b>. {{ Session::get('alert') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @break;
       @case ('error'):
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-body d-flex align-items-center">
                    <i data-feather="alert-triangle" class="me-50"></i>
                    <span><b>Error!</b>. {{ Session::get('alert') }}</span>
                  </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    
            @break;
    @endswitch
@endif