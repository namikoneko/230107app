@extends("layout")

@section("content")

    <form class="ins-form" action='../dataUpdExe' method='post'>
      <input type='hidden' name='id' value={{$row["id"]}}>

      <label for="ins-title">title:</label>
      <input type="text" class="inputText form-control" name="title" id="ins-title" value={{$row["title"]}}>

    <label for="ins-tag">tag:</label>
    <input type="date" class="inputText form-control" name="tag" id="ins-tag">

    <label for="ins-linkTo">linkTo:</label>
    <input type="date" class="inputText form-control" name="linkTo" id="ins-linkTo">

    <label for="ins-linked">linked:</label>
    <input type="date" class="inputText form-control" name="linked" id="ins-linked">

      <textarea class="myTextarea form-control vh-50 mt-3" name='text'>{{$row["text"]}}</textarea>


      <input class="btn btn-light mt-2" type='submit' value='send'>
    </form>



@endsection
