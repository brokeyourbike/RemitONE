<?php

// Copyright (C) 2021 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\RemitOne\Interfaces;

use BrokeYourBike\RemitOne\Interfaces\DecodedAddressPartsInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface DecodedTransactionInterface
{
    public function getReference(): string;
    public function getType(): string;
    public function getStatus(): string;
    public function getRemitterId(): string;
    public function getRemitterGender(): ?string;
    public function getRemitterDateOfBirth(): ?string;
    public function getRemitterFirstName(): ?string;
    public function getRemitterLastName(): ?string;
    public function getRemitterMiddleName(): ?string;
    public function getRemitterNationality(): ?string;
    public function getRemitterAddressParts(): ?DecodedAddressPartsInterface;
    public function getRemitterMobileNumber(): ?string;
    public function getRemitterIdentificationType(): ?string;
    public function getRemitterIdentificationDetails(): ?string;
    public function getRemitterIdentificationExpiry(): ?string;
    public function getBeneficiaryId(): string;
    public function getBeneficiaryFirstName(): ?string;
    public function getBeneficiaryLastName(): ?string;
    public function getBeneficiaryMiddleName(): ?string;
    public function getBeneficiaryIdType(): ?string;
    public function getBeneficiaryIdDetails(): ?string;
    public function getBeneficiaryPostcode(): ?string;
    public function getBeneficiaryMobileTransferNumber(): ?string;
    public function getBeneficiaryMobileTransferNetwork(): ?string;
    public function getBeneficiaryMobileTransferNetworkThirdPartyId(): ?string;
    public function getBeneficiaryAddress(): ?string;
    public function getBeneficiaryCity(): ?string;
    public function getBeneficiaryMobileNumber(): ?string;
    public function getBeneficiaryEmail(): ?string;
    public function getBeneficiaryNationality(): ?string;
    public function getBeneficiaryBranch(): ?string;
    public function getBeneficiaryBranchCode(): ?string;
    public function getBeneficiaryBankAccountNumber(): ?string;
    public function getBeneficiaryBankAccountType(): ?string;
    public function getBeneficiaryBankSwiftCode(): ?string;
    public function getBeneficiaryBankIban(): ?string;
    public function getBeneficiaryBankThirdPartyId(): ?string;
    public function getBeneficiaryBankThirdPartyName(): ?string;
    public function getBeneficiaryBankThirdPartyCode(): ?string;
    public function getBeneficiaryBranchThirdPartyId(): ?string;
    public function getBeneficiaryBranchThirdPartyName(): ?string;
    public function getBeneficiaryBranchThirdPartyCode(): ?string;
    public function getSendCountryIso(): string;
    public function getSendCurrency(): ?string;
    public function getSendAmount(): ?string;
    public function getReceiveCountryIso(): string;
    public function getReceiveCurrency(): string;
    public function getReceiveAmount(): string;
    public function getReceiveAmountAfterBankCharges(): string;
}
