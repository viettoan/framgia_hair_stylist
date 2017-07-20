<?php

namespace App\Contracts\Repositories;

interface OrderBookingRepository extends AbstractRepository
{
    public function getBookingByBookingId($bookingId, $with = []);
}
