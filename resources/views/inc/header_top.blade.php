<div id="header-top" class="row header-top col-9">
    <div class="header-menu col-7">
        @foreach (Menu::get('header') as $item)
            <a href="{{ $item->link }}">{{ $item->name }}</a>            
        @endforeach
    </div>
    <div class="contacts col-5">
        <div>ул. Гамарника 86-12 &nbsp</div>
        <div>8-914-405-43-43 &nbsp</div>
    </div>
</div>
