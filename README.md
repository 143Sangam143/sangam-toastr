# Sangam Toastr

A Laravel package for Toastr notifications (success, error, warning, info).  
Supports both **Session flash messages** and **AJAX responses**.

## Notice:
This is the first package developed by Sangam Katwal. So, if things aren't clear you could reach me through my email.

---

## Installation

```bash
composer require sangamkatwal/sangam-toastr
```
## Publish Assets
```bash
php artisan vendor:publish --tag=assets
php artisan vendor:publish --tag=views
```
This will publish:
<ul>
    <li>public/vendor/toastr/toastr.min.js</li>
    <li>public/vendor/toastr/toastr.min.css</li>
    <li>resources/views/vendor/toastr.blade.php</li>
</ul>

## Usage
### Step 1: Include Assets

In your layouts/app.blade.php (inside <head>):
```blade
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/sangam-toastr/toastr.css') }}">
    <script src="{{ asset('vendor/sangam-toastr/toastr.min.js') }}"></script>
```
Note: if you already have jquery in the head you don't need to add again

### Step 2: Include Notifications Partial

In your layout (usually layout.blade.php):
```blade
<body class="@yield('body-class')">
    @include('sangam-toastr::toastr')
</body>
```

### Step 3: Send Notifications
#### From Controller (Session)
```
return back()->with([
    'success' => true,
    'message' => 'Operation completed successfully!',
]);

return back()->with([
    'error' => true,
    'message' => 'Permission already exists.',
]);
```

#### From Controller (AJAX)
```
    return response()->json([
        'error' => true,
        'message' => 'Permission not found.'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Data saved successfully!'
    ]);
```

#### Frontend AJAX
```js
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(res) {
            // show toastr notifications
            ajax_response(res);
        }
    });
```

## Notification Types
<ul>
    <li>success</li>
    <li>error</li>
    <li>info</li>
    <li>warning</li>
</ul>

## Helper: ajax_response(res)
This helper checks the JSON response and shows toastr messages automatically.
```js
function ajax_response(response) {
    const notificationTypes = ['success', 'error', 'info', 'warning'];

    notificationTypes.forEach(function(type) {
        if (response[type]) {
            if (Array.isArray(response.message)) {
                response.message.forEach(function(msg) {
                    toastr[type](msg);
                });
            } else {
                toastr[type](response.message);
            }
        }
    });
}
```

## License
This package is open-sourced under the [MIT license](LICENSE).
