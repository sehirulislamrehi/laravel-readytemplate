$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault()
        $(".loading").show()

        let $this = $(this);
        let formData = new FormData(this);

        $this.find(".has-danger").removeClass('has-error');
        $this.find(".form-errors").remove();

        $.ajax({
            type: $this.attr('method'),
            url: $this.attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $(".loading").hide()
                // if (response.redirect) {
                //     swal('', `${response.message}`, `${response.status}`)
                //     setTimeout(function () {
                //         return window.location.href = response.redirect
                //     }, 1000);
                // }
                // else if (response.login) {
                //     swal("Login Successfully Done", "Redirecting Please Wait", "success")
                //     return window.location.href = response.login
                // }
                // else if (response.location_reload) {
                //     swal('', `${response.location_reload}`, `${response.status}`)
                //     return location.reload()
                // }

                if( response.location_reload == true ){
                    swal('', `${response.message}`, `${response.status}`)
                    setTimeout(function () {
                        return window.location.href = response.url
                    }, 1000);
                }
                else {
                    swal('', `${response.message}`, `${response.status}`)
                    if ($("#datatable").length) {
                        $("#datatable").DataTable().ajax.reload();
                    }
                }

            },
            error: function (response) {
                $(".loading").hide()
                if (response.status === 500) {
                    let error = JSON.parse(response.responseText);
                    swal('', `${error.message}`, `${error.status}`)
                }
                else {
                    let data = JSON.parse(response.responseText);
                    $.each(data.errors, (key, value) => {
                        swal("", `${value}`, "warning");
                        $("[name^=" + key + "]").parent().addClass('has-error')
                        $("[name^=" + key + "]").parent().append('<small class="danger text-muted form-errors">' + value[0] + '</small>');
                    })
                }
                console.clear()
            }
        })
    })


})
