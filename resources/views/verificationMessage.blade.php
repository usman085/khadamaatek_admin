@if ($message)
<div class="alert alert-warning">
    {{ $message }} . Signin Again
    <br>
    <p>Redirecting to website...</p>
</div>
@endif

<script>
    setTimeout(() => {
        window.location.href = "{{ url('/') }}";
        // localStorage.clear();
    }, 2000);

</script>
