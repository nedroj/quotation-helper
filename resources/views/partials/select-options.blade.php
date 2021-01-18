@foreach($options as $option)
    <option value="{{ $option['value'] }}"{{ $selected == $option['value'] ? ' selected' : ''}}>{{ $option['name'] }}</option>
    @if(isset($option['children']) && is_array($option['children']))
        @include('partials.select-options', ['options' => $option['children']])
    @endif
@endforeach
