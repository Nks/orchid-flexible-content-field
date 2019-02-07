<div class="card layout" data-fc_key="{{ $index }}">
    <div class="card-header">
        <h5 class="actions">
            <span class="badge badge-pill layout-index"
                  data-target="fields--flexible_content.layoutIndex"></span>
            <span class="action card-handle icon-size-fullscreen"
                  data-parent-container-key="{{ $layout->getContainerKey() }}"></span>
            <span class="action icon-minus" data-action="click->fields--flexible_content#delete"></span>
            <span class="badge badge-info pull-right">{{ $title }}</span>
        </h5>
    </div>
    <div class="card-body repeater-content">
        <input type="hidden" name="{{ $layout->getFormPrefix() }}[_fc_layout]" value="{{ $layout->name() }}"/>
        {!! $form ?? '' !!}
    </div>
</div>