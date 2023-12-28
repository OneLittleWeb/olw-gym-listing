/* jshint esversion: 6 */

//suggest an edit temporarily and permanently closed enable disable script

$(document).ready(function () {
    $('#is_it_closed').change(function () {
        let temporarilyClosedCheckbox = $('#temporarily_closed');
        temporarilyClosedCheckbox.prop('disabled', this.checked);
    });

    $('#temporarily_closed').change(function () {
        let isClosedCheckbox = $('#is_it_closed');
        isClosedCheckbox.prop('disabled', this.checked);
    });
});

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
        let stateList = $('.state-list');
        stateList.empty();

        if (states.length === 0) {
            stateList.append('<p>No State Found</p>');
        } else {
            states.forEach(function (state) {
                let stateWiseOrganizationsURL = stateWiseOrganizationsRoute + '/' + state.slug + '/gym';

                let stateCard = '<a href="' + stateWiseOrganizationsURL + '" class="generic-img-card d-block hover-y overflow-hidden mb-3">' +
                    '<img src="' + assetPath + '" data-src="' + assetPath + '" ' +
                    'alt="image" class="generic-img-card-img filter-image lazy" loading="lazy">' +
                    '<div class="generic-img-card-content d-flex align-items-center justify-content-between">' +
                    '<span class="badge text-capitalize">' + state.name + '</span>' +
                    '<span class="generic-img-card-counter">' + state.organizations_count + '</span>' +
                    '</div>' +
                    '</a';

                stateList.append(stateCard);
            });
        }
    }

    $('#state_search').on('keyup', function () {
        let query = $(this).val();
        performSearch(query);
    });
});

//All state search script

$(document).ready(function () {
    $('#all_state_search').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        let resultsFound = false;

        $('.organization-state-list .responsive-column').each(function () {
            let itemText = $(this).text().toLowerCase();
            let itemVisible = itemText.indexOf(value) > -1;
            $(this).toggle(itemVisible);
            if (itemVisible) {
                resultsFound = true;
            }
        });

        if (!resultsFound) {
            $('#no_results_message').show();
        } else {
            $('#no_results_message').hide();
        }
    });
});

//autocomplete search script

$(document).ready(function () {
    $('#search_from_header').typeahead({
        source: function (query, process) {
            return $.get(autocompleteRoute, {term: query}, function (data) {
                return process(data);
            });
        },
        updater: function (item) {
            let id = item.id;
            let name = item.source;
            $('#source_value').val(name);
            $('#source_id').val(id);
            return item.name;
        }
    });
});

//Organization review star script

$(document).ready(function () {
    if ($.fn.starRating) {
        $('.users_review_ratings').starRating({
            totalStars: 5,
            starSize: 18,
            starShape: 'rounded',
            emptyColor: 'lightgray',
            activeColor: '#FFA718',
            readOnly: true,
            useGradient: false
        });

        $('.organization_rating').starRating({
            totalStars: 5,
            starSize: 18,
            starShape: 'rounded',
            emptyColor: 'lightgray',
            activeColor: '#FFA718',
            readOnly: true,
            useGradient: false
        });
    }

    /* 1. Visualizing things on Hover - See next part for action on click */

    $('#stars li').on('mouseover', function () {
        let onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function (e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });

    }).on('mouseout', function () {
        $(this).parent().children('li.star').each(function (e) {
            $(this).removeClass('hover');
        });
    });

    /* 2. Action to perform on click */
    $('#stars li').on('click', function () {
        let onStar = parseInt($(this).data('value'), 10); // The star currently selected
        let stars = $(this).parent().children('li.star');

        for (let i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (let i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
        // JUST RESPONSE (Not needed)
        document.getElementById('review_rate_stars').value = parseInt($('#stars li.selected').last().data('value'), 10);
    });
});

//State toggle script

$(document).ready(function () {
    // Initial state: Hide city information for all states except the first one after the page loads
    $('.all-state-info-list-box').not(':first').hide();

    // Handle toggling of the first state's information after the page loads
    let firstStateTarget = $('.all-state-info-list-box:first').attr('id');
    let firstStateTargetUpdated = $('#' + firstStateTarget);
    firstStateTargetUpdated.slideDown();

    // Set the initial icon state for the first state
    let firstStateIcon = $('.single-state-block-card-div:first').find('.toggle-icon i');
    if (firstStateTargetUpdated.is(':hidden')) {
        firstStateIcon.removeClass('fa-caret-up').addClass('fa-caret-down');
    } else {
        firstStateIcon.removeClass('fa-caret-down').addClass('fa-caret-up');
    }

    // Function to toggle state and city information
    function toggleStateAndCity(target) {
        // Toggle the visibility of the target element
        target.slideToggle();

        // Toggle the caret icon
        let iconElement = $('[data-target="' + target.attr('id') + '"]').find('.toggle-icon i');
        iconElement.toggleClass('fa-caret-down fa-caret-up');
    }

    // Function to reapply toggle after search by city
    function reapplyToggleForCity(cityElement) {
        let targetState = cityElement.closest('.single-state-block-card-div').data('target');
        let targetStateElement = $('#' + targetState);

        // Expand state block if it's collapsed
        if (targetStateElement.is(':hidden')) {
            toggleStateAndCity(targetStateElement);
        }
    }

    // Function to show all elements when the search input is empty
    function showAllElements() {
        $('.single-state-block-card-div').show();
        $('.all-cities-from-states li').show();
        $('.no-state-found-message').hide();
    }

    // When the search input changes
    $('#all_state_search').on('input', function () {
        let searchText = $(this).val().toLowerCase();
        let foundStates = false;

        if (searchText === '') {
            // Show all elements when search input is empty
            showAllElements();
            foundStates = true; // Set foundStates to true to indicate at least one state is found
        } else {
            // Iterate over each state container
            $('.single-state-block-card-div').each(function () {
                let stateName = $(this).find('.all-state-widget-title span').text().toLowerCase();
                let cityList = $(this).find('.all-cities-from-states li');

                // Show or hide based on the search text for state name
                if (stateName.includes(searchText)) {
                    $(this).show();
                    foundStates = true;
                } else {
                    $(this).hide();
                }

                // Iterate over each city in the state
                cityList.each(function () {
                    let cityName = $(this).text().toLowerCase();

                    // Show or hide city based on the search text
                    if (cityName.includes(searchText)) {
                        $(this).show();
                        // If a city matches, show its parent state container
                        $(this).closest('.single-state-block-card-div').show();
                        foundStates = true; // Set foundStates to true if a city is found

                        // Expand state block associated with the city
                        reapplyToggleForCity($(this).find('a'));
                    } else {
                        $(this).hide();
                    }
                });
            });
        }

        // Show the "No State Found" message if no states are found
        if (!foundStates) {
            $('.no-state-found-message').show();
        } else {
            $('.no-state-found-message').hide();
        }
    });

    // Use event delegation for dynamically added elements
    $(document).on('click', '.single-state-block-card-div', function () {
        let targetSelector = $(this).data('target');
        let targetElement = $('#' + targetSelector);

        toggleStateAndCity(targetElement);
    });

    // Show all elements when the page loads or reloads
    showAllElements();
});


// $(document).ready(function () {
//     // Hide city information for all states except the first one after the page loads
//     $('.all-state-info-list-box').not(':first').hide();
//
//     // Handle toggling of the first state's information after the page loads
//     let firstStateTarget = $('.all-state-info-list-box:first').attr('id');
//     let firstStateTargetUpdated = $('#' + firstStateTarget);
//     firstStateTargetUpdated.slideDown();
//
//     // Set the initial icon state for the first state
//     let firstStateIcon = $('.single-state-block-card-div:first').find('.toggle-icon i');
//     if (firstStateTargetUpdated.is(':hidden')) {
//         firstStateIcon.removeClass('fa-caret-up').addClass('fa-caret-down');
//     } else {
//         firstStateIcon.removeClass('fa-caret-down').addClass('fa-caret-up');
//     }
//
//     // Use event delegation for dynamically added elements
//     $(document).on('click', '.single-state-block-card-div', function () {
//         // Find the target element to toggle based on the data-target attribute
//         let targetSelector = $(this).data('target');
//         let targetElement = $('#' + targetSelector);
//
//         // Toggle the visibility of the target element
//         targetElement.slideToggle();
//
//         // Toggle the caret icon
//         let iconElement = $(this).find('.toggle-icon i');
//         iconElement.toggleClass('fa-caret-down fa-caret-up');
//     });
// });

//state search script

// $(document).ready(function () {
//     // When the search input changes
//     $('#all_state_search').on('input', function () {
//         let searchText = $(this).val().toLowerCase();
//         let foundStates = false;
//
//         // Iterate over each state container
//         $('.single-state-block-card-div').each(function () {
//             let stateName = $(this).find('.all-state-widget-title span').text().toLowerCase();
//
//             // Show or hide based on the search text
//             if (stateName.includes(searchText)) {
//                 $(this).show();
//                 foundStates = true;
//             } else {
//                 $(this).hide();
//             }
//         });
//
//         // Show the "No State Found" message if no states are found
//         if (!foundStates) {
//             $('.no-state-found-message').show();
//         } else {
//             $('.no-state-found-message').hide();
//         }
//     });
// });

// Review scroll to top script

$(window).on('load', function() {
    let urlParams = new URLSearchParams(window.location.search);
    let pageParam = urlParams.get('g_reviews');

    if (pageParam) {
        let businessReviewsCard = $('#business_reviews_card');

        if (businessReviewsCard.length) {
            $('html, body').animate({
                scrollTop: businessReviewsCard.offset().top
            }, 1000);
        }
    }
});

