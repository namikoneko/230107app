@extends("layout")

@section("content")


<div class="">

    <button type="button" class="btn btn-light" @click="showInsForm">ins Form</button>
    <button type="button" class="btn btn-light" @click="showUpdForm">upd Form</button>
    <button type="button" class="btn btn-light" @click="showAddDelForm">Add Del Form</button>
    <button type="button" class="btn btn-light" @click="showSearchForm">search Form</button>
    <a class="d-inline px-2 py-1 ms-2" href='/230107/dataKzm/{{$mainRow["id"]}}/{{$mainRow["id"]}}'>kzm</a>

</div>

<div class="bg-white px-2 mt-2 me-2 rounded">

        <span class="text-black-50">id: {{$mainRow["id"]}}</span>
        <span class="text-black-50">level: {{$mainRow["level"]}}</span>
        <span class="text-black-50">sort: {{$mainRow["sort"]}}</span>
        <span class="text-black-50">リンク先: {{$mainRow["linkTo"]}}</span>
        <span class="text-black-50">被リンク: {{$mainRow["linked"]}}</span>
</div>


<h3 class="bg-white px-2 mt-2 rounded">
    {{$mainRow["title"]}}
</h3>

<div class="bg-white px-2 mt-2 rounded">
    {!!$mainRow["text"]!!}
</div>

<!-- add、del form 
    <button type="button" class="btn btn-light toggleBtn">btn</button>
    <div class="bg-info mt-2 px-3 py-2 rounded toggle-show">
-->


<!-- search form -->
<div :class="{'hiddenSearchForm': isSearchForm}">
        <form class="mt-2" action="/230107/find" method="get">
              <input type='hidden' name='id' value={{$mainRow["id"]}}>

            <div class="d-flex">

                <div class="form-check me-2">
                  <input class="form-check-input" type="radio" name="titleOrText" id="flexRadioDefault1" value="1">
                  <label class="form-check-label" for="flexRadioDefault1">
                    title
                  </label>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="radio" name="titleOrText" id="flexRadioDefault2" value="2" checked>
                  <label class="form-check-label" for="flexRadioDefault2">
                    text
                  </label>
                </div>

              </div>


            <div class="d-flex">
                <input type='text' name='word' class="form-control me-2">
                <input class="btn btn-light mt-2" type='submit' value='send'>
            </div>

        </form>
</div>


<!-- add、del form -->
<div :class="{'hiddenAddDelForm': isAddDelForm}">
        <form  action="/230107/dataUpdExeAddLink" method="post">
              <input type='hidden' name='id' value={{$mainRow["id"]}}>
            <p>
                <label for="title">linkTo add:</label>
                <input type='text' name='addLink' class="form-control">
            </p>
              <input class="btn btn-light mt-2" type='submit' value='send'>
        </form>

        <form class="" action="/230107/dataUpdExeDelLink" method="post">
              <input type='hidden' name='id' value={{$mainRow["id"]}}>
            <p>
                <label for="title">linkTo del:</label>
                <input type='text' name='delLink' class="form-control">
            </p>
              <input class="btn btn-light mt-2" type='submit' value='send'>
        </form>
</div>

<!-- upd form -->
<div :class="{'hiddenUpdForm': isUpdForm}">

        <form class="mt-2" action="/230107/dataUpdExe" method="post">

              <input type='hidden' name='mainRowId' value='{{$mainRow["id"]}}'>
              <input type='hidden' name='id' value={{$mainRow["id"]}}>

            <div class="d-flex">
                <label for="level" class="form-label mx-2">level:</label>
                <input type='text' name='level' value='{{$mainRow["level"]}}' class="form-control">

                <label for="sort" class="form-label mx-2">sort:</label>
                <input type='text' name='sort' value='{{$mainRow["sort"]}}' class="form-control">
            </div>

            <div class="d-flex mt-2">
                <label for="title" class="form-label mx-2">title:</label>
                <input type='text' name='title' value='{{$mainRow["title"]}}' class="form-control">
            </div>

              <textarea class="myTextarea form-control vh-min-50 mt-3 data-textarea-upd" name='text'>{!!$mainRow["rawText"]!!}</textarea>
              <input class="btn btn-light mt-2" type='submit' value='send'>





        </form>

</div>

<div :class="{'hiddenInsForm': isInsForm}">


    <form class="ins-form mt-2" action="/230107/dataInsExe" method="post">
        <input type="hidden" class="inputText form-control" name="linkToId" value="{{$mainRow['id']}}">
        <input type="text" class="inputText form-control" name="title">
        <br>
        <textarea class="form-control data-textarea" name='text'></textarea>
        <input class="btn btn-light mt-2" type='submit' value='insert'>
    </form>

</div>

リンク先：
  @foreach($linkToRows as $row)
<div class="d-flex flex-wrap">
    <div class="bg-white mt-2 px-3 py-2 rounded data-record d-flex">

        <span class="text-black-50 me-2">id:{{$row["id"]}}</span><br>
        <span class="text-black-50">title: </span><a href='/230107/datas/{{$row["id"]}}'>{{$row["title"]}}</a><br>


    </div>
</div>


  @endforeach

<hr>

被リンク：
  @foreach($linkedRows as $row)

<div>
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
        <button type="button" class="btn btn-light toggleBtn">upd form</button>
        <a href="#" @click.prevent.stop="linkClick" class="toggleBtn">udpate</a>
        <a href="javascript:void(0)" class="toggleBtn">udpate</a>
-->

        <a href="javascript:void(0)" @click='toggleLinked({{$row["id"]}})'>udpate</a>



        <a class="d-inline px-2 py-1 ms-2" href='/230107/dataKzm/{{$mainRow["id"]}}/{{$row["id"]}}'>kzm</a>

        <a class="d-inline text-decoration-none px-2 py-1 ms-2 rounded data-item-a border border-primary" href='/230107/dataUp/{{$mainRow["id"]}}/{{$row["id"]}}'>up</a>

    </div>

<!-- upd form -->
    <div class="bg-white mt-2 px-3 py-2 rounded toggle-show hiddenLinked" :class="{'showLinked': isShowLinked[{{$row['id']}}]}">
        <form class="" action="/230107/dataUpdExe" method="post">
              <input type='hidden' name='mainRowId' value='{{$mainRow["id"]}}'>
              <input type='hidden' name='id' value='{{$row["id"]}}'>

            <div class="d-flex">
                <label for="level" class="form-label mx-2">level:</label>
                <input type='text' name='level' value='{{$row["level"]}}' class="form-control">

                <label for="sort" class="form-label mx-2">sort:</label>
                <input type='text' name='sort' value='{{$row["sort"]}}' class="form-control">
            </div>

            <div class="d-flex mt-2">
                <label for="title" class="form-label mx-2">title:</label>
                <input type='text' name='title' value='{{$row["title"]}}' class="form-control">
            </div>

              <textarea class="myTextarea form-control vh-min-50 mt-3 data-textarea-upd" name='text'>{!!$row["rawText"]!!}</textarea>
              <input class="btn btn-light mt-2" type='submit' value='send'>
        </form>

    </div>


</div>

  @endforeach

<div class="my-2">
  <a class="btn btn-light" href='./{{$mainRow["id"]}}?page={{$page - 1}}'>前へ</a>
  <a class="btn btn-light" href='./{{$mainRow["id"]}}?page={{$page + 1}}'>次へ</a>
  <a class="btn btn-light" href='./{{$mainRow["id"]}}?page=0'>全表示へ</a>
</div>

<!--

-->


@endsection
