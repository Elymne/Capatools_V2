<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Enum that is used to manage user roles.
 */
class CompanyTypeEnum extends Enum
{

    const UNKNOW = 'unknow';
    const PRIVATE_COMPANY = 'private_company';
    const RESEARCH_ORGANIZATION = "research_organization";
    const PUBLIC_COMPANY = "public_company";
    const ASSOCIATION = "association";
    const SELF_EMPLOYED = "self_employed";

    const UNKNOW_STRING = 'Inconnu';
    const PRIVATE_COMPANY_STRING = 'Entreprise privée';
    const RESEARCH_ORGANIZATION_STRING = "Etablissement et organisme de recherche";
    const PUBLIC_COMPANY_STRING = "Etablissement public";
    const ASSOCIATION_STRING = "Association";
    const SELF_EMPLOYED_STRING = "Auto-entrepreneur";

    const COMPANY_TYPE = [
        self::PRIVATE_COMPANY,
        self::RESEARCH_ORGANIZATION,
        self::PUBLIC_COMPANY,
        self::ASSOCIATION,
        self::SELF_EMPLOYED,
    ];

    const COMPANY_TYPE_STRING = [
        self::PRIVATE_COMPANY_STRING,
        self::RESEARCH_ORGANIZATION_STRING,
        self::PUBLIC_COMPANY_STRING,
        self::ASSOCIATION_STRING,
        self::SELF_EMPLOYED_STRING,
    ];

    static function getTypeCompanyString(string $companyEnum): string
    {
        $result = self::UNKNOW_STRING;

        switch ($companyEnum) {
            case self::PRIVATE_COMPANY:
                $result = self::PRIVATE_COMPANY_STRING;
                break;
            case self::RESEARCH_ORGANIZATION:
                $result = self::RESEARCH_ORGANIZATION_STRING;
                break;
            case self::PUBLIC_COMPANY:
                $result = self::PUBLIC_COMPANY_STRING;
                break;
            case self::ASSOCIATION:
                $result = self::ASSOCIATION_STRING;
                break;
            case self::SELF_EMPLOYED:
                $result = self::SELF_EMPLOYED_STRING;
                break;
        }

        return $result;
    }

    static function getTypeCompany(string $companyEnum): string
    {
        $result = self::UNKNOW;

        switch ($companyEnum) {
            case self::PRIVATE_COMPANY_STRING:
                $result = self::PRIVATE_COMPANY;
                break;
            case self::RESEARCH_ORGANIZATION_STRING:
                $result = self::RESEARCH_ORGANIZATION;
                break;
            case self::PUBLIC_COMPANY_STRING:
                $result = self::PUBLIC_COMPANY;
                break;
            case self::ASSOCIATION_STRING:
                $result = self::ASSOCIATION;
                break;
            case self::SELF_EMPLOYED_STRING:
                $result = self::SELF_EMPLOYED;
                break;
        }

        return $result;
    }
}
