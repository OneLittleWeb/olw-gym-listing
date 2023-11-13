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
                let stateWiseOrganizationsURL = stateWiseOrganizationsRoute + '/' + state.slug;

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

// document.addEventListener('DOMContentLoaded', function () {
//     const input = document.getElementById('search_from_header');
//     const placeholders = [
//         'Looking for? Business',
//         'Looking for? State',
//         'Looking for? City',
//     ];
//     let currentIndex = 0;
//
//     function showNextPlaceholder() {
//         input.placeholder = placeholders[currentIndex];
//         currentIndex = (currentIndex + 1) % placeholders.length;
//
//         setTimeout(showNextPlaceholder, 2000); // 2000 milliseconds (2 seconds)
//     }
//
//     showNextPlaceholder();
// });

document.addEventListener('DOMContentLoaded', function () {
    const title = document.getElementById('hero_title_animation');
    const titles = [
        'Find The Best GymNear California',
        'Find The Best GymNear Florida',
        'Find The Best GymNear Georgia',
        'Find The Best GymNear Illinois',
        'Find The Best GymNear Michigan',
        'Find The Best GymNear New York',
        'Find The Best GymNear Ohio',
        'Find The Best GymNear Texas',
    ];
    let currentIndex = 0;

    function showNextTitle() {
        if (title) {
            title.textContent = titles[currentIndex];
            currentIndex = (currentIndex + 1) % titles.length;

            setTimeout(showNextTitle, 2000); // 2000 milliseconds (2 seconds)
        }
    }

    showNextTitle();
});

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

$(document).ready(function () {
    // Use event delegation for dynamically added elements
    $(document).on('click', '.single-state-block-card-div', function () {
        // Find the target element to toggle based on the data-target attribute
        var targetSelector = $(this).data('target');
        var targetElement = $('#' + targetSelector);

        // Toggle the visibility of the target element
        targetElement.slideToggle();

        // Toggle the caret icon
        var iconElement = $(this).find('.toggle-icon i');
        iconElement.toggleClass('fa-caret-down fa-caret-up');
    });
});

$(document).ready(function () {
    // When the search input changes
    $('#all_state_search').on('input', function () {
        var searchText = $(this).val().toLowerCase();

        // Iterate over each state container
        $('.all-state-container').each(function () {
            var stateName = $(this).find('.widget-title a').text().toLowerCase();

            // Show or hide based on the search text
            if (stateName.includes(searchText)) {
                $(this).removeClass('hidden');
            } else {
                $(this).addClass('hidden');
            }
        });
    });
});

$(window).on('load', function() {
    // Check if the page parameter is present in the URL
    var urlParams = new URLSearchParams(window.location.search);
    var pageParam = urlParams.get('g_reviews');

    if (pageParam) {
        // Scroll down to the element with the ID "business-reviews-card"
        var businessReviewsCard = $('#business_reviews_card');

        if (businessReviewsCard.length) {
            $('html, body').animate({
                scrollTop: businessReviewsCard.offset().top
            }, 1000);
        }
    }
});

