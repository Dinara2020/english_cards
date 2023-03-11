<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.css">
    <title>English words</title>
</head>
<body>
<div class="main">
    <div class="autoComplete_wrapper">
        <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off"
               autocapitalize="off">
    </div>
    <div class="statistic"><h2>Статистика</h2>
        <p>Всего слов - {{$stat['all']}}</p>
        <p>На изучении- {{$stat['learn']}}</p>
        <p>Изучено слов - {{$stat['done']}}</p>
    </div>
    <div class="card">
        <div class="front">
            <div class="front-content">
                <p><a href="update/delete/id{{ $word->id}}"><span
                            class="badge badge-danger no_click float-right align-top"><i
                                class="fa fa-times"></i></span></a></p>
                <p class="no_click">{{$word->word}}</p>
                <div class="pron">{!! $word->pron !!}</div>
                <input id="sound" type="hidden" value="{{$word->sound}}">
                @if($word->pic)
                    <div class="image"><img src="{{ $word->pic }}" width="90px" height="90"></div>

                @endif
                <div class="ll-sets-words__sound no_click">
                    <audio src="{{$word->sound}}"></audio>
                    <span class="ll-icon  " style="width: 32px; height: 32px; color: rgb(126, 145, 159);"><svg
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="currentColor"
                                                                                         d="M15.788 13.007a3 3 0 110 5.985c.571 3.312 2.064 5.675 3.815 5.675 2.244 0 4.064-3.88 4.064-8.667 0-4.786-1.82-8.667-4.064-8.667-1.751 0-3.244 2.363-3.815 5.674zM19 26c-3.314 0-12-4.144-12-10S15.686 6 19 6s6 4.477 6 10-2.686 10-6 10z"
                                                                                         fill-rule="evenodd"></path></svg></span>
                </div>
                <div class="phrase no_click">{!! $word->phrase !!}</div>
                <div class="phrase">{{$word->status}}</div>
            </div>
            <div class="bottom">
                <div class="buttons">
                    <a href="/update/learn/{{ $word->id}}">
                        <button type="button" class="btn btn-warning no_click m-1">Изучать</button>
                    </a>
                    <a href="/update/done/{{ $word->id}}">
                        <button type="button" class="btn btn-success no_click m-1">Изучено</button>
                    </a>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link no_click" href="/{{ $word->id}}/back" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link no_click" href="/{{ $word->id}}/next" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="back">
            <div class="back-content">
                <div class="tranlation">{{ $word->translation }}</div>
            </div>
            <div class="bottom">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link no_click" href="/{{ $word->id}}/back" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link no_click" href="/{{ $word->id}}/next" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
<script src="/js/pure_js.js"></script>
</body>
</html>
