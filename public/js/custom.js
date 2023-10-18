function handleIsClosedChange() {
    var isClosedCheckbox = document.getElementById('is_it_closed');
    var temporarilyClosedCheckbox = document.getElementById('temporarily_closed');

    temporarilyClosedCheckbox.disabled = !!isClosedCheckbox.checked;
}

function handleTemporarilyClosedChange() {
    var isClosedCheckbox = document.getElementById('is_it_closed');
    var temporarilyClosedCheckbox = document.getElementById('temporarily_closed');

    isClosedCheckbox.disabled = !!temporarilyClosedCheckbox.checked;
}

//Search Organization state script

$(document).ready(function () {
    function performSearch(query) {
        $.ajax({
            url: searchStatesRoute,
            method: 'GET',
            data: {query: query},
            success: function (data) {
                updateStateList(data.states);
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    function updateStateList(states) {
        var stateList = $('.state-list');
        stateList.empty();

        if (states.length === 0) {
            // If no states are found, display "No State Found"
            stateList.append('<p>No State Found</p>');
        } else {
            // Display states if found
            states.forEach(function (state) {
                // Construct the dynamic URL for each state
                var stateWiseOrganizationsURL = stateWiseOrganizationsRoute + '/' + state.slug;

                // Create the state card HTML
                var stateCard = '<a href="' + stateWiseOrganizationsURL + '" class="generic-img-card d-block hover-y overflow-hidden mb-3">' +
                    '<img src="' + assetPath + '" data-src="' + assetPath + '" ' +
                    'alt="image" class="generic-img-card-img filter-image lazy" loading="lazy">' +
                    '<div class="generic-img-card-content d-flex align-items-center justify-content-between">' +
                    '<span class="badge text-capitalize">' + state.name + '</span>' +
                    '<span class="generic-img-card-counter">' + state.organizations_count + '</span>' +
                    '</div>' +
                    '</a';

                // Append the state card to the state list
                stateList.append(stateCard);
            });
        }
    }

    $('#state_search').on('keyup', function () {
        var query = $(this).val();
        performSearch(query);
    });
});

//All state search script
$(document).ready(function () {
    $('#all_state_search').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.organization-state-list .responsive-column').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});




