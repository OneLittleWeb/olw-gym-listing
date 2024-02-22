/* jshint esversion: 6 */
/* jshint unused: false */

function displayReviewProsCons(event, keyword, count, slug, type) {

    event.preventDefault();

    $('#getProsConsModal').modal('show');

    $('#getProsConsModal #review_pros_cons_list').empty();
    $('#keyword_count').text(`${keyword} (${count})`);

    $('#pros_cons_loader').show();

    if (type === 'pros') {
        $('#getProsConsModal .review-pros-cons-keyword').removeClass('text-danger');
        $('#getProsConsModal .review-pros-cons-keyword').addClass('text-success');
        $('#getProsConsModal .review-pros-cons-keyword .la-circle-thin').removeClass('red-circle');
        $('#getProsConsModal .review-pros-cons-keyword .la-circle-thin').addClass('green-circle');
    } else {
        $('#getProsConsModal .review-pros-cons-keyword').removeClass('text-success');
        $('#getProsConsModal .review-pros-cons-keyword').addClass('text-danger');
        $('#getProsConsModal .review-pros-cons-keyword .la-circle-thin').removeClass('green-circle');
        $('#getProsConsModal .review-pros-cons-keyword .la-circle-thin').addClass('red-circle');
    }

    $.ajax({
        url: `/get-pros-cons-reviews/${slug}/${keyword}/${type}`,
        method: 'GET',
        success: function (response) {
            let modalContent = '';
            response.reviews.forEach(review => {
                let reviewDate = review.review_specified_date ? review.review_specified_date : review.created_at;
                let formattedDate = moment(reviewDate).fromNow();

                function highlightKeyword(text, keyword) {
                    if (type === 'pros') {
                        return text.replace(new RegExp(keyword, 'gi'), match => `<span class="pros-highlight">${match}</span>`);
                    } else {
                        return text.replace(new RegExp(keyword, 'gi'), match => `<span class="cons-highlight">${match}</span>`);
                    }
                }

                let highlightedReviewText = highlightKeyword(review.review_text_original, keyword);

                modalContent += `
                    <div class="comment">
                        <div class="user-thumb user-thumb-lg flex-shrink-0">
                            <img src="${review.reviewer_name ? `https://ui-avatars.com/api/?name=${review.reviewer_name}&background=random` : baseUrl + '/images/bb.png'}" alt="author-img">
                        </div>
                        <div class="comment-body">
                            <div class="meta-data d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="comment__title">${review.reviewer_name}</h4>
                                </div>
                                <div class="star-rating-wrap text-center">
                                    <div class="pros_cons_review_ratings" data-rating="${review.review_rate_stars}"></div>
                                    <p class="font-size-13 font-weight-medium">${formattedDate}</p>
                                </div>
                            </div>
                            <p class="comment-desc">${highlightedReviewText}</p>
                        </div>
                    </div>`;
            });

            $('#getProsConsModal #review_pros_cons_list').html(modalContent);

            if ($.fn.starRating) {
                $('.pros_cons_review_ratings').starRating({
                    totalStars: 5,
                    starSize: 18,
                    starShape: 'rounded',
                    emptyColor: 'lightgray',
                    activeColor: '#FFA718',
                    readOnly: true,
                    useGradient: false
                });
            }

            $('#pros_cons_loader').hide();
        },
        error: function (xhr, status, error) {
            console.error(error);
            $('#pros_cons_loader').hide();
        }
    });
}
