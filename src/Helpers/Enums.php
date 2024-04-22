<?php

namespace SYSOTEL\OTA\Common\Helpers;

class Enums
{
    const PROPERTY_DOCUMENT_AADHAAR = 'AADHAAR';
    const PROPERTY_DOCUMENT_BANK_DETAILS = 'BANK_DETAILS';
    const PROPERTY_DOCUMENT_PAN = 'PAN';
    const PROPERTY_DOCUMENT_GST = 'GST';
    const PROPERTY_DOCUMENT_NO_GST_DECLARATION = 'NO_GST_DECLARATION';
    const PROPERTY_DOCUMENT_NO_OBJECTION_CERTIFICATE = 'NO_OBJECTION_CERTIFICATE';
    const PROPERTY_DOCUMENT_TRADE_LICENCE = 'TRADE_LICENCE';
    const PROPERTY_DOCUMENT_LEASE_CONTRACT = 'LEASE_CONTRACT';
    const PROPERTY_DOCUMENT_PROPERTY_OWNERSHIP_CERTIFICATE = 'PROPERTY_OWNERSHIP_CERTIFICATE';
    const PROPERTY_DOCUMENT_MSME_CERTIFICATE = 'MSME_CERTIFICATE';

    const PROMOTION_TYPE_BASIC = 'BASIC';
    const PROMOTION_TYPE_LAST_MINUTE = 'LAST_MINUTE';
    const PROMOTION_TYPE_EARLY_BIRD = 'EARLY_BIRD';

    const BOOKING_SOURCE_TRAVELBABU = 'TRAVELBABU';
    const BOOKING_SOURCE_MAKEMYTRIP = 'MAKEMYTRIP';
    const BOOKING_SOURCE_GOIBIBO = 'GOIBIBO';
    const BOOKING_SOURCE_AGODA = 'AGODA';
    const BOOKING_SOURCE_BOOKING_DOT_COM = 'BOOKING_DOT_COM';
    const BOOKING_SOURCE_EXPEDIA = 'EXPEDIA';
    const BOOKING_SOURCE_YATRA = 'YATRA';
    const BOOKING_SOURCE_EASE_MY_TRIP = 'EASE_MY_TRIP';
    const BOOKING_SOURCE_TRIP_DOT_COM = 'TRIP_DOT_COM';
    const BOOKING_SOURCE_AIRBNB = 'AIRBNB';
    const BOOKING_SOURCE_HOTEL_BEDS = 'HOTEL_BEDS';
    const BOOKING_SOURCE_GOROOMGO = 'GOROOMGO';
    const BOOKING_SOURCE_EASYGOROOMS = 'EASYGOROOMS';
    const BOOKING_SOURCE_CLEARTRIP = 'CLEARTRIP';

    const MARKET_SEGMENT_B2C = 'B2C';
    const MARKET_SEGMENT_B2B = 'B2B';
    const MARKET_SEGMENT_CORPORATE = 'CORPORATE';
    const MARKET_SEGMENT_OTHER = 'OTHER';

    const BASE_CURRENCY_INR = 'INR';

    const AGE_CODE_ADULT = 'A';
    const AGE_CODE_CHILD = 'C';

    const BOOKING_STATUS_ATTEMPT = 'ATTEMPT';
    const BOOKING_STATUS_EXPIRED = 'EXPIRED';
    const BOOKING_STATUS_FAILED = 'FAILED';
    const BOOKING_STATUS_CONFIRMED = 'CONFIRMED';
    const BOOKING_STATUS_CANCELLED = 'CANCELLED';
    const BOOKING_STATUS_MODIFIED = 'MODIFIED';

    const PAYMENT_SERVICE_PROVIDER = 'CASHFREE_PG';
    const PAYMENT_SERVICE_CUSTOM = 'CUSTOM';

    const PG_GROUP_CASH = 'CASH';
    const PG_GROUP_PREPAID_CARD = 'PREPAID_CARD';
    const PG_GROUP_CREDIT_CARD = 'CREDIT_CARD';
    const PG_GROUP_CREDIT_CARD_EMI = 'CREDIT_CARD_EMI';
    const PG_GROUP_DEBIT_CARD_EMI = 'DEBIT_CARD_EMI';
    const PG_GROUP_DEBIT_CARD = 'DEBIT_CARD';
    const PG_GROUP_UPI_CREDIT_CARD = 'UPI_CREDIT_CARD';
    const PG_GROUP_PAYPAL = 'PAYPAL';
    const PG_GROUP_NET_BANKING = 'NET_BANKING';
    const PG_GROUP_CARDLESS_EMI = 'CARDLESS_EMI';
    const PG_GROUP_BANK_TRANSFER = 'BANK_TRANSFER';
    const PG_GROUP_PAY_LATER = 'PAY_LATER';
    const PG_GROUP_WALLET = 'WALLET';
    const PG_GROUP_UPI = 'UPI';
    const PG_GROUP_UPI_PPI = 'UPI_PPI';
    const PG_GROUP_UPI_PPI_OFFLINE = 'UPI_PPI_OFFLINE';
    const UNKNOWN = 'UNKNOWN';

    public const BOOKING_PAYMENT_STATUS_PAID = 'PAID';
    public const BOOKING_PAYMENT_STATUS_PENDING = 'PENDING';
    public const BOOKING_PAYMENT_STATUS_CANCELLED = 'CANCELLED';
    public const BOOKING_PAYMENT_STATUS_FAILED = 'FAILED';
    public const BOOKING_PAYMENT_STATUS_INTERNAL_ERROR = 'INTERNAL_ERROR';
    public const BOOKING_PAYMENT_STATUS_NOT_REQUIRED = 'NOT_REQUIRED';

    public const BOOKING_PAYMENT_TRANSACTION_STATUS_PAID = 'PAID';
    public const BOOKING_PAYMENT_TRANSACTION_STATUS_PENDING = 'PENDING';
    public const BOOKING_PAYMENT_TRANSACTION_STATUS_CANCELLED = 'CANCELLED';
    public const BOOKING_PAYMENT_TRANSACTION_STATUS_FAILED = 'FAILED';
    public const BOOKING_PAYMENT_TRANSACTION_STATUS_INTERNAL_ERROR = 'INTERNAL_ERROR';
    public const BOOKING_PAYMENT_TRANSACTION_STATUS_NOT_REQUIRED = 'NOT_REQUIRED';

    /**
     * @return string[]
     */
    public static function bookingSources(): array
    {
        return [
            static::BOOKING_SOURCE_TRAVELBABU,
            static::BOOKING_SOURCE_MAKEMYTRIP,
            static::BOOKING_SOURCE_GOIBIBO,
            static::BOOKING_SOURCE_AGODA,
            static::BOOKING_SOURCE_BOOKING_DOT_COM,
            static::BOOKING_SOURCE_EXPEDIA,
            static::BOOKING_SOURCE_YATRA,
            static::BOOKING_SOURCE_CLEARTRIP,
            static::BOOKING_SOURCE_EASE_MY_TRIP,
            static::BOOKING_SOURCE_TRIP_DOT_COM,
            static::BOOKING_SOURCE_AIRBNB,
            static::BOOKING_SOURCE_HOTEL_BEDS,
            static::BOOKING_SOURCE_GOROOMGO,
            static::BOOKING_SOURCE_EASYGOROOMS,
        ];
    }

    /**
     * @return string[]
     */
    public static function marketSegments(): array
    {
        return [
            static::MARKET_SEGMENT_B2C,
            static::MARKET_SEGMENT_B2B,
            static::MARKET_SEGMENT_CORPORATE,
            static::MARKET_SEGMENT_OTHER,
        ];
    }

    /**
     * @return string[]
     */
    public static function paymentGroups(): array
    {
        return [
            static::PG_GROUP_CASH,
            static::PG_GROUP_PREPAID_CARD,
            static::PG_GROUP_CREDIT_CARD,
            static::PG_GROUP_CREDIT_CARD_EMI,
            static::PG_GROUP_DEBIT_CARD_EMI,
            static::PG_GROUP_DEBIT_CARD,
            static::PG_GROUP_UPI_CREDIT_CARD,
            static::PG_GROUP_PAYPAL,
            static::PG_GROUP_NET_BANKING,
            static::PG_GROUP_CARDLESS_EMI,
            static::PG_GROUP_BANK_TRANSFER,
            static::PG_GROUP_PAY_LATER,
            static::PG_GROUP_WALLET,
            static::PG_GROUP_UPI,
            static::PG_GROUP_UPI_PPI,
            static::PG_GROUP_UPI_PPI_OFFLINE,
            static::UNKNOWN,
        ];
    }

    /**
     * @return string[]
     */
    public static function propertyDocumentTypes(): array
    {
        return [
            static::PROPERTY_DOCUMENT_AADHAAR,
            static::PROPERTY_DOCUMENT_BANK_DETAILS,
            static::PROPERTY_DOCUMENT_PAN,
            static::PROPERTY_DOCUMENT_GST,
            static::PROPERTY_DOCUMENT_NO_GST_DECLARATION,
            static::PROPERTY_DOCUMENT_NO_OBJECTION_CERTIFICATE,
            static::PROPERTY_DOCUMENT_TRADE_LICENCE,
            static::PROPERTY_DOCUMENT_LEASE_CONTRACT,
            static::PROPERTY_DOCUMENT_PROPERTY_OWNERSHIP_CERTIFICATE,
            static::PROPERTY_DOCUMENT_MSME_CERTIFICATE,
        ];
    }

    /**
     * @return string[]
     */
    public function promotionTypes(): array
    {
        return [
            static::PROMOTION_TYPE_BASIC,
            static::PROMOTION_TYPE_LAST_MINUTE,
            static::PROMOTION_TYPE_EARLY_BIRD,
        ];
    }
}