<form method="POST" action="{{ route('test.form') }}">
    @csrf
    <button type="submit">Submit Test</button>
</form>
