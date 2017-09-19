<?php

namespace App\Contracts\Repositories;

interface OrderBookingRepository extends AbstractRepository
{
    public function getBookingByBookingId($bookingId, $with = []);

    public function create($data = []);

    public function checkLastBookingByPhone($with = [], $select = ['*'], $value);

    public function find($id, $with = [], $select = ['*']);

    public function getAllBooking($perPage, $with = [], $select = ['*']);

    public function filterBookingbyDate($startDate, $endDate, $status, $with = [], $select = ['*']);

    public function filterBookingByMonth($month, $year, $perPage, $status, $with = [], $select = ['*']);

    public function filterBookingByStatus($status, $perPage, $with = [], $select = ['*']);

    public function getFilterChoice();

    public function getBookingByCustomerId($customer_id, $with = [], $select = ['*']);

    public function getBookingByStatus($customer_id, $with = [], $select = ['*']);

}
