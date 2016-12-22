  <div class="row m-b-lg m-t-lg">
                <div class="col-md-5">

                    <div class="profile-image">
                        <img src="{{ has_image($guardian) ? asset('storage/' . $guardian->image) : asset('storage/images/' . strtolower($guardian->sex) . '.png') }}" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h3 class="no-margins">
                                    {{ $guardian->name }}
                                </h3>
                                <h4><a href="mailto: {{ $guardian->email or '#'}}">{{ $guardian->email or 'no email' }}</a></h4>
                                <h5>{{ $guardian->guardian_id }}</h5>
                                <h4>Wards: {{ $guardian->students->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                Sex <strong> {{ $guardian->sex }} </strong>
                            </td>
                            <td>
                                Phone <strong>{{ $guardian->phone }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>State of origin</strong> {{ $guardian->state->name }}, {{ $guardian->lga->name }}
                            </td>
                            <td>
                                <strong>Occupation</strong> {{ $guardian->occupation }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Address</strong> {{ $guardian->address }}
                            </td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>