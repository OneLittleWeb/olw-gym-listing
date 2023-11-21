<!-- Suggest Edit Modal -->
<div class="modal fade" id="suggestEditModal" tabindex="-1" role="dialog" aria-labelledby="suggestEditModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header suggest-edit-modal-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $organization->organization_name }}</h5>
                    </div>
                    <div class="col-2">
                        <button type="button" class="close suggest-edit-close-button" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <p class="la la-map-marker mr-2 pt-2 suggest-edit-modal-address">
                    @if($organization->organization_address)
                        {{ $organization->organization_address }}
                    @else
                        {{ ucfirst($organization->city->name) }}, Nebraska, US
                    @endif
                </p>
                <p class="la la-phone mr-2 pt-2 suggest-edit-modal-address">
                    {{ $organization->organization_phone_number }}
                </p>
            </div>
            <form method="post" action="{{ route('store.suggest.edit',$organization->slug ) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="suggested-modal-content-section">
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Is It Closed?</div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input suggest-edit-form-check-input" type="checkbox"
                                           name="is_it_closed"
                                           id="is_it_closed"
                                           value="1"
                                        {{ $organization->permanently_closed ? 'checked' : '' }}>
                                    <label class="form-check-label suggested-modal-content-text" for="is_it_closed">
                                        Yes, this business is permanently closed
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Temporarily closed?</div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input suggest-edit-form-check-input" type="checkbox"
                                           name="temporarily_closed"
                                           id="temporarily_closed"
                                           value="1"
                                        {{ $organization->temporarily_closed ? 'checked' : '' }}>
                                    <label class="form-check-label suggested-modal-content-text"
                                           for="temporarily_closed">
                                        Yes, this business is temporarily closed
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Are you the owner?</div>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <input class="form-check-input suggest-edit-form-check-input" type="checkbox"
                                           name="are_you_the_owner"
                                           id="are_you_the_owner" value="1">
                                    <label class="form-check-label suggested-modal-content-text"
                                           for="are_you_the_owner">
                                        I'm the owner (manager) of the business
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Business Name</div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="organization_name" id="organization_name"
                                       value="{{ $organization->organization_name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Address</div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="organization_address"
                                       id="organization_address" value="{{ $organization->organization_address }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Phone</div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="organization_phone_number"
                                       id="organization_phone_number"
                                       value="{{ $organization->organization_phone_number }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Website Url</div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="organization_website"
                                       id="organization_website" value="{{ $organization->organization_website }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Price list Url</div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="price_list_url" id="price_list_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Hours of Operation</div>
                            <div class="col-sm-9">

                                <div class="form-box table-responsive">
                                    <table class="table time-list mb-0">
                                        <thead>
                                        <tr>
                                            <th class="w-50">Days</th>
                                            <th>Open</th>
                                            <th>Close</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($organization->organization_work_time && $organization->organization_work_time != ". Hide open hours for the week")
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $first_day }}</td>
                                                <input type="hidden" name="first_day" value="{{ $first_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="first_day_open"
                                                            id="first_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{ $hours }}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $first_day_opening_hours)  ? 'selected' : '' }}>
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="first_day_close"
                                                            id="first_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $first_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $second_day }}</td>
                                                <input type="hidden" name="second_day" value="{{ $second_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="second_day_open"
                                                            id="second_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $second_day_opening_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="second_day_close"
                                                            id="second_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $second_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $third_day }}</td>
                                                <input type="hidden" name="third_day" value="{{ $third_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="third_day_open"
                                                            id="third_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $third_day_opening_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="third_day_close"
                                                            id="third_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $third_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $fourth_day }}</td>
                                                <input type="hidden" name="fourth_day" value="{{ $fourth_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fourth_day_open"
                                                            id="fourth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{ $hours }}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $fourth_day_opening_hours) ? 'selected' : '' }}>
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fourth_day_close"
                                                            id="fourth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $fourth_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $fifth_day }}</td>
                                                <input type="hidden" name="fifth_day" value="{{ $fifth_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fifth_day_open"
                                                            id="fifth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{ $hours }}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $fifth_day_opening_hours) ? 'selected' : '' }}>
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fifth_day_close"
                                                            id="fifth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $fifth_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $sixth_day }}</td>
                                                <input type="hidden" name="sixth_day" value="{{ $sixth_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sixth_day_open"
                                                            id="sixth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{ $hours }}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $sixth_day_opening_hours) ? 'selected' : '' }}>
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sixth_day_close"
                                                            id="sixth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $sixth_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">{{ $seventh_day }}</td>
                                                <input type="hidden" name="seventh_day" value="{{ $seventh_day }}">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="seventh_day_open"
                                                            id="seventh_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{ $hours }}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $seventh_day_opening_hours) ? 'selected' : '' }}>
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="seventh_day_close"
                                                            id="seventh_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}" {{ str_replace(' ', ' ', $hours) == str_replace(' ', ' ', $seventh_day_closing_hours) ? 'selected' : '' }}>{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @else
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Monday</td>
                                                <input type="hidden" name="first_day" value="Monday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="first_day_open"
                                                            id="first_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{ $hours }}">
                                                                {{ $hours }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="first_day_close"
                                                            id="first_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Tuesday</td>
                                                <input type="hidden" name="second_day" value="Tuesday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="second_day_open"
                                                            id="second_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="second_day_close"
                                                            id="second_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Wednesday</td>
                                                <input type="hidden" name="third_day" value="Wednesday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="third_day_open"
                                                            id="third_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="third_day_close"
                                                            id="third_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Thursday</td>
                                                <input type="hidden" name="fourth_day" value="Thursday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fourth_day_open"
                                                            id="fourth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{ $hours }}">{{ $hours }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fourth_day_close"
                                                            id="fourth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Friday</td>
                                                <input type="hidden" name="fifth_day" value="Friday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fifth_day_open"
                                                            id="fifth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{ $hours }}">{{ $hours }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="fifth_day_close"
                                                            id="fifth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Saturday</td>
                                                <input type="hidden" name="sixth_day" value="Saturday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sixth_day_open"
                                                            id="sixth_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{ $hours }}">{{ $hours }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="sixth_day_close"
                                                            id="sixth_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="business-opening-wrap">
                                                <td class="business-day">Sunday</td>
                                                <input type="hidden" name="seventh_day" value="Sunday">
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="seventh_day_open"
                                                            id="seventh_day_open">
                                                        @foreach($select_hours as $hours)
                                                            <option value="{{ $hours }}">{{ $hours }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="user-chosen-select-container">
                                                    <select class="user-chosen-select" name="seventh_day_close"
                                                            id="seventh_day_close">
                                                        @foreach($select_hours as $hours)
                                                            <option
                                                                value="{{$hours}}">{{$hours}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Description</div>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="organization_short_description"
                                          id="organization_short_description"
                                          rows="3">{{ $organization->organization_short_description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 suggested-modal-content-text">Your Message</div>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="message" id="message"
                                          rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Suggest Edit Modal -->

<!-- Get Your Award Modal -->
<div class="modal fade" id="getYourAwardModal" tabindex="-1" role="dialog" aria-labelledby="getYourAwardModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header suggest-edit-modal-header">
                <div class="row">
                    <div class="col-10">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ $organization->organization_name }}</h5>
                    </div>
                    <div class="col-2">
                        <button type="button" class="close suggest-edit-close-button" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <p class="la la-map-marker mr-2 pt-2 suggest-edit-modal-address">
                    @if($organization->organization_address)
                        {{ $organization->organization_address }}
                    @else
                        {{ ucfirst($organization->city->name) }}, Nebraska, US
                    @endif
                </p>
                <p class="la la-phone mr-2 pt-2 suggest-edit-modal-address">
                    {{ $organization->organization_phone_number }}
                </p>
            </div>
            <form method="post" action="{{ route('get.award.certificate', $organization->slug) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="suggested-modal-content-section">
                        <div class="form-group row">
                            <div class="col-sm-5 suggested-modal-content-text">Are you affiliated
                                with {{ $organization->organization_name }} ?
                            </div>
                            <div class="col-sm-7">
                                <div class="form-check">
                                    <input class="form-check-input suggest-edit-form-check-input" type="checkbox"
                                           name="is_affiliated"
                                           id="is_affiliated" value="1">
                                    <label class="form-check-label suggested-modal-content-text"
                                           for="is_affiliated">
                                        Yes
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-5 suggested-modal-content-text">Name <span class="required">*</span>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="requested_user_name"
                                       id="requested_user_name" value="{{ old('requested_user_name') }}"
                                       placeholder="Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-5 suggested-modal-content-text">Your Email <span
                                    class="required">*</span></div>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" name="requested_user_email"
                                       id="requested_user_email"
                                       value="{{ old('requested_user_email') }}" placeholder="Your Email" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Get Your Award Modal -->
