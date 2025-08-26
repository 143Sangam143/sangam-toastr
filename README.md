# 🎉 Sangam Toastr

[![Latest Version](https://img.shields.io/packagist/v/sangamkatwal/sangam-toastr.svg)](https://packagist.org/packages/sangamkatwal/sangam-toastr)
[![License](https://img.shields.io/packagist/l/sangamkatwal/sangam-toastr.svg)](https://packagist.org/packages/sangamkatwal/sangam-toastr)

A simple and elegant Laravel package for **Toastr notifications** that works seamlessly with both **session flash messages** and **AJAX responses**.

> **Note**: This is my first Laravel package! 🚀 If anything isn't clear, feel free to reach out via email or create an issue.

## ✨ Features

- 🔄 **Dual Support**: Works with both session redirects and AJAX calls
- 🎨 **4 Notification Types**: Success, Error, Warning, Info
- 🚀 **Zero Configuration**: Works out of the box
- 📱 **Responsive**: Mobile-friendly notifications
- 🔧 **Laravel Integration**: Auto-discovery support
- 💡 **Simple API**: Consistent key-value pair format

## 📦 Installation

```bash
composer require sangamkatwal/sangam-toastr
```

## 🔧 Setup

### 1. Publish Assets
```bash
# Publish everything
php artisan vendor:publish --tag=sangam-toastr

# Or publish separately
php artisan vendor:publish --tag=sangam-toastr-assets
php artisan vendor:publish --tag=sangam-toastr-views
```

### 2. Include Assets in Layout
Add to your `layouts/app.blade.php` (inside `<head>`):

```blade
{{-- jQuery (required) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Toastr Assets --}}
<link rel="stylesheet" href="{{ asset('vendor/sangam-toastr/toastr.min.css') }}">
<script src="{{ asset('vendor/sangam-toastr/toastr.min.js') }}"></script>
```

### 3. Include Notifications
Add before closing `</body>` tag in your layout:

```blade
@include('sangam-toastr::toastr')
```

## 🚀 Usage

### Session Flash Messages (Redirects)

```php
// Success notification
return redirect()->back()->with([
    'success' => true,
    'message' => 'Data saved successfully!'
]);

// Error notification
return redirect()->back()->with([
    'error' => true,
    'message' => 'Something went wrong!'
]);

// Multiple messages (arrays supported)
return redirect()->back()->with([
    'error' => true,
    'message' => ['Field is required', 'Email must be valid']
]);
```

### AJAX Responses

```php
// Success response
return response()->json([
    'success' => true,
    'message' => 'Operation completed!'
]);

// Error response
return response()->json([
    'error' => true,
    'message' => 'Validation failed!'
]);
```

### Frontend AJAX Implementation

```javascript
$.ajax({
    url: '/your-endpoint',
    type: 'POST',
    data: formData,
    success: function(response) {
        // This will automatically show toastr notifications
        ajax_response(response);
        
        // Alternative function name
        // showToastr(response);
    },
    error: function(xhr) {
        // Handle server errors
        ajax_response({
            error: true,
            message: 'Server error occurred'
        });
    }
});
```

### Mixed Request Types (AJAX + Regular)

Perfect for controllers that handle both AJAX and regular requests:

```php
public function store(Request $request)
{
    try {
        // Your logic here...
        
        $message = 'Record created successfully!';
        
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => $message])
            : redirect()->back()->with(['success' => true, 'message' => $message]);
            
    } catch (Exception $e) {
        $message = 'Something went wrong!';
        
        return $request->ajax()
            ? response()->json(['error' => true, 'message' => $message])
            : redirect()->back()->with(['error' => true, 'message' => $message]);
    }
}
```

## 📋 Notification Types

| Type | Usage |
|------|-------|
| `success` | ✅ Success operations |
| `error` | ❌ Error messages |
| `warning` | ⚠️ Warning alerts |
| `info` | ℹ️ Information notices |

## ⚙️ Requirements

- **PHP**: >= 8.0
- **Laravel**: 8.x, 9.x, 10.x, 11.x
- **jQuery**: 3.7.1 (recommended, not tested with other versions)

## 🔍 Validation Examples

See [ValidationExamples.md](docs/ValidationExamples.md) for detailed examples with Laravel validation.

## 🤝 Contributing

This is my first package, so contributions and suggestions are very welcome!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📝 License

This package is open-sourced under the [MIT license](LICENSE).

## 👨‍💻 Author

**Sangam Katwal** - [katwalsangam@gmail.com](mailto:katwalsangam@gmail.com)

## ✍️ Note By Author
This README was written with the help of AI based on my inputs.
If you notice anything unclear or incorrect, feel free to reach out to me via email.

The Toastr CSS and JS used in this package are from the original Toastr.js v2.1.3.
This package is completely free and open-source.

The main reason I built this package is because I often had to dig through old projects just to copy my custom Toastr response logic. By turning it into a reusable package, I’ve made it easier for myself—and I’m sharing it publicly in case it simplifies things for others too.

## 👨‍💻 Note For Developers
While this package encourages a simple and consistent response format (one notification type + one message), it does not restrict Laravel’s default flexibility. You can still attach additional values to your responses, whether for session flashes or AJAX.

For example:
```php
// Redirect response with extra data
return redirect()->back()->with([
    'success' => true,
    'message' => 'Data saved successfully!',
    'status'  => 200,
    'extra'   => 'Any other value'
]);

// AJAX response with extra fields
return response()->json([
    'success' => true,
    'message' => 'Data saved successfully!',
    'status'  => 200,
    'data'    => ['id' => 123, 'name' => 'Sample']
]);

So, you still get all the power of Laravel responses while enjoying clean, consistent Toastr notifications. 🚀

---

⭐ **Star this repo if it helped you!**