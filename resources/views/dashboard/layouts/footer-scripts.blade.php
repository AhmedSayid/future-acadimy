<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<div class="whatsapp-float" onclick="window.open('https://wa.me/+201024104413', '_blank')">
    <i class="fab fa-whatsapp"></i>
    <span class="tooltip-text">تواصل مع الدعم الفني</span>
</div>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        $('.search-popup').hide();
        // Bind search input
        $('.search-control').on('keyup', function () {
            $('.search-control').on('focus', function () {
                const searchBar = $(this);
                const popup = $('.search-popup');
                popup.css({
                    width: searchBar.outerWidth(),
                });
            });
            let query = $(this).val().trim();

            // Toggle the visibility of the search popup
            if (query.length > 0) {
                $('.search-popup').show();
            } else {
                $('.search-popup').hide();
            }

            // Trigger AJAX search if query length > 2
            if (query.length > 2) {
                $.ajax({
                    url: '{{ route("search") }}',
                    type: 'GET',
                    data: { query: query },
                    success: function (data) {
                        let searchContent = $('.search-content');
                        let noResults = true;

                        searchContent.empty();

                        // Handle Teachers
                        if (data.teachers.length) {
                            noResults = false;
                            searchContent.append(`<h5>المدرسين</h5>`);
                            data.teachers.forEach(teacher => {
                                searchContent.append(`<a href="{{ url('platform/teachers/show') }}/${teacher.id}" class="d-block py-1">` + teacher.name + '</a>');
                            });
                        }

                        // Handle Students
                        if (data.students.length) {
                            noResults = false;
                            searchContent.append(`<h5>الطلاب</h5>`);
                            data.students.forEach(student => {
                                searchContent.append(`<a href="{{ url('platform/students/show') }}/${student.id}" class="d-block py-1">` + student.name + '</a>');
                            });
                        }

                        // No results found
                        if (noResults) {
                            searchContent.append(`<p class="text-muted">${lang === 'ar' ? 'لا توجد نتائج' : 'No results found'}</p>`);
                        }
                    },
                    error: function () {
                        $('.search-content').html(`<p class="text-danger">${lang === 'ar' ? 'حدث خطأ أثناء البحث' : 'An error occurred while searching'}</p>`);
                    }
                });
            } else {
                $('.search-content').empty();
            }
        });

        // Close search popup
        $('.search-close').on('click', function () {
            $('.search-popup').hide();
        });
    });
</script>
<script>
    $(document).on('click', '#mark-all-read', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('notifications.mark-all') }}",
            method: 'GET',
            success: function () {
                location.reload();
            }
        });
    });
</script>
{{--<script>--}}
{{--    document.addEventListener('contextmenu', event => event.preventDefault());--}}
{{--    document.addEventListener('keydown', event => {--}}
{{--        if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I')) {--}}
{{--            event.preventDefault();--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
