@if(Session::has('success'))
    <script>

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ Session::get('success') }}',
            timer: 12000, // Set the timer (in milliseconds) or remove it to make it persistent
            timerProgressBar: true,
        });
    </script>
@endif

@if(Session::has('error'))
    <script>

        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ Session::get('error') }}',
            timer: 12000,
            timerProgressBar: true,
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
