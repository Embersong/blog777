<a @class(['active' => request()->routeIs('home')]) href="{{ route('home') }}">Главная блог</a>
<a @class(['active' => request()->routeIs('admin.home')]) href="{{ route('admin.home') }}">Админка</a>
<a @class(['active' => request()->routeIs('admin.posts.*')]) href="{{ route('admin.posts.index') }}">CRUD Посты</a>
<a @class(['active' => request()->routeIs('admin.categories.*')]) href="{{ route('admin.categories.index') }}">CRUD Категории</a>
<br>
