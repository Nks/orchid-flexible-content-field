@push('scripts')
    <script type="text/html" data-target="fields--flexible_content.layout" data-name="{{ $name }}">
    @include(\Nakukryskin\OrchidFlexibleContentField\Screen\Layouts\FlexibleContentLayout::BLOCK_TEMPLATE, [
        'value' => []
    ])
    </script>
@endpush