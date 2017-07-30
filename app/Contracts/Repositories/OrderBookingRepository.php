<?php

namespace App\Contracts\Repositories;

interface OrderBookingRepository extends AbstractRepository
{
    public function getBookingByBookingId($bookingId, $with = []);

    public function create($data = []);

    public function checkLastBookingByPhone($with = [], $select = ['*'], $value);

    public function find($id, $with = [], $select = ['*']);

    public function getAllBooking($perPage, $with = [], $select = ['*']);

    public function filterBookingbyDate($startDate, $endDate, $perPage, $with = [], $select = ['*']);
    public function filterBookingByMonth($month, $year, $perPage, $with = [], $select = ['*']);

    public function filterBookingByStatus($status, $perPage, $with = [], $select = ['*']);

    public function getFilterChoice();
}
