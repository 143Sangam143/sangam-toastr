# Validation Examples with Sangam Toastr

This shows how to use Sangam Toastr with Laravel validation errors.

---

## Example 1: Normal Request (try/catch with validation)

```php
public function update(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$request->id
        ]);

        // Update logic...
        return redirect()->back()->with([
            'success' => true,
            'message' => 'Category successfully updated'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->with([
            'error' => true,
            'message' => $e->validator->errors()->all()
        ]);
    } catch (\Exception $e) {
        return redirect()->back()->with([
            'error' => true,
            'message' => app()->isLocal() ? $e->getMessage() : 'Something went wrong. Please try again.'
        ]);
    }
}
```
## Example 2: Works with Both AJAX & Normal Request
```php
public function create(Request $request)
{
    $requestType = $request->ajax();

    try {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string',
            'product_id' => 'required|exists:products,id'
        ]);

        // Save review...
        $message = 'Your review is being verified.';
        return $requestType
            ? response()->json(['success' => true, 'message' => $message])
            : redirect()->back()->with(['success' => true, 'message' => $message]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        $message = $e->validator->errors()->all();
        return $requestType
            ? response()->json(['error' => true, 'message' => $message])
            : redirect()->back()->with(['error' => true, 'message' => $message]);
    }
}
```