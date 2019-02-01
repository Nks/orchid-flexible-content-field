@component($typeForm,get_defined_vars())
    <div class="repeater"
         data-controller="fields--flexible-content">
        <input type="hidden" name="{{ $name }}" value=""/>
        <div class="row">
            <div class="col-md-12">
                <section class="repeaters_container" data-target="fields--repeater.repeaterContainer"></section>
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-plus m-r-xs"></i> {{ __('Add block') }}
                    </button>
                    @if($layouts)
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach($layouts as $layout)
                                <a class="dropdown-item" href="#"
                                   data-action="click->fields--flexible-content#addBlock">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endcomponent