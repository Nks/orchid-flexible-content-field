@foreach($layouts as $layout)
    {!! $layout->build(new \Orchid\Screen\Repository()) !!}
@endforeach