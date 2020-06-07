$(document).ready(function () {

    $('#bulk-sync').click(function () {
        $('.sync').trigger('click');
    });

    $('.sync').on('click', function () {

        let queryId = $(this).closest('tr').attr('id');
        jQuery.ajax(sync(queryId));

    });

    $('.edit-query').click(function () {
        $(this).closest('tr').find('.search-key').attr('contenteditable', 'true').focus();
    });

    $('.search-key').keypress(function (e) {

        if(e.key === 'Enter') {
            $(this).blur();
        }

    }).focusin(function () {
        console.log('old value: ' + $(this).data('text'));
    }).focusout(function () {

        let oldValue = $(this).data('text');
        let newValue = $(this).text().trim();

        console.log('oldValue: ' + oldValue);

        let queryId = $(this).closest('tr').attr('id');
        $(this).attr('contenteditable', 'false');

        if(oldValue !== newValue) {
            console.log('updating search key...');
            jQuery.ajax(editSearchKey(queryId, newValue));
        }

    });

    $('.delete-query').on('click', function () {

        let queryId = $(this).closest('tr').attr('id');
        jQuery.ajax(deleteQuery(queryId));

    });

});

function sync(queryId) {

    return {
        type: "PATCH",
        url: '/api/query/' + queryId + '/sync',
        beforeSend: function() {

            $('tr#'+queryId).find('.fa-sync-alt').addClass('fa-spin');

            spin = setInterval(function() {
                $('tr#'+queryId).find('.fa-sync-alt').toggleClass('fa-spin');
            }, 1000);

        },
        complete: function() {
            $('tr#'+queryId).find('.fa-sync-alt').removeClass('fa-spin');
            clearInterval(spin);
        },
        success: function (response) {

            let unreadListings = JSON.parse(response).unread_listings;
            $('tr#' + queryId + ' > td.new').html(unreadListings)
            console.log(unreadListings);

        }
    }
}

let spin = null;

function editSearchKey(queryId, searchKey) {

    return {
        type: "PATCH",
        url: '/api/query/' + queryId,
        data: {
            searchKey: searchKey
        },
        success: function (response) {

            $('tr#'+queryId).find('.search-key').data('text', searchKey);
            console.log('new value: ', $('tr#'+queryId).find('.search-key').data('text'));

        }
    }

}

function deleteQuery(queryId) {

    return {
        type: "DELETE",
        url: '/api/query/' + queryId,
        success: function (response) {

            console.log(JSON.parse(response));
            $('tr#'+queryId).fadeOut();

        }
    }
}
