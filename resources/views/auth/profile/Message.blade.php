@extends('layouts.app')


@section('cssarea')

@endsection
@section('dynamiccontent')
<form action="{{URL('SendMessage',$userData->id)}}" method="POST">
  {{ csrf_field() }}
  <input type="hidden" name="messageId" value="{{Auth::user()->id}}">
<div class="col-sm-5">
  To:<label> <strong>{{$userData->name}}</strong></label>
  <textarea class="form-control" rows="4" placeholder="Enter Message" id="Address" name="usermessage"></textarea>
  <button type="submit" class="btn btn-primary">
                                    Send Message                                </button>
</div>
</form>
@endsection
@section('scriptarea')

@endsection