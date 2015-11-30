@if(App::getLocale() == 'en')
    {!!  link_to_route('language.select', 'العربية', ['ar'])!!}
@else
    {!! link_to_route('language.select', 'En', ['en'])!!}
@endif