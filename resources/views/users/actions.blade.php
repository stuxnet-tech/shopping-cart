<form action="{{ route('users.destroy', $id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Delete</button>
</form>
