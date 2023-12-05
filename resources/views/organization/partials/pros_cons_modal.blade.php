<div class="modal fade" id="getProsConsModal" tabindex="-1" role="dialog" aria-labelledby="getProsConsTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header suggest-edit-modal-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="modal-title" id="exampleModalLongTitle">Review Keywords Analysis</h5>
                    </div>
                    <div class="col-2">
                        <button type="button" class="close suggest-edit-close-button" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <p class="mr-2 pt-2 suggest-edit-modal-address">
                    <span class="la la-circle-thin mr-1 green-circle"></span>Friendly (7)
                </p>
            </div>
            <div class="block-card mb-4">
                <div class="tab-content review-tab-content">
                    <div class="tab-pane fade show active" role="tabpanel"
                         aria-labelledby="google-tab">
                        <div>
                            <div class="comments-list">
                                @foreach($organization->reviews_paginator as $review)
                                    <div class="comment">
                                        @if($review->reviewer_name)
                                            <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                <img
                                                    src="{{ Avatar::create($review->reviewer_name)->toBase64() }}"
                                                    alt="author-img">
                                            </div>
                                        @else
                                            <div class="user-thumb user-thumb-lg flex-shrink-0">
                                                <img src="{{ asset('images/bb.png') }}"
                                                     alt="author-img">
                                            </div>
                                        @endif
                                        <div class="comment-body">
                                            <div
                                                class="meta-data d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h4 class="comment__title">{{ $review->reviewer_name }}</h4>
                                                </div>
                                                <div class="star-rating-wrap text-center">
                                                    <div class="users_review_ratings"
                                                         data-rating="{{ $review->review_rate_stars }}">
                                                    </div>
                                                    @if($review->review_date)
                                                        <p class="font-size-13 font-weight-medium">{{ Carbon::parse($review->review_specified_date)->diffForHumans() }}</p>
                                                    @else
                                                        <p class="font-size-13 font-weight-medium">{{ Carbon::parse($review->created_at)->diffForHumans() }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="comment-desc">{{ $review->review_text_original }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
