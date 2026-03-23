<?php

it('returns a successful response', function () {
    $response = $this->get('/vue');

    $response->assertStatus(200);
});
