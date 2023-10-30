@props(['title', 'name', 'type'])

<label for="{{ $name }}">{{ $title }}</label>
<input type="{{ $type }}" name="{{ $name }}" value="{{ old($name) }}" class="form-control" id="{{ $name }}"
    placeholder="Enter {{ $title }}" 
    >
@error($name)
    <span class="invalid-feedback d-block">{{ $message }}</span>
@enderror
