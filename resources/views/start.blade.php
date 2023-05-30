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
    <div class="auto_complete_wrapper">
        <div class="max-w-xs relative space-y-3">
            <label
                for="search"
                class="text-gray-900"
            >
            </label>
            <input
                type="text"
                id="search"
                v-model="searchTerm"
                placeholder="Type here..."
                class="auto_complete"
            >
            <button v-if="showAddButton" class="btn-info ml-3 p-2" @click.stop.prevent="addWord">Добавить</button>
            <ul
                v-if="searchWords.length"
                class="w-full rounded bg-white border border-gray-300 px-4 py-2 space-y-1 absolute z-10"
            >
                <li
                    v-for="country in searchWords"
                    :key="country.value"
                    @click="selectCountry(country.key)"
                    class="cursor-pointer hover:bg-gray-100 p-1"
                >
                    @{{ country.value }}
                </li>
            </ul>
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
