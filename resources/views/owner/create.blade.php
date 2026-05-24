<h1>Add Owner</h1>

<form method="POST" action="{{ route('owners.store') }}">
    @csrf

    <input type="text" name="full_name" placeholder="Full Name"><br>
    <input type="text" name="contact_number" placeholder="Contact Number"><br>
    <textarea name="address" placeholder="Address"></textarea><br>

    <button type="submit">Save</button>
</form>