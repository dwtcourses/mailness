@extends('layouts.main')

@section('content')
  
<div class="flex items-center justify-between mb-3">
  <h1 class="text-gray-700 text-2xl py-4" >Campaign {{ $campaign->subject }}</h1>
</div>

<div>
  <h3>Send test campaign to:</h3>
  <form action="{{ route('campaigns.send.test', $campaign->id) }}" method="POST" > 
    @csrf
    <input type="text" name="email" placeholder="Email" class="block bg-gray-300 p-2" >
    <button type="submit" class="bg-blue-500 px-5 py-3 text-white mt-2" >Send</button> 
  </form>
</div>

<div class="mt-10">
  <h1>Send campaign</h1>

  <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST">
    @csrf

    @foreach($lists as $list)
      <div class="block" >
        <input type="checkbox" name="lists[{{$list->id}}]" > {{ $list->name }}
      </div>
    @endforeach

  <button type="submit" class="bg-blue-500 px-5 py-3 text-white mt-2" >Send</button>
  </form>

</div>


@endsection