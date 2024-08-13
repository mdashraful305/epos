<script>
     @if (session('success'))
    iziToast.success({
        title: 'Success',
        timeout: 2000,
        overlay: true,
        message: '{{ session('success') }}',
        position: 'topRight'

    });
@endif
@if (session('error'))
    iziToast.error({
        title: 'Error',
        timeout: 2000,
        overlay: true,
        message: '{{ session('error') }}',
        position: 'topRight'

    });
@endif
@if (session('warning'))
    iziToast.warning({
        title: 'Warning',
        timeout: 2000,
        overlay: true,
        message: '{{ session('warning') }}',
        position: 'topRight'

    });
@endif
@if (session('info'))
    iziToast.info({
        title: 'Info',
        timeout: 2000,
        overlay: true,
        message: '{{ session('info') }}',
        position: 'topRight'

    });
@endif
</script>
