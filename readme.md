# Studi Kasus Laravel Multiauth 5.6

Berikut ini adalah contoh aplikasi yang menggunakan konsep multiple auth. Multiple auth di sini diimplementasikan dalam bentuk multiple guard. 

## Penjelasan

Aplikasi ini memiliki 3 guard yakni **web**, **admin** dan **writer**. 3 guard ini juga terhubung ke 3 model yang berbeda. Guard web terhubung ke User model, guard admin terhubung ke Admin model, guard writer terhubung ke Writer model.

Kita bisa lihat konfigurasinya pada file `auth.php` di dalam folder config.

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],

    'writer' => [
        'driver' => 'session',
        'provider' => 'writers',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\User::class,
    ],

    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Admin::class,
    ],
    'writers' => [
        'driver' => 'eloquent',
        'model' => App\Writer::class,
    ],
],
```

Kemudian, di Writer dan Admin model juga harus memasang nilai pada property `$guard` agar eksplisit.

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Writer extends Authenticatable
{
    use Notifiable;

    protected $guard = 'writer';

    //...
}
```

```php
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    //...
}
```

Untuk mengakses data writer yang sedang login bisa dilakukan dengan perintah berikut.

```php
\Auth::guard('writer')->user()->name;
// atau
auth('writer')->user()->name;
```

Untuk mengakses data admin yang sedang login pun juga sama dengan perintah berikut.

```php
\Auth::guard('admin')->user()->name;
// atau
auth('admin')->user()->name;
```

Untuk mengakses data user kita tidak perlu memasukkan parameter ke dalam method `guard` ataupun di dalam helper `auth`. Sehingga aksesnya pun seperti di bawah ini.

```php
\Auth::guard()->user()->name;
// atau
auth()->user()->name;
```

Untuk memproteksi halaman yang hanya bisa diakses baik writer, admin dan user, kita bisa masukkan perintah middleware ke dalam file routes.

```php
Route::view('/home', 'home')->middleware('auth');
Route::view('/admin', 'admin')->middleware('auth:admin');
Route::view('/writer', 'writer')->middleware('auth:writer');
```

Kemudian, kita perlu mengatur bagaimana user di arahkan ke halaman login berdasarkan guard yang sudah kita pasang. Caranya adalah memodifikasi method `handle()` yang ada di dalam class middleware `RedirectIfAuthenticated.php`.

```php
// app/Http/Controllers/Middleware/RedirectIfAuthenticated.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            return redirect('/admin');
        }
        if ($guard == "writer" && Auth::guard($guard)->check()) {
            return redirect('/writer');
        }
        if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }

        return $next($request);
    }
}
```

Dengan adanya **fitur multiple guard di Laravel sejak versi 5.2 memudahkan Anda untuk melakukan multiple Auth dan data auth user akan diakses terpisah berdasarkan guard yang didefinisikan sebelumnya**.

## Pembuktian

1. Clone repository.
2. Jalankan `composer install`.
3. Pastikan sudah ada file `.env` dan buat database bernama `multiauth.sql`.
4. Jalankan `php artisan migrate`.
5. Jalankan `php artisan db:seed`.
6. Jalankan `php artisan serve`.
7. Buka halaman `/home` maka akan diarahkan ke halaman login user. Masukkan email `tina@toon.com` dan password adalah `secret`.
8. Buka halaman `/admin` maka akan diarahkan ke halaman login admin. Masukkan email `dahlan@iskan.com` dan password adalah `secret`.
8. Buka halaman `/writer` maka akan diarahkan ke halaman login admin. Masukkan email `azrul@ananda.com` dan password adalah `secret`.

