$(document).ready(function () {

    'use strict';

    $('.price-filter').keypress(function (e) {

        if(e.key === 'Enter') {
            $('#filter-by-price').submit();
        }

    });

    $('#toggle-all-listings').on('change', function () {
        $('.toggle-listing').prop('checked', $(this).prop('checked'));
    });

    $('#delete-selected-listings').on('click', function () {

        let listingsIds = [];

        $('.toggle-listing:checked').each(function () {
            listingsIds.push($(this).closest('tr').attr('id'));
        });

        if(listingsIds.length > 0) {

            let queryId = $('#delete-selected-listings').closest('table').attr('id');
            jQuery.ajax(bulkMarkAsRead(queryId, listingsIds));

        }

    });

    $('.delete-listing').on('click', function () {

        let listing = $(this).closest('tr');

        let listingId = listing.attr('id');
        let queryId = $(this).closest('table').attr('id');

        jQuery.ajax(markAsRead(listing, queryId, listingId));

    });

});

function bulkMarkAsRead(queryId, listingsIds) {

    return {
        type: "PATCH",
        url: '/api/query/' + queryId + '/listing/bulk-mark-as-read',
        data: {
            listingIds: listingsIds
        },
        success: function (response) {

            listingsIds.forEach(function (id) {
                $('tr#'+id).fadeOut();
            });

            $('#toggle-all-listings').prop('checked', false);

        }
    }

}

function markAsRead(listing, queryId, listingId) {

    return {
        type: "PATCH",
        url: '/api/query/' + queryId + '/listing/' + listingId + '/mark-as-read',
        success: function (response) {

            console.log(JSON.parse(response));
            listing.fadeOut();

        }
    }

}

function search(query) {

    return {
        type: "GET",
        url: '/api/search?q=' + encodeURI(query),
        success: function (response) {

            let resultsTable = $('#results > tbody');
            resultsTable.html("");

            response.results.forEach(item => {

                let row = $('<tr>').append(
                    $('<td>').text(item.title),
                    $('<td>').text('R$' + item.price),
                    $('<td>').text(item.condition),
                    $('<td>').append($('<img>').attr('src', item.thumbnail)),
                    $('<td>').append($('<i>').addClass('fas').addClass('fa-link')).wrapInner($('<a>').attr('href', item.permalink))
                ).attr('id', item.id);

                resultsTable.append(row);

            });
        }
    }

}
