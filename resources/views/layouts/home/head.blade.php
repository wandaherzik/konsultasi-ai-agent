<!-- Fonts and Icons -->
<script src="{{ asset('kaiadmin-lite-1.2.0/assets/js/plugin/webfont/webfont.min.js') }}"></script>

<script>
    WebFont.load({
        google: {
            families: [
                "Public Sans:300,400,500,600,700"
            ]
        },

        custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],

            urls: [
                "{{ asset('kaiadmin-lite-1.2.0/assets/css/fonts.min.css') }}"
            ],
        },

        active: function () {
            sessionStorage.fonts = true;
        },
    });
</script>


<!-- CSS Files -->

<link
    rel="stylesheet"
    href="{{ asset('kaiadmin-lite-1.2.0/assets/css/bootstrap.min.css') }}"
/>

{{-- DataTables CSS --}}
<link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css"
>

<link
    rel="stylesheet"
    href="{{ asset('kaiadmin-lite-1.2.0/assets/css/plugins.min.css') }}"
/>

<link
    rel="stylesheet"
    href="{{ asset('kaiadmin-lite-1.2.0/assets/css/kaiadmin.min.css') }}"
/>