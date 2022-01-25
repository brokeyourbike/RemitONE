<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Models;

use BrokeYourBike\RemitOne\Interfaces\DecodedTransactionInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Transaction implements DecodedTransactionInterface
{
    public function __construct(
        private string $trans_ref,
        private string $trans_type,
        private string $status,

        private string $benef_id,
        private ?string $benef_firstname,
        private ?string $benef_middlename,
        private ?string $benef_lastname,
        private ?string $benef_mobile,
        private ?string $benef_email,
        private ?string $benef_nationality,
        private ?string $benef_id_type,
        private ?string $benef_id_detail,
        private ?string $benef_ac,
        private ?string $benef_ac_type,
        private ?string $benef_bank_swift_code,
        private ?string $benef_bank_iban,
        private ?string $benef_branch,
        private ?string $benef_branch_code,
        private ?string $benef_address1,
        private ?string $benef_address2,
        private ?string $benef_address3,
        private ?string $benef_city,
        private ?string $benef_postcode,
        private ?string $benef_mobiletransfer_number,
        private ?string $benef_mobiletransfer_network,
        private ?string $benef_mobiletransfer_network_third_party_id,
        private ?string $benef_bank_third_party_id,
        private ?string $benef_bank_third_party_name,
        private ?string $benef_bank_third_party_code,
        private ?string $benef_branch_third_party_id,
        private ?string $benef_branch_third_party_name,
        private ?string $benef_branch_third_party_code,

        private string $remitter_id,
        private ?string $remitter_firstname,
        private ?string $remitter_middlename,
        private ?string $remitter_lastname,
        private ?AddressParts $remitter_address_parts,
        private ?string $remitter_id1_type,
        private ?string $remitter_id1_details,
        private ?string $remitter_id1_expiry,
        private ?string $remitter_nationality,
        private ?string $remitter_dob,
        private ?string $remitter_mobile,
        private ?string $remitter_gender,

        private string $send_country_iso,
        private ?string $send_currency,
        private ?string $send_amount,
        private string $receive_country_iso,
        private string $receive_currency,
        private string $receive_amount,
        private string $receive_amount_after_bank_charges,
    ) {
    }

    public function getReference(): string
    {
        return $this->trans_ref;
    }

    public function getType(): string
    {
        return $this->trans_type;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getRemitterId(): string
    {
        return $this->remitter_id;
    }

    public function getRemitterGender(): ?string
    {
        return $this->remitter_gender;
    }

    public function getRemitterDateOfBirth(): ?string
    {
        return $this->remitter_dob;
    }

    public function getRemitterFirstName(): ?string
    {
        return $this->remitter_firstname;
    }

    public function getRemitterLastName(): ?string
    {
        return $this->remitter_lastname;
    }

    public function getRemitterMiddleName(): ?string
    {
        return $this->remitter_middlename;
    }

    public function getRemitterNationality(): ?string
    {
        return $this->remitter_nationality;
    }

    public function getRemitterAddressParts(): ?AddressParts
    {
        return $this->remitter_address_parts;
    }

    public function getRemitterMobileNumber(): ?string
    {
        return $this->remitter_mobile;
    }

    public function getRemitterIdentificationType(): ?string
    {
        return $this->remitter_id1_type;
    }

    public function getRemitterIdentificationDetails(): ?string
    {
        return $this->remitter_id1_details;
    }

    public function getRemitterIdentificationExpiry(): ?string
    {
        return $this->remitter_id1_expiry;
    }

    public function getBeneficiaryId(): string
    {
        return $this->benef_id;
    }

    public function getBeneficiaryFirstName(): ?string
    {
        return $this->benef_firstname;
    }

    public function getBeneficiaryLastName(): ?string
    {
        return $this->benef_lastname;
    }

    public function getBeneficiaryMiddleName(): ?string
    {
        return $this->benef_middlename;
    }

    public function getBeneficiaryIdType(): ?string
    {
        return $this->benef_id_type;
    }

    public function getBeneficiaryIdDetails(): ?string
    {
        return $this->benef_id_detail;
    }

    public function getBeneficiaryPostcode(): ?string
    {
        return $this->benef_postcode;
    }

    public function getBeneficiaryMobileTransferNumber(): ?string
    {
        return $this->benef_mobiletransfer_number;
    }

    public function getBeneficiaryMobileTransferNetwork(): ?string
    {
        return $this->benef_mobiletransfer_network;
    }

    public function getBeneficiaryMobileTransferNetworkThirdPartyId(): ?string
    {
        return $this->benef_mobiletransfer_network_third_party_id;
    }

    public function getBeneficiaryAddress(): string
    {
        return trim("{$this->benef_address1} {$this->benef_address2} {$this->benef_address3}");
    }

    public function getBeneficiaryCity(): ?string
    {
        return $this->benef_city;
    }

    public function getBeneficiaryMobileNumber(): ?string
    {
        return $this->benef_mobile;
    }

    public function getBeneficiaryEmail(): ?string
    {
        return $this->benef_email;
    }

    public function getBeneficiaryNationality(): ?string
    {
        return $this->benef_nationality;
    }

    public function getBeneficiaryBranch(): ?string
    {
        return $this->benef_branch;
    }

    public function getBeneficiaryBranchCode(): ?string
    {
        return $this->benef_branch_code;
    }

    public function getBeneficiaryBankAccountNumber(): ?string
    {
        return $this->benef_ac;
    }

    public function getBeneficiaryBankAccountType(): ?string
    {
        return $this->benef_ac_type;
    }

    public function getBeneficiaryBankSwiftCode(): ?string
    {
        return $this->benef_bank_swift_code;
    }

    public function getBeneficiaryBankIban(): ?string
    {
        return $this->benef_bank_iban;
    }

    public function getBeneficiaryBankThirdPartyId(): ?string
    {
        return $this->benef_bank_third_party_id;
    }

    public function getBeneficiaryBankThirdPartyName(): ?string
    {
        return $this->benef_bank_third_party_name;
    }

    public function getBeneficiaryBankThirdPartyCode(): ?string
    {
        return $this->benef_bank_third_party_code;
    }

    public function getBeneficiaryBranchThirdPartyId(): ?string
    {
        return $this->benef_branch_third_party_id;
    }

    public function getBeneficiaryBranchThirdPartyName(): ?string
    {
        return $this->benef_branch_third_party_name;
    }

    public function getBeneficiaryBranchThirdPartyCode(): ?string
    {
        return $this->benef_branch_third_party_code;
    }

    public function getSendCountryIso(): string
    {
        return $this->send_country_iso;
    }

    public function getSendCurrency(): ?string
    {
        return $this->send_currency;
    }

    public function getSendAmount(): ?string
    {
        return $this->send_amount;
    }

    public function getReceiveCountryIso(): string
    {
        return $this->receive_country_iso;
    }

    public function getReceiveCurrency(): string
    {
        return $this->receive_currency;
    }

    public function getReceiveAmount(): string
    {
        return $this->receive_amount;
    }

    public function getReceiveAmountAfterBankCharges(): string
    {
        return $this->receive_amount_after_bank_charges;
    }
}
