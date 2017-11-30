<option value="">--- Select Branch ---</option>
@if(!empty($states))
  @foreach($states as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif