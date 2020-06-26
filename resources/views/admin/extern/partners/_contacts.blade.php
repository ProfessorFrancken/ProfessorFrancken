
<div class="card mt-4">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-users"></i>
            Partner contacts
        </h4>
        <ul class='list-unstyled'>
            @forelse ($partner->contacts as $contact)
                <li class="d-flex flex-column my-3 {{ $loop->last ? '' : 'border-bottom  py-3' }}">
                    <div class="d-flex justify-content-start">
                        <div class="mr-3">
                            <img
                                id="contact-photo"
                                alt="Photo of {{ $contact->fullname }}"
                                src="{{ optional($contact)->photo }}"
                                class="mb-3 img-fluid rounded"
                                style="max-height: 40px; object-fit: cover"
                            />
                        </div>
                        <div>
                            <h6>
                                {{ $contact->fullname }}
                            </h6>
                            <ul class="list-unstyled">
                                <li>
                                    <i class="fas fa-user fa-fw text-muted"></i>
                                    {{ $contact->position }}
                                </li>
                                @if ($contact->contactDetails->has_email)
                                    <li>
                                        <i class="fas fa-envelope-open-text fa-fw text-muted"></i>
                                        {{ $contact->contactDetails->email }}
                                    </li>
                                @endif
                                @if ($contact->contactDetails->phone_number)
                                    <li>
                                        <i class="fas fa-mobile fa-fw text-muted"></i>
                                        {{ $contact->contactDetails->phone_number }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="ml-auto">
                            <a
                                href="{{ action(
                                         [\Francken\Extern\Http\AdminPartnerContactsController::class, 'edit'],
                                         ['partner' => $partner, 'contact' => $contact]
                                         ) }}"
                                class="btn btn-text btn-sm"
                            >
                                <i class="fas fa-edit"></i>
                                Edit contact
                            </a>
                        </div>
                    </p>
                </li>
            @empty
                <li class="d-flex flex-column my-3">
                    Add contacts so that you and your future kandi know who to contact for sponsor deals etc.
                </li>
            @endforelse
        </ul>
    </div>

    <div class="card-footer">
        <a
            href="{{ action([\Francken\Extern\Http\AdminPartnerContactsController::class, 'create'], ['partner' => $partner]) }}"
            class="btn btn-text btn-sm"
        >
            <i class="fas fa-plus"></i>
            Add contact
        </a>
    </div>
</div>
