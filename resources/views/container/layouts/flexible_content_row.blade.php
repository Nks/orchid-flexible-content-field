<div class="flexible-content-layout" data-target="fields--flexible_content.layout" data-name="{{ $name }}">
    <div class="card">
        <div class="card-header">
            <h5 class="actions">
                <span class="action card-handle icon-size-fullscreen"></span>
                <span class="action icon-plus" data-action="click->fields--flexible-content#add"
                      data-toggle="tooltip" data-placement="top" title="{{ __('Add new block below') }}"></span>
                <span class="action icon-minus" data-action="click->fields--flexible-content#delete"
                      data-toggle="tooltip" data-placement="top" title="{{ __('Delete block') }}"></span>
                <span class="badge badge-light pull-right"
                      data-target="fields--flexible-content.index"></span>
            </h5>
        </div>
        <div class="card-body repeater-content">
            {!! $form ?? '' !!}
        </div>
    </div>
</div>
