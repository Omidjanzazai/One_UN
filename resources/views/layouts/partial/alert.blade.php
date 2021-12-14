<script>
    "@if (session('success'))";
    $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Success',
        subtitle: ' ',
        icon: 'fas fa-check fa-lg',
        body: "{{session('success')}}",
        autohide: true,
        delay: 2000,
    });
    "@endif";
    
    "@if (session('warning'))";
    $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Warning',
        subtitle: ' ',
        icon: 'fas fa-exclamation-triangle fa-lg',
        body: "{{session('warning')}}",
        autohide: true,
        delay: 2000,
    });
    "@endif";
    
    "@if (session('danger'))";
    $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Blocked',
        subtitle: ' ',
        icon: 'fas fa-ban fa-lg',
        body: "{{session('danger')}}",
        autohide: true,
        delay: 2000,
    });
    "@endif";

// $(function() {
//     $('.toastsDefaultAutohide').click(function() {
//       $(document).Toasts('create', {
//         title: 'Toast Title',
//         autohide: true,
//         delay: 750,
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
//       })
//     });
//     $('.toastsDefaultFull').click(function() {
//       $(document).Toasts('create', {
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
//         title: 'Toast Title',
//         subtitle: 'Subtitle',
//         icon: 'fas fa-envelope fa-lg',
//       })
//     });
//     $('.toastsDefaultSuccess').click(function() {
//       $(document).Toasts('create', {
//         class: 'bg-success',
//         title: 'Toast Title',
//         subtitle: 'Subtitle',
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
//       })
//     });
//     $('.toastsDefaultInfo').click(function() {
//       $(document).Toasts('create', {
//         class: 'bg-info',
//         title: 'Toast Title',
//         subtitle: 'Subtitle',
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
//       })
//     });
//     $('.toastsDefaultWarning').click(function() {
//       $(document).Toasts('create', {
//         class: 'bg-warning',
//         title: 'Toast Title',
//         subtitle: 'Subtitle',
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
//       })
//     });
//     $('.toastsDefaultDanger').click(function() {
//       $(document).Toasts('create', {
//         class: 'bg-danger',
//         title: 'Toast Title',
//         subtitle: 'Subtitle',
//         body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
//       })
//     });
// });
</script>