<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebSearchEngine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/css/mdb.min.css" rel="stylesheet">
</head>

<body style="background-color: #f7f7f7">
<form action="{{route('index')}}" method="get">
    @csrf
    <h1 style="text-align: center;margin-top:100px;font-size:70px"><span
            class="badge badge-dark">WEB SEARCH ENGINE</span>
    </h1>
    <div class="card" style="margin-right: 20%;margin-left: 20%;margin-top: 40px;">
        <div class="card-body">
            <div class="form-group">
                <input type="text" class="form-control" name="search" id="search"
                       placeholder="Enter your search query..." value="{{$s}}"
                       required>
            </div>
            <div style="text-align: center">
                <button class="btn btn-primary btn-lg active" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
@if($show_results)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="margin-right: 10%;margin-left:10%;margin-top:30px">
            <li class="breadcrumb-item active" aria-current="page">{{sizeof($results)}} Results</li>
        </ol>
    </nav>
    <div style="margin-bottom: 100px">
        @php $i=1; @endphp
        @foreach($results as $result)
            @php
                $url=\App\Models\Url::find($result->doc_url_id);
                $url_link=$url->url;
                $url_title=$url->title;
            @endphp
            <a href="{{$url_link}}">
                <div class="card" style="margin-right: 10%;margin-left: 10%;margin-top: 30px;padding: 20px">
                    {{$i}}
                    <hr>
                    {{$url_link}}
                    <hr>
                    {{$url_title}}
                </div>
            </a>
            @php $i=$i+1; @endphp
        @endforeach
    </div>
@endif
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.9/js/mdb.min.js"></script>
</body>

</html>
