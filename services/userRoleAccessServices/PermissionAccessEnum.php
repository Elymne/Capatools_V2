<?php

namespace app\services\userRoleAccessServices;

/**
 * Classe d'énumération qui liste toutes les permissions de l'application.
 * Une permission est défini par une chaîne de caractère.
 * Les permissions sont créés à partir des fichiers de migrations rbac. S'y réferer pour comprendre le processus qui régit les droits d'utilisateur.
 * 
 * A chaque fois que vous voulez créer un nouveau droit, faite d'abbord une nouvelle énumération dans cette classe que vous utiliserez ensuite dans le fichier de migration et dans le code.
 */
class PermissionAccessEnum
{

    // Enums relatif à la gestions des projets.
    const PROJECT_INDEX = 'projectIndex';
    const PROJECT_CREATE = 'projectCreate';
    const PROJECT_VIEW = 'projectView';
    const PROJECT_UPDATE = 'projectUpdate';
    const PROJECT_DELETE = 'projectDelete';
    const PROJECT_UPDATE_STATUS = 'ProjectUpdateStatus';
    const PROJECT_PDF = 'projectPdf';

    // Enums relatif à la gestions des utilisateurs.
    const ADMIN_INDEX = 'adminIndex';
    const ADMIN_CREATE = 'adminCreate';
    const ADMIN_VIEW = 'adminView';
    const ADMIN_UPDATE = 'adminUpdate';
    const ADMIN_DELETE = 'adminDelete';
    const ADMIN_DEVIS_PARAMETERS_VIEW = 'adminDevisParametersView';
    const ADMIN_DEVIS_PARAMETERS_UPDATE = 'adminDevisParametersUpdate';
    const ADMIN_EQUIPEMENT_INDEX = 'adminEquipementIndex';
    const ADMIN_EQUIPEMENT_CREATE = 'adminEquipementCreate';

    // Enums relatif à la gestions des sociétés et des contacts.
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
