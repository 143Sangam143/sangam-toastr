# 📝 Validation Examples with Sangam Toastr

This guide shows how to use Sangam Toastr with Laravel validation in different scenarios.

## 🔄 Example 1: Regular Request with Validation

```php
public function update(Request $request, $id)
{
    try {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500'
        ]);

        // Update your model...
        Category::findOrFail($id)->update($request->validated());

        return redirect()->back()->with([
            'success' => true,
            'message' => 'Category updated successfully!'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->with([
            'error' => true,
            'message' => $e->validator->errors()->all()
        ]);
    } catch (\Exception $e) {
        \Log::error('Category update failed: ' . $e->getMessage());
        
        return redirect()->back()->with([
            'error' => true,
            'message' => app()->isLocal() ? $e->getMessage() : 'Something went wrong. Please try again.'
        ]);
    }
}
```

## 🌐 Example 2: AJAX Only Request

```php
public function storeAjax(Request $request)
{
    try {
        $request->validate([
            'title' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email'
        ]);

        // Save your data...
        User::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'error' => true,
            'message' => $e->validator->errors()->all()
        ], 422);
    } catch (\Exception $e) {
        \Log::error('User creation failed: ' . $e->getMessage());
        
        return response()->json([
            'error' => true,
            'message' => app()->isLocal() ? $e->getMessage() : 'Server error occurred.'
        ], 500);
    }
}
```

## 🔀 Example 3: Mixed Request Type (AJAX + Regular)

Perfect for forms that can be submitted both ways:

```php
public function store(Request $request)
{
    $isAjax = $request->ajax();

    try {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000',
            'product_id' => 'required|exists:products,id'
        ]);

        // Save review...
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'pending' // Reviews need approval
        ]);

        $message = 'Thank you! Your review is being verified and will be published soon.';

        return $isAjax
            ? response()->json(['success' => true, 'message' => $message])
            : redirect()->back()->with(['success' => true, 'message' => $message]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->validator->errors()->all();
        
        return $isAjax
            ? response()->json(['error' => true, 'message' => $errors])
            : redirect()->back()->with(['error' => true, 'message' => $errors]);
            
    } catch (\Exception $e) {
        \Log::error('Review submission failed: ' . $e->getMessage());
        $message = app()->isLocal() ? $e->getMessage() : 'Unable to submit review. Please try again.';

        return $isAjax
            ? response()->json(['error' => true, 'message' => $message])
            : redirect()->back()->with(['error' => true, 'message' => $message]);
    }
}
```

## 💡 Pro Tips

### 1. Environment-Aware Error Messages
```php
catch (\Exception $e) {
    \Log::error($e->getMessage());
    
    $message = app()->isLocal() 
        ? $e->getMessage()  // Show actual error in development
        : 'Something went wrong. Please try again.'; // Generic message in production
        
    return redirect()->back()->with(['error' => true, 'message' => $message]);
}
```

### 2. Multiple Validation Errors
Laravel automatically returns all validation errors as an array, and our package handles them perfectly:

```php
// This will show each validation error as a separate toastr notification
catch (\Illuminate\Validation\ValidationException $e) {
    return redirect()->back()->with([
        'error' => true,
        'message' => $e->validator->errors()->all() // Array of error messages
    ]);
}
```

### 3. Frontend AJAX Implementation
```javascript
$('#reviewForm').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            ajax_response(response); // Show success message
            $('#reviewForm')[0].reset(); // Reset form
        },
        error: function(xhr) {
            //By deafult ajax_respoonse(response) in success function handles the error message.
            //But if you need to see the xhr response then you will have to write the error function 
            // and access the xhr responseJSON the natural way. Otherwise you don't need to write
            //this error funciton at all.
        }
    });
});
```

## 🎯 Key Benefits

- ✅ **Consistent Format**: Same `['type' => true, 'message' => '...']` format everywhere
- ✅ **Array Support**: Multiple messages shown as separate notifications
- ✅ **Environment Aware**: Different messages for local vs production
- ✅ **AJAX Ready**: Works seamlessly with AJAX requests
- ✅ **Error Logging**: Actual errors logged while showing user-friendly messages
