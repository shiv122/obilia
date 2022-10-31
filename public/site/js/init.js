"use strict";
Notiflix.Loading.init({
    zindex: 999999,
});
Notiflix.Block.init({
    zindex: 9999999,
});

Notiflix.Notify.init({
    zindex: 99999999,
    position: 'right-bottom',
    cssAnimation: true,
    cssAnimationDuration: 400,
    cssAnimationStyle: 'zoom',
});



const notify = Notiflix.Notify;

const rebound = ({
    form = null,
    data = null,
    method = 'POST',
    url = null,
    refresh = false,
    reset = true,
    reload = false,
    redirect = null,
    block = null,
    beforeSendCallback = null,
    successCallback = null,
    errorCallback = null,
    completeCallback = null,
    notification = true,
    logging = true,
    returnData = false,

}) => {
    if (form === null && data === null) {
        throw new Error('No form or data provided in rebound()');
    }
    if (url === null) {
        throw new Error('No url provided in rebound()');
    }

    if (form !== null) {
        const formData = $(form)[0];
        data = new FormData(formData);
    }
    if (data !== null) {
        data = data;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: method,
        data: data,
        processData: (data.length > 0) ? true : false,
        contentType: (data.length > 0) ? true : false,
        beforeSend: function () {

            (block !== null) ? Notiflix.Block.hourglass(block) : Notiflix.Loading.hourglass();
            if (beforeSendCallback !== null) {
                beforeSendCallback.apply(null, arguments);
            }
        },
        success: function (response) {
            (logging) ? console.log(response) : null;
            (block !== null) ? Notiflix.Block.remove(block) : Notiflix.Loading.remove();

            if (reset) {
                $(form).find('input').each(function () {
                    $(this).val('').trigger('change');
                });
            }

            if (reload) {
                location.reload();
            }


            if (notification) {
                notify.success(response.header ?? 'Success!!', response.message ?? '');
            }
            (refresh || response.refresh) ? location.reload() : null;
            if (redirect !== null || (response.redirect !== null && response.redirect !== undefined)) {
                window.location.href = redirect ?? response.redirect;
            }
            if (successCallback !== null) {
                successCallback.apply(null, arguments);
            }

            if (returnData) {
                return response;
            }
            $(form).find('.is-invalid').each(function () {
                $(this).removeClass('is-invalid');
            });
            return true;
        },
        error: function (xhr, status, error) {
            // (logging) ? console.error(error) : null;
            (block !== null) ? Notiflix.Block.remove(block) : Notiflix.Loading.remove();
            if (errorCallback !== null) {
                errorCallback.apply(null, arguments);
            }
            if (xhr.status == 422) {
                $(form).find('.is-invalid').each(function () {
                    $(this).removeClass('is-invalid');
                });
                $.each(xhr.responseJSON.errors, function (key, item) {
                    notify.failure(item[0]);
                    $(form).find(`[name=${key}]`).addClass('is-invalid');
                    console.log(key);
                });
            } else if (xhr.status == 500) {
                notify.failure(error);
            } else {
                notify.failure(error);
            }
            return false;
        },
        complete: () => {
            if (block !== null) {
                Notiflix.Block.remove(block);
            } else {
                Notiflix.Loading.remove();
            }
            if (completeCallback !== null) {
                completeCallback.apply(null, arguments);
            }
        }
    });



}



// remove is-invalid class from input if it is valid
$(document).on('change', 'input,select,textarea', function () {
    if ($(this).val()) {
        if ($(this).is('input')) {
            $(this).removeClass('is-invalid');
        } else if ($(this).is('select')) {
            $(this).closest('.form-group').find('.select2-selection').css('border',
                '1px solid #ced4da');
        } else if ($(this).is('textarea')) {
            $(this).removeClass('is-invalid');
        }
    } else {
        if ($(this).is('input')) {
            $(this).addClass('is-invalid');
        } else if ($(this).is('select')) {
            $(this).closest('.form-group').find('.select2-selection').css('border',
                '1px solid red');
        } else if ($(this).is('textarea')) {
            $(this).addClass('is-invalid');
        }
    }
});
