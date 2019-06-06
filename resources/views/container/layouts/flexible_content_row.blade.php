@push('scripts')
    <script type="text/html" data-fc-field-template-name="{{ $layout->field->get('template') }}" data-fc-layout-name="{{ $name }}">
    @include(\Nakukryskin\OrchidFlexibleContentField\Screen\Layouts\FlexibleContentLayout::BLOCK_TEMPLATE, [
        'value' => null
    ])
    </script>
@endpush