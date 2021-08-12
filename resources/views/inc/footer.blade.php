<footer class="row">
    <div class="col-3 logo">

    </div>
    <div class="col-md-3 sitemap">
        <span>Карта сайта</span>
        @foreach (Menu::get('footer') as $item)
            <a href="{{ $item->link }}">{{ $item->name }}</a>
        @endforeach
    </div>
    <div class="socials col-md-3">
        <a href="https://instagram.com/gadget_dv_" target="_blank">INSTAGRAM<img src="/img/icon/ig_small.png" alt=""></a>
    </div>
    <div class="contacts col-md-3">
        <div class="whatsapp"><img src="/img/icon/wa.png" alt="wa" class="wa-logo"><a href="https://wa.me/89144054343">89144054343</a></div>
        <div class="address">г.Хабаровск ул. Ленина,66</div>
        <div class="worktime">
            пн-пт 10-20<br>
            сб-вс 10-18
        </div>
    </div>
</footer>
