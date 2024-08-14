<script>
     @if (session('success'))
    iziToast.success({
        title: 'Success',
        timeout: 1500,
        message: '{{ session('success') }}',
        position: 'topRight'

    });
@endif
@if (session('error'))
    iziToast.error({
        title: 'Error',
        timeout: 1500,
        message: '{{ session('error') }}',
        position: 'topRight'

    });
@endif
@if (session('warning'))
    iziToast.warning({
        title: 'Warning',
        timeout: 1500,
        message: '{{ session('warning') }}',
        position: 'topRight'

    });
@endif
@if (session('info'))
    iziToast.info({
        title: 'Info',
        timeout: 1500,
        message: '{{ session('info') }}',
        position: 'topRight'

    });
@endif
</script>
