<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.css">
    <title>@yield('title')</title>
</head>
<body>
<div id="app" class="container-fluid" >
    <div class="row">
        <div class="col-12">
            <div class="autoComplete_wrapper">
                <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off"
                       autocapitalize="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <div class="statistic">
                <p><a href="/">Главная</a></p>
                <p><a href="/all">Все слова</a></p>
                <h2>Статистика</h2>
                <p>Всего слов - {{$stat['all']}}</p>
                <p>На изучении- {{$stat['learn']}}</p>
                <p>Изучено слов - {{$stat['done']}}</p>
            </div>
            <div class="filters">
                <h2>Фильтры</h2>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="learn" id="defaultCheck1" @click="filter($event)">
                    <label class="form-check-label" for="defaultCheck1">
                        Изучать
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="done" id="defaultCheck2" @click="filter($event)">
                    <label class="form-check-label" for="defaultCheck2">
                        Изучено
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck3" @click="filter($event)">
                    <label class="form-check-label" for="defaultCheck3">
                        На повторении
                    </label>
                </div>
            </div>
        </div>
        <div class="col-10">
            @yield('content')
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
</body>
</html>
