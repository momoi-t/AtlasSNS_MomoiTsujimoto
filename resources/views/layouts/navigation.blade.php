<div id="head" class="header-container">
    <h1>
        <a href="{{ route('top') }}">
            <img src="{{ asset('images/atlas.png') }}" alt="Atlas Logo">
         </a>
    </h1>
    <div class="user-menu">
        <p class="accordion-toggle">{{ Auth::user()->username }}さん<span class="toggle-icon">Ｖ</span></p>
            @if(Auth::check())
                <img src="{{ asset('images/' . Auth::user()->icon_image) }}" alt="ユーザーアイコン" class="user-icon">
            @endif
            <ul class="accordion-content">
                <li><a href="{{ route('top') }}">HOME</a></li>
                <li><a href="{{ route('profile.edit') }}">プロフィール編集</a></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                </li>
            </ul>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(".accordion-toggle").click(function(){
            var $accordionContent = $(this).siblings(".accordion-content");

            // Toggle the current dropdown
            $accordionContent.toggleClass("active");

            // Optionally, toggle the 'v' symbol (rotate it)
            $(this).toggleClass("active");

            // Close other dropdowns
            $(".accordion-content").not($accordionContent).slideUp();
            $(".accordion-toggle").not(this).removeClass("active");
        });
    });
</script>
