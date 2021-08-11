@extends('layouts.main')


@section('content')
<div id="categories-list">
    @foreach($category->subcategories as $subcategory)
    <div class="catalog-category">

        <img src="{{ $subcategory->getImagePath() }}" alt="" class="category-img">
        <a href="/{{ (config('catalog.path') . '/' . $subcategory->full_code) }}/">
            {{ $subcategory->name }}
        </a>
    </div>
    @endforeach
</div>
@endsection
