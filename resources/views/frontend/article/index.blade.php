@extends('layouts.app')

@section('content')

    <h2>Artikelverwaltung</h2>

    <div class="row">
        <div class="col-md-5 col-lg-3 order-last order-md-first">
            <div class="card mb-3">
                <a class="card-header" href="#collapseManufacturer" data-toggle="collapse">Hersteller</a>
                <ul class="list-group list-group-flush collapse {{ (request('manufacturer')) ? 'show' : '' }}" id="collapseManufacturer">
                        <a href="{{ App\Helpers\SearchHelper::buildManufacturer('all') }}" class="list-group-item list-group-item-action {{ (request('manufacturer')) ? '' : 'active' }}">Alle</a>
                    @foreach($manufacturers as $item)
                            <a href="{{ App\Helpers\SearchHelper::buildManufacturer($item->name) }}" class="list-group-item list-group-item-action {{ App\Helpers\SearchHelper::searchButtons($item->name) }}">{{ $item->name }}</a>
                    @endforeach
                </ul>
            </div>
            <div class="card mb-3">
                <a class="card-header" href="#collapseCategorie" data-toggle="collapse">Kategorie</a>
                <ul class="list-group list-group-flush collapse {{ (request('categorie')) ? 'show' : '' }}" id="collapseCategorie">
                    <a href="{{ App\Helpers\SearchHelper::buildCategorie('all') }}" class="list-group-item list-group-item-action {{ (request('categorie')) ? '' : 'active' }}">Alle</a>
                    @foreach($categories as $item)
                        <a href="{{ App\Helpers\SearchHelper::buildCategorie($item->name) }}" class="list-group-item list-group-item-action {{ App\Helpers\SearchHelper::searchButtons($item->name) }}">{{ $item->name }}</a>
                    @endforeach
                </ul>
            </div>
            <div class="card">
                <a class="card-header" href="#collapseTags" data-toggle="collapse">Tags</a>
                <ul class="list-group list-group-flush collapse {{ (request('tag')) ? 'show' : '' }}" id="collapseTags">
                    <a href="{{ App\Helpers\SearchHelper::buildTag('all') }}" class="list-group-item list-group-item-action {{ (request('tag')) ? '' : 'active' }}">Alle</a>
                    @foreach($tags as $item)
                        <a href="{{ App\Helpers\SearchHelper::buildTag($item->name) }}" class="list-group-item list-group-item-action {{ App\Helpers\SearchHelper::searchButtons($item->name) }}">{{ $item->name }}</a>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-7 col-lg-9">
            <div class="row">


                @foreach($articles as $article)
                    <article-card :article="{{ $article }}" :url="'{{ route('frontend.article.show', $article->id) }}'"></article-card>

                @endforeach
            </div>
            {{ $articles->links() }}
        </div>
    </div>





@endsection
