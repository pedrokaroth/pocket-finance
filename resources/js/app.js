$(function() {
    const app = $('.app');

    /*
    *   TOASTR
    */
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    /*
    *   FLASH
    */

    if (app.data().hasOwnProperty('message')) {
        let type = app.data('type');
        let message = app.data('message');

        switch (type){
            case 'success':
                toastr.success(message);
                break;
        }
    }

    /*
    *   AJAX
    */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $("form:not('.ajax-off')").submit(function(event) {
        event.preventDefault();
        const form = $(this);
        const data = form.serialize();
        const action = form.attr('action');

        $.ajax({
            url: action,
            type: 'POST',
            data: data,
            dataType: 'json',

            success: function(response) {
                if(response.reload) {
                    window.location.reload();
                }
            },

            error: function(response) {
                const errors = response.responseJSON.errors;

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key]);
                });
            }
        })
    })

    $('.open-modal').click(function() {
        if ($(".app-modal").length) {
            let modal = $(this).data('modal');
            $('#' + modal).modal('show');
        }
    })
    /*
    *   MASK
    */
    $(".mask-money").mask('000.000.000.000.000,00', {
        reverse: true,
        placeholder: "0,00"
    });
    /*
    *   SELECT2
    */
    $('.select2').select2({
        width: '150px',
    });
})
