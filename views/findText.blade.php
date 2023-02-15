@extends("layout")

@section("content")

  @foreach($rows as $row)

    <div class="bg-white mt-2 px-3 py-2 rounded data-record">

        <div class="d-flex">
            <span class="text-black-50">id: {{$row["id"]}}</span>
            <span class="text-black-50">level: {{$row["level"]}}</span>
            <span class="text-black-50">sort: {{$row["sort"]}}</span>
            <span class="text-black-50">リンク先: {{$row["linkTo"]}}</span>
            <span class="text-black-50">被リンク: {{$row["linked"]}}</span>

        </div>

        <div>
            <span class="text-black-50">title: </span><a href='/230107/datas/{{$row["id"]}}'>{{$row["title"]}}</a><br>
        </div>

        <div>
            {!!$row["text"]!!}
        </div>

        </div>


    </div>

  @endforeach


@endsection
