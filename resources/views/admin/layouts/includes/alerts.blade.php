 <script>
     @if (session('failed'))
         notifier.show('Failed!', '{{ session('failed') }}', 'danger',
             '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
     @endif
     @if ($errors = session('errors'))
         @if (is_object($errors))
             @foreach ($errors->all() as $error)
                 notifier.show('Error!', '{{ $error }}', 'danger',
                     '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
             @endforeach
         @else
             notifier.show('Error!', '{{ session('errors') }}', 'danger',
                 '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
         @endif
     @endif
     @if (session('successful'))
         notifier.show('Successfully!', '{{ session('successful') }}', 'success',
             '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
     @endif
     @if (session('success'))
         notifier.show('Done!', '{{ session('success') }}', 'success',
             '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
     @endif
     @if (session('warning'))
         notifier.show('Warning!', '{{ session('warning') }}', 'warning',
             '{{ asset('assets/images/notification/medium_priority-48.png') }}', 4000);
     @endif
     @if (session('status'))
         notifier.show('Great!', '{{ session('status') }}', 'info',
             '{{ asset('assets/images/notification/survey-48.png') }}', 4000);
     @endif
 </script>
 <script>
     $(document).on('click', '.delete-action', function() {
         var form_id = $(this).attr('data-form-id')
         $.confirm({
             title: '{{ __('Alert !') }}',
             conentt: '{{ __('Are You sure ?') }}',
             buttons: {
                 confirm: function() {
                     $("#" + form_id).submit();
                 },
                 cancel: function() {}
             }
         });
     });
 </script>
 <script>
     const sweetAlert = Swal.mixin({
         customClass: {
             confirmButton: 'btn btn-success m-1',
             cancelButton: 'btn btn-danger m-1'
         },
         buttonsStyling: false,
         title: 'Are you sure?',
          text: "This action can not be undone. Do you want to continue?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Next Page',
         cancelButtonText: 'No',
         reverseButtons: true
     })
 </script>
