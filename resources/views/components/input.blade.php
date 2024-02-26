@props(['input', 'name', 'required' => false, 'title', 'rows' => 3, 'title', 'label', 'options', 'value' => '', 'Values', 'multiple' => false])

<div class="form-group">

	@isset($title)
		<label style="font-weight: bold;" for="{{ $name }}">@lang($title)</label>
	@endisset

	@if ($input === 'textarea')
		<div class="form-control-wrap">
			<textarea class="form-control" rows="{{ $rows }}" id="{{ $name }}" name="{{ $name }}"
				@if ($required) required @endif>{{ old($name, $value) }}</textarea>
		</div>
	@elseif ($input === 'checkbox')
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" id="{{ $name }}" name="{{ $name }}" type="checkbox"
				{{ $value ? 'checked' : '' }}>
			<label class="custom-control-label" for="{{ $name }}">
				{{ __($label) }}
			</label>
		</div>
	@elseif ($input === 'select')
		<div class="form-control-wrap">
			<select @if ($required) required @endif class="form-select form-control" name="{{ $name }}"
				id="{{ $name }}">
				@foreach ($options as $option)
					<option value="{{ $option['value'] }}"
						{{ old($name)? (old($name) == $option['name']? 'selected': ''): ($option['name'] == $value? 'selected': '') }}>
						{{ $option['name'] }}
					</option>
				@endforeach
			</select>
		</div>
	@elseif ($input === 'selectMultiple')
		<div class="form-control-wrap">
			<select multiple @if ($required) required @endif class="form-control"
				name="{{ $name }}[]" id="{{ $name }}">
				@foreach ($options as $id => $title)
					<option value="{{ $id }}"
						{{ old($name)? (in_array($id, old($name))? 'selected': ''): ($values->contains('id', $id)? 'selected': '') }}>
						{{ $title }}
					</option>
				@endforeach
			</select>
		</div>
	@else
		<div class="form-control-wrap">
			<input type="{{ $input }}" class="form-control" id="{{ $name }}" name="{{ $name }}"
				value="{{ old($name, $value) }}" @if ($required) required @endif>
		</div>

	@endif

	@if ($errors->has($name))
		<div class="invalid-feedback">
			{{ $errors->first($name) }}
		</div>
	@endif

</div>
