<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/">E-Reserve</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    {{-- 貸出予約ページへのリンク --}}
                    <li class="nav-item"><a href="#">貸出予約</a></li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">貸出状況</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- ユーザ予約状況ページへのリンク --}}
                            <li class="dropdown-item"><a href="#">{{ Auth::user()->name }}</a></li>
                            {{-- 全体貸出状況ページへのリンク --}}
                            <li class="dropdown-item"><a href="#">全体</a></li>
                            {{-- カテゴリー別貸出状況ページへのリンク --}}
                            <li class="dropdown-item"><a href="#">カテゴリー別</a></li>
                        </ul>
                    </li>
                    {{-- ログアウトへのリンク --}}
                    <li class="nav-item">{!! link_to_route('logout.get', 'ログアウト', [], ['class' => 'nav-link']) !!}</li>
                @else
                    {{-- ユーザ登録ページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('signup.get', 'ユーザ登録', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ログインページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
                @endif
            </ul>
        </div>
    </nav>
</header>