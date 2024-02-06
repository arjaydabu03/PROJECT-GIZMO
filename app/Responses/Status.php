<?php
namespace App\Responses;

class Status
{
    //STATUS CODES
    const CREATED_STATUS = 201;
    const UNPROCESS_STATUS = 422;
    const DATA_NOT_FOUND = 404;
    const SUCESS_STATUS = 200;
    const DENIED_STATUS = 403;
    const CUT_OFF_STATUS = 409;

    //CRUD OPERATION
    const USER_SAVE = "User successfully registered.";

    const COMPANY_SAVE = "Company save successfully.";
    const DEPARTMENT_SAVE = "Department save successfully.";
    const LOCATION_SAVE = "Location save successfully.";
    const ROLE_SAVE = "Role successfully saved.";
    const TAGGING_SAVE = "Tagging successfully saved.";

    // DISPLAY DATA
    const USER_DISPLAY = "User display successfully.";
    const ROLE_DISPLAY = "Role display successfully.";
    const COMPANY_DISPLAY = "Company display successfully.";
    const DEPARTMENT_DISPLAY = "Department display successfully.";
    const LOCATION_DISPLAY = "Location display successfully.";
    const TAGGING_DISPLAY = "Ap tagging display successfully.";
    //UPDATE
    const USER_UPDATE = "User successfully updated.";
    const TAGGING_UPDATE = "Tagging successfully updated.";
    const ROLE_UPDATE = "Role successfully updated.";
    const COMPANY_UPDATE = "Company updated successfully.";
    const DEPARTMENT_UPDATE = "Department updated successfully.";
    const LOCATION_UPDATE = "Location updated successfully.";
    //SOFT DELETE
    const ARCHIVE_STATUS = "Successfully archived.";
    const RESTORE_STATUS = "Successfully restored.";
    //ACCOUNT RESPONSE
    const INVALID_RESPONSE = "The provided credentials are incorrect.";
    const CHANGE_PASSWORD = "Password successfully changed.";
    const LOGIN_USER = "Log-in successfully.";
    const LOGOUT_USER = "Log-out successfully.";

    // DISPLAY ERRORS
    const NOT_FOUND = "Data not found.";
    //VALIDATION
    const SINGLE_VALIDATION = "Data has been validated.";
    const INVALID_ACTION = "Invalid action.";
    const INVALID_UPDATE_POSTED = "Unable to update this transaction is already posted.";
    const NEW_PASSWORD = "Please change your password.";
    const EXISTS = "Data already exists.";
    const ACCESS_DENIED = "You do not have permission.";
    const DATA_EXPORT = "Data has been exported successfully.";
}
