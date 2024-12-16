<div class="flex justify-between">
    <form action="{{ route('products.destroy', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <form action="{{ route('products.forceDelete', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product and images permanently?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hard Delete</button>
    </form>
</div>
