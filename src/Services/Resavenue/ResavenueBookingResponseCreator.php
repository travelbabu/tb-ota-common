<?php

namespace SYSOTEL\OTA\Common\Services\Resavenue;


use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\PaymentDetails\BookingPaymentDetails;
use SYSOTEL\OTA\Common\Helpers\Enums;

class ResavenueBookingResponseCreator
{
    protected function __construct(protected Booking $booking)
    {
    }

    public static function prepare(Booking $booking): static
    {
        return new self($booking);
    }

    public function create(): array
    {
        $booking = $this->booking;

        $data = [
            'UniqueID' => $this->getUniqueId(),
            'ResStatus' => $this->getBookingStatusCode(),
            'CreatedDateTime' => $booking->createdAt->format('y-m-d h:i:s'),
            'PayAtHotel' => $booking->paymentDetails?->paymentMode === BookingPaymentDetails::PAYMENT_MODE_PAY_NOW ? 'N' : 'Y',
            'ResGlobalInfo' => $this->getGlobalInfo(),
            'RoomStays' => [
                'RoomStay' => []
            ],
            'ResGuests' => [],
        ];

        foreach ($this->booking->guestCalculations->spaceWiseBreakup as $spaceBreakupItem) {

            $bookingSpace = $this->booking->spaceDetails->getSpaceForSpaceNo($spaceBreakupItem->spaceNo);

            $roomStayData = [
                'TimeSpan' => [
                    'Start' => $this->booking->stayDates->checkInDate->format('y-m-d\Th:i:s'),
                    'End' => $this->booking->stayDates->checkOutDate->format('y-m-d\Th:i:s'),
                ],
                'BasicPropertyInfo' => [
                    'HotelCode' => $this->booking->property->id,
                    'HotelName' => $this->booking->property->displayName
                ],
                'GuestCounts' => [
                    'GuestCount' => [
                        [
                            'Count' => $bookingSpace->guestCount->adultCount,
                            'AgeQualifyingCode' => Enums::RESAVENUE_AGE_CODE_ADULT
                        ],
                        [
                            'Count' => $bookingSpace->guestCount->childCount,
                            'AgeQualifyingCode' => Enums::RESAVENUE_AGE_CODE_CHILD
                        ],

                    ],

                ],
                'RoomTypes' => [
                    'RoomType' => [
                        'NumberOfUnits' => 1,
                        'RoomDescription' => [
                            'Name' => $bookingSpace->spaceName,
                        ],
                        'RoomTypeCode' => $bookingSpace->spaceID
                    ]
                ],
                'RatePlans' => [
                    'RatePlan' => [
                        'RatePlanName' => $bookingSpace->productName,
                        'RatePlanCode' => $bookingSpace->productID,
                    ]
                ],
                'Total' => [
                    'CurrencyCode' => $this->booking->baseCurrency,
                    'Amount' => $this->booking->guestCalculations?->payableAmount
                ],

                'RoomRates' => [],

                'ResGuestRPHs' => []
            ];

            foreach ($bookingSpace->guestIDs as $guestNo) {

                if ($guestProfile = $this->booking?->guestDetails?->getGuestByNo($guestNo)) {
                    if ($guestProfile->firstName && $guestProfile->lastName) {
                        $ResGuestRPH = [
                            'RPH' => $guestNo ?? null
                        ];

                        $roomStayData['ResGuestRPHs']['ResGuestRPH'] = $ResGuestRPH;
                    }
                }

            }

            foreach ($spaceBreakupItem->timelyBreakup as $timelyBreakupItem) {
                $roomStay = [
                    'Amount' => $timelyBreakupItem->spaceCharges->amountAfterDiscount,
                    'EffectiveDate' => $timelyBreakupItem->startTime->format('Y-m-d')
                ];

                $roomStayData['RoomRates']['RoomRate']['Rates'][] = $roomStay;
            }

            $data['RoomStays']['RoomStay'][] = $roomStayData;

            foreach ($bookingSpace->guestIDs as $guestNo) {

                if ($guestProfile = $this->booking->guestDetails->getGuestByNo($guestNo)) {
                    if ($guestProfile->firstName && $guestProfile->lastName) {
                        $resGuest = [
                            'Profiles' => [
                                'ProfileInfo' => [
                                    'UniqueId' => [
                                        'Type' => $guestProfile->guestNo,
                                        'ID_Context' => ''
                                    ],
                                    'Profile' => [
                                        'ProfileType' => $guestProfile->guestNo,
                                        'Customer' => [
                                            'PersonName' => [
                                                'GivenName' => $guestProfile->firstName,
                                                'Surname' => $guestProfile->lastName
                                            ],
                                            'Email' => $this->booking->contactDetails?->email?->id,
                                            'PhoneNumber' => $this->booking->contactDetails?->mobile?->value
                                        ]
                                    ]
                                ]
                            ],
                            'ResGuestRPH' => $guestProfile->guestNo
                        ];

                        $data['ResGuests'] = [
                            'ResGuest' => [$resGuest]
                        ];
                    }
                }
            }
        }

        return ['HotelReservation' => $data];
    }

    /**
     * @return array[]
     */
    protected function getUniqueId(): array
    {
        return [

            'ID' => $this->booking->id,
            'OTA' => 'TRAVELBABU',
            'BookingSource' => $this->booking->source,
        ];
    }

    /**
     * @return array
     */
    protected function getGlobalInfo(): array
    {
        return [
            'SpecialRequest' => $this->booking->specialInstructions?->description ?? '',
            'Total' => [
                'CurrencyCode' => $this->booking->baseCurrency,
                'TotalTax' => $this->booking?->guestCalculations?->spaceCharges?->tax?->amount,
                'TaxType' => 'Inclusive',
                'TotalBookingAmount' => $this->booking?->guestCalculations?->payableAmount,
                'Commission' => $this->booking?->propertyCalculations?->spaceCharges?->otaCommission?->amount,
                'CommissionType' => 'Exclusive',
            ]
        ];
    }

    public function getBookingStatusCode(): string
    {
        return match ($this->booking->status) {
            Enums::BOOKING_STATUS_CONFIRMED => 'confirm',
            Enums::BOOKING_STATUS_MODIFIED => 'modify',
            Enums::BOOKING_STATUS_CANCELLED => 'cancel',
            default => '',
        };
    }
}
