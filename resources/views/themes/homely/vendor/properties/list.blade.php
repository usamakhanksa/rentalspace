@extends(template().'layouts.user')
@section('title',trans('Properties'))
@section('content')
    @php
        $activeTab = request('tab', 'nav-list');
    @endphp
    <section class="listing">
        <div class="container">
            <div class="listing-top">
                <h3>@lang('Your listing')</h3>
                <div class="listing-top-box">
                    <div class="listing-top-btn-area">
                        <div class="header-right-form search-box top-search-box">
                            <form action="{{ route('user.property.list') }}" method="get">
                                <input type="hidden" name="tab" value="{{ request('tab', 'nav-list') }}">
                                <div class="hrader-search-input select-option top-select-option">
                                    <input type="text" name="search" value="{{ request('search') }}" class="soValue optionSearch top-optionSearch" placeholder="Search here">
                                    <button type="submit" class="header-search-btn"><i class="fa-light fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>

                        <div class="shop-view-btn">
                            <nav class="new-arrival-nav">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link {{ $activeTab == 'nav-list' ? 'active' : '' }}" id="nav-list-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab"
                                            aria-controls="nav-list" aria-selected="{{ $activeTab == 'nav-list' ? 'true' : 'false' }}">
                                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="3" cy="6" r="2.5" stroke="#181818"></circle><rect x="7.5" y="3.5" width="12" height="5" rx="2.5" stroke="#181818"></rect><circle cx="3" cy="14" r="2.5" stroke="#181818"></circle><rect x="7.5" y="11.5" width="12" height="5" rx="2.5" stroke="#181818"></rect></svg>
                                    </button>

                                    <button class="nav-link {{ $activeTab == 'nav-two' ? 'active' : '' }}" id="nav-two-tab"
                                            data-bs-toggle="tab" data-bs-target="#nav-two" type="button" role="tab"
                                            aria-controls="nav-two" aria-selected="{{ $activeTab == 'nav-two' ? 'true' : 'false' }}">
                                        <svg class="icon" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="6" cy="6" r="2.5" stroke="#181818"></circle><circle cx="14" cy="6" r="2.5" stroke="#181818"></circle><circle cx="6" cy="14" r="2.5" stroke="#181818"></circle><circle cx="14" cy="14" r="2.5" stroke="#181818"></circle></svg>
                                    </button>
                                </div>
                            </nav>

                            <a href="{{ route('user.listing.introduction') }}" class="listing-plus-btn"><i class="fa-light fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="listing-container">
                <div class="shop-view-content">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade {{ $activeTab == 'nav-list' ? 'show active' : '' }}" id="nav-list">
                            <div class="list-view-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                        <tr>
                                            <th scope="col">@lang('Listing')</th>
                                            <th scope="col">@lang('Location')</th>
                                            <th scope="col">@lang('Status')</th>
                                            <th scope="col">@lang('Action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($properties as $item)
                                                <tr>
                                                    <td data-label="Listing">
                                                        <div class="listing-image-container">
                                                            <div class="listing-image">
                                                                @if($item->photos && isset($item->photos->images['thumb']))
                                                                    <img src="{{ getFile($item->photos->images['thumb']['driver'], $item->photos->images['thumb']['path']) }}" alt="{{ $item->title ?? '' }}">
                                                                @else
                                                                    <img src="{{ asset(template(true).'img/no_image.png') }}" alt="@lang('No image available')">
                                                                @endif
                                                            </div>
                                                            <h6>{!! Str::limit($item->title, 50) !!}</h6>
                                                        </div>
                                                    </td>
                                                    <td data-label="Location" title="{{ $item->address }}"><span>{{ Str::limit($item->address, 30, '...') }}</span></td>
                                                    <td data-label="Status">
                                                        @if($item->status == 0)
                                                            <span class="badge bg-secondary-subtle text-secondary">@lang('In progress')</span>
                                                        @elseif($item->status == 1)
                                                            <span class="badge bg-success-subtle text-success">@lang('Active')</span>
                                                        @elseif($item->status == 2)
                                                            <span class="badge bg-info-subtle text-info">@lang('Resubmission')</span>
                                                        @elseif($item->status == 3)
                                                            <span class="badge bg-warning-subtle text-warning">@lang('Hold')</span>
                                                        @elseif($item->status == 4)
                                                            <span class="badge bg-danger-subtle text-danger">@lang('Soft Rejected')</span>
                                                        @elseif($item->status == 5)
                                                            <span class="badge bg-dark-subtle text-dark">@lang('Hard Rejected')</span>
                                                        @elseif($item->status == 6)
                                                            <span class="badge bg-warning-subtle text-warning">@lang('Pending')</span>
                                                        @endif
                                                    </td>
                                                    <td data-label="Edit">
                                                        <div class="dropdown">
                                                            <button class="action-btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fa-regular fa-ellipsis-stroke-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                @if($item->status != 0)
                                                                    <li><a class="dropdown-item" href="{{ route('user.listing.about.your.place', ['property_id' => $item->id]) }}">@lang('Edit listing')</a></li>
                                                                    <li><a class="dropdown-item" href="{{ route('user.seo.index', ['slug' => $item->slug, 'type' => 'property']) }}">@lang('Seo')</a></li>
                                                                @endif
                                                                @if($item->status == 0)
                                                                    <li><a class="dropdown-item" href="{{ route('user.listing.about.your.place', ['property_id' => $item->id]) }}">@lang('Complete listing')</a></li>
                                                                @endif

                                                                <li>
                                                                    <a class="dropdown-item delete-btn" href="#"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#deletePropertyModal"
                                                                       data-route="{{ route('user.property.delete', $item->id) }}"
                                                                    >
                                                                        @lang('Remove listing')
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="text-center py-5">
                                                            <img class="no-data-image" src="{{ asset(template(true).'img/resource/error.gif') }}" alt="No listings" style="max-width: 200px;">
                                                            <p class="mt-3 text-muted">@lang('No listings found.')</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $properties->appends(request()->query())->links(template().'partials.pagination') }}
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade {{ $activeTab == 'nav-two' ? 'show active' : '' }}" id="nav-two">
                            <div class="row">
                                @forelse($properties as $item)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="categories-single">
                                            <div class="categories-single-image-container">
                                                <div class="most-favorite">
                                                    <a href="#">
                                                        @if($item->status == 0)
                                                            <span class="text-secondary">@lang('In progress')</span>
                                                        @elseif($item->status == 1)
                                                            <span class="text-success">@lang('Active')</span>
                                                        @elseif($item->status == 2)
                                                            <span class="text-info">@lang('Resubmission')</span>
                                                        @elseif($item->status == 3)
                                                            <span class="text-warning">@lang('Hold')</span>
                                                        @elseif($item->status == 4)
                                                            <span class="text-danger">@lang('Soft Rejected')</span>
                                                        @elseif($item->status == 5)
                                                            <span class="text-dark">@lang('Hard Rejected')</span>
                                                        @elseif($item->status == 6)
                                                            <span class="text-primary">@lang('Pending')</span>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="categories-single-image">
                                                    <a href="#"
                                                       data-bs-target="#infoModal"
                                                       data-bs-toggle="modal"
                                                       data-title="{{ $item->title }}"
                                                       data-status="{{ $item->status }}"
                                                       data-location="{{ $item->city.', '. $item->state.', '. $item->country }}"
                                                       data-edit_route="{{ route('user.listing.about.your.place', ['property_id' => $item->id]) }}"
                                                       data-delete_route="{{ route('user.property.delete', $item->id) }}"
                                                       data-image="{{ $item->photos && isset($item->photos->images['thumb']) ? getFile($item->photos->images['thumb']['driver'], $item->photos->images['thumb']['path']) : asset(template(true).'img/no_image.png') }}"
                                                    >
                                                        @if($item->photos && isset($item->photos->images['thumb']))
                                                            <img src="{{ getFile($item->photos->images['thumb']['driver'], $item->photos->images['thumb']['path']) }}" alt="{{ $item->title ?? '' }}">
                                                        @else
                                                            <img src="{{ asset(template(true).'img/no_image.png') }}" alt="@lang('No image available')">
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="categories-single-content">

                                                <div class="categories-single-btn mt-2">
                                                    <div class="categories-single-btn-text">
                                                        <h5>{{ $item->title ?? '' }}</h5>
                                                        <p>{{ $item->city.', '. $item->state.', '. $item->country }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center py-5">
                                                <img class="no-data-image" src="{{ asset(template(true).'img/resource/error.gif') }}" alt="No listings" style="max-width: 200px;">
                                                <p class="mt-3 text-muted">@lang('No listings found.')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </div>
                            {{ $properties->appends(request()->query())->links(template().'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content info-modal-content text-center position-relative px-4 pt-4 pb-3">

                <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>

                <div class="d-flex justify-content-center">
                    <img id="modalListingImage"
                         src=""
                         alt="Listing Image"
                         class="rounded border mb-3"
                         style="width: 80px; height: 80px; object-fit: cover; border: 3px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                </div>

                <h6 id="modalListingTitle" class="fw-semibold mb-1 text-break"></h6>

                <p id="modalListingLocation" class="text-muted small mb-3 text-break"></p>

                <a id="modalEditLink" href="#" class="btn btn-dark w-100 fw-semibold mb-2">
                    @lang('Edit listing')
                </a>

                <a href="#"
                   id="modalDeleteTrigger"
                   class="btn btn-link text-danger p-0 fw-semibold small"
                   data-bs-toggle="modal"
                   data-bs-target="#deletePropertyModal"
                   data-route=""
                >
                    <i class="fas fa-trash-alt me-1"></i> @lang('Remove listing')
                </a>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deletePropertyModal" tabindex="-1" aria-labelledby="deletePropertyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="deletePropertyForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePropertyModalLabel">@lang('Delete Property')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to delete this property?')</p>
                    </div>
                    <div class="modal-footer bx-shadow-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .info-modal-content {
            border-radius: 16px;
            background: #fff;
            max-width: 360px;
            margin: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-close-custom {
            position: absolute;
            top: 12px;
            right: 12px;
            background: transparent;
            border: none;
            color: #333;
            font-size: 1rem;
            z-index: 10;
        }

        .btn-close-custom i {
            pointer-events: none;
        }

        .btn-close-custom:hover {
            color: #000;
        }

        .modal-content .btn-dark {
            font-size: 0.9rem;
            padding: 0.5rem;
            border-radius: 6px;
        }

        .modal-content .btn-link {
            font-size: 0.85rem;
            text-decoration: none;
        }

        .modal-content .btn-link:hover {
            text-decoration: underline;
        }
        .shop-view-btn {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        @media only screen and (max-width: 767px){
            .listing-top-box {
                width: 100%;
            }
        }

    </style>
@endpush

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const targetTab = this.getAttribute('data-bs-target').replace('#', '');
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', targetTab);
                    window.location.href = url.toString();
                });
            });

            const activeTab = new URL(window.location).searchParams.get('tab');
            if (activeTab) {
                document.querySelectorAll('.pagination a').forEach(link => {
                    const url = new URL(link.href);
                    url.searchParams.set('tab', activeTab);
                    link.href = url.toString();
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('deletePropertyModal');
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const route = button.getAttribute('data-route');
                const form = document.getElementById('deletePropertyForm');
                form.setAttribute('action', route);
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const infoModal = document.getElementById('infoModal');

            infoModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;

                const title = trigger.getAttribute('data-title');
                const location = trigger.getAttribute('data-location');
                const imageSrc = trigger.getAttribute('data-image');
                const editRoute = trigger.getAttribute('data-edit_route');
                const deleteRoute = trigger.getAttribute('data-delete_route');
                const status = trigger.getAttribute('data-status');



                document.getElementById('modalListingTitle').textContent = title;
                document.getElementById('modalListingLocation').textContent = location;
                document.getElementById('modalListingImage').setAttribute('src', imageSrc);
                document.getElementById('modalEditLink').setAttribute('href', editRoute);

                document.getElementById('modalDeleteTrigger').setAttribute('data-route', deleteRoute);
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('deletePropertyModal');

            deleteModal.addEventListener('show.bs.modal', function (event) {
                const trigger = event.relatedTarget;
                const route = trigger.getAttribute('data-route');
                document.getElementById('deletePropertyForm').setAttribute('action', route);
            });
        });
    </script>
@endpush

