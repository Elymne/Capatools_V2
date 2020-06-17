<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Classe d'énumération qui liste toutes les permissions de l'application.
 */
class PermissionAccessEnum extends Enum
{

    const PROJECT_INDEX = 'projectIndex';
    const PROJECT_CREATE = 'projectCreate';
    const PROJECT_VIEW = 'projectView';
    const PROJECT_UPDATE = 'projectUpdate';
    const PROJECT_DELETE = 'projectDelete';
    const PROJECT_UPDATE_STATUS = 'ProjectUpdateStatus';
    const PROJECT_PDF = 'projectPdf';

    const ADMIN_INDEX = 'adminIndex';
    const ADMIN_CREATE = 'adminCreate';
    const ADMIN_VIEW = 'adminView';
    const ADMIN_UPDATE = 'adminUpdate';
    const ADMIN_DELETE = 'adminDelete';
    const ADMIN_PROJECT_PARAMETERS = 'adminProjectParameters';

    const COMPANY_INDEX = 'companyIndex';
    const COMPANY_CREATE = 'companyCreate';
    const COMPANY_VIEW = 'companyView';
    const COMPANY_UPDATE = 'companyUpdate';
    const COMPANY_DELETE = 'companyDelete';
    const COMPANY_CONTACT_INDEX = 'companyContactIndex';
    const COMPANY_CONTACT_CREATE = 'companyContactCreate';
    const COMPANY_CONTACT_VIEW = 'companyContactView';
    const COMPANY_CONTACT_UPDATE = 'companyContactUpdate';
    const COMPANY_CONTACT_DELETE = 'companyContactDelete';
}
