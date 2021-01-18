@if(session()->has('successmessage') || session()->has('errormessage'))
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(session()->has('successmessage'))
                    <div class="alert alert-success alert-dismissable fade show" role="alert">
                        {{ session()->get('successmessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session()->has('errormessage'))
                    <div class="alert alert-danger alert-dismissable fade show" role="alert">
                        {{ session()->get('errormessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
