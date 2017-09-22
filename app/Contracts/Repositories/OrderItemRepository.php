<?php

namespace App\Contracts\Repositories;

interface OrderItemRepository extends AbstractRepository
{
    public function create($data);

    public function find($id, $with = [], $select = ['*']);

    public function findItemWithStylistIdServiceId($stylistId, $serviceId, $order_booking_id, $with = [], $select = ['*']);

    public function getItemsByBookingId($order_booking_id, $with = [], $select = ['*']);

    public function getGrandTotal($order_booking_id);
}
