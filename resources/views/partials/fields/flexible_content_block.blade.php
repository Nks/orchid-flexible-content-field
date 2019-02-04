<div class="card layout">
    <div class="card-header">
        <h5 class="actions">
            <span class="action card-handle icon-size-fullscreen"></span>
            <span class="action icon-plus" data-action="click->fields--flexible_content#add"></span>
            <span class="action icon-minus" data-action="click->fields--flexible_content#delete"></span>
            <span class="badge badge-light pull-right"
                  data-target="fields--flexible_content.index"></span>
        </h5>
    </div>
    <div class="card-body repeater-content">
        {!! $form ?? '' !!}
    </div>
</div>