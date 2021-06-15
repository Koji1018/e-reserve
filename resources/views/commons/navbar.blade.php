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
                    <li class="nav-item">{!! link_to_route('reservations.create', '貸出予約', [], ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">貸出状況</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- ユーザ予約状況ページへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('reservations.index_user', Auth::user()->name) !!}</li>
                            {{-- 全体貸出状況ページへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('reservations.index_all', '全体') !!}</li>
                            {{-- カテゴリー別貸出状況ページへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('reservations.index_category', 'カテゴリー別', []) !!}</li>
                        </ul>
                    </li>
                    {{-- 認証ユーザが管理者の場合 --}}
                    @if (Auth::user()->user_group == 0)
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">管理機能</a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                {{-- 備品一覧ページへのリンク --}}
                                <li class="dropdown-item"><li class="dropdown-item">{!! link_to_route('equipments.index', '備品一覧') !!}</li>
                                {{-- カテゴリー一覧ページへのリンク --}}
                                <li class="dropdown-item"><li class="dropdown-item">{!! link_to_route('categories.index', 'カテゴリー一覧') !!}</li>
                                <li class="dropdown-divider"></li>
                                {{-- 管理者一覧ページへのリンク --}}
                                <li class="dropdown-item"><li class="dropdown-item">{!! link_to_route('admin.index', '管理者一覧') !!}</li>
                                {{-- ユーザ一覧ページへのリンク --}}
                                <li class="dropdown-item"><li class="dropdown-item">{!! link_to_route('users.index', 'ユーザ一覧') !!}</li>
                            </ul>
                        </li>
                    @endif
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