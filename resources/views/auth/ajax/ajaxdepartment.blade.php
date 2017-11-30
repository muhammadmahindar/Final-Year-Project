<option value="">--- Select Department ---</option>
@if(!empty($states))
  @foreach($states as $chekc)
  @foreach($chekc->departments as $ch) 
    <option value="{{$ch->id}}">{{$ch->name}}</option>
  @endforeach
  @endforeach
@endif