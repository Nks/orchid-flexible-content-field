@component($typeForm,get_defined_vars())
    <div class="flexible-content"
         data-controller="fields--flexible_content"
         data-name="{{ $name }}">
        <input type="hidden" name="{{ $name }}" value=""/>
        <div class="row">
            <div class="col-md-12">
                <section class="content b wrapper-xs mb-2 empty" data-target="fields--flexible_content.content">
                    <div class="no-value-message">
                        {{ __('Click the "Add Block" button below to start creating your layout') }}
                    </div>
                    <div data-target="fields--flexible_content.blocks"></div>
                </section>
                <div class="dropdown pull-right dropup">
                    <button class="btn btn-default dropdown-toggle" type="button"
                            id="flexible_content_selector_{{ $name }}"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-plus m-r-xs"></i> {{ __('Add block') }}
                    </button>
                    @if($layouts)
                        <div class="dropdown-menu dropdown-menu-right"
                             aria-labelledby="flexible_content_selector_{{ $name }}">
                            @foreach($layouts as $layout)
                                <a class="dropdown-item" href="#"
                                   data-action="click->fields--flexible_content#layoutSelect"
                                   data-layout="{{ $layout->name() }}"
                                   data-max="{{ $layout->max }}"
                                   data-min="{{ $layout->min }}">
                                    {{ $layout->title() }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @include('platform::partials.fields.flexible_content_layouts')
    </div>
@endcomponent