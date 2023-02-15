@extends("layout")

@section("content")

<form class="ins-form" action="/230107/dataInsExeTop" method="post">
    <input type="text" class="inputText form-control" name="title">
    <textarea class="form-control data-textarea mt-2" name='text'></textarea>
    <input class="btn btn-light mt-2" type='submit' value='insert'>
</form>

<button type="button" class="btn btn-light my-2" @click="VueToggleBtn">id表示</button>

<div class="d-flex flex-wrap my-2">

  @foreach($rows as $row)

  <div class="bg-white p-2 rounded me-2 mb-2">

    <span class="text-black-50" :class="{'toggle-show': isShow}">id: {{$row["id"]}}</span>
    <a class="d-inline text-decoration-none px-2 py-1 data-item-b" href='./datas/{{$row["id"]}}'>{{$row["title"]}}</a>
    <a class="d-inline text-decoration-none px-2 py-1 ms-1 rounded data-item-a border border-primary" href='./catUp/{{$row["id"]}}'>up</a>
      <!--
      -->
  </div>


  @endforeach

</div>

@endsection
