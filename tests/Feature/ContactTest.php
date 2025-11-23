<?php

it('can validate ABGCODE', function () {
    $contact = new \mmerlijn\msgRepo\Contact(
        agbcode: '12345601',
        name: new \mmerlijn\msgRepo\Name(
            initials: 'P.',
            firstname: 'Piet',
            lastname: 'Jansen'
        )
    );
    expect($contact->hasValidAgbcode())->toBeTrue();
    $contact = new \mmerlijn\msgRepo\Contact(
        agbcode: '123456',
        name: new \mmerlijn\msgRepo\Name(
            initials: 'P.',
            firstname: 'Piet',
            lastname: 'Jansen'
        )
    );
    expect($contact->hasValidAgbcode())->toBeFalse();
    $contact = new \mmerlijn\msgRepo\Contact(
        agbcode: '',
        name: new \mmerlijn\msgRepo\Name(
            initials: 'P.',
            firstname: 'Piet',
            lastname: 'Jansen'
        )
    );
    expect($contact->hasValidAgbcode())->toBeFalse();
});
