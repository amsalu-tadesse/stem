@props(['title', 'name'])

<label for="{{ $name }}">{{ $title }}</label>
<textarea {{ $attributes->merge(['rows'=>'rows="10"']) }} name="{{ $name }}" id="{{ $name }}" cols="30"  class="form-control" placeholder="Enter {{ $title }}">{{ old($name) }}</textarea>

@error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
@enderror
