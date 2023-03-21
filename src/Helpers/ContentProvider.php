<?php

namespace SYSOTEL\OTA\Common\Helpers;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\Booking;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingCancellationDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Booking\BookingRefund;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Channel;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccountBranch;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Employee\Employee;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Inquiry\Inquiry;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyContact\PropertyContact;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PartialPayment;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyProduct\PropertyProduct;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\SpaceView;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\Admin\Admin;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class ContentProvider
{
    public static function internalChannels(): array
    {
        return self::idTextArray([
            Channel::ID_INTERNAL_B2C => 'B2C',
            Channel::ID_INTERNAL_B2B => 'B2B',
            Channel::ID_INTERNAL_CORPORATE => 'CORPORATE',
        ]);
    }

    public static function suppliers(): array
    {
        return self::idTextArray([
            Supplier::ID_SELF => 'Self',
            Supplier::ID_TRAVELGURU => 'Yatra',
        ]);
    }

    public static function adminRoles(): array
    {
        return self::idTextArray([
            Admin::ADMIN_ROLE_ADMIN => 'ADMIN',
            Admin::ADMIN_ROLE_SUPER_ADMIN => 'SUPER_ADMIN',
        ]);
    }

    public static function employeeTypes(): array
    {
        return self::idTextArray([
            Employee::TYPE_SALES => 'SALES',
            Employee::TYPE_SUPPORT => 'SUPPORT',
            Employee::TYPE_BD => 'BD',
            Employee::TYPE_MANAGEMENT => 'MANAGEMENT',
            Employee::TYPE_OTHER => 'OTHER',
        ]);
    }

    public static function inquiryTypes(): array
    {
        return self::idTextArray([
            Inquiry::TYPE_GENERAL => 'General',
            Inquiry::TYPE_B2B => 'B2B',
        ]);
    }

    public static function cancellationStatuses(): array
    {
        return self::idTextArray([
            BookingCancellationDetails::STATUS_INITIATED => 'Initiated',
            BookingCancellationDetails::STATUS_PROCESSING => 'Processing',
            BookingCancellationDetails::STATUS_PROCESSED => 'Processed',
        ]);
    }

    public static function inquirySources(): array
    {
        return self::idTextArray([
            Inquiry::SOURCE_CONTACT_US => 'Contact Us Page',
        ]);
    }

    public static function bookingSources(): array
    {
        return self::idTextArray([
            Booking::SOURCE_B2C_PORTAL => 'B2C Portal',
            Booking::SOURCE_AGENT_PORTAL => 'Agent Portal',
            Booking::SOURCE_CORPORATE_PORTAL => 'Corporate Portal',
        ]);
    }

    public static function inquiryStatuses(): array
    {
        return self::idTextArray([
            Inquiry::STATUS_OPEN => 'Open',
            Inquiry::STATUS_CLOSED => 'Close',
        ]);
    }

    public static function verificationStatuses(bool $includePending = true): array
    {
        $data = [
            Verification::STATUS_APPROVED => 'Approved',
            Verification::STATUS_REJECTED => 'Rejected',
        ];

        if($includePending) {
            $data[Verification::STATUS_PENDING] = 'Verification Pending';
        }

        return self::idTextArray($data);
    }

    public static function propertyTypes(): array
    {
        return self::idTextArray([
            Property::TYPE_HOTEL => 'Hotel',
            Property::TYPE_RESORT => 'Resort',
            Property::TYPE_HOMESTAY => 'Homestay',
            Property::TYPE_VILLA => 'Villa',
            Property::TYPE_APARTMENT => 'Apartment',
            Property::TYPE_GUEST_HOUSE => 'Guest House',
            Property::TYPE_HOUSEBOAT => 'Houseboat',
            Property::TYPE_FARM_HOUSE => 'Farm House',
            Property::TYPE_PALACE => 'Palace',
            Property::TYPE_MOTEL => 'Motel',
            Property::TYPE_DHARAMSHALA => 'Dharamshala',
            Property::TYPE_LODGE => 'Lodge',
            Property::TYPE_COTTAGE => 'Cottage',
            Property::TYPE_CAMP => 'Camp',
        ]);
    }

    public static function propertyStatuses(): array
    {
        return self::idTextArray([
            Property::STATUS_VERIFICATION_PENDING => 'Verification Pending',
            Property::STATUS_ACTIVE => 'Live',
            Property::STATUS_DISABLED => 'Disabled',
            Property::STATUS_BLOCKED => 'Blocked',
        ]);
    }

    public static function userStatuses(): array
    {
        return self::idTextArray([
            User::STATUS_ACTIVE => 'ACTIVE',
            User::STATUS_BLOCKED => 'BLOCKED',
        ]);
    }

    public static function spaceViews(): array
    {
        return self::idTextArray([
            SpaceView::OCEAN_VIEW => 'Ocean View',
            SpaceView::MOUNTAIN_VIEW => 'Mountain View',
            SpaceView::CITY_VIEW => 'City View',
            SpaceView::GARDEN_VIEW => 'Garden View',
            SpaceView::LAKE_VIEW => 'Lake View',
            SpaceView::POOL_VIEW => 'Pool View',
            SpaceView::RIVER_VIEW => 'River View',
            SpaceView::VALLEY_VIEW => 'Valley View',
            SpaceView::PALACE_VIEW => 'Palace View',
            SpaceView::JUNGLE_VIEW => 'Jungle View',
        ]);
    }

    public static function mealPlanCodes(): array
    {
        return [
            PropertyProduct::MEAL_PLAN_CODE_EP,
            PropertyProduct::MEAL_PLAN_CODE_CP,
            PropertyProduct::MEAL_PLAN_CODE_MAP,
            PropertyProduct::MEAL_PLAN_CODE_AP,
        ];
    }

    public static function productPaymentModes(): array
    {
        return self::idTextArray([
            PropertyProduct::PAYMENT_MODE_PAY_NOW => 'Pay Now',
//            PropertyProduct::PAYMENT_MODE_PAY_AT_PROPERTY => 'Pay @ Property',
            PropertyProduct::PAYMENT_MODE_PAY_PARTIAL => 'Pay Partial',
        ]);
    }

    public static function productPartialPaymentValueTypes(): array
    {
        return self::idTextArray([
//            PartialPayment::VALUE_TYPE_FLAT => 'Fixed Value',
            PartialPayment::VALUE_TYPE_PERC => 'Percentage',
        ]);
    }

    public static function propertyContactTypes(): array
    {
        return self::autoIdTextArray([
            PropertyContact::TYPE_GENERAL_INQUIRY,
            PropertyContact::TYPE_RESERVATION,
            PropertyContact::TYPE_ACCOUNTS,
            PropertyContact::TYPE_INVENTORY,
        ]);
    }

    public static function propertyContactNotificationTypes(): array
    {
        return self::autoIdTextArray([
            PropertyContact::NOTIFICATION_BOOKING,
            PropertyContact::NOTIFICATION_INQUIRY,
        ]);
    }

    public static function earlyCheckInOptions(): array
    {
        return self::autoIdTextArray([
            CheckInPolicy::EARLY_CHECK_IN_ALLOWED,
            CheckInPolicy::EARLY_CHECK_IN_AS_PER_AVAILABILITY,
            CheckInPolicy::EARLY_CHECK_IN_NOT_ALLOWED,
        ]);
    }

    public static function lateCheckOutOptions(): array
    {
        return self::autoIdTextArray([
            CheckOutPolicy::LATE_CHECK_OUT_ALLOWED,
            CheckOutPolicy::LATE_CHECK_OUT_AS_PER_AVAILABILITY,
            CheckOutPolicy::LATE_CHECK_OUT_NOT_ALLOWED,
        ]);
    }

    public static function refundStatuses(): array
    {
        return self::autoIdTextArray([
            BookingRefund::STATUS_INITIATED,
            BookingRefund::STATUS_FAILED,
            BookingRefund::STATUS_CONFIRMED,
        ]);
    }

    public static function refundReasons(): array
    {
        return self::autoIdTextArray([
            BookingRefund::REASON_ADJUSTMENT,
            BookingRefund::REASON_CANCELLATION,
        ]);
    }

    public static function refundMethods(): array
    {
        return self::autoIdTextArray([
            BookingRefund::METHOD_CASHFREE_PG,
            BookingRefund::METHOD_CASH,
            BookingRefund::METHOD_BANK_TRANSFER,
            BookingRefund::METHOD_UNKNOWN,
        ]);
    }

    public static function agentAccountStatuses(): array
    {
        return self::autoIdTextArray([
            AgentAccount::STATUS_VERIFICATION_PENDING,
            AgentAccount::STATUS_ACTIVE,
            AgentAccount::STATUS_INACTIVE,
        ]);
    }

    public static function corporateAccountStatuses(): array
    {
        return self::autoIdTextArray([
            CorporateAccount::STATUS_VERIFICATION_PENDING,
            CorporateAccount::STATUS_ACTIVE,
            CorporateAccount::STATUS_INACTIVE,
        ]);
    }

    public static function corporateBranchStatuses(): array
    {
        return self::autoIdTextArray([
            CorporateAccountBranch::STATUS_VERIFICATION_PENDING,
            CorporateAccountBranch::STATUS_ACTIVE,
            CorporateAccountBranch::STATUS_INACTIVE,
        ]);
    }

    /**
     * @param array $items
     * @param string $idFieldName
     * @param string $textFieldName
     * @return array
     */
    protected static function idTextArray(array $items = [], string $idFieldName = 'id', string $textFieldName = 'text'): array
    {
        $data = [];
        foreach ($items as $id => $text) {
            $data[] = [
                $idFieldName => $id,
                $textFieldName => $text
            ];
        }
        return $data;
    }

    /**
     * @param string[] $items
     * @param string $idFieldName
     * @param string $textFieldName
     * @return array
     */
    protected static function autoIdTextArray(array $items = [], string $idFieldName = 'id', string $textFieldName = 'text'): array
    {
        $data = [];
        foreach ($items as $id) {
            $data[] = [
                $idFieldName => $id,
                $textFieldName => constantToCamelCase($id)
            ];
        }
        return $data;
    }
}
