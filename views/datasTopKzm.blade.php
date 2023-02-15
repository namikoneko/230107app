@extends("layout")

@section("content")

  @foreach($rows as $row)

    <div class="bg-white mt-2 px-3 py-2 rounded data-record">

        <span class="text-black-50">id: {{$row["id"]}}</span>
        <span class="text-black-50">level: {{$row["level"]}}</span>
        <span class="text-black-50">sort: {{$row["sort"]}}</span>
        <span class="text-black-50">リンク先: {{$row["linkTo"]}}</span>
        <span class="text-black-50">被リンク: {{$row["linked"]}}</span>



        <br>
        <span class="text-black-50">title: </span><a href='/230107/datas/{{$row["id"]}}'>{{$row["title"]}}</a><br>
        <div>
        {!!$row["text"]!!}
        </div>
<!--
-->

        <a class="d-inline px-2 py-1 ms-2" href='/230107/dataKzmBack/{{$row["id"]}}'>kzmを戻す</a>

    </div>

  @endforeach

@endsection
